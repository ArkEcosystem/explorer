@component('layouts.app', ['isLanding' => true, 'fullWidth' => true])

    @section('content')
        <x-general.header class="overflow-auto">
            <div class="px-8 md:w-full">
                <livewire:stats-highlights />
            </div>
        </x-general.header>

        <x-ark-container class="bg-white dark:bg-theme-secondary-900">
            <x-stats.insights-wrapper>
                <livewire:stats.insight-all-time-transactions />
                <livewire:stats.insight-current-average-fee />
                <livewire:stats.insight-all-time-fees-collected />
            </x-stats.insights-wrapper>

            {{--@TODO: <livewire:stats-chart />--}}
        </x-ark-container>
    @endsection

@endcomponent
