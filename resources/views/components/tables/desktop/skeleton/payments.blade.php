<x-table-skeleton
    device="desktop"
    :items="[
        'general.transaction.recipient' => [
            'name' => 'address',
            'lastOn' => 'md',
        ],
        'general.transaction.amount'  => [
            'name' => 'number',
            'responsive' => true,
            'breakpoint' => 'md',
        ],
    ]"
/>
