<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SignupMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $verifyCode;
    public string $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $verifyCode, string $email)
    {
        $this->verifyCode = $verifyCode;
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function build(): mixed
    {
        return $this->subject('Welcome to Emaildata')->view('emails.customer.auth.signupEmail');
    }
}
