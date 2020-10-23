@component('layouts.app', ['isLanding' => true, 'fullWidth' => true])

    @push('metatags')
        <meta property="og:title" content="@lang('metatags.home.title')" />
        <meta property="og:description" content="@lang('metatags.home.description')">
    @endpush

    @section('content')
        <x-general.search.header />

        @if(Settings::usesCharts())
            <div class="content-container">
                <div class="flex flex-col w-full divide-y divide-dashed divide-theme-secondary-300 dark:divide-theme-secondary-700">
                    <div class="flex-col hidden w-full py-16 space-x-0 sm:flex lg:flex-row lg:space-x-10">
                        @if(Settings::usesPriceChart())
                            <x-charts.price :data="$prices" identifier="price" colours-scheme="#339A51" />
                        @endif

                        @if(Settings::usesFeeChart())
                            <x-charts.price :data="$fees" identifier="fees" colours-scheme="#FFAE10" />
                        @endif
                    </div>

                    <div class="flex-row justify-between hidden w-full mb-12 xl:flex">
                        <x-details-box title="Price" :value="$aggregates['price'] . ' ' . 'BTC'" icon="app-price" />
                        <x-details-box title="Lifetime Transaction Volume" :value="$aggregates['volume'] . ' ' . Network::currencySymbol()" icon="app-volume" />

                        <x-details-box title="Lifetime Transactions" :value="$aggregates['transactionsCount']" icon="app-transactions-amount" />
                        <x-details-box title="Total Votes" :value="$aggregates['votesCount'] . ' ' . Network::currencySymbol()" extra-value="74.08%" icon="app-votes" />
                    </div>
                    <div class="flex flex-row justify-between w-full mb-12 xl:hidden space-x-18">
                        <div class="space-y-12">
                            <x-details-box title="Price" :value="$aggregates['price'] . ' ' . 'BTC'" icon="app-price" />
                            <x-details-box title="Lifetime Transactions" :value="$aggregates['transactionsCount']" icon="app-transactions-amount" />
                        </div>
                        <div class="space-y-12">
                            <x-details-box title="Lifetime Transaction Volume" :value="$aggregates['volume'] . ' ' . Network::currencySymbol()" icon="app-volume" />
                            <x-details-box title="Total Votes" :value="$aggregates['votesCount'] . ' ' . Network::currencySymbol()" extra-value="74.08%" icon="app-votes" />
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <x-home.content />
    @endsection

@endcomponent
