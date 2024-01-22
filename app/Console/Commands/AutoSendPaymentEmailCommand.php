<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Settings;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentNextMonthEmail;
use App\Exceptions\Err;

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
            ->where('expired_at', '>', now())
            ->where('expired_at', '<=', now()->addDays(5))
            ->get();
        $setting = Settings::where('key', 'payments')->first();
        if (!$setting) {
            Err::throw('Contact to administrator to pay out!!');
        }
        $config = json_decode($setting->value, true);
        // $client = new StripeClient($config['stripe_secret_key']);
        $amount = $config['pay_amount'] ?? 200;     
        foreach($users as $user) {
            Mail::to($user->email)->send(new PaymentNextMonthEmail($user->expired_at, $amount, $user->email));
        }
        return Command::SUCCESS;
    }
}
