<div x-data="{ dropdownOpen: false, selected: 'transactions', 'transactionsFilter': 'all' }" x-cloak class="w-full">
    <div class="relative flex items-center justify-between">
        <h2 class="text-3xl sm:text-4xl">@lang('pages.home.transactions_and_blocks')</h2>
        <div x-show="selected === 'transactions'">
            <x-ark-dropdown dropdown-classes="left-0 w-64 mt-3" button-class="w-64 h-10 dropdown-button"
                :init-alpine="false">
                @slot('button')
                <div
                    class="flex items-center justify-end w-full space-x-2 font-semibold flex-inline text-theme-secondary-700">
                    <div>
                        @lang('general.transaction.type'): <span x-text="transactionsFilter"></span>
                    </div>
                    <span :class="{ 'rotate-180': open }"
                        class="flex items-center justify-center w-4 h-4 transition duration-150 ease-in-out rounded-full bg-theme-primary-100">
                        @svg('chevron-up', 'h-3 w-2 text-theme-primary-600')
                    </span>
                </div>
                @endslot
                <div class="py-3">
                    @foreach(['all', 'transfer', 'vote', 'secondSignature', 'delegateRegistration',
                    'multiSignature', 'ipfs', 'multiPayment', 'delegateResignation', 'businessRegistration',
                    'businessUpdate', 'productEntityRegistration', 'productEntityResignation'] as $type)
                    <div class="cursor-pointer dropdown-entry" @click="applyFilter('{{ $type }}'); transactionsFilter = '{{ $type }}'">
                        {{ $type }}
                    </div>
                    @endforeach
                </div>
            </x-ark-dropdown>
        </div>
    </div>
    <div class="hidden tabs md:flex">
        <div
            class="tab-item transition-default"
            :class="{ 'tab-item-current': selected === 'transactions' }"
            @click="selected = 'transactions'"
        >
            @lang('pages.home.latest_transactions')
        </div>

        <div
            class="tab-item transition-default"
            :class="{ 'tab-item-current': selected === 'blocks' }"
            @click="selected = 'blocks'"
        >
            @lang('pages.home.latest_blocks')
        </div>
    </div>

    <div class="md:hidden">
        <x-ark-dropdown
            wrapper-class="relative w-full p-2 mb-8 border rounded-lg border-theme-secondary-300 dark:border-theme-secondary-800"
            button-class="w-full font-semibold text-left text-theme-secondary-900 dark:text-theme-secondary-200"
            dropdown-classes="left-0 w-full z-20"
            :init-alpine="false"
        >
            <x-slot name="button">
                <div class="flex items-center space-x-4">
                    @svg('menu-open', 'h-4 w-4')

                    <div x-show="selected === 'transactions'">@lang('pages.home.latest_transactions')</div>
                    <div x-show="selected === 'blocks'">@lang('pages.home.latest_blocks')</div>
                </div>
            </x-slot>

            <div class="p-4">
                <a @click="selected = 'transactions'" class="dropdown-entry">
                    @lang('pages.home.latest_transactions')
                </a>

                <a @click="selected = 'blocks'" class="dropdown-entry">
                    @lang('pages.home.latest_blocks')
                </a>
            </div>
        </x-ark-dropdown>
    </div>

    <div x-show="selected === 'transactions'">
        <livewire:transaction-table id="test" view-more transactionsFilter="all" />
    </div>

    <div x-show="selected === 'blocks'">
        <livewire:block-table view-more />
    </div>
</div>

<script>
    window.applyFilter = function(filter) {
        let element = document.getElementById('transaction-list');
        let component = window.livewire.find(element.getAttribute("wire:id"));

        component.transactionsFilter = filter;
    }
</script>
