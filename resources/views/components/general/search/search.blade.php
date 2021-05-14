<div
    x-data="{
        showAdvanced: true,
        showAdvancedMobile: false,
        searchType: '{{ $type ?? 'block' }}',
    }"
    @search-type-changed.window="searchType = $event.detail"
    class="w-full"
>
    <div class="flex flex-col bg-white rounded-lg dark:bg-theme-secondary-900">
        <x-general.search.search-input />

        <x-general.search.advanced-search
            :transaction-options="$transactionOptions"
            :type="$type ?? 'block'"
            :state="$state"
            x-cloak
            x-show="showAdvanced"
            class="hidden md:block"
        />

        <x-general.search.advanced-search
            :transaction-options="$transactionOptions"
            :type="$type ?? 'block'"
            :state="$state"
            x-show="showAdvancedMobile"
            class="md:hidden"
            x-cloak
        />

        <div
            class="py-4 font-semibold text-center rounded-b-lg bg-theme-primary-100 text-theme-primary-600 dark:bg-theme-secondary-800 dark:text-theme-secondary-200 md:hidden"
            @click="showAdvancedMobile = !showAdvancedMobile"
            x-cloak
        >
            <span x-show="!showAdvancedMobile">@lang('actions.advanced_search')</span>
            <span x-show="showAdvancedMobile">@lang('actions.hide_search')</span>
        </div>
    </div>
</div>
