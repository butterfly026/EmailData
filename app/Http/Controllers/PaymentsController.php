<?php

namespace App\Http\Controllers;

use App\Exceptions\Err;
use App\Mail\PaymentVerifyEmail;
use App\Mail\PaymentSuccessEmail;
use App\Models\Payments;
use App\Models\Settings;
use App\Models\User;
use App\Traits\ControllerTrait;
use Illuminate\Support\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Stripe\Stripe;
use Stripe\StripeClient;
use Stripe\Customer;
use Stripe\Charge;
use net\authorize\api\controller as AnetController;
use net\authorize\api\contract\v1 as AnetAPI;

class PaymentsController extends CustomBaseController
{
    //
    use ControllerTrait;

    public function payout()
    {
        $setting = Settings::where('key', 'payments')->first();
        if (!$setting) {
            Err::throw('Contact to administrator to pay out!!');
        }
        $config = json_decode($setting->value, true);
        Stripe::setApiKey($config['stripe_secret_key']);
        $user = $this->getUser();

        // $stripe = new StripeClient($config['stripe_secret_key']);
        // $order = $this->Stripe_getUrl();
        // try{
        //     return redirect($stripe->checkout->sessions->retrieve($order->id, [])->url);
        // }catch(Exception $e){
        //     return redirect('/home');
        // }
        $StripeKey = $config['stripe_api_key'];
        $SecretKey = $config['stripe_secret_key'];
        $PayAmount = $config['pay_amount'] ?? 200;
        return view('payout', compact('StripeKey', 'SecretKey', 'PayAmount'));
    }

    public function payout_non_user()
    {
        $setting = Settings::where('key', 'payments')->first();
        if (!$setting) {
            Err::throw('Contact to administrator to pay out!!');
        }
        $config = json_decode($setting->value, true);
        Stripe::setApiKey($config['stripe_secret_key']);

        $StripeKey = $config['stripe_api_key'];
        $SecretKey = $config['stripe_secret_key'];
        $PayAmount = $config['pay_amount'] ?? 200;
        return view('payout', compact('StripeKey', 'SecretKey', 'PayAmount'));
    }

    public function myPaymentsPage()
    {
        $user = $this->getUser();
        $payments = Payments::where('user_email', $user->email)->get();
        return view('mypayments', compact('payments'));
    }

    public function confirmPaymentPage($order_no)
    {
        $payment = Payments::where('order_no', $order_no)->first();

        $errMsg = '';
        if (empty($payment)) {
            $errMsg = "Can not find valid payment, Please check you did a payment request correctly!";
            return view('paymentConfirm', compact('errMsg'));
        }

        $UserEmail = $payment->user_email;
        $PayElements = json_decode($payment->pay_elements);
        $PayAmount = $payment->amount;
        $payment->confirmed_at = now()->toDateTimeString();
        $setting = Settings::where('key', 'payments')->first();
        if (!$setting) {
            Err::throw('Contact to administrator to pay out!!');
        }
        $config = json_decode($setting->value, true);
        Stripe::setApiKey($config['stripe_secret_key']);

        $user = User::where('email', $UserEmail)->first();
        if (empty($user) || !$user->stripe_customer_id) {
            $errMsg = "Can not find valid user information, Please contact to administrator!";
            return view('paymentConfirm', compact('errMsg'));
        }
        $amount = $config['pay_amount'] ?? 200;

        $charge = Charge::create([
            'amount' => $amount * 100, // amount in cents
            'currency' => 'usd',
            'customer' => $user->stripe_customer_id,
        ]);
        if ($charge->status == 'succeeded') {
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
                $payment->save();
                if (!$user->is_email_verified) {
                    $user->email_verif_sent_at = now()->toDateTimeString();
                    $user->is_email_verified = 1;
                }
                $user->save();
            }
            try {
                Mail::to($user->email)->send(new PaymentSuccessEmail($payment->order_no, $payment->amount, $payment->user_email));
            } catch (Exception $e) {
                logger($e->getMessage());
            }
        } else {
            logger(json_encode($charge));
            logger('An error occurred while creating payment');
        }

        $payment->save();
        return view('paymentConfirm', compact('UserEmail', 'PayAmount', 'order_no'));
    }

    public function checkout()
    {
        // $setting = Settings::where('key', 'payments')->first();
        // if (!$setting) {
        //     Err::throw('Contact to administrator to pay out!!');
        // }
        // $config = json_decode($setting->value, true);
        // $client = new StripeClient($config['stripe_secret_key']);
        // $paymentIntent = $client->paymentIntents->create([
        //     'amount' => $config['pay_amount'] * 100,
        //     'currency' => 'usd',
        //     // In the latest version of the API, specifying the `automatic_payment_methods` parameter is optional because Stripe enables its functionality by default.
        //     'automatic_payment_methods' => [
        //         'enabled' => true,
        //     ],
        // ]);
        // return [
        //     'clientSecret' => $paymentIntent->client_secret,
        // ];

        $setting = Settings::where('key', 'payments')->first();
        if (!$setting) {
            Err::throw('Contact to administrator to pay out!!');
        }
        $config = json_decode($setting->value, true);
        $client = new StripeClient($config['stripe_secret_key']);
        $paymentIntent = $client->paymentIntents->create([
            'amount' => $config['pay_amount'] * 100,
            'currency' => 'usd',
            // In the latest version of the API, specifying the `automatic_payment_methods` parameter is optional because Stripe enables its functionality by default.
            // 'automatic_payment_methods' => [
            //     'enabled' => true,
            // ],
            'confirmation_method' => 'manual',
            'confirm' => true,
            'payment_method_options' => [
                'card' => [
                    'installments' => [
                        'enabled' => true,
                    ],
                ],
            ],
            'metadata' => [
                'integration_check' => 'accept_a_payment',
            ],
            'items' => [
                [
                    'price' => $config['stripe_product_id'],
                    'quantity' => 1,
                ],
            ],
        ]);
        return [
            'clientSecret' => $paymentIntent->client_secret,
        ];
    }

    function Stripe_getUrl()
    {
        $setting = Settings::where('key', 'payments')->first();
        if (!$setting) {
            Err::throw('Contact to administrator to pay out!!');
        }
        $config = json_decode($setting->value, true);
        $client = new StripeClient($config['stripe_secret_key']);
        // Create array with all the products
        $items = [[
            'price_data' => [
                'currency' => 'USD',
                'product_data' => [
                    'name' => 'Access All Marketing Data',
                    'description' => 'You can pay for full access permission',
                ],
                'unit_amount' => $config['pay_amount'] * 100,
            ],
            'quantity' => 1,
        ]];
        try {
            $order = $client->checkout->sessions->create([
                'line_items' => $items,
                'mode' => 'payment',
                'payment_intent_data' => [
                    'description' => 'This is test stripe mode'
                ],
                'success_url' => route('payments.paySuccess'),
                'cancel_url' => route('home'),
                'customer_email' => auth()->user()->email,
                'metadata' => [
                    'user_id' => auth()->user()->id,
                    'amount' => $config['pay_amount'],
                    'order_no' => strtoupper('D' . uniqid() . rand(1000, 9999)),
                ],
            ]);
            return $order;
        } catch (Exception $e) {
            return redirect('home');
        }
    }

    function payment_hook(Request $request, $productPrice = null)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('stripe-signature');
        $setting = Settings::where('key', 'payments')->first();
        if (!$setting) {
            Err::throw('Contact to administrator to pay out!!');
        }
        $config = json_decode($setting->value, true);
        // $endpoint_secret = 'whsec_BSKW7aOAFKhJwGnsnoON7qsnShYMiJWE';
        $endpoint_secret = $config['web_hook_secret'];
        Stripe::setApiKey($config['stripe_secret_key']);
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            logger('Stripe Web Hook Exception \r\t\t\t' . $e->getMessage());
            exit;
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            http_response_code(400);
            logger('Stripe Web Hook Exception 2 \r\t\t\t' . $e->getMessage());
            exit;
        }
        logger('Stripe Payment Hook \n\t\t\t' . json_encode($event));
        if ($event->type == 'checkout.session.completed') {
            logger(json_encode($event->data));
            $order = $event->data->object;
            $order_no = $order->metadata->order_no;
            // $user_id = $order->metadata->user_id;
            $amount = $order->metadata->amount;
            // if ($user_id) {
            //     $user = User::where('id', $user_id)->first();
            //     // if ($user) {
            //     //     $user->is_paid = 1;
            //     //     $user->last_paid_at = now();
            //     //     $user->save();
            //     //     Payments::updateOrCreate([
            //     //         'order_no' => $order_no
            //     //     ], [
            //     //         'paid_at' => now()->toDateTimeString(),
            //     //         'amount' => $amount
            //     //     ]);
            //     // }
            // }
        }
    }

    function paySuccess(Request $request)
    {
        // {"payment_intent":"pi_3ObDUnLndwq2SynH1MGNjjLT","payment_intent_client_secret":"pi_3ObDUnLndwq2SynH1MGNjjLT_secret_fmLt512OOXoDrH4rBrIT1YWOv","redirect_status":"succeeded"}.
        $params = $request->all();
        $setting = Settings::where('key', 'payments')->first();
        if (!$setting) {
            error_log('ERRRRRR');
            Err::throw('Contact to administrator to pay out!!');
        }
        $config = json_decode($setting->value, true);
        $client = new StripeClient($config['stripe_secret_key']);
        $paymentIntent = $client->paymentIntents->retrieve($params['payment_intent'], []);
        $email = $paymentIntent['receipt_email'];
        $payment = Payments::create([
            'user_email' => $email,
            'amount' => $paymentIntent['amount'] / 100,
            'order_no' => strtoupper('D' . uniqid() . rand(1000, 9999)),
            'ordered_at' => now()->toDateTimeString(),
            'paid_at' => now()->toDateTimeString(),
        ]);
        $user = User::where('email', $email)->first();
        if ($user) {
            $user->is_paid = 1;
            $user->last_paid_at = now();
            $expiredAt = Carbon::parse($user->expired_at);
            if ($expiredAt < now()) {
                $user->expired_at = now()->addMonth()->toDateTimeString();
            } else {
                $user->expired_at = $expiredAt->addMonth()->toDateTimeString();
            }
            $payment->expired_at = $user->expired_at;
            $payment->save();
            $user->email_verif_sent_at = now()->toDateTimeString();
            $user->is_email_verified = 1;
            $user->save();
        }
        try {
            Mail::to($email)->send(new PaymentVerifyEmail($payment->order_no, $payment->amount, $payment->user_email));
        } catch (Exception $e) {
            logger($e->getMessage());
        }

        return redirect('/home');
    }
    function cancelSubscription(Request $request)
    {
        $params = $request->all();
        $email = $params["user_email"];
        $user = User::where('email', $email)->first();
        $user->is_paid = 0;
        $user->save();
        echo 'cancelled';
    }
    function payments_search(Request $request): mixed
    {
        $user = $this->getUser();
        if ($user->user_type != 1) {
            return [];
        }
        $params = $request->validate([
            'perPage' => 'nullable',
            'curPage' => 'nullable',
        ]);
        return Payments::with('user')->paginate($this->perPage());
    }


    function sendPaymentEmail(Request $request): mixed
    {
        $params = $request->validate([
            'user_email' => 'required|email',
        ]);
        $setting = Settings::where('key', 'payments')->first();
        if (!$setting) {
            Err::throw('Contact to administrator to pay out!!');
        }
        $config = json_decode($setting->value, true);
        // $client = new StripeClient($config['stripe_secret_key']);
        $amount = $config['pay_amount'] ?? 200;
        $payment = Payments::create([
            'user_email' => $params['user_email'],
            'amount' => $amount,
            'order_no' => strtoupper('D' . uniqid() . rand(1000, 9999)),
            'ordered_at' => now()->toDateTimeString()
        ]);
        Mail::to($params['user_email'])->send(new PaymentVerifyEmail($payment->order_no, $payment->amount, $payment->user_email));
        return 'success';
    }

    function getElementsFromOrderNo(Request $request)
    {
        $params = $request->validate([
            'order_no' => 'required|string'
        ]);

        $payment = Payments::where('order_no', $params['order_no'])->first();
        if ($payment) {
            return [
                'data' => $payment->pay_elements
            ];
        } else {
            Err::throw('Can not find payment from order number!');
        }
    }

    function confirm_payout_stripe(Request $request)
    {
        $params = $request->validate([
            'email' => 'required|email',
            'token_id' => 'required|string'
        ]);
        $setting = Settings::where('key', 'payments')->first();
        if (!$setting) {
            Err::throw('Contact to administrator to pay out!!');
        }
        $config = json_decode($setting->value, true);
        Stripe::setApiKey($config['stripe_secret_key']);
        $user = User::where('email', $params['email'])->first();
        if (!$user) {
            Err::throw('Email is not valid or not registered!!');
        }
        if ($user && !$user->stripe_customer_id) {
            $customer = Customer::create([
                'email' => $params['email'],
                'source' => $params['token_id'],
            ]);
            $user->stripe_customer_id = $customer->id;
            $user->save();
        }
        $amount = $config['pay_amount'] ?? 200;
        $payment = Payments::create([
            'user_email' => $user->email,
            'amount' => $amount,
            'order_no' => strtoupper('D' . uniqid() . rand(1000, 9999)),
            'ordered_at' => now()->toDateTimeString(),
        ]);

        $payment->confirmed_at = now()->toDateTimeString();
        $charge = Charge::create([
            'amount' => $amount * 100, // amount in cents
            'currency' => 'usd',
            'customer' => $user->stripe_customer_id,
        ]);
        if ($charge->status == 'succeeded') {
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
                $payment->save();
                if (!$user->is_email_verified) {
                    $user->email_verif_sent_at = now()->toDateTimeString();
                    $user->is_email_verified = 1;
                }
                $user->save();
            }
            try {
                Mail::to($user->email)->send(new PaymentSuccessEmail($payment->order_no, $payment->amount, $payment->user_email));
            } catch (Exception $e) {
                logger($e->getMessage());
            }
        } else {
            logger(json_encode($charge));
            logger('An error occurred while creating payment');
            Err::Throw('An error occurred while creating payment');
        }

        return [
            'order_no' => $payment->order_no
        ];
    }

    function confirm_payout(Request $request)
    {
        $setting = Settings::where('key', 'payments')->first();
        if (!$setting) {
            Err::throw('Contact to administrator to pay out!!');
        }
        $config = json_decode($setting->value, true);
        $amount = $config['pay_amount'] ?? 200;
        $authLoginId = $config['auth_login_id'] ?? env('AUTHORIZE_LOGIN_ID');
        $authTransactionKey = $config['auth_transaction_key'] ?? env('AUTHORIZE_TRANSACTION_KEY');
        $authSandbox = $config['auth_sandbox'] ?? 0;
        $authSandbox = 0;
        error_log("Auth Login ID: $authLoginId, TransactionKey: $authTransactionKey, Sandbox: $authSandbox");

        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName($authLoginId);
        $merchantAuthentication->setTransactionKey($authTransactionKey);

        // Set the transaction's refId
        $refId = 'ref' . time();

        // Create the payment data for a credit card
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($request->input('card_number'));

        $dateString = $request->input('expiration');
        if (!empty($dateString)) {
            $month = substr($dateString, 0, 2);
            $year = substr($dateString, -2);
            $dateString = $month . '/'. $year;
        }

        // Create a DateTime object from the given string
        $dateTime = Carbon::createFromFormat('m/y', $dateString);
        $formattedDate = $dateTime->format('Y-m');

        $creditCard->setExpirationDate($formattedDate);
        $creditCard->setCardCode($request->input('cvc'));

        // Add the payment data to a paymentType object
        $paymentOne = new AnetAPI\PaymentType();
        $paymentOne->setCreditCard($creditCard);

        $customerData = new AnetAPI\CustomerDataType();
        $customerData->setType("individual");
        $customerData->setId(strtoupper('D' . uniqid() . rand(1000, 9999)));
        $customerData->setEmail($request->input('user_email'));


        // Create order information
        $order = new AnetAPI\OrderType();
        $order->setInvoiceNumber("10101");
        $order->setDescription("Gadget");

        // // Set the customer's Bill To address
        // $customerAddress = new AnetAPI\CustomerAddressType();
        // $customerAddress->setFirstName($request->input('first_name'));
        // $customerAddress->setLastName($request->input('last_name'));
        // $customerAddress->setCompany($request->input('company'));
        // $customerAddress->setAddress($request->input('address'));
        // $customerAddress->setCity($request->input('city'));
        // $customerAddress->setState($request->input('state'));
        // $customerAddress->setZip($request->input('zip'));
        // $customerAddress->setCountry($request->input('country'));

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
            error_log(json_encode($response));
            if (($tresponse != null) && ($tresponse->getResponseCode() == "1")) {
                echo "Charge Credit Card AUTH CODE : " . $tresponse->getAuthCode() . "\n";
                echo "Charge Credit Card TRANS ID  : " . $tresponse->getTransId() . "\n";
                return "Transaction Successful!";
            } else {
                Err::Throw('An error occurred while creating payment. ' . $tresponse->getErrors()[0]->getErrorText());
            }
        } else {
            Err::Throw('An error occurred while creating payment');
        }
    }
}
