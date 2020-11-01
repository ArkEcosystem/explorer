@isset($useConfirmations)
    <x-table-skeleton
        device="desktop"
        :headers="[
            'general.transaction.id'            => 'filler',
            'general.transaction.timestamp'     => 'text',
            'general.transaction.sender'        => 'address',
            'general.transaction.recipient'     => 'address',
            'general.transaction.amount'        => 'number',
            'general.transaction.fee'           => 'number',
            'general.transaction.confirmations' => 'number'
        ]"
        :rows="[
            'text',
            'text',
            'address',
            'address',
            'number',
            'number',
            'number'
        ]"
    />
@else
<x-table-skeleton
        device="desktop"
        :headers="[
            'general.transaction.id'            => 'filler',
            'general.transaction.timestamp'     => 'text',
            'general.transaction.sender'        => 'address',
            'general.transaction.recipient'     => 'address',
            'general.transaction.amount'        => 'number',
            'general.transaction.fee'           => 'number'
        ]"
        :rows="[
            'text',
            'text',
            'address',
            'address',
            'number',
            'number'
        ]"
    />
@endif
