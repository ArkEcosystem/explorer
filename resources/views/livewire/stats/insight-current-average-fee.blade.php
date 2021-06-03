<div wire:poll.{{ $refreshInterval }}s>
    <x-stats.insight
        id="current-average-fee"
        :mainTitle="$currentAverageFeeTitle"
        :mainValue="$currentAverageFeeValue"
        :secondaryTitle="$minFeeTitle"
        :secondaryValue="$minFeeValue"
        :tertiaryTitle="$maxFeeTitle"
        :tertiaryValue="$maxFeeValue"
        :options="$options"
        :selected="$period"
        model="period"
    />
</div>
