<div wire:poll.{{ $refreshInterval }}s>
    <x-stats.insight
        id="all-time-fees-collected"
        :mainTitle="$allTimeFeesCollectedTitle"
        :mainValue="$allTimeFeesCollectedValue"
        :secondaryTitle="$feesTitle"
        :secondaryValue="$feesValue"
        :chart="$chartValues"
        :chart-theme="$chartTheme"
        :options="$options"
        wire:model="period"
    />
</div>
