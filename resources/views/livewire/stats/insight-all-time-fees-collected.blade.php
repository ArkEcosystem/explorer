<div wire:poll.{{ $refreshInterval }}s>
    <x-stats.insight
        :mainTitle="$allTimeFeesCollectedTitle"
        :mainValue="$allTimeFeesCollectedValue"
        :secondaryTitle="$feesTitle"
        :secondaryValue="$feesValue"
        :chart="$chartValues"
        :chart-color="$chartColor"
        :options="$options"
        wire:model="period"
    />
</div>
