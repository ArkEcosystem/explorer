<?php

declare(strict_types=1);

return [

    'block' => [
        'title'                 => 'Block Details',
        'block_id'              => 'Block ID',
        'generated_by'          => 'Generated By',
        'transaction_volume'    => 'Transaction Volume',
        'transactions'          => 'Transactions',
        'total_rewards'         => 'Total Rewards',
        'total_rewards_tooltip' => 'Includes :0 Block Reward',
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
        'title'                   => 'Transaction Details',
        'transaction_id'          => 'Transaction ID',
        'transaction_type'        => 'Transaction Type',
        'fee'                     => 'Fee',
        'amount'                  => 'Amount',
        'confirmations'           => 'Confirmations',
        'participants'            => 'Participants',
        'vote'                    => 'Vote',
        'unvote'                  => 'Unvote',
        'recipient_list'          => 'Recipient List',
        'musig_participants'      => 'M-of-N Multisig',
        'musig_participants_text' => ':0 of :1',
        'transaction_type'        => 'Transaction Type',
        'name'                    => 'Name',
        'category'                => 'Category',
        'ipfs_hash'               => 'IPFS Hash',
        'delegate_username'       => 'Delegate Name',
        // Type Labels (Different than in other places :facepalm:)
        'business-entity-registration'    => 'Registration (Business)',
        'business-entity-resignation'     => 'Resignation (Business)',
        'business-entity-update'          => 'Update (Business)',
        'delegate-entity-registration'    => 'Registration (Delegate)',
        'delegate-entity-resignation'     => 'Resignation (Delegate)',
        'delegate-entity-update'          => 'Update (Delegate)',
        'legacy-bridgechain-registration' => 'Registration (Legacy Bridgechain)',
        'legacy-bridgechain-resignation'  => 'Resignation (Legacy Bridgechain)',
        'legacy-bridgechain-update'       => 'Update (Legacy Bridgechain)',
        'legacy-business-registration'    => 'Registration (Legacy Business)',
        'legacy-business-resignation'     => 'Resignation (Legacy Business)',
        'legacy-business-update'          => 'Update (Legacy Business)',
        'module-entity-registration'      => 'Registration (Module)',
        'module-entity-resignation'       => 'Resignation (Module)',
        'module-entity-update'            => 'Update (Module)',
        'plugin-entity-registration'      => 'Registration (Plugin)',
        'plugin-entity-resignation'       => 'Resignation (Plugin)',
        'plugin-entity-update'            => 'Update (Plugin)',
        'product-entity-registration'     => 'Registration (Product)',
        'product-entity-resignation'      => 'Resignation (Product)',
        'product-entity-update'           => 'Update (Product)',
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
        'address_delegate'      => ':0 Address',
        'address_generator'     => 'Generated by :0',
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
        'vote_rank'             => '#:0',
        'qrcode'                => [
            'title'       => 'QR Code',
            'description' => 'Scan for address',
        ],
        'public_key' => [
            'title'       => 'Public Key',
        ],
        'delegate'              => [
            'title'            => 'Delegate :0',
            'rank'             => 'Rank',
            'commission'       => 'Commission',
            'payout_frequency' => 'Payout Frequency',
            'payout_minimum'   => 'Payout Minimum',
            'forged_total'     => 'Total Forged',
            'votes'            => 'Votes :0',
            'forged_blocks'    => 'Forged Blocks',
            'productivity'     => 'Productivity (30 Days)',
            'voters'           => 'Voters',
        ],
    ],

    'monitor' => [
        'title'      => 'Monitor',
        'active'     => 'Active',
        'standby'    => 'Standby',
        'resigned'   => 'Resigned',
        'order'      => 'Order',
        'name'       => 'Name',
        'forging_at' => 'Time to Forge',
        'status'     => 'Status',
        'block_id'   => 'Block Id',
        'success'    => 'Block Generated',
        'warning'    => 'Block Missed',
        'danger'     => '(:0) Blocks Missed',
        'completed'  => 'Completed',
        'next'       => 'Next',
        'now'        => 'Now',
        'statistics' => [
            'delegate_registrations' => 'Delegate Registrations',
            'block_reward'           => 'Block Reward',
            'fees_collected'         => 'Fees Collected (24h)',
            'votes'                  => 'Current Votes',
            'block_count'            => 'Current Round',
            'transactions'           => 'Round Transactions',
            'current_delegate'       => 'Current',
            'next_delegate'          => 'Next',
            'blocks_generated'       => '(:0/:1) Blocks Generated',
        ],
    ],

    'blocks_by_wallet' => [
        'title' => 'Block History',
    ],

    'voters_by_wallet' => [
        'title'    => 'Voting for Delegate',
        'subtitle' => 'Voters',
    ],

    'blocks' => [
        'title' => 'Blocks',
    ],

];
