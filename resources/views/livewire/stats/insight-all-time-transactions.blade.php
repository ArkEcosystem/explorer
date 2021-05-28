<div wire:poll.{{ $refreshInterval }}s>
    <x-stats.insight
        :mainTitle="$allTimeTransactionsTitle"
        :mainValue="$allTimeTransactionsValue"
        :secondaryTitle="$transactionsTitle"
        :secondaryValue="$transactionsValue"
        :chart="$chartValues"
        :chart-color="$chartColor"
        :options="$options"
        wire:model="period"
    />
</div>
