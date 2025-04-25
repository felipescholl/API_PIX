<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;

class EmailService
{
    public function enviar($to, $subject, $body)
    {
        Mail::raw($body, function ($message) use ($to, $subject) {
            $message->to($to)
                    ->subject($subject);
        });
    }
}