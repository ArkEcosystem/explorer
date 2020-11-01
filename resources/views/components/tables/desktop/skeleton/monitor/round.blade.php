<x-table-skeleton
    device="desktop"
    :headers="[
        'pages.monitor.order'      => 'text',
        'pages.monitor.name'       => 'address',
        'pages.monitor.forging_at' => 'number',
        'pages.monitor.status'     => 'text',
        'pages.monitor.block_id'   => 'text',
    ]"
    :rows="[
        'text',
        'address',
        'number',
        'text',
        'text',
    ]"
/>
