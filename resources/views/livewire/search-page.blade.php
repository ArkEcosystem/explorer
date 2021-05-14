<div>
    <div class="bg-theme-secondary-100 dark:bg-black">
        <div class="w-full p-8 content-container-full-width">
            <livewire:search-module :type="$state['type']" />
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
