<div wire:poll.{{ $refreshInterval }}s>
    <x-stats.insight
        :title="$allTimeFeesCollectedTitle"
        :value="$allTimeFeesCollectedValue"
        :title2="$feesTitle"
        :value2="$feesValue"
        :chart="$chartValues"
        :chart-color="$chartColor"
        :options="$options"
        wire:model="period"
    />
</div>
