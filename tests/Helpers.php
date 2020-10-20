<?php

declare(strict_types=1);

namespace Tests;

use App\Enums\CoreTransactionTypeEnum;
use App\Enums\MagistrateTransactionEntityActionEnum;
use App\Enums\MagistrateTransactionEntitySubTypeEnum;
use App\Enums\MagistrateTransactionEntityTypeEnum;
use App\Enums\MagistrateTransactionTypeEnum;
use App\Enums\TransactionTypeGroupEnum;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

function configureExplorerDatabase(): void
{
    $database = database_path('explorer.sqlite');

    File::delete($database);

    touch($database);

    Config::set('database.connections.explorer', [
        'driver'                  => 'sqlite',
        'url'                     => '',
        'database'                => $database,
        'prefix'                  => '',
        'foreign_key_constraints' => true,
    ]);

    Artisan::call('migrate', [
        '--database' => 'explorer',
        '--path'     => 'tests/migrations',
    ]);
}

function fakeKnownWallets(): void
{
    Http::fake([
        'github.com' => [
            [
                'type'    => 'team',
                'name'    => 'ACF Hot Wallet',
                'address' => 'AagJoLEnpXYkxYdYkmdDSNMLjjBkLJ6T67',
            ], [
                'type'    => 'team',
                'name'    => 'ACF Hot Wallet (old)',
                'address' => 'AWkBFnqvCF4jhqPSdE2HBPJiwaf67tgfGR',
            ], [
                'type'    => 'exchange',
                'name'    => 'Altilly',
                'address' => 'ANvR7ny44GrLy4NTfuVqjGYr4EAwK7vnkW',
            ], [
                'type'    => 'team',
                'name'    => 'ARK Bounty',
                'address' => 'AXxNbmaKspf9UqgKhfTRDdn89NidP2gXWh',
            ], [
                'type'    => 'team',
                'name'    => 'ARK Bounty Hot Wallet',
                'address' => 'AYCTHSZionfGoQsRnv5gECEuFWcZXS38gs',
            ], [
                'type'    => 'team',
                'name'    => 'ARK GitHub Bounty',
                'address' => 'AZmQJ2P9xg5j6VPZWjcTzWDD4w7Qww2KGX',
            ], [
                'type'    => 'team',
                'name'    => 'ARK Hot Wallet',
                'address' => 'ANkHGk5uZqNrKFNY5jtd4A88zzFR3LnJbe',
            ], [
                'type'    => 'team',
                'name'    => 'ARK Shield',
                'address' => 'AHJJ29sCdR5UNZjdz3BYeDpvvkZCGBjde9',
            ], [
                'type'    => 'team',
                'name'    => 'ARK Shield (old)',
                'address' => 'AdTyTzaXPtj1J1DzTgVksa9NYdUuXCRbm1',
            ], [
                'type'    => 'team',
                'name'    => 'ARK Team',
                'address' => 'AXzxJ8Ts3dQ2bvBR1tPE7GUee9iSEJb8HX',
            ], [
                'type'    => 'team',
                'name'    => 'ARK Team (old)',
                'address' => 'AUDud8tvyVZa67p3QY7XPRUTjRGnWQQ9Xv',
            ], [
                'type'    => 'exchange',
                'name'    => 'Binance',
                'address' => 'AFrPtEmzu6wdVpa2CnRDEKGQQMWgq8nE9V',
            ], [
                'type'    => 'exchange',
                'name'    => 'Binance Cold Wallet',
                'address' => 'AQkyi31gUbLuFp7ArgH9hUCewg22TkxWpk',
            ], [
                'type'    => 'exchange',
                'name'    => 'Binance Cold Wallet II',
                'address' => 'AdS7WvzqusoP759qRo6HDmUz2L34u4fMHz',
            ], [
                'type'    => 'exchange',
                'name'    => 'Binance Cold Wallet III',
                'address' => 'Aakg29vVhQhJ5nrsAHysTUqkTBVfmgBSXU',
            ], [
                'type'    => 'exchange',
                'name'    => 'Binance Cold Wallet IV',
                'address' => 'AazoqKvZQ7HKZMQ151qaWFk6nDY1E9faYu',
            ], [
                'type'    => 'exchange',
                'name'    => 'Bittrex',
                'address' => 'AUexKjGtgsSpVzPLs6jNMM6vJ6znEVTQWK',
            ], [
                'type'    => 'exchange',
                'name'    => 'Changelly',
                'address' => 'AdA5THjiVFAWhcMo5QyTKF1Y6d39bnPR2F',
            ], [
                'type'    => 'exchange',
                'name'    => 'COSS',
                'address' => 'AcPwcdDbrprJf8FNCE3dKZaTvPJT8y4Cqi',
            ], [
                'type'    => 'exchange',
                'name'    => 'Cryptopia',
                'address' => 'AJbmGnDAx9y91MQCDApyaqZhn6fBvYX9iJ',
            ], [
                'type'    => 'exchange',
                'name'    => 'Genesis Wallet',
                'address' => 'AewxfHQobSc49a4radHp74JZCGP8LRe4xA',
            ], [
                'type'    => 'exchange',
                'name'    => 'Livecoin',
                'address' => 'AcVHEfEmFJkgoyuNczpgyxEA3MZ747DRAu',
            ], [
                'type'    => 'exchange',
                'name'    => 'OKEx',
                'address' => 'AZcK6t1P9Z2ndiYvdVaS7srzYbTn5DHmck',
            ], [
                'type'    => 'exchange',
                'name'    => 'Upbit',
                'address' => 'ANQftoXeWoa9ud9q9dd2ZrUpuKinpdejAJ',
            ], [
                'type'    => 'exchange',
                'name'    => 'Upbit Cold Wallet',
                'address' => 'AdzbhuDTyhnfAqepZzVcVsgd1Ym6FgETuW',
            ], [
                'type'    => 'exchange',
                'name'    => 'Upbit Hot Wallet',
                'address' => 'AReY3W6nTv3utiG2em5nefKEsGQeqEVPN4',
            ],
        ],
    ]);
}

function transactionTypeSchemas(): array
{
    return [
        [
            'isTransfer',
            CoreTransactionTypeEnum::TRANSFER,
            TransactionTypeGroupEnum::CORE,
            [],
        ], [
            'isSecondSignature',
            CoreTransactionTypeEnum::SECOND_SIGNATURE,
            TransactionTypeGroupEnum::CORE,
            [],
        ], [
            'isDelegateRegistration',
            CoreTransactionTypeEnum::DELEGATE_REGISTRATION,
            TransactionTypeGroupEnum::CORE,
            [],
        ], [
            'isVote',
            CoreTransactionTypeEnum::VOTE,
            TransactionTypeGroupEnum::CORE,
            [],
        ], [
            'isMultiSignature',
            CoreTransactionTypeEnum::MULTI_SIGNATURE,
            TransactionTypeGroupEnum::CORE,
            [],
        ], [
            'isIpfs',
            CoreTransactionTypeEnum::IPFS,
            TransactionTypeGroupEnum::CORE,
            [],
        ], [
            'isDelegateResignation',
            CoreTransactionTypeEnum::DELEGATE_RESIGNATION,
            TransactionTypeGroupEnum::CORE,
            [],
        ], [
            'isMultiPayment',
            CoreTransactionTypeEnum::MULTI_PAYMENT,
            TransactionTypeGroupEnum::CORE,
            [],
        ], [
            'isTimelock',
            CoreTransactionTypeEnum::TIMELOCK,
            TransactionTypeGroupEnum::CORE,
            [],
        ], [
            'isTimelockClaim',
            CoreTransactionTypeEnum::TIMELOCK_CLAIM,
            TransactionTypeGroupEnum::CORE,
            [],
        ], [
            'isTimelockRefund',
            CoreTransactionTypeEnum::TIMELOCK_REFUND,
            TransactionTypeGroupEnum::CORE,
            [],
        ], [
            'isEntityRegistration',
            MagistrateTransactionTypeEnum::ENTITY,
            TransactionTypeGroupEnum::MAGISTRATE,
            [
                'action' => MagistrateTransactionEntityActionEnum::REGISTER,
            ],
        ], [
            'isEntityResignation',
            MagistrateTransactionTypeEnum::ENTITY,
            TransactionTypeGroupEnum::MAGISTRATE,
            [
                'action' => MagistrateTransactionEntityActionEnum::RESIGN,
            ],
        ], [
            'isEntityUpdate',
            MagistrateTransactionTypeEnum::ENTITY,
            TransactionTypeGroupEnum::MAGISTRATE,
            [
                'action' => MagistrateTransactionEntityActionEnum::UPDATE,
            ],
        ], [
            'isBusinessEntityRegistration',
            MagistrateTransactionTypeEnum::ENTITY,
            TransactionTypeGroupEnum::MAGISTRATE,
            [
                'type'    => MagistrateTransactionEntityTypeEnum::BUSINESS,
                'subType' => MagistrateTransactionEntitySubTypeEnum::NONE,
                'action'  => MagistrateTransactionEntityActionEnum::REGISTER,
            ],
        ], [
            'isBusinessEntityResignation',
            MagistrateTransactionTypeEnum::ENTITY,
            TransactionTypeGroupEnum::MAGISTRATE,
            [
                'type'    => MagistrateTransactionEntityTypeEnum::BUSINESS,
                'subType' => MagistrateTransactionEntitySubTypeEnum::NONE,
                'action'  => MagistrateTransactionEntityActionEnum::RESIGN,
            ],
        ], [
            'isBusinessEntityUpdate',
            MagistrateTransactionTypeEnum::ENTITY,
            TransactionTypeGroupEnum::MAGISTRATE,
            [
                'type'    => MagistrateTransactionEntityTypeEnum::BUSINESS,
                'subType' => MagistrateTransactionEntitySubTypeEnum::NONE,
                'action'  => MagistrateTransactionEntityActionEnum::UPDATE,
            ],
        ], [
            'isProductEntityRegistration',
            MagistrateTransactionTypeEnum::ENTITY,
            TransactionTypeGroupEnum::MAGISTRATE,
            [
                'type'    => MagistrateTransactionEntityTypeEnum::PRODUCT,
                'subType' => MagistrateTransactionEntitySubTypeEnum::NONE,
                'action'  => MagistrateTransactionEntityActionEnum::REGISTER,
            ],
        ], [
            'isProductEntityResignation',
            MagistrateTransactionTypeEnum::ENTITY,
            TransactionTypeGroupEnum::MAGISTRATE,
            [
                'type'    => MagistrateTransactionEntityTypeEnum::PRODUCT,
                'subType' => MagistrateTransactionEntitySubTypeEnum::NONE,
                'action'  => MagistrateTransactionEntityActionEnum::RESIGN,
            ],
        ], [
            'isProductEntityUpdate',
            MagistrateTransactionTypeEnum::ENTITY,
            TransactionTypeGroupEnum::MAGISTRATE,
            [
                'type'    => MagistrateTransactionEntityTypeEnum::PRODUCT,
                'subType' => MagistrateTransactionEntitySubTypeEnum::NONE,
                'action'  => MagistrateTransactionEntityActionEnum::UPDATE,
            ],
        ], [
            'isPluginEntityRegistration',
            MagistrateTransactionTypeEnum::ENTITY,
            TransactionTypeGroupEnum::MAGISTRATE,
            [
                'type'    => MagistrateTransactionEntityTypeEnum::PLUGIN,
                'subType' => MagistrateTransactionEntitySubTypeEnum::NONE,
                'action'  => MagistrateTransactionEntityActionEnum::REGISTER,
            ],
        ], [
            'isPluginEntityResignation',
            MagistrateTransactionTypeEnum::ENTITY,
            TransactionTypeGroupEnum::MAGISTRATE,
            [
                'type'    => MagistrateTransactionEntityTypeEnum::PLUGIN,
                'subType' => MagistrateTransactionEntitySubTypeEnum::NONE,
                'action'  => MagistrateTransactionEntityActionEnum::RESIGN,
            ],
        ], [
            'isPluginEntityUpdate',
            MagistrateTransactionTypeEnum::ENTITY,
            TransactionTypeGroupEnum::MAGISTRATE,
            [
                'type'    => MagistrateTransactionEntityTypeEnum::PLUGIN,
                'subType' => MagistrateTransactionEntitySubTypeEnum::NONE,
                'action'  => MagistrateTransactionEntityActionEnum::UPDATE,
            ],
        ], [
            'isModuleEntityRegistration',
            MagistrateTransactionTypeEnum::ENTITY,
            TransactionTypeGroupEnum::MAGISTRATE,
            [
                'type'    => MagistrateTransactionEntityTypeEnum::MODULE,
                'subType' => MagistrateTransactionEntitySubTypeEnum::NONE,
                'action'  => MagistrateTransactionEntityActionEnum::REGISTER,
            ],
        ], [
            'isModuleEntityResignation',
            MagistrateTransactionTypeEnum::ENTITY,
            TransactionTypeGroupEnum::MAGISTRATE,
            [
                'type'    => MagistrateTransactionEntityTypeEnum::MODULE,
                'subType' => MagistrateTransactionEntitySubTypeEnum::NONE,
                'action'  => MagistrateTransactionEntityActionEnum::RESIGN,
            ],
        ], [
            'isModuleEntityUpdate',
            MagistrateTransactionTypeEnum::ENTITY,
            TransactionTypeGroupEnum::MAGISTRATE,
            [
                'type'    => MagistrateTransactionEntityTypeEnum::MODULE,
                'subType' => MagistrateTransactionEntitySubTypeEnum::NONE,
                'action'  => MagistrateTransactionEntityActionEnum::UPDATE,
            ],
        ], [
            'isDelegateEntityRegistration',
            MagistrateTransactionTypeEnum::ENTITY,
            TransactionTypeGroupEnum::MAGISTRATE,
            [
                'type'    => MagistrateTransactionEntityTypeEnum::DELEGATE,
                'subType' => MagistrateTransactionEntitySubTypeEnum::NONE,
                'action'  => MagistrateTransactionEntityActionEnum::REGISTER,
            ],
        ], [
            'isDelegateEntityResignation',
            MagistrateTransactionTypeEnum::ENTITY,
            TransactionTypeGroupEnum::MAGISTRATE,
            [
                'type'    => MagistrateTransactionEntityTypeEnum::DELEGATE,
                'subType' => MagistrateTransactionEntitySubTypeEnum::NONE,
                'action'  => MagistrateTransactionEntityActionEnum::RESIGN,
            ],
        ], [
            'isDelegateEntityUpdate',
            MagistrateTransactionTypeEnum::ENTITY,
            TransactionTypeGroupEnum::MAGISTRATE,
            [
                'type'    => MagistrateTransactionEntityTypeEnum::DELEGATE,
                'subType' => MagistrateTransactionEntitySubTypeEnum::NONE,
                'action'  => MagistrateTransactionEntityActionEnum::UPDATE,
            ],
        ], [
            'isLegacyBusinessRegistration',
            MagistrateTransactionTypeEnum::BUSINESS_REGISTRATION,
            TransactionTypeGroupEnum::MAGISTRATE,
            [],
        ], [
            'isLegacyBusinessResignation',
            MagistrateTransactionTypeEnum::BUSINESS_RESIGNATION,
            TransactionTypeGroupEnum::MAGISTRATE,
            [],
        ], [
            'isLegacyBusinessUpdate',
            MagistrateTransactionTypeEnum::BUSINESS_UPDATE,
            TransactionTypeGroupEnum::MAGISTRATE,
            [],
        ], [
            'isLegacyBridgechainRegistration',
            MagistrateTransactionTypeEnum::BRIDGECHAIN_REGISTRATION,
            TransactionTypeGroupEnum::MAGISTRATE,
            [],
        ], [
            'isLegacyBridgechainResignation',
            MagistrateTransactionTypeEnum::BRIDGECHAIN_RESIGNATION,
            TransactionTypeGroupEnum::MAGISTRATE,
            [],
        ], [
            'isLegacyBridgechainUpdate',
            MagistrateTransactionTypeEnum::BRIDGECHAIN_UPDATE,
            TransactionTypeGroupEnum::MAGISTRATE,
            [],
        ],
    ];
}
