@if (Network::usesMarketSquare())
    <x-table-skeleton
        device="desktop"
        :items="[
            'general.delegates.rank'       => 'text',
            'general.delegates.name'       => 'adress',
            'general.delegates.votes' => [
                'name' => 'number',
                'responsive' => true,
            ],
            'general.delegates.profile' => [
                'name' => 'text',
                'lastOn' => 'xl',
            ],
            'general.delegates.commission'  => [
                'name' => 'text',
                'responsive' => true,
                'breakpoint' => 'xl',
            ],
        ]"
    />
@else
    <x-table-skeleton
        device="desktop"
        :items="[
            'general.delegates.rank'  => 'text',
            'general.delegates.name' => [
                'name' => 'address',
                'lastOn' => 'lg',
            ],
            'general.delegates.votes' => [
                'name' => 'number',
                'responsive' => true,
            ],
        ]"
    />
@endif
