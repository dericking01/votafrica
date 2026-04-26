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

    'sms' => [
        'base_url' => env('SMS_API_BASE_URL', 'https://messaging-service.co.tz'),
        'single_sms_endpoint' => env('SMS_API_SINGLE_SMS_ENDPOINT', '/api/sms/v2/text/single'),
        'api_key' => env('SMS_API_KEY'),
        'sender_id' => env('SMS_SENDER_ID', 'VOT AFRICA'),
        'flash' => (int) env('SMS_FLASH', 0),
        'timeout' => (int) env('SMS_API_TIMEOUT', 15),
        'verify_ssl' => (bool) env('SMS_VERIFY_SSL', true),
        'ca_bundle' => env('SMS_CA_BUNDLE', ''),
    ],

];
