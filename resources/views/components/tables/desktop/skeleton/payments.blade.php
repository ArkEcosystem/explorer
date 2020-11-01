<x-table-skeleton
    device="desktop"
    :headers="[
        'general.transaction.recipient' => 'address',
        'general.transaction.amount'    => 'number',
    ]"
    :rows="['text', 'number']"
/>
