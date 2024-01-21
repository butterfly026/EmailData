<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentVerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public string $order_no;
    public string $name;
    public float $amount;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $order_no, float $amount, string $email)
    {
        $this->order_no = $order_no;
        $this->name = substr($email, 0, strrpos($email, '@'));
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function build(): mixed
    {
        return $this->subject('Verify your payment of EmailData')->view('emails.customer.paymentVerify');
    }
}
