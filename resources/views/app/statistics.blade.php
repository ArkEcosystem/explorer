@component('layouts.app', ['isLanding' => true, 'fullWidth' => true])

    @section('content')
        <x-general.header>
            {{--@TODO: <livewire:stats-highlights />--}}
            <div class="w-full gap-5 flex overflow-x-auto md:overflow-x-hidden md:grid md:grid-cols-2 md:grid-rows-2 xl:grid-cols-4 xl:grid-rows-1">
                <x-general.card class="flex-shrink-0 min-w-80 sm:min-w-60" icon="app.stats-total-supply" title="Total Supply" value="155,558,312 ARK" />
                <x-general.card class="flex-shrink-0 min-w-80 sm:min-w-60" icon="app.stats-voting" title="Voting (74.08%)" value="84,235,364.45 ARK" />
                <x-general.card class="flex-shrink-0 min-w-80 sm:min-w-60" icon="app.stats-delegates" title="Registered Delegates" value="1,171" />
                <x-general.card class="flex-shrink-0 min-w-80 sm:min-w-60" icon="app.stats-wallets" title="Wallets" value="150,235" />
            </div>
        </x-general.header>

        <x-ark-container class="bg-white dark:bg-theme-secondary-900">
            {{--@TODO: <livewire:stats-insights />--}}
            {{--@TODO: <livewire:stats-chart />--}}
        </x-ark-container>
    @endsection

@endcomponent
