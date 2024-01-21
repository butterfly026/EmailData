<?php

namespace App\Http\Controllers;

use App\Exceptions\Err;
use App\Mail\PaymentVerifyEmail;
use App\Models\Payments;
use App\Models\Settings;
use App\Models\User;
use App\Traits\ControllerTrait;
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
        if(!$setting) {
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
        if(!$setting) {
            Err::throw('Contact to administrator to pay out!!');
        }
        $config = json_decode($setting->value, true);
        Stripe::setApiKey($config['stripe_secret_key']);

        $StripeKey = $config['stripe_api_key'];
        $SecretKey = $config['stripe_secret_key'];
        $PayAmount = $config['pay_amount'] ?? 200;
        return view('payments', compact('StripeKey', 'SecretKey', 'PayAmount'));
    }

    public function checkout() {
        $setting = Settings::where('key', 'payments')->first();
        if(!$setting) {
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
        if(!$setting) {
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
        try{
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
        }catch(Exception $e){
            return redirect('home');
        }

    }

    function payment_hook(Request $request, $productPrice = null)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('stripe-signature');
        $setting = Settings::where('key', 'payments')->first();
        if(!$setting) {
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
            $user_id = $order->metadata->user_id;
            $amount = $order->metadata->amount;
            if($user_id) {
                $user = User::where('id', $user_id)->first();
                if($user) {
                    $user->is_paid = 1;
                    $user->last_paid_at = now();
                    $user->save();
                    Payments::updateOrCreate([
                        'order_no' => $order_no
                    ], [
                        'users_id' => $user->id,
                        'paid_at' => now()->toDateTimeString(),
                        'amount' => $amount
                    ]);
                }
            }
        }
    }

    function paySuccess(Request $request)
    {
        $user = $this->getUser();
        // if($user) {
        //     $user->is_paid = 1;
        //     $user->last_paid_at = now();
        //     $user->save();
        // }
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
            'card_number' => 'required|string',
            'expiration' => 'required|string',
            'cvc' => 'required|string',
            'country' => 'required|string',
            'zipcode' => 'required|string',
        ]);
        $setting = Settings::where('key', 'payments')->first();
        if(!$setting) {
            Err::throw('Contact to administrator to pay out!!');
        }
        $config = json_decode($setting->value, true);
        
        $amount = $config['pay_amount'] ?? 200;
        $payment = Payments::create([
            'user_email' => $params['user_email'],
            'card_number'=> $params['card_number'],
            'expiration'=> $params['expiration'],
            'cvc'=> $params['cvc'],
            'country'=> $params['country'],
            'zipcode'=> $params['zipcode'],
            'amount' => $amount,
            'order_no' => strtoupper('D' . uniqid() . rand(1000, 9999)),
            'ordered_at' => now()->toDateTimeString()
        ]);
        Mail::to($params['user_email'])->send(new PaymentVerifyEmail($payment->order_no, $payment->amount, $payment->user_email));
        return 'success';
    }

}
