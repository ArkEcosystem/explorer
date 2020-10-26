<div x-data="{
    filterOpen: false,
    transactionTypeFilter: 'all',
    transactionTypeFilterLabel: 'All',
}" x-cloak>
    <x-ark-dropdown
        wrapper-class="transaction-filter-wrapper"
        dropdown-classes="transaction-filter-dropdown"
        button-class="transaction-filter-button"
        dropdown-property="filterOpen"
        :init-alpine="false"
    >
        @slot('button')
            <div class="space-x-2 transaction-filter-button-container">
                <div>
                    <span>@lang('general.transaction.type'):</span>

                    <span
                        x-text="transactionTypeFilterLabel"
                        class="text-theme-secondary-900 md:text-theme-secondary-700"
                    ></span>
                </div>

                <span
                    :class="{ 'rotate-180 md:bg-theme-primary-600 md:text-theme-secondary-100': filterOpen }"
                    class="transaction-filter-button-icon"
                >
                    @svg('chevron-down', 'w-6 h-6 md:h-3 md:w-2')
                </span>
            </div>
        @endslot

        <div class="items-center justify-center block py-3">
            <div
                class="cursor-pointer dropdown-entry text-theme-secondary-900"
                @click="window.livewire.emit('filterTransactionsByType', 'all'); transactionTypeFilter = 'all'; transactionTypeFilterLabel = '@lang('forms.search.transaction_types.all')'"
            >
                @lang('forms.search.transaction_types.all')
            </div>

            <div class="w-full border-b border-theme-secondary-300"></div>

            @foreach([
                'core' => [
                    'transfer',
                    'secondSignature',
                    'delegateRegistration',
                    'vote',
                    'voteCombination',
                    'multiSignature',
                    'ipfs',
                    'multiPayment',
                    'timelock',
                    'timelockClaim',
                    'timelockRefund',
                ],
                'magistrate' => [
                    'businessEntityRegistration',
                    'businessEntityResignation',
                    'businessEntityUpdate',
                    'delegateEntityRegistration',
                    'delegateEntityResignation',
                    'delegateEntityUpdate',
                    'delegateResignation',
                    'entityRegistration',
                    'entityResignation',
                    'entityUpdate',
                    'legacyBridgechainRegistration',
                    'legacyBridgechainResignation',
                    'legacyBridgechainUpdate',
                    'legacyBusinessRegistration',
                    'legacyBusinessResignation',
                    'legacyBusinessUpdate',
                    'moduleEntityRegistration',
                    'moduleEntityResignation',
                    'moduleEntityUpdate',
                    'pluginEntityRegistration',
                    'pluginEntityResignation',
                    'pluginEntityUpdate',
                    'productEntityRegistration',
                    'productEntityResignation',
                    'productEntityUpdate',
                ],
            ] as $typeGroup => $types)
                <span class="flex items-center w-full px-8 pt-8 text-sm font-bold leading-5 text-left text-theme-secondary-500">{{ ucfirst($typeGroup) }}</span>

                @foreach ($types as $type)
                    <div
                        class="cursor-pointer dropdown-entry text-theme-secondary-900"
                        @click="window.livewire.emit('filterTransactionsByType', '{{ $type }}'); transactionTypeFilter = '{{ $type }}'; transactionTypeFilterLabel = '@lang('forms.search.transaction_types.'.$type)'"
                    >
                        @lang('forms.search.transaction_types.'.$type)
                    </div>
                @endforeach

                @if (! $loop->last)
                    <div class="w-full border-b border-theme-secondary-300"></div>
                @endif
            @endforeach
        </div>
    </x-ark-dropdown>
</div>
