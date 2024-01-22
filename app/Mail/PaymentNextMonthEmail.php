<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentNextMonthEmail extends Mailable
{
    use Queueable, SerializesModels;

    public string $expired_at;
    public string $name;
    public float $amount;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $expired_at, float $amount, string $email)
    {
        $this->expired_at = $expired_at;
        $this->name = substr($email, 0, strrpos($email, '@'));
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function build(): mixed
    {
        return $this->subject('Payment for Next Month')->view('emails.customer.paymentNextMonth');
    }
}
