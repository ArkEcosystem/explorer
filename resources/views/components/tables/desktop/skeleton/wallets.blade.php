<x-table-skeleton
    device="desktop"
    :items="[
        'general.wallet.address' => 'address',
        'general.wallet.info'    => 'text',
        'general.wallet.balance' => [
            'name' => 'number',
            'lastOn' => 'lg',
        ],
        'general.wallet.supply'  => [
            'name' => 'number',
            'responsive' => true,
        ],
    ]"
/>
