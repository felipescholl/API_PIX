<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'senior' => [
        'wsdl' => env('SENIOR_WSDL', 'https://webp22.seniorcloud.com.br:30211/g5-senior-services/sapiens_Synccom_senior_g5_co_mfi_cre_titulos?wsdl'),
        'user' => env('SENIOR_USER'),
        'password' => env('SENIOR_PASSWORD'),
    ],

    'admin' => [
        'email' => env('ADMIN_EMAIL'),
    ],

];
