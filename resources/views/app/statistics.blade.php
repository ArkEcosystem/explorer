@component('layouts.app', ['isLanding' => true, 'fullWidth' => true])

    @section('content')
        <livewire:stats-highlights />

        <x-ark-container class="bg-white dark:bg-theme-secondary-900">
            <livewire:latest-records />
        </x-ark-container>
    @endsection

@endcomponent
