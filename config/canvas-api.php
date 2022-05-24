<?php

return [

    // configurations

    'defaults' => [
        'config'  => 'oys.staging', // config key where 'class' is set
        'adapter' => \Uncgits\CanvasApi\Adapters\Guzzle::class, // adapter class
    ],

    'configs' => [

        'oys' => [
            'staging' => [
                'class' => \App\CanvasApiConfigs\Oys\Staging::class,
                'host'  => env('CANVAS_API_MYDOMAIN_PRODUCTION_HOST'),
                'token' => env('CANVAS_API_MYDOMAIN_PRODUCTION_TOKEN'),
                'proxy' => [
                    'use'  => env('CANVAS_API_MYDOMAIN_PRODUCTION_USE_HTTP_PROXY', 'false') == 'true',
                    'host' => env('CANVAS_API_MYDOMAIN_PRODUCTION_HTTP_PROXY_HOST'),
                    'port' => env('CANVAS_API_MYDOMAIN_PRODUCTION_HTTP_PROXY_PORT'),
                ],
            ],
            'beta' => [
                'class' => \App\CanvasApiConfigs\Mydomain\Beta::class,
                'host'  => env('CANVAS_API_MYDOMAIN_BETA_HOST'),
                'token' => env('CANVAS_API_MYDOMAIN_BETA_TOKEN'),
                'proxy' => [
                    'use'  => env('CANVAS_API_MYDOMAIN_BETA_USE_PROXY', 'false') == 'true',
                    'host' => env('CANVAS_API_MYDOMAIN_BETA_PROXY_HOST'),
                    'port' => env('CANVAS_API_MYDOMAIN_BETA_PROXY_PORT'),
                ],
            ],
            'test' => [
                'class' => \App\CanvasApiConfigs\Mydomain\Test::class,
                'host'  => env('CANVAS_API_MYDOMAIN_TEST_HOST'),
                'token' => env('CANVAS_API_MYDOMAIN_TEST_TOKEN'),
                'proxy' => [
                    'use'  => env('CANVAS_API_MYDOMAIN_TEST_USE_PROXY', 'false') == 'true',
                    'host' => env('CANVAS_API_MYDOMAIN_TEST_PROXY_HOST'),
                    'port' => env('CANVAS_API_MYDOMAIN_TEST_PROXY_PORT'),
                ],
            ],
        ]
    ],

    // caching

    'cache_active'    => env('CANVAS_API_CACHING', 'on') == 'on', // set to 'on' or 'off' in .env file
    'cache_minutes'   => env('CANVAS_API_CACHE_MINUTES', 10),

    // cache these specific GET requests by client class. use * to cache all
    'cacheable_calls' => [
//         'Uncgits\CanvasApi\Clients\Accounts' => [
//             'listAccounts',
//             'getSingleAccount'
//         ],
         'Uncgits\CanvasApi\Clients\Accounts' => ['*'],
         'Uncgits\CanvasApi\Clients\EnrollmentTerms' => ['*'],
         'Uncgits\CanvasApi\Clients\Users' => ['*']
    ],

];
