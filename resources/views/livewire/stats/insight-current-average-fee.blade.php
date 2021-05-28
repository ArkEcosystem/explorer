<div wire:poll.{{ $refreshInterval }}s>
    <x-stats.insight
        :mainTitle="$currentAverageFeeTitle"
        :mainValue="$currentAverageFeeValue"
        :secondaryTitle="$minFeeTitle"
        :secondaryValue="$minFeeValue"
        :tertiaryTitle="$maxFeeTitle"
        :tertiaryValue="$maxFeeValue"
        :options="$options"
        wire:model="period"
    />
</div>
