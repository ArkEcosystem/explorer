<div x-data="{
    tabsOpen: false,
    selected: 'transactions',
    transactionTypeFilter: '{{ $state["type"] }}',
    transactionTypeFilterLabel: '@lang('forms.search.transaction_types.' . $state['type'])',
}" x-cloak class="w-full">

    <x-tabs.wrapper
        class="mb-4"
        default-selected="transactions"
        on-selected="(selected) => $wire.set('state.selected', 'transactions')"
    >
        <x-tabs.tab name="transactions">
            @lang('pages.home.latest_transactions')
        </x-tabs.tab>

        <x-tabs.tab name="blocks">
            @lang('pages.home.latest_blocks')
        </x-tabs.tab>

        <x-slot name="right">
            <div x-show="selected === 'transactions'">
                <x-transaction-table-filter :type="$state['type']"/>
            </div>
        </x-slot>
    </x-tabs.wrapper>


    <div class="md:hidden">
        <x-ark-dropdown
            wrapper-class="relative w-full p-2 mb-8 border rounded-lg border-theme-secondary-300 dark:border-theme-secondary-800"
            button-class="w-full p-3 font-semibold text-left text-theme-secondary-900 dark:text-theme-secondary-200"
            dropdown-classes="left-0 w-full z-20"
            :init-alpine="false"
            dropdown-property="tabsOpen"
        >
            <x-slot name="button">
                <div class="flex items-center space-x-4">
                    <div>
                        <div x-show="tabsOpen !== true">
                            <x-ark-icon name="menu" size="sm" />
                        </div>

                        <div x-show="tabsOpen === true">
                            <x-ark-icon name="menu-show" size="sm" />
                        </div>
                    </div>

                    <div x-show="selected === 'transactions'">@lang('pages.home.latest_transactions')</div>
                    <div x-show="selected === 'blocks'">@lang('pages.home.latest_blocks')</div>
                </div>
            </x-slot>

            <div class="p-4">
                <a wire:click="$set('state.selected', 'transactions')" @click="selected = 'transactions'" class="dropdown-entry">
                    @lang('pages.home.latest_transactions')
                </a>

                <a wire:click="$set('state.selected', 'blocks')" @click="selected = 'blocks'" class="dropdown-entry">
                    @lang('pages.home.latest_blocks')
                </a>
            </div>
        </x-ark-dropdown>
    </div>

    @if($state['selected'] === 'blocks')
        <div id="block-list" class="w-full">
            @if($blocks->isEmpty())
                <div wire:poll="pollBlocks" wire:key="poll_blocks_skeleton">
                    <x-tables.desktop.skeleton.blocks />

                    <x-tables.mobile.skeleton.blocks />
                </div>
            @else
                <div wire:poll.{{ Network::blockTime() }}s="pollBlocks" wire:key="poll_blocks_real">
                    <x-tables.desktop.blocks :blocks="$blocks" />

                    <x-tables.mobile.blocks :blocks="$blocks" />

                    @if(count($blocks) === 15)
                        <div class="pt-4 mt-8 border-t border-theme-secondary-300 dark:border-theme-secondary-800 md:mt-0 md:border-dashed">
                            <a href="{{ route('blocks', ['page' => 2]) }}" class="w-full button-secondary">@lang('actions.view_all')</a>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    @else
        <div id="transaction-list" class="w-full">
            @if($transactions->isEmpty())
                @if($state['type'] !== 'all')
                    <div wire:poll.{{ Network::blockTime() }}s="pollTransactions" wire:key="poll_transactions_empty">
                        <x-general.no-results :text="trans('pages.home.no_transaction_results', [trans('forms.search.transaction_types.'.$state['type'])])" />
                    </div>
                @else
                    <div wire:poll="pollTransactions" wire:key="poll_transactions_skeleton">
                        <x-tables.desktop.skeleton.transactions />

                        <x-tables.mobile.skeleton.transactions />
                    </div>
                @endif
            @else
                <div wire:poll.{{ Network::blockTime() }}s="pollTransactions" wire:key="poll_transactions_real">
                    <x-tables.desktop.transactions :transactions="$transactions" />

                    <x-tables.mobile.transactions :transactions="$transactions" />

                    @if(count($transactions) === 15)
                        <div class="pt-4 mt-8 border-t border-theme-secondary-300 dark:border-theme-secondary-800 md:mt-0 md:border-dashed">
                            <a href="{{ route('transactions', ['page' => 2, 'state[type]' => $state['type']]) }}" class="w-full button-secondary">@lang('actions.view_all')</a>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    @endif
</div>
