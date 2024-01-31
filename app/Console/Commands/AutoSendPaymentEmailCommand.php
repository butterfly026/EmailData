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
                    $user->stripe_customer_id
                ) {
                    $payment = Payments::create([
                        'user_email' => $user->email,
                        'amount' => $amount,
                        'order_no' => strtoupper('D' . uniqid() . rand(1000, 9999)),
                        'ordered_at' => now()->toDateTimeString(),
                    ]);
                    Stripe::setApiKey($config['stripe_secret_key']);
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
                                $user->email_verif_code = md5(uniqid(rand(), true));
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
                        error_log(json_encode($charge));
                        logger('An error occurred while creating payment');
                    }
                } else {
                    Mail::to($user->email)->send(new PaymentNextMonthEmail($user->expired_at, $amount, $user->email));
                }
            } catch (Exception $e) {
                error_log($e->getMessage());
            }
        }
        return Command::SUCCESS;
    }
}
