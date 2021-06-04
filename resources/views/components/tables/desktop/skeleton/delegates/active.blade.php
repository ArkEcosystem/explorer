<x-table-skeleton
    class="block"
    device="desktop"
    :items="[
        'general.delegates.rank'         => 'text',
        'general.delegates.name' => 'address-alt',
        'general.delegates.status'       => [
            'type' => 'status',
            'lastOn' => 'md',
        ],
        'general.delegates.votes'  => [
            'type' => 'number',
            'responsive' => true,
        ],
        'general.delegates.productivity' => [
            'type' => 'number',
            'responsive' => true,
            'breakpoint' => 'md',
        ]
    ]"
/>
