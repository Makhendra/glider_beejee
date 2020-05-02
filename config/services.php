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
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    /**
     * @TODO удалить ключи и вынести их в env
     */
    'vkontakte' => [
        'client_id' => '7444974',
        'client_secret' => 'oCHTPiEDseH60XdsM8h9',
//        'client_secret' => 'feaf6a02feaf6a02feaf6a02a8fedef3ecffeaffeaf6a02a0023536f797720c036eef53',
        'redirect' => '/social-auth/vkontakte/callback',
    ],
    'google' => [
        'client_id' => '999287025749-9rhbc25sj155iut59ili7olistifk0n1.apps.googleusercontent.com',
        'client_secret' => '-MeIud1GuQPsCxTpcn66udOo',
        'redirect' => '/social-auth/google/callback',
    ],
    'facebook' => [
        'client_id' => '162076665223797',
        'client_secret' => '49ad7dd2bc7f57b52d83b66266f82075',
        'redirect' => '/social-auth/facebook/callback',
    ]

];
