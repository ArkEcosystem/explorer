@component('layouts.app', ['isLanding' => true, 'fullWidth' => true])

    @section('content')
        <x-ark-container>
            <div x-cloak class="w-full">
                <div class="relative flex items-center justify-between">
                    <h2>@lang('pages.blocks.title')</h2>
                </div>

                <livewire:block-table />
            </div>
        </x-ark-container>
    @endsection

@endcomponent
