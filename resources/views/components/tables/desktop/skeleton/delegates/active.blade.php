<x-table-skeleton
    device="desktop"
    :items="[
        'general.delegates.rank'         => 'text',
        'general.delegates.name'         => 'address',
        'general.delegates.status'       => 'status',
        'general.delegates.votes'  => [
            'name' => 'number',
            'responsive' => true,
        ],
        'general.delegates.productivity' => 'number'
    ]"
/>
