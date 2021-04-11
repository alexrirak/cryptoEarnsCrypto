<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RateChange extends Mailable
{

    public $testMessage;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(String $message)
    {
        //
        $this->testMessage = $message;

        // This is to get the mailer to work on cli
        $mailTransport = app()->make('mailer')->getSwiftMailer()->getTransport();

        if ($mailTransport instanceof \Swift_SmtpTransport) {
           $mailTransport->setLocalDomain('0.0.0.0');
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject("Test Email")
            ->view('emails.rateChange');
    }
}
