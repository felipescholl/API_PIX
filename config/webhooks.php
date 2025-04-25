<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Webhook Callbacks Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for webhook callbacks to source systems
    | when a PIX payment is processed.
    |
    */

    'scr' => [
        'callback_url' => env('SCR_WEBHOOK_CALLBACK_URL', 'http://scr.emater.tche.br/api/webhook/pix/callback'),
        'secret' => env('SCR_WEBHOOK_SECRET'),
        'timeout' => env('SCR_WEBHOOK_TIMEOUT', 30),
    ],

    'sisclas' => [
        'callback_url' => env('SISCLAS_WEBHOOK_CALLBACK_URL', 'http://sisclas.emater.tche.br/api/webhook/pix/callback'),
        'secret' => env('SISCLAS_WEBHOOK_SECRET'),
        'timeout' => env('SISCLAS_WEBHOOK_TIMEOUT', 30),
    ],
];