@isset($useConfirmations)
    <x-table-skeleton
        device="desktop"
        :items="[
            'general.transaction.id'            => 'text',
            'general.transaction.timestamp'     => 'text',
            'general.transaction.sender'        => 'address',
            'general.transaction.recipient'     => 'address',
            'general.transaction.amount'        => 'number',
            'general.transaction.fee'           => 'number',
            'general.transaction.confirmations' => 'number'
        ]"
        compact="{{ isset($compact) }}"
    />
@else
<x-table-skeleton
        device="desktop"
        :items="[
            'general.transaction.id'            => 'text',
            'general.transaction.timestamp'     => 'text',
            'general.transaction.sender'        => 'address',
            'general.transaction.recipient'     => 'address',
            'general.transaction.amount'        => 'number',
            'general.transaction.fee'           => 'number'
        ]"
        compact="{{ isset($compact) }}"
    />
@endif
