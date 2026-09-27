<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Log Levels
    |--------------------------------------------------------------------------
    |
    | The available log levels are:
    |     emergency, alert, critical, error, warning, notice, info, debug,
    |
    | The particular sap is used to filter logs based on severity.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This determines the "channel" that is used by default when writing
    | log messages. Feel free to add as many channels as you like using
    | the "channels" key of the configuration array.
    |
    */

    'default' => env('LOG_CHANNEL', 'structured'),

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure any number of log channels. You can also
    | configure the handlers, levels, and other aspects of logging.
    | A channel is a combination of a writer and a log level.
    |
    */

    'channels' => [

        'structured' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
            'formatter' => \Monolog\Formatter\JsonFormatter::class,
        ],

        'stack' => [
            'driver' => 'stack',
            'channels' => ['structured'],
            'ignore_empty' => true,
        ],

    ],

];