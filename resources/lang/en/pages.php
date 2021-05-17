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

        'no_transaction_results'  => 'No :0 transactions could be found.',
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
        'amount'                => 'Amount',
        'smartbridge'           => 'Smartbridge',
        'vote_rank'             => '#:0',
        'productivity'          => 'Productivity',
        'productivity_tooltip'  => 'Success rate of validating blocks over the last 30 days.',
        'no_results'            => 'No :0 transactions could be found.',
        'qrcode'                => [
            'title'            => 'Send Funds',
            'description'      => 'Enter the amount you wish to transfer to this address and confirm.',
            'automatic_notice' => 'The QR-code is updated automatically, you do not need to press anything.',
            'specify_amount'   => 'Specify Amount',
            'send_from_wallet' => 'Send from wallet',
        ],
        'public_key' => [
            'title'       => 'Public Key',
        ],
        'delegate'              => [
            'title'            => 'Delegate :0',
            'rank'             => 'Rank',
            'status'           => 'Status',
            'commission'       => 'Commission',
            'payout_frequency' => 'Payout Frequency',
            'payout_minimum'   => 'Payout Minimum',
            'forged_total'     => 'Total Forged',
            'votes'            => 'Votes (:0)',
            'forged_blocks'    => 'Forged Blocks',
            'productivity'     => 'Productivity (30 Days)',
            'voters'           => 'Voters',
            'resigned'         => 'Resigned',
        ],
    ],

    'delegates' => [
        'title'      => 'Delegates',
        'active'     => 'Active',
        'standby'    => 'Standby',
        'resigned'   => 'Resigned',
        'order'      => 'Order',
        'name'       => 'Delegate Name',
        'forging_at' => 'Time to Forge',
        'status'     => 'Status',
        'block_id'   => 'Block Id',
        'success'    => 'Block Generated',
        'warning'    => 'Block Missed',
        'danger'     => ':0 Blocks Missed',
        'completed'  => 'Completed',
        'next'       => 'Next',
        'now'        => 'Now',
        'monitor'    => 'Monitor',
        'statistics' => [
            'delegate_registrations' => 'Delegate Registrations',
            'block_reward'           => 'Block Reward',
            'fees_collected'         => 'Fees Collected (24h)',
            'votes'                  => 'Current Votes',
            'block_count'            => 'Current Round',
            'transactions'           => 'Round Transactions',
            'current_delegate'       => 'Current',
            'next_delegate'          => 'Next',
            'blocks_generated'       => ':0/:1 Blocks',
        ],
        'info' => [
            'status'       => 'View the status of the last 5 blocks for a delegate. Latest blocks are displayed from right to left.',
            'productivity' => 'The productivity statistic is calculated over the previous 30 day period.',
        ],
    ],

    'blocks_by_wallet' => [
        'title'       => 'Forged Blocks',
        'table_title' => 'Block History',
        'no_results'  => 'Delegate :0 has not yet forged. Once he becomes active his blocks will appear here.',
    ],

    'voters_by_wallet' => [
        'title'      => 'Voting for Delegate',
        'subtitle'   => 'Voters',
        'no_results' => 'Delegate :0 has no voters yet. You can be the first!',
    ],

    'blocks' => [
        'title' => 'Blocks',
    ],

];
