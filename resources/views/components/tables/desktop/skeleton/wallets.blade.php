<x-table-skeleton
    device="desktop"
    :headers="[
        'general.wallet.address' => 'address',
        'general.wallet.info'    => 'number',
        'general.wallet.balance' => 'number',
        'general.wallet.supply'  => 'number',
    ]"
    :rows="['address', 'text', 'number', 'number']"
/>
