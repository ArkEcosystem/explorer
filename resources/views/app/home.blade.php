@component('layouts.app', ['isLanding' => true, 'fullWidth' => true])
    @section('content')
        <div class="bg-white dark:bg-theme-secondary-900">
            <x-ark-container>
                <livewire:latest-records />
            </x-ark-container>
        </div>
    @endsection
@endcomponent
