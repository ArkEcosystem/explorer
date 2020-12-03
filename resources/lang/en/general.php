<?php

declare(strict_types=1);

return [
    'address'          => 'Address',
    'beta_uppercase'   => 'BETA',
    'optional'         => 'Optional',
    'or'               => 'or',
    'filler'           => '',
    'height'           => 'Height',
    'network'          => 'Network',
    'supply'           => 'Supply',
    'market_cap'       => 'Market Cap',
    'search_explorer'  => 'Search Explorer',
    'verified_address' => 'Verified Address',
    'exchange'         => 'Exchange',
    'reload'           => 'Reload',
    'confirmed'        => 'Confirmed',
    'see_all'          => 'See all',
    'wallet_not_found' => '<span class="bg-theme-warning-100">:0</span> has no balance. <br/> <span class="text-base font-normal">Return to this page after the address has received a transaction.</span>',
    'more_details'     => 'For more :transactionType details',
    'learn_more'       => 'Learn more',
    'confirmations'    => ':count confirmation|:count confirmations',

    'block' => [
        'id'            => 'ID',
        'timestamp'     => 'Timestamp',
        'generated_by'  => 'Generated By',
        'height'        => 'Height',
        'transactions'  => 'Transactions',
        'tx'            => 'Tx',
        'amount'        => 'Amount',
        'fee'           => 'Fee',
        'reward'        => 'Reward',
        'confirmations' => 'Confirmations',
    ],

    'transaction' => [
        'id'                      => 'ID',
        'timestamp'               => 'Timestamp',
        'type'                    => 'Type',
        'sender'                  => 'Sender',
        'recipient'               => 'Recipient',
        'recipients'              => 'Recipients',
        'amount'                  => 'Amount',
        'fee'                     => 'Fee',
        'confirmations'           => 'Confirmations',
        'block_id'                => 'Block ID',
        'smartbridge'             => 'SmartBridge',
        'nonce'                   => 'Nonce',
        'multi_signature_address' => 'Multisignature Address',
        'participant'             => 'Participant #:0',
        'ipfs-hash'               => 'IPFS Hash',
        'well-confirmed'          => 'Well Confirmed',

        'types' => [
            'delegate-registration'        => 'Delegate Registration',
            'delegate-resignation'         => 'Delegate Resignation',
            'delegate-entity-registration' => 'Delegate Entity Registration',
            'delegate-entity-resignation'  => 'Delegate Entity Resignation',
            'delegate-entity-update'       => 'Delegate Entity Update',
            'bridgechain-registration'     => 'Bridgechain Registration',
            'bridgechain-resignation'      => 'Bridgechain Resignation',
            'bridgechain-update'           => 'Bridgechain Update',
            'business-registration'        => 'Business Registration',
            'business-resignation'         => 'Business Resignation',
            'business-update'              => 'Business Update',
            'business-entity-registration' => 'Business Entity Registration',
            'business-entity-resignation'  => 'Business Entity Resignation',
            'business-entity-update'       => 'Business Entity Update',
            'ipfs'                         => 'IPFS',
            'multi-payment'                => 'Multipayment',
            'module-registration'          => 'Module Registration',
            'module-resignation'           => 'Module Resignation',
            'module-update'                => 'Module Update',
            'vote-combination'             => 'Multivote',
            'multi-signature'              => 'Multisignature',
            'plugin-registration'          => 'Plugin Registration',
            'plugin-resignation'           => 'Plugin Resignation',
            'plugin-update'                => 'Plugin Update',
            'product-registration'         => 'Product Registration',
            'product-resignation'          => 'Product Resignation',
            'product-update'               => 'Product Update',
            'second-signature'             => 'Second Signature',
            'timelock'                     => 'Timelock',
            'timelock-claim'               => 'Timelock Claim',
            'timelock-refund'              => 'Timelock Refund',
            'transfer'                     => 'Transfer',
            'unvote'                       => 'Unvote',
            'vote'                         => 'Vote',
            'unknown'                      => 'Unknown',
        ],
    ],

    'wallet' => [
        'rank'    => 'Rank',
        'address' => 'Address',
        'info'    => 'Info',
        'balance' => 'Balance',
        'supply'  => 'Supply',
    ],

    'delegates' => [
        'id'           => 'ID',
        'rank'         => 'Rank',
        'name'         => 'Delegate Name',
        'status'       => 'Status',
        'votes'        => 'Votes',
        'profile'      => 'Profile',
        'commission'   => 'Commission',
        'productivity' => 'Productivity',
    ],
];
