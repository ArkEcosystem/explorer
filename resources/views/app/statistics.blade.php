@component('layouts.app', ['isLanding' => true, 'fullWidth' => true])

    @section('content')
        {{--highlights--}}

        <div class="bg-white dark:bg-theme-secondary-900">
            <x-ark-container>
                {{--insights--}}
                {{--chart--}}
            </x-ark-container>
        </div>
    @endsection

@endcomponent
