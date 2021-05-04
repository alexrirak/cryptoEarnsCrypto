<?php

namespace App\Mail;

use App\Models\ProviderMetadata;
use Illuminate\Mail\Mailable;

class RateChange extends Mailable
{

    public $rateChanges;
    public $user;

    /**
     * The provider
     *
     * @var ProviderMetadata
     */
    public $provider;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($rateChanges, $user, ProviderMetadata $provider)
    {
        $this->rateChanges = $rateChanges;
        $this->user = $user;
        $this->provider = $provider;

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
            ->subject(sprintf ("[%s] %s Rate Change", config('app.name'), $this->provider->name))
            ->view('emails.rateChange');
    }
}
