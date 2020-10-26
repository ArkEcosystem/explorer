<?php

declare(strict_types=1);

return [

    'block' => [
        'title'              => 'Block Details',
        'block_id'           => 'Block ID',
        'generated_by'       => 'Generated By',
        'transaction_volumn' => 'Transaction Volumn',
        'transactions'       => 'Transactions',
        'total_rewards'      => 'Total Rewards',
    ],

    'home' => [
        'charts' => [
            'price'     => 'Price',
            'min_price' => 'Min Price',
            'max_price' => 'Max Price',
            'avg_price' => 'Avg Price',

            'fees'     => 'Fees',
            'min_fees' => 'Min Fees',
            'max_fees' => 'Max Fees',
            'avg_fees' => 'Avg Fees',

            'periods' => [
                'day'       => 'Day',
                'week'      => 'Week',
                'month'     => 'Month',
                'quarter'   => 'Quarter',
                'year'      => 'Year',
            ],
        ],

        'network-details' => [
            'price'                        => 'Price',
            'lifetime_transactions_volume' => 'Lifetime Transaction Volume',
            'lifetime_transactions'        => 'Lifetime Transactions',
            'total_votes'                  => 'Total Votes',
        ],

        'transactions_and_blocks' => 'Transaction & Blocks',
        'latest_transactions'     => 'Latest Transactions',
        'latest_blocks'           => 'Latest Blocks',
    ],

    'search_results' => [
        'title'      => 'Results',
        'no_results' => 'We could not find anything matching your search criteria, please try again!',
    ],

    'transaction' => [
        'title'            => 'Transaction Details',
        'transaction_id'   => 'Transaction ID',
        'transaction_type' => 'Transaction Type',
        'fee'              => 'Fee',
        'amount'           => 'Amount',
        'confirmations'    => 'Confirmations',
        'participants'     => 'Participants',
        'vote'             => 'Vote',
        'unvote'           => 'Unvote',
        'recipient_list'   => 'Recipient List',
    ],

    'transactions' => [
        'title' => 'Transactions',
    ],

    'wallets' => [
        'title' => 'Wallets',
    ],

    'wallet' => [
        'title'                 => 'Address Details',
        'address'               => 'Address',
        'transaction_history'   => 'Transaction History',
        'all_transactions'      => 'All History',
        'received_transactions' => 'Incoming',
        'sent_transactions'     => 'Outgoing',
        'registrations'         => 'Registrations',
        'voting_for'            => 'Voting For',
        'rank'                  => 'Rank',
        'commission'            => 'Commission',
        'balance'               => 'Balance',
        'hide_options'          => 'Hide Options',
        'show_options'          => 'Show Options',
        'amount'                => 'Amount',
        'smartbridge'           => 'Smartbridge',
        'qrcode'                => [
            'title'       => 'QR Code',
            'description' => 'Scan for address',
        ],
        'delegate'              => [
            'title'            => 'Delegate :0',
            'rank'             => 'Rank',
            'commission'       => 'Commission',
            'payout_frequency' => 'Payout Frequency',
            'payout_minimum'   => 'Payout Minimum',
            'forged_total'     => 'Forged Total',
            'votes'            => 'Votes :0',
            'forged_blocks'    => 'Forged Blocks',
            'productivity'     => 'Productivity',
        ],
    ],

    'monitor' => [
        'title'      => 'Delegate',
        'active'     => 'Active',
        'standby'    => 'Standby',
        'resigned'   => 'Resigned',
        'statistics' => [
            'delegate_registrations' => 'Delegate Registrations',
            'block_reward'           => 'Block Reward',
            'fees_collected'         => 'Fees Collected (24h)',
            'votes'                  => 'Current Votes',
        ],
    ],

];
