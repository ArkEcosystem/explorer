<div wire:poll.{{ $refreshInterval }}s>
    <x-stats.insight
        :title="$allTimeTransactionsTitle"
        :value="$allTimeTransactionsValue"
        :title2="$transactionsTitle"
        :value2="$transactionsValue"
        :chart="$chartValues"
        :chart-color="$chartColor"
        :options="$options"
        wire:model="period"
    />
</div>
