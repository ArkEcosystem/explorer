<?php

declare(strict_types=1);

return [

    'home' => [
        'title'       => ':name Blockchain Explorer',
        'description' => 'View transactions, blocks, nodes, and other network activity on the :name Blockchain.',
        'image'       => asset('images/metadata/explorer-preview.png'),
    ],

    'statistics' => [
        'title'       => 'Statistics & Analytics - :name Blockchain Explorer',
        'description' => 'View statistics and analyze network activity on the :name Blockchain.',
        'image'       => asset('images/metadata/explorer-preview.png'),
    ],

    'delegates' => [
        'title'       => 'Delegates - :name Blockchain Explorer',
        'description' => 'View Delegates (Validators) and their activity on the :name Blockchain.',
        'image'       => asset('images/metadata/explorer-preview.png'),
    ],

    'transactions' => [
        'title'       => 'Transactions - :name Blockchain Explorer',
        'description' => 'View transaction details from the :name Blockchain.',
        'image'       => asset('images/metadata/explorer-preview.png'),
    ],

    'transaction' => [
        'title'       => ':txid Transaction Details - :name Blockchain Explorer',
        'description' => 'View information and details for transaction with ID :txid on :name Blockchain.',
        'image'       => asset('images/metadata/explorer-preview.png'),
    ],

    'blocks' => [
        'title'       => 'Blocks - :name Blockchain Explorer',
        'description' => 'View details for blocks on the :name Blockchain.',
        'image'       => asset('images/metadata/explorer-preview.png'),
    ],

    'block' => [
        'title'       => ':blockID Block Details - :name Blockchain Explorer',
        'description' => 'View information and details for block with ID :blockID on :name Blockchain.',
        'image'       => asset('images/metadata/explorer-preview.png'),
    ],

    'wallets' => [
        'title'       => 'Wallets - :name Blockchain Explorer',
        'description' => 'View wallet address details on the :name Blockchain.',
        'image'       => asset('images/metadata/explorer-preview.png'),
    ],

    'wallet' => [
        'title'       => ':address Wallet Details - :name Blockchain Explorer',
        'description' => 'View balance, transaction history, and other details for :address on :name Blockchain.',
        'image'       => asset('images/metadata/explorer-preview.png'),
    ],

    'wallet-voters' => [
        'title'       => 'Voters of :address Wallet - :name Blockchain Explorer',
        'description' => 'View all voters of :address wallet on :name Blockchain.',
        'image'       => asset('images/metadata/explorer-preview.png'),
    ],

    'wallet-blocks' => [
        'title'       => 'Blocks Validated by :address Wallet - :name Blockchain Explorer',
        'description' => 'View blocks validated by :address wallet on :name Blockchain.',
        'image'       => asset('images/metadata/explorer-preview.png'),
    ],

    'search' => [
        'title'       => 'Search Results for :searchTerm - :name Blockchain Explorer',
        'description' => 'View search results for :searchTerm on :name Blockchain.',
        'image'       => asset('images/metadata/explorer-preview.png'),
    ],
];
