<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class MagicLoginLink extends Mailable
{
    use Queueable, SerializesModels;

    public $plaintextToken;
    public $expiresAt;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($plaintextToken, $expiresAt)
    {
        $this->plaintextToken = $plaintextToken;
        $this->expiresAt = $expiresAt;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject(sprintf ("[%s] Login Verification", config('app.name')))
            ->view('emails.magicLoginLink', [
                'url' => URL::temporarySignedRoute('verify-login', $this->expiresAt, [
                    'token' => $this->plaintextToken,
                ]),
            ]);
    }
}
