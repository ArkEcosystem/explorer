@isset($useConfirmations)
    <x-table-skeleton
        device="desktop"
        :items="[
            'general.transaction.id'            => 'text',
            'general.transaction.timestamp'     => 'text',
            'general.transaction.sender'        => 'address',
            'general.transaction.recipient'     => 'address',
            'general.transaction.amount'        => 'number',
            'general.transaction.amount'        => [
                'name' => 'number',
                'lastOn' => 'xl',
            ],
            'general.transaction.fee' => [
                'name' => 'number',
                'responsive' => true,
                'breakpoint' => 'xl',
            ],
            'general.transaction.confirmations' => [
                'name' => 'number',
                'responsive' => true,
                'breakpoint' => 'xl',
            ]
        ]"
    />
@else
    <x-table-skeleton
        device="desktop"
        :items="[
            'general.transaction.id'            => 'text',
            'general.transaction.timestamp'     => 'text',
            'general.transaction.sender'        => 'address',
            'general.transaction.recipient'     => 'address',
            'general.transaction.amount'        => [
                'name' => 'number',
                'lastOn' => 'xl',
            ],
            'general.transaction.fee' => [
                'name' => 'number',
                'responsive' => true,
                'breakpoint' => 'xl',
            ],
        ]"
    />
@endif
