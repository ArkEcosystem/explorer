<?php

declare(strict_types=1);

return [

    'network' => env('EXPLORER_NETWORK', 'development'),

    'networks' => [
        'production' => [
            'name'             => env('EXPLORER_NETWORK_NAME', 'ARK Public Network'),
            'alias'            => env('EXPLORER_NETWORK_ALIAS', 'mainnet'),
            'currency'         => env('EXPLORER_NETWORK_CURRENCY', 'ARK'),
            'currencySymbol'   => env('EXPLORER_NETWORK_CURRENCY_SYMBOL', 'Ѧ'),
            'confirmations'    => env('EXPLORER_NETWORK_CONFIRMATIONS', 51),
            'knownWallets'     => env('EXPLORER_NETWORK_KNOWN_WALLETS', 'https://raw.githubusercontent.com/ArkEcosystem/common/master/mainnet/known-wallets-extended.json'),
            'canBeExchanged'   => env('EXPLORER_NETWORK_CAN_BE_EXCHANGED', true),
            'usesMarketsquare' => env('EXPLORER_NETWORK_USES_MARKETSQUARE', false),
            'epoch'            => env('EXPLORER_NETWORK_EPOCH', '2017-03-21T13:00:00.000Z'),
            'delegateCount'    => env('EXPLORER_NETWORK_DELEGATE_COUNT', 51),
            'blockTime'        => env('EXPLORER_NETWORK_BLOCK_TIME', 8),
            'blockReward'      => env('EXPLORER_NETWORK_BLOCK_REWARD', 2),
            'base58Prefix'     => env('EXPLORER_NETWORK_BASE58_PREFIX', 23),
        ],
        'development' => [
            'name'             => env('EXPLORER_NETWORK_NAME', 'ARK Development Network'),
            'alias'            => env('EXPLORER_NETWORK_ALIAS', 'devnet'),
            'currency'         => env('EXPLORER_NETWORK_CURRENCY', 'DARK'),
            'currencySymbol'   => env('EXPLORER_NETWORK_CURRENCY_SYMBOL', 'DѦ'),
            'confirmations'    => env('EXPLORER_NETWORK_CONFIRMATIONS', 51),
            'canBeExchanged'   => env('EXPLORER_NETWORK_CAN_BE_EXCHANGED', false),
            'usesMarketsquare' => env('EXPLORER_NETWORK_USES_MARKETSQUARE', false),
            'epoch'            => env('EXPLORER_NETWORK_EPOCH', '2017-03-21T13:00:00.000Z'),
            'delegateCount'    => env('EXPLORER_NETWORK_DELEGATE_COUNT', 51),
            'blockTime'        => env('EXPLORER_NETWORK_BLOCK_TIME', 8),
            'blockReward'      => env('EXPLORER_NETWORK_BLOCK_REWARD', 2),
            'base58Prefix'     => env('EXPLORER_NETWORK_BASE58_PREFIX', 30),
        ],
    ],

    'nodejs' => env('EXPLORER_NODEJS', '/usr/bin/node'),

];
