<div x-data="{
    filterOpen: false,
    transactionTypeFilter: '{{ $type }}',
    transactionTypeFilterLabel: '@lang('forms.search.transaction_types.' . $type)',
}" x-cloak>
    <x-ark-dropdown
        wrapper-class="block"
        dropdown-classes="right-0 w-full mt-3 dark:bg-theme-secondary-900 md:w-84"
        button-class="w-full px-8 font-semibold text-left text-theme-secondary-900 dark:text-theme-secondary-200 md:items-end"
        dropdown-property="filterOpen"
        :init-alpine="false"
    >
        @slot('button')
            <div class="flex items-center justify-between w-full space-x-2 font-semibold text-theme-secondary-500 md:justify-end md:text-theme-secondary-700">
                <div>
                    <span class="text-theme-secondary-500 dark:text-theme-secondary-600">@lang('general.transaction.type'):</span>

                    <span
                        x-text="transactionTypeFilterLabel"
                        class="whitespace-nowrap text-theme-secondary-900 md:text-theme-secondary-700 dark:text-theme-secondary-200"
                    ></span>
                </div>

                <span
                    :class="{ 'rotate-180 md:bg-theme-primary-600 md:text-theme-secondary-100': filterOpen }"
                    class="flex items-center justify-center w-6 h-6 transition duration-150 ease-in-out rounded-full text-theme-secondary-400 dark:bg-theme-secondary-800 dark:text-theme-secondary-200 md:w-4 md:h-4 md:bg-theme-primary-100 md:text-theme-primary-600"
                >
                    <x-ark-icon name="chevron-down" size="xs" class="md:h-3 md:w-2" />
                </span>
            </div>
        @endslot

        <div class="items-center justify-center block h-64 py-3 overflow-y-scroll dropdown-scrolling md:h-72">
            @foreach([
                'all',
                'transfer',
                'secondSignature',
                'delegateRegistration',
                'vote',
                'voteCombination',
                'multiSignature',
                'ipfs',
                'multiPayment',
                'delegateResignation',
                'timelock',
                'timelockClaim',
                'timelockRefund',
                'magistrate',
            ] as $type)
                <div
                    class="cursor-pointer dropdown-entry text-theme-secondary-900 dark:text-theme-secondary-200"
                    :class="{
                        'dropdown-entry-selected': transactionTypeFilter === '{{ $type }}'
                    }"
                    @click="window.livewire.emit('filterTransactionsByType', '{{ $type }}'); transactionTypeFilter = '{{ $type }}'; transactionTypeFilterLabel = '@lang('forms.search.transaction_types.'.$type)'"
                >
                    @lang('forms.search.transaction_types.'.$type)
                </div>

            @endforeach
        </div>
    </x-ark-dropdown>
</div>
