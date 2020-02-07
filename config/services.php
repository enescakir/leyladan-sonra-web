<?php

return [
    'ses' => [
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION'),
    ],

    'iletimerkezi' => [
        'username' => env('ILETI_USERNAME'),
        'password' => env('ILETI_PASSWORD'),
        'url'      => env('ILETI_URL'),
    ],

    'recaptcha' => [
        'secret' => env('RECAPTCHA_SECRET'),
    ],

    'telegram-bot-api' => [
        'token' => env('TELEGRAM_BOT_TOKEN')
    ],
];
