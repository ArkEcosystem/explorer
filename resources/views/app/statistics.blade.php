@component('layouts.app', ['isLanding' => true, 'fullWidth' => true])

    @section('content')
        <x-general.header>
            <livewire:stats-highlights />
        </x-general.header>

        <x-ark-container class="bg-white dark:bg-theme-secondary-900">
            {{--@TODO: <livewire:stats-insights />--}}
            {{--@TODO: <livewire:stats-chart />--}}
        </x-ark-container>
    @endsection

@endcomponent
