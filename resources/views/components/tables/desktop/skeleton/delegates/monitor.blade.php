<x-table-skeleton
    class="block"
    device="desktop"
    :items="[
        'pages.delegates.order'      => 'text',
        'pages.delegates.name'       => 'address',
        'pages.delegates.forging_at' => [
            'type' => 'number',
            'responsive' => true,
            'breakpoint' => 'sm',
        ],
        'pages.delegates.status'     => [
            'type' => 'text',
            'lastOn' => 'md',
        ],
        'pages.delegates.block_id'   => [
            'type' => 'text',
            'responsive' => true,
            'breakpoint' => 'md',
            'align' => 'right',
        ]
    ]"
/>
