<x-table-skeleton
    device="desktop"
    :items="[
        'general.delegates.rank'  => 'text',
        'general.delegates.name'  => [
            'name' => 'address',
            'lastOn' => 'lg',
        ],
        'general.delegates.votes'  => [
            'name' => 'number',
            'responsive' => true,
        ],
    ]"
/>
