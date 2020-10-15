<?php

return [

    'network' => env('EXPLORER_NETWORK', 'ark.development'),

    'networks' => [

        'ark' => [

            'production' => [
                'driver' => \App\Services\Blockchain\Networks\ARK\Production::class,
            ],

            'development' => [
                'driver' => \App\Services\Blockchain\Networks\ARK\Development::class,
            ],

        ],

    ],

];
