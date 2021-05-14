<div>
    <div class="bg-theme-secondary-100 dark:bg-black">
        <div class="content-container-full-width md:py-8 md:px-10">
            <div class="flex flex-col space-y-5 w-full">
                <div class="flex justify-between items-center">
                    <div class="hidden text-2xl font-bold whitespace-nowrap text-theme-secondary-900 lg:block dark:text-theme-secondary-200">
                        @lang('general.search_explorer')
                    </div>

                    <livewire:network-status-block />
                </div>

                <div class="px-8 md:px-0">
                    <livewire:search-module :is-advanced="true" :type="$state['type']" />
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white border-t-20 border-theme-secondary-100 dark:border-black dark:bg-theme-secondary-900" id="results-list">
        <x-ark-container>
            <h1 class="header-2">@lang('pages.search_results.title')</h1>

            @if($results && $results->count())
                <div>
                    @if ($state['type'] === 'block')
                        <x-tables.blocks :blocks="$results" />
                    @endif

                    @if ($state['type'] === 'transaction')
                        <x-tables.transactions :transactions="$results" />
                    @endif

                    @if ($state['type'] === 'wallet')
                        <x-tables.wallets :wallets="$results" />
                    @endif
                </div>
            @else
                <x-general.no-results :text="trans('pages.search_results.no_results')" />
            @endif
        </x-ark-container>
    </div>

    <script>
        window.addEventListener('livewire:load', () => window.livewire.on('pageChanged', () => scrollToQuery('#results-list')));
    </script>
</div>
