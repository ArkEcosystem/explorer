<div>
    <div class="bg-theme-secondary-100 dark:bg-black">
        <div class="content-container-full-width md:py-8 md:px-10">
            <div class="flex flex-col w-full space-y-5">
                <div class="flex items-center justify-between">
                    <div class="hidden text-2xl font-bold whitespace-nowrap text-theme-secondary-900 lg:block dark:text-theme-secondary-200">
                        @lang('general.search_explorer')
                    </div>

                    <livewire:network-status-block />
                </div>

                <div class="px-8 md:px-0">
                    <livewire:search-module :type="$state['type']" />
                </div>
            </div>
        </div>
    </div>

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

    <script>
        window.addEventListener('livewire:load', () => window.livewire.on('pageChanged', () => scrollToQuery('#results-list')));
    </script>
</div>
