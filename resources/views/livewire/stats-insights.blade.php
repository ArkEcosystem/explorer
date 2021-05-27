<div class="grid grid-cols-1 grid-rows-3 gap-5 xl:grid-cols-3 xl:grid-rows-1" wire:poll.60s>
    <x-stats.insight
        wire:model="$selected"
        title="All-Time Transactions"
        value="321,634,035"
        title2="All-Time Transactions"
        value2="321,634,035"
        title3="All-Time Transactions"
        value3="321,634,035"
        :options="[
            'items' => [
                'day' => 'Day',
                'week' => 'Week',
                'month' => 'Month',
                'year' => 'Year',
                'all-time' => 'All-Time',
            ],
            'selected' => 'week',
        ]"
    />

{{--    <x-stats.insight />--}}

{{--    <x-stats.insight />--}}
</div>
