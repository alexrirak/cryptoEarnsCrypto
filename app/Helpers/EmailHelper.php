<?php

namespace App\Helpers;

use App\Mail\RateChange;
use Illuminate\Support\Facades\Mail;

class EmailHelper
{
    public static function sendMail($msg) {

        Mail::to("alexrirak@yahoo.com")
        ->send(new RateChange($msg));
    }

}
