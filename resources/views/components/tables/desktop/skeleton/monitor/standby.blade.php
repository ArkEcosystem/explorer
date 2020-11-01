@if (Network::usesMarketSquare())
    <x-table-skeleton
        device="desktop"
        :headers="[
            'general.delegates.rank'       => 'text',
            'general.delegates.name'       => 'text',
            'general.delegates.votes'      => 'number',
            'general.delegates.profile'    => 'text',
            'general.delegates.commission' => 'text'
        ]"
        :rows="[
            'text',
            'address',
            'number',
            'text',
            'text'
        ]"
    />
@else
    <x-table-skeleton
        device="desktop"
        :headers="[
            'general.delegates.rank'       => 'text',
            'general.delegates.name'       => 'text',
            'general.delegates.votes'      => 'number'
        ]"
        :rows="[
            'text',
            'address',
            'number'
        ]"
    />
@endif
