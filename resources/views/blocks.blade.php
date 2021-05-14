@component('layouts.app', ['isLanding' => true, 'fullWidth' => true])

    @section('content')
        <x-general.search.header />

        <div class="bg-white border-t-20 border-theme-secondary-100 dark:border-black dark:bg-theme-secondary-900">
            <x-ark-container>
                <div x-cloak class="w-full">
                    <div class="flex relative justify-between items-center">
                        <h2>@lang('pages.blocks.title')</h2>
                    </div>

                    <livewire:block-table />
                </div>
            </x-ark-container>
        </div>
    @endsection

@endcomponent
