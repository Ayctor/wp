<?php

return [

    'username' => env('MAIL_USERNAME'),

    'password' => env('MAIL_PASSWORD'),

    'host' => env('MAIL_HOST'),

    'port' => env('MAIL_PORT', 587),

    'from' => [
        'name' => env('MAIL_FROM_NAME'),
        'address' => env('MAIL_FROM_ADDRESS'),
    ]

];
