<?php

namespace App\Http\Controllers;

use App\Exceptions\Err;
use App\Mail\PaymentVerifyEmail;
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
        return view('payments', compact('StripeKey', 'SecretKey', 'PayAmount'));
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
        return view('payments', compact('StripeKey', 'SecretKey', 'PayAmount'));
    }

    public function myPaymentsPage() {
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
        // if ($payment->confirmed_at) {
        //     $errMsg = "Oh, You already confirmed your payment!";
        //     return view('paymentConfirm', compact('errMsg'));
        // }
        
        $UserEmail = $payment->user_email;
        $PayElements = json_decode($payment->pay_elements);
        $PayAmount = $payment->amount;
        $setting = Settings::where('key', 'payments')->first();
        if (!$setting) {
            $errMsg = "Oh, An error occured while confirming your payment, Contact administrator to pay out!!";
            return view('paymentConfirm', compact('errMsg'));
        }
        $config = json_decode($setting->value, true);
        $StripeKey = $config['stripe_api_key'];
        
        $client = new StripeClient($config['stripe_secret_key']);
        Stripe::setApiKey($config['stripe_secret_key']);
        error_log('creating card payment');        
        $paymentMethod = $client->paymentMethods->create([
            'type' => 'card',
            'card' => [
              'number' => '4242424242424242',
              'exp_month' => 8,
              'exp_year' => 2026,
              'cvc' => '314',
            ],
          ]);
          error_log('created card payment');
        try {
            $paymentIntent = $client->paymentIntents->create([
                'amount' => $PayAmount * 100,  // Amount in cents
                'currency' => 'usd',
                'payment_method' => $paymentMethod->id,
                'confirmation_method' => 'manual',
                'confirm' => true,
              ]);
              
              // Confirm the PaymentIntent
              $client->paymentIntents->confirm(
                $paymentIntent->id,
                ['payment_method' => $paymentMethod->id]
              );
              
              // Handle the result
              if ($paymentIntent->status === 'succeeded') {
                  // Payment succeeded
                  
              } else {
                  // Payment failed
                  $errMsg = 'Payment failed: ' . $paymentIntent->status;
                  return view('paymentConfirm', compact('errMsg'));
              }
        } catch (\Exception $e) {
            $errMsg = $e->getMessage();            
            return view('paymentConfirm', compact('errMsg'));
        }
        $payment->confirmed_at = now()->toDateTimeString();
        $payment->save();
        return view('paymentConfirm', compact('UserEmail', 'PayAmount', 'order_no', 'StripeKey'));
    }

    public function checkout()
    {
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
            'automatic_payment_methods' => [
                'enabled' => true,
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
        error_log(json_encode($params));
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
            // 'card_number' => $params['card_number'],
            // 'expiration' => $params['expiration'],
            // 'cvc' => $params['cvc'],
            // 'card_holder_name' => $params['holder_name'],
            'amount' => $paymentIntent['amount'] / 100,
            'order_no' => strtoupper('D' . uniqid() . rand(1000, 9999)),
            'ordered_at' => now()->toDateTimeString(),
            'paid_at' => now()->toDateTimeString(),
        ]);        
        $user = User::where('email', $email)->first();
        if($user) {
            $user->is_paid = 1;
            $user->last_paid_at = now();            
            $expiredAt = Carbon::parse($user->expired_at);
            if($expiredAt < now()) {
                $user->expired_at = now()->addMonth()->toDateTimeString();
            } else {
                $user->expired_at = $expiredAt->addMonth()->toDateTimeString();
            }
            $payment->expired_at = $user->expired_at;
            $payment->save();
            $user->email_verif_code = md5(uniqid(rand(), true));
            $user->email_verif_sent_at = now()->toDateTimeString();
            $user->is_email_verified = 1;
            $user->save();
        }
        try{
            Mail::to($email)->send(new PaymentVerifyEmail($payment->order_no, $payment->amount, $payment->user_email));                
        }catch (Exception $e) {
            logger($e->getMessage());
        }
        
        return redirect('/home');
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
            // 'card_number' => 'required|string',
            // 'expiration' => 'required|string',
            // 'cvc' => 'required|string',
            // 'holder_name' => 'required|string',
        ]);
        $setting = Settings::where('key', 'payments')->first();
        if (!$setting) {
            Err::throw('Contact to administrator to pay out!!');
        }
        $config = json_decode($setting->value, true);
        // $client = new StripeClient($config['stripe_secret_key']);
        $amount = $config['pay_amount'] ?? 200;     
        // \Stripe\Stripe::setApiKey();
        // $intent = \Stripe\PaymentIntent::create([
        // 'customer' => $customer->id,
        // 'setup_future_usage' => 'off_session',
        // 'amount' => 1099,
        // 'currency' => 'usd',
        // // In the latest version of the API, specifying the `automatic_payment_methods` parameter is optional because Stripe enables its functionality by default.
        // 'automatic_payment_methods' => [
        //     'enabled' => 'true',
        // ],
        // ]);
        $payment = Payments::create([
            'user_email' => $params['user_email'],
            // 'card_number' => $params['card_number'],
            // 'expiration' => $params['expiration'],
            // 'cvc' => $params['cvc'],
            // 'card_holder_name' => $params['holder_name'],
            'amount' => $amount,
            'order_no' => strtoupper('D' . uniqid() . rand(1000, 9999)),
            'ordered_at' => now()->toDateTimeString()
        ]);
        Mail::to($params['user_email'])->send(new PaymentVerifyEmail($payment->order_no, $payment->amount, $payment->user_email));
        return 'success';
    }

    function getElementsFromOrderNo(Request $request) {
        $params = $request->validate([
            'order_no' => 'required|string'
        ]);

        $payment = Payments::where('order_no', $params['order_no'])->first();
        if($payment) {
            return [
                'data' => $payment->pay_elements
            ];
        } else {
            Err::throw('Can not find payment from order number!');
        }
    }
}
