<?php

namespace App\Console\Commands;

use App\Mail\EmailVerifyMail;
use App\Mail\PaymentVerifyEmail;
use App\Mail\PaymentNextMonthEmail;
use App\Mail\SignupMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'TestCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Mail::to('drollmatt26@outlook.com')->send(new PaymentVerifyEmail('123123', '240', 'drollmatt26@outlook.com'));
        // Mail::to('drollmatt26@outlook.com')->send(new SignupMail('123123'));
        return Command::SUCCESS;
    }
}
