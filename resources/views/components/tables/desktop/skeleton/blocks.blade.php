@isset($withoutGenerator)
    <x-table-skeleton
        device="desktop"
        :items="[
            'general.block.id'           => 'text',
            'general.block.timestamp'    => 'text',
            'general.block.height'       => 'number',
            'general.block.transactions' => 'number',
            'general.block.amount' => [
                'name' => 'number',
                'lastOn' => 'lg',
            ],
            'general.block.fee'  => [
                'name' => 'number',
                'responsive' => true,
            ],
        ]"
    />
@else
    <x-table-skeleton
        device="desktop"
        :items="[
            'general.block.id'           => 'text',
            'general.block.timestamp'    => 'text',
            'general.block.generated_by' => 'address',
            'general.block.height'       => 'number',
            'general.block.transactions' => 'number',
            'general.block.amount' => [
                'name' => 'number',
                'lastOn' => 'lg',
            ],
            'general.block.fee'  => [
                'name' => 'number',
                'responsive' => true,
            ],
        ]"
    />
@endif
