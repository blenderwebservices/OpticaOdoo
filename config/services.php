<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Resend, Postmark, AWS, and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'odoo' => [
        'url' => env('ODOO_URL', 'https://es-labs.odoo.com'),
        'db' => env('ODOO_DB', 'es-labs'),
        'api_key' => env('ODOO_API_KEY', 'f09a5fec74121a8bfbb49dc47f546723851cc5e9'),
        'uid' => env('ODOO_UID', 5),
        'company_name' => env('ODOO_COMPANY_NAME', 'ES VISION'),
        'company_id' => env('ODOO_COMPANY_ID', 2),
    ],

];
