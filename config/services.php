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

    'whatsapp' => [
        'api_url' => 'https://pickyassist.com/app/api/v2/push',
        'token' => env('PICKYASSIST_API_TOKEN'),
        'application_id' => env('PICKYASSIST_APPLICATION_ID'),
        'otp_template' => env('PICKYASSIST_OTP_TEMPLATE'),
    ],

    'payment' => [
        'gateway' => env('PAYMENT_GATEWAY', 'razorpay'),
        'key_id' => env('RAZORPAY_KEY_ID'),
        'key_secret' => env('RAZORPAY_KEY_SECRET'),
        'api_url' => env('PAYMENT_API_URL', 'https://api.razorpay.com/v1'),
        'webhook_secret' => env('RAZORPAY_WEBHOOK_SECRET'),
    ],

    'crm' => [
        'push_url' => env('CRM_PUSH_URL'),
        'api_key' => env('CRM_API_KEY'),
    ],
    'arihant_client' => [
        'url' => env('ARIHAINT_CLIENT_API_URL'),
        'auth' => env('ARIHAINT_CLIENT_API_AUTH'),
    ],
    'atom' => [
        'merchant_id'         => env('ATOM_MERCHANT_ID'),
        'password'            => env('ATOM_PASSWORD'),
        'product_id'          => env('ATOM_PRODUCT_ID'),
        'pay_url'             => env('ATOM_PAY_URL', 'https://payment1.atomtech.in/ots/aipay/auth'),
        'js_cdn'              => env('ATOM_JS_CDN', 'https://psa.atomtech.in/staticdata/ots/js/atom.js'),

        'aes_request_key'     => env('ATOM_AES_REQUEST_KEY'),
        'aes_request_salt'    => env('ATOM_AES_REQUEST_SALT'),
        'aes_response_key'    => env('ATOM_AES_RESPONSE_KEY'),
        'aes_response_salt'   => env('ATOM_AES_RESPONSE_SALT'),
        'return_url' => env('ATOM_RETURN_URL', env('APP_URL') . '/payment/callback'),
    ],

];
