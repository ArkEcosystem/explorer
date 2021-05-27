@component('layouts.app', ['isLanding' => true, 'fullWidth' => true])
    @section('content')
        <livewire:network-status-block />

        <div class="bg-white dark:bg-theme-secondary-900">
            <x-ark-container>
                <livewire:latest-records />
            </x-ark-container>
        </div>
    @endsection
@endcomponent
