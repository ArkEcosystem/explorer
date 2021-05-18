@component('layouts.app', ['isLanding' => true, 'fullWidth' => true])

    @section('content')



        <div class="bg-theme-secondary-100 dark:bg-black">
            <div class="content-container-full-width md:py-16 md:px-8">

                <livewire:network-status-block />

            </div>
        </div>


        <div class="bg-white dark:bg-theme-secondary-900">
            <x-ark-container>
                <livewire:latest-records />
            </x-ark-container>
        </div>
    @endsection

@endcomponent
