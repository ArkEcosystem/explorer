<div wire:poll.{{ $refreshInterval }}s>
    <x-stats.insight
        id="all-time-transactions"
        :mainTitle="$allTimeTransactionsTitle"
        :mainValue="$allTimeTransactionsValue"
        :secondaryTitle="$transactionsTitle"
        :secondaryValue="$transactionsValue"
        :chart="$chartValues"
        :chart-theme="$chartTheme"
        :options="$options"
        wire:model="period"
    />
</div>
