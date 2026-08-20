<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

<<<<<<< HEAD
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],


    'allowed_origins' => ['http://localhost:3000',
                         'https://ariatechshop.netlify.app', 
                      ],

    'allowed_origins' => [
                         'https://ariatechshop.netlify.app',  // frontend producción
                        'http://localhost:3000',            
],
    'supports_credentials' => true,        // cookies


=======
    'paths' => ['api/*', 'sanctum/csrf-cookie','login','register'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'https://ariatechshop.netlify.app',
        'http://localhost:3000'
    ],
>>>>>>> 92925bac025897d0d44f08032ee7ee60e5a198dc
    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

<<<<<<< HEAD
    'supports_credentials' => false,
=======
    'supports_credentials' => true,

>>>>>>> 92925bac025897d0d44f08032ee7ee60e5a198dc

];
