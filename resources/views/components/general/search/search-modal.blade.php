<div>
    @if($modalShown)
        <div
            x-ref="modal"
            x-data="Modal.livewire({
                searchType: '{{ $type ?? 'block' }}',
                showAdvanced: false,
                searching: false,
                initSearch() {
                    this.$nextTick(() => {
                        this.focusSearchInput();
                    });
                },
                getScrollable() {
                    const { advancedSearch } = this.$refs;
                    return advancedSearch;
                },
                focusSearchInput(){
                    const { input, inputMobile } = this.$refs;
                    const style = window.getComputedStyle(input);
                    if (style.display === 'none') {
                        inputMobile.focus();
                    } else {
                        input.focus();
                    }
                },
            })"
            class="container fixed inset-0 z-50 flex flex-col w-full h-screen py-16 mx-auto overflow-auto outline-none md:overflow-visible md:px-8"
            tabindex="0"
            data-modal
            wire:keydown.escape="closeModal"
            x-init="
                init();
                initSearch();
            "
            @search-type-changed.window="searchType = $event.detail"
        >
            <div wire:click.self="closeModal" class="fixed inset-0 opacity-70 dark:opacity-80 bg-theme-secondary-900 dark:bg-theme-secondary-800"></div>

            <div class="relative flex flex-col w-full overflow-auto md:overflow-visible content-container-full-width md:px-8">
                <h2 class="px-8 mx-auto mb-8 text-4xl font-bold text-center text-white">@lang('pages.search.title')</h2>

                <div class="flex flex-col overflow-auto bg-white rounded-lg md:overflow-visible dark:bg-theme-secondary-900 mb-14">
                    <x-general.search.search-input />

                    <x-general.search.advanced-search
                        x-show="showAdvanced"
                        :transaction-options="$transactionOptions"
                        :type="$type ?? 'block'"
                        :state="$state"
                        class="overflow-auto md:overflow-visible"
                        x-cloak
                    />

                    <div
                        class="py-4 font-semibold text-center rounded-b-lg bg-theme-primary-100 text-theme-primary-600 dark:bg-theme-secondary-800 dark:text-theme-secondary-200 md:hidden"
                        @click="showAdvanced = !showAdvanced"
                    >
                        <span x-show="!showAdvanced">@lang('actions.advanced_search')</span>
                        <span x-show="showAdvanced">@lang('actions.hide_advanced')</span>
                    </div>
                </div>
            </div>
        </div>
   @endif
</div>

