<div x-data="{ tab: 'transactions' }" class="w-full">
    <div class="tabs space-x-8">
        <div class="tab-item" :class="{ 'tab-item-current': tab === 'transactions' }" @click="tab = 'transactions'">
            @lang('pages.home.latest_transactions')
        </div>

        <div class="tab-item" :class="{ 'tab-item-current': tab === 'blocks' }" @click="tab = 'blocks'">
            @lang('pages.home.latest_blocks')
        </div>
    </div>

    <div x-show="tab === 'transactions'">
        <livewire:transaction-table view-more />
    </div>

    <div x-show="tab === 'blocks'">
        <livewire:block-table view-more />
    </div>
</div>
