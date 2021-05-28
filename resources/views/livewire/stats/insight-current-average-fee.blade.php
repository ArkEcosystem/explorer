<div wire:poll.{{ $refreshInterval }}s>
    <x-stats.insight
        :title="$currentAverageFeeTitle"
        :value="$currentAverageFeeValue"
        :title2="$minFeeTitle"
        :value2="$minFeeValue"
        :title3="$maxFeeTitle"
        :value3="$maxFeeValue"
        :options="$options"
        wire:model="period"
    />
</div>
