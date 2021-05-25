@component('layouts.app', ['isLanding' => true, 'fullWidth' => true])

    @section('content')
        {{--highlights--}}

        <x-ark-container class="bg-white dark:bg-theme-secondary-900">
            <livewire:stats-insight />
            {{--@TODO: <livewire:stats-chart />--}}
        </x-ark-container>
    @endsection

@endcomponent
