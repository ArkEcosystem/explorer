<x-table-skeleton
    device="desktop"
    :headers="[
        'general.block.id'           => 'filler',
        'general.block.timestamp'    => 'text',
        'general.block.generated_by' => 'address',
        'general.block.height'       => 'number',
        'general.block.transactions' => 'number',
        'general.block.amount'       => 'number',
        'general.block.fee'          => 'number',
    ]"
    :rows="['text', 'text', 'address', 'number', 'number', 'number', 'number']"
/>
