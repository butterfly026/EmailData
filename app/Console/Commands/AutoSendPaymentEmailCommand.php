<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Payments;
use App\Models\Settings;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;
use App\Mail\PaymentNextMonthEmail;
use App\Mail\PaymentSuccessEmail;
use App\Exceptions\Err;
use Exception;
use Stripe\Stripe;
use Stripe\Charge;

use net\authorize\api\controller as AnetController;
use net\authorize\api\contract\v1 as AnetAPI;

class AutoSendPaymentEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'AutoSendPaymentEmailCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'AutoSendPaymentEmailCommand';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::where('is_paid', 1)
            ->where('expired_at', '>=', now())
            ->where('expired_at', '<=', now()->addDays(3))
            ->get();
        $setting = Settings::where('key', 'payments')->first();
        if (!$setting) {
            Err::throw('Contact to administrator to pay out!!');
        }
        $config = json_decode($setting->value, true);
        // $client = new StripeClient($config['stripe_secret_key']);
        $amount = $config['pay_amount'] ?? 200;
        foreach ($users as $user) {
            try {
                $expired_at = Carbon::parse($user->expired_at)->startOfDay();
                $now = now()->startOfDay();
                if (
                    $expired_at->eq($now) && $user->monthly_subscription == 1 &&
                    $user->payment_id
                ) {
                    $oldPayment = Payments::where('id', $user->payment_id)->first();
                    if (!$oldPayment) continue;
                    $setting = Settings::where('key', 'payments')->first();
                    if (!$setting) {
                        Err::throw('Contact to administrator to pay out!!');
                    }
                    $config = json_decode($setting->value, true);

                    $authLoginId = $config['auth_login_id'] ?? env('AUTHORIZE_LOGIN_ID');
                    $authTransactionKey = $config['auth_transaction_key'] ?? env('AUTHORIZE_TRANSACTION_KEY');
                    $authSandbox = $config['auth_sandbox'] ?? 0;
                    $amount = $config['pay_amount'] ?? 200;
                    error_log("Auth Login ID: $authLoginId, TransactionKey: $authTransactionKey, Sandbox: $authSandbox");

                    $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
                    $merchantAuthentication->setName($authLoginId);
                    $merchantAuthentication->setTransactionKey($authTransactionKey);

                    // Set the transaction's refId
                    $refId = 'ref' . time();

                    // Create the payment data for a credit card
                    $creditCard = new AnetAPI\CreditCardType();
                    $creditCard->setCardNumber($oldPayment->card_number);

                    $dateString = $oldPayment->expiration;
                    if (!empty($dateString)) {
                        $month = substr($dateString, 0, 2);
                        $year = substr($dateString, -2);
                        $dateString = $month . '/' . $year;
                    }

                    // Create a DateTime object from the given string
                    $dateTime = Carbon::createFromFormat('m/y', $dateString);
                    $formattedDate = $dateTime->format('Y-m');

                    $creditCard->setExpirationDate($formattedDate);
                    $creditCard->setCardCode($oldPayment->cvc);

                    // Add the payment data to a paymentType object
                    $paymentOne = new AnetAPI\PaymentType();
                    $paymentOne->setCreditCard($creditCard);

                    $customerData = new AnetAPI\CustomerDataType();
                    $customerData->setType("individual");
                    $customerData->setId(strtoupper('D' . uniqid() . rand(1000, 9999)));
                    $customerData->setEmail($user->email);


                    // Create order information
                    $order = new AnetAPI\OrderType();
                    $orderId = strtoupper('D' . uniqid() . rand(1000, 9999));
                    $order->setInvoiceNumber($orderId);
                    $order->setDescription("Pay for full access");

                    // Create a transaction
                    $transactionRequestType = new AnetAPI\TransactionRequestType();
                    $transactionRequestType->setTransactionType("authCaptureTransaction");
                    $transactionRequestType->setAmount($amount * 100);
                    $transactionRequestType->setOrder($order);
                    $transactionRequestType->setPayment($paymentOne);
                    // $transactionRequestType->setBillTo($customerAddress);

                    $request = new AnetAPI\CreateTransactionRequest();
                    $request->setMerchantAuthentication($merchantAuthentication);
                    $request->setRefId($refId);
                    $request->setTransactionRequest($transactionRequestType);
                    $controller = new AnetController\CreateTransactionController($request);

                    $response = $controller->executeWithApiResponse($authSandbox == 1 ? \net\authorize\api\constants\ANetEnvironment::SANDBOX :
                        \net\authorize\api\constants\ANetEnvironment::PRODUCTION);
                    if ($response != null) {
                        $tresponse = $response->getTransactionResponse();
                        if (($tresponse != null) && ($tresponse->getResponseCode() == "1")) {
                            $payment = Payments::create([
                                'user_email' => $user->email,
                                'amount' => $amount,
                                'order_no' => $orderId,
                                'ordered_at' => now()->toDateTimeString(),
                            ]);

                            $payment->confirmed_at = now()->toDateTimeString();

                            if ($user) {
                                $user->is_paid = 1;
                                $user->last_paid_at = now();
                                $expiredAt = Carbon::parse($user->expired_at);
                                if ($expiredAt < now()) {
                                    $user->expired_at = now()->addMonth()->toDateTimeString();
                                } else {
                                    $user->expired_at = $expiredAt->addMonth()->toDateTimeString();
                                }
                                $payment->paid_at = now()->toDateTimeString();
                                $payment->expired_at = $user->expired_at;
                                $payment->confirmed_at = $user->expired_at;
                                $payment->card_number = $oldPayment->card_number;
                                $payment->expiration = $oldPayment->expiration;
                                $payment->card_holder_Name = $oldPayment->card_holder_name;
                                $payment->cvc = $oldPayment->cvc;
                                $payment->auth_trans_id = $tresponse->getTransId();
                                $payment->save();
                                if (!$user->is_email_verified) {
                                    $user->email_verif_sent_at = now()->toDateTimeString();
                                    $user->is_email_verified = 1;
                                }
                                $user->payment_id = $payment->id;
                                $user->save();
                            }
                            try {
                                Mail::to($user->email)->send(new PaymentSuccessEmail($payment->order_no, $payment->amount, $payment->user_email));
                            } catch (Exception $e) {
                                logger($e->getMessage());
                            }

                            echo "Charge Credit Card AUTH CODE : " . $tresponse->getAuthCode() . "\n";
                            echo "Charge Credit Card TRANS ID  : " . $tresponse->getTransId() . "\n";
                            return "Transaction Successful!";
                        } else {
                            Err::Throw('An error occurred while creating payment. ' . $tresponse->getErrors()[0]->getErrorText());
                        }
                    } else {
                        Err::Throw('An error occurred while creating payment' . $user->email);
                    }
                } else {
                    // Mail::to($user->email)->send(new PaymentNextMonthEmail($user->expired_at, $amount, $user->email));
                }
            } catch (Exception $e) {
                error_log($e->getMessage());
            }
        }
        return Command::SUCCESS;
    }
}
