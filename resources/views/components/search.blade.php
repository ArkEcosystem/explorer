{{-- TODO: Tidy up fields - review compared to design to see if they can be improved --}}
<div
    x-data="{
        showAdvanced: {{ $isAdvanced ? 'true' : 'false' }},
        isMobileOpen: false,
        isFocused: false,
        searchType: '{{ $type ?? 'block' }}',
    }"
    @mobile-search.window="isMobileOpen = true"
    class="searchbar shadow-search-subtle rounded-b-lg"
    x-bind:class="{
        'search-mobile': isMobileOpen,
        'search-advanced': showAdvanced,
        'search-focused': isFocused,
    }"
    x-init="$watch('isMobileOpen', isMobileOpen => {
        const body = document.getElementsByTagName('body')[0];
        if (isMobileOpen) {
            body.style.overflow = 'hidden';
        } else {
            body.style.overflow = null;
        }
    })"
    @search-type-changed.window="searchType = $event.detail"
>
    <div
        :class="{
            'fixed inset-0 z-30 bg-black opacity-75 dark:opacity-50 dark:bg-theme-secondary-800 md:hidden': isMobileOpen
        }"
    ></div>

    <div :class="{ 'fixed inset-0 z-30 overflow-y-auto md:hidden pb-20': isMobileOpen }">
        <div class="search-container" @click.away="isMobileOpen = false">
            <div class="search-simple">
                <div class="flex-1 mr-8">
                    <input
                        type="text"
                        placeholder="@lang('forms.search.term_placeholder')"
                        class="hidden searchbar-input sm:block"
                        wire:model.defer="state.term"
                        wire:keydown.enter="performSearch"
                    />

                    <input
                        type="text"
                        placeholder="@lang('forms.search.term_placeholder_mobile')"
                        class="searchbar-input sm:hidden"
                        wire:model.defer="state.term"
                        wire:keydown.enter="performSearch"
                    />
                </div>

                <button
                    type="button"
                    class="hidden text-theme-secondary-900 mr-8 rounded  text-center transition-default font-normal hover:bg-theme-primary-100 dark:hover:bg-theme-secondary-800 dark:text-theme-secondary-600 md:block px-4 py-2"
                    @click="showAdvanced = !showAdvanced; isFocused = true"
                >
                    <span x-show="!showAdvanced">@lang('actions.advanced_search')</span>
                    <span x-show="showAdvanced" x-cloak>@lang('actions.hide_search')</span>
                </button>

                <button
                    type="button"
                    class="hidden button-primary md:block"
                    wire:click="performSearch"
                >
                    @lang('actions.find_it')
                </button>

                <div
                    class="cursor-pointer text-theme-primary-300 hover:text-theme-primary-400 dark:text-theme-secondary-500 dark:hover:text-theme-secondary-400 md:hidden"
                    wire:click="performSearch"
                >
                    <x-ark-icon name="search" />
                </div>
            </div>

            <div
                x-show="showAdvanced"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="opacity-0 transform"
                x-transition:enter-end="opacity-100 transform"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 transform"
                x-transition:leave-end="opacity-0 transform"
                x-cloak
            >
                <div class="search-advanced-options">
                    <x-general.search.advanced-option class="md:border-b" option-class="border-r" :title="trans('forms.search.type')">
                        <x-ark-rich-select
                            button-class="block w-full font-medium text-left bg-transparent text-theme-secondary-900 dark:text-theme-secondary-200"
                            initial-value="{{ $type ?? 'block' }}"
                            dispatch-event="search-type-changed"
                            wire:model.defer="state.type"
                            :options="[
                                'block' => __('forms.search.block'),
                                'transaction' => __('forms.search.transaction'),
                                'wallet' => __('forms.search.wallet'),
                            ]"
                        />
                    </x-general.search.advanced-option>

                    <x-search.block />
                    <x-search.transaction :transaction-options="$transactionOptions" :transaction-type="Arr::get($state, 'transactionType', 'all')" />
                    <x-search.wallet />
                </div>
            </div>

            <div
                 class="py-4 font-semibold text-center rounded-b-lg bg-theme-primary-100 text-theme-primary-600 dark:bg-theme-secondary-800 dark:text-theme-secondary-200 md:hidden"
                @click="showAdvanced = !showAdvanced"
            >
                <span x-show="!showAdvanced">@lang('actions.advanced_search')</span>
                <span x-show="showAdvanced">@lang('actions.hide_search')</span>
            </div>
        </div>
    </div>
</div>
