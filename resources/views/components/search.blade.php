{{-- TODO: Tidy up fields - review compared to design to see if they can be improved --}}
<div
    x-data="{
        showAdvanced: {{ $isAdvanced ? 'true' : 'false' }},
        isMobileOpen: false,
        isFocused: false,
        searchType: '{{ $type ?? 'block' }}',
    }"
    @mobile-search.window="isMobileOpen = true"
    class="searchbar @if ($isSlim ?? false) searchbar-slim @else shadow-lg rounded-b-lg @endif"
    x-bind:class="{
        'search-mobile': isMobileOpen,
        'search-advanced': showAdvanced,
        'search-focused': isFocused,
    }"
    @search-type-changed.window="searchType = $event.detail"
>
    <div
        class="fixed inset-0 z-30 overflow-y-auto opacity-75 bg-theme-secondary-900 md:hidden"
        @click="isMobileOpen = false"
    ></div>

    <div class="search-container ">
        <div class="search-simple">
            @if ($isSlim ?? false)
                <div
                    x-show="isFocused"
                    class="mr-4 cursor-pointer text-theme-primary-600 hover:text-theme-primary-700"
                    @click="showAdvanced = false; isFocused = false; $dispatch('search-slim-close')"
                >
                    <x-ark-icon name="close" size="md" />
                </div>
            @endif

            <div class="flex-1 mr-8">
                <input
                    type="text"
                    placeholder="@lang('forms.search.term_placeholder')"
                    class="hidden w-full dark:text-theme-secondary-700 dark:bg-theme-secondary-900 {{ ($isSlim ?? false) ? 'xl:block' : 'sm:block' }}"
                    wire:model.defer="state.term"
                    wire:keydown.enter="performSearch"
                    @if ($isSlim ?? false) x-on:focus="isFocused = true; $dispatch('search-slim-expand')" @endif
                />

                <input
                    type="text"
                    placeholder="@lang('forms.search.term_placeholder_mobile')"
                    class="w-full dark:text-theme-secondary-700 dark:bg-theme-secondary-900 {{ ($isSlim ?? false) ? 'xl:hidden' : 'sm:hidden' }}"
                    wire:model.defer="state.term"
                    wire:keydown.enter="performSearch"
                />
            </div>

            <span class="md:hidden text-theme-primary-300 dark:text-theme-secondary-600">
               <x-ark-icon name="search" />
            </span>

            <button
                type="button"
                class="hidden text-theme-secondary-900 mr-8 rounded text-center transition-default font-normal hover:bg-theme-primary-100 dark:hover:bg-theme-secondary-800 dark:text-theme-secondary-600 md:block {{ ($isSlim ?? false) ? 'px-2 py-1 -my-2' : 'px-4 py-2' }}"
                @click="showAdvanced = !showAdvanced; isFocused = true; $dispatch('search-slim-expand')"
            >
                <span x-show="!showAdvanced">@lang('actions.advanced_search')</span>
                <span x-show="showAdvanced" x-cloak>@lang('actions.hide_search')</span>
            </button>

            @unless($isSlim ?? false)
                <button
                    type="button"
                    class="hidden button-primary md:block"
                    wire:click="performSearch"
                >
                    @lang('actions.find_it')
                </button>
            @else
                <div
                    class="cursor-pointer text-theme-primary-300 hover:text-theme-primary-400 dark:text-theme-secondary-500 dark:hover:text-theme-secondary-400 @unless($isSlim ?? false) md:hidden @endif"
                    wire:click="performSearch"
                >
                    <x-ark-icon name="search" />
                </div>
            @endunless
        </div>

        <div
            x-show="showAdvanced"
            @unless($isSlim ?? false)
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="opacity-0 transform"
                x-transition:enter-end="opacity-100 transform"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 transform"
                x-transition:leave-end="opacity-0 transform"
            @endunless
            x-cloak
        >

            <div class="search-advanced-options" x-show="searchType === 'block'">
                <x-search.block />
            </div>

            <div class="search-advanced-options" x-show="searchType === 'transaction'">
                <x-search.transaction :transaction-options="$transactionOptions" :transaction-type="Arr::get($state, 'transactionType', 'all')" />
            </div>

            <div class="search-advanced-options" x-show="searchType === 'wallet'">
                <x-search.wallet />
            </div>
        </div>

        <div
            class="py-4 font-semibold text-center bg-theme-primary-100 text-theme-primary-600 dark:bg-theme-secondary-800 dark:text-theme-secondary-200 md:hidden"
            @click="showAdvanced = !showAdvanced"
        >
            <span x-show="!showAdvanced">@lang('actions.advanced_search')</span>
            <span x-show="showAdvanced">@lang('actions.hide_search')</span>
        </div>
    </div>
</div>
