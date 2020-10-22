@component('layouts.app', ['isLanding' => true, 'fullWidth' => true])

    @push('metatags')
        <meta property="og:title" content="@lang('metatags.home.title')" />
        <meta property="og:description" content="@lang('metatags.home.description')">
    @endpush

    @section('content')
        <x-general.search.header />

        <div class="content-container">
            <div class="flex-col hidden w-full py-16 space-x-0 sm:flex lg:flex-row lg:space-x-10">
                <x-charts.price :data="$prices" identifier="price" colours-scheme="#339A51" />
                <x-charts.price :data="$fees" identifier="fees" colours-scheme="#FFAE10" />
            </div>
        </div>

        <x-home.content />
    @endsection

@endcomponent
