@component('layouts.app', ['isLanding' => true, 'fullWidth' => true])

    @push('metatags')
        <meta property="og:title" content="@lang('metatags.block.title')" />
        <meta property="og:description" content="@lang('metatags.block.description')">
    @endpush

    @push('scripts')
        <script src="{{ mix('js/clipboard.js')}}"></script>
    @endpush

    @section('breadcrumbs')
        <x-general.breadcrumbs :crumbs="[
            ['route' => 'home', 'label' => trans('menus.home')],
            ['label' => trans('menus.block')],
        ]" />
    @endsection

    @section('content')
        <x-block.header :block="$block" />

        <x-details.grid>
            <x-grid.height :model="$block" />

            <x-grid.timestamp :model="$block" />

            <x-grid.reward :model="$block" />

            <x-grid.fee :model="$block" />

            <x-grid.confirmations :model="$block" without-border />
        </x-details.grid>

        @if($transactions->isNotEmpty())
            <div class="bg-white border-t-20 border-theme-secondary-100 dark:border-black dark:bg-theme-secondary-900">
                <div class="py-16 content-container md:px-8">
                    <div id="transaction-list" class="w-full">
                        <div class="relative flex items-end justify-between mb-8">
                            <h2 class="text-xl sm:text-2xl">@lang('pages.block.transactions')</h2>
                        </div>

                        <x-skeletons.transactions>
                            <x-transactions.table-desktop :transactions="$transactions" />

                            <x-transactions.table-mobile :transactions="$transactions" />
                        </x-skeletons.transactions>
                    </div>
                </div>
            </div>
        @endif
    @endsection

@endcomponent
