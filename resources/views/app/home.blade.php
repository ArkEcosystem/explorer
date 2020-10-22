@component('layouts.app', ['isLanding' => true, 'fullWidth' => true])

    @push('metatags')
        <meta property="og:title" content="@lang('metatags.home.title')" />
        <meta property="og:description" content="@lang('metatags.home.description')">
    @endpush

    @section('content')
        <x-general.search.header />

        <div class="flex-col justify-center hidden w-full space-y-10 sm:flex lg:flex-row lg:space-y-0">
            <x-charts.price :data="$prices" identifier="price" colours-scheme="#339A51" />
            <x-charts.price :data="$fees" identifier="fees" colours-scheme="#FFAE10" />

            <hr class="mt-12 border-t border-dashed text-theme-secondary-300 border-theme-secondary-300" />
        </div>

        <x-home.content />
    @endsection

@endcomponent
