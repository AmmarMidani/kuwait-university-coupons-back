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

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'passport' => [
        'login_endpoint' => env('PASSPORT_LOGIN_ENDPOINT'),
        'client_id' => env('PASSPORT_CLIENT_ID'),
        'client_secret' => env('PASSPORT_CLIENT_SECRET'),
    ],

    'allowed_file_extensions' => [
        'images' => env('ALLOWED_IMAGE_EXT', ''),
        'files' => env('ALLOWED_FILE_EXT', ''),
    ],

    'exchange_rate' => [
        'endpoint' => env('RATE_EXCHANGE_ENDPOINT', ''),
        'version' => env('RATE_EXCHANGE_VERSION', ''),
        'api_key' => env('RATE_EXCHANGE_API_KEY', ''),
    ],

    'google_map' => [
        'key' => env('GOOGLE_MAP_API_KEY', ''),
    ],

    'mapbox' => [
        'access_token' => env('MAPBOX_ACCESS_TOKEN', ''),
    ],
];
