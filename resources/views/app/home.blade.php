@component('layouts.app', ['isLanding' => true, 'fullWidth' => true])

    @push('metatags')
        <meta property="og:title" content="@lang('metatags.home.title')" />
        <meta property="og:description" content="@lang('metatags.home.description')">
    @endpush

    @section('content')
        <x-general.search.header />

        @if(Settings::usesCharts())
            <div class="hidden sm:flex content-container">
                <div class="flex flex-col w-full divide-y divide-dashed divide-theme-secondary-300 dark:divide-theme-secondary-700">
                    <div class="flex-col w-full pt-16 space-x-0 flex lg:flex-row lg:space-x-10">
                        @if(Settings::usesPriceChart())
                            <x-charts.price :data="$prices" identifier="price" colours-scheme="#339A51" />
                        @endif

                        @if(Settings::usesFeeChart())
                            <x-charts.price :data="$fees" identifier="fees" colours-scheme="#FFAE10" />
                        @endif
                    </div>

                    <div class="w-full mt-5 pt-8 mb-16 grid grid-cols-2 grid-flow-row xl:grid-cols-4 gap-6 gap-y-12 xl:gap-y-4">
                        <x-details-box :title="trans('pages.home.network-details.price')" :value="$aggregates['price'] . ' ' . 'BTC'" icon="app-price" />
                        <x-details-box :title="trans('pages.home.network-details.lifetime_transactions_volume')" :value="$aggregates['volume'] . ' ' . Network::currencySymbol()" icon="app-volume" />
                        <x-details-box :title="trans('pages.home.network-details.lifetime_transactions')" :value="$aggregates['transactionsCount']" icon="app-transactions-amount" />
                        <x-details-box :title="trans('pages.home.network-details.total_votes')" :value="$aggregates['votesCount'] . ' ' . Network::currencySymbol()" extra-value="74.08%" icon="app-votes" />
                    </div>
                </div>
            </div>
        @endif

        <x-home.content />
    @endsection

@endcomponent
