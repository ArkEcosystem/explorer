@if (Network::usesMarketSquare())
    <x-table-skeleton
        device="desktop"
        :headers="[
            'general.delegates.rank'         => 'text',
            'general.delegates.name'         => 'address',
            'general.delegates.status'       => 'text',
            'general.delegates.votes'        => 'number',
            'general.delegates.profile'      => 'text',
            'general.delegates.commission'   => 'text',
            'general.delegates.productivity' => 'number'
        ]"
        :rows="[
            'text',
            'address',
            'status',
            'number',
            'text',
            'text',
            'number'
        ]"
    />
@else
    <x-table-skeleton
        device="desktop"
        :headers="[
            'general.delegates.rank'         => 'text',
            'general.delegates.name'         => 'address',
            'general.delegates.status'       => 'text',
            'general.delegates.votes'        => 'number',
            'general.delegates.productivity' => 'number'
        ]"
        :rows="[
            'text',
            'address',
            'status',
            'number',
            'number'
        ]"
    />
@endif
