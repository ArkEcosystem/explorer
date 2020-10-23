<div class="dark:bg-theme-secondary-900">
    <div class="flex-col py-16 space-y-6 content-container">
        <x-general.search.header-slim :title="trans('pages.transaction.title')" />

        <x-general.entity-header
            title="Transaction ID"
            value="58dc75dfd97709acd4a268e318ee7f53651fdc54294325c4a7a4bca08777558a"
        >
            <x-slot name="logo"><span class="text-lg font-medium">ID</span></x-slot>

            <x-slot name="bottom">
                <div class="grid grid-cols-1 gap-8 md:grid-cols-2 xl:grid-cols-4">
                    <x-general.entity-header-item title="Transaction Type" icon="app-transactions.transfer" text="Transfer" />
                    <x-general.entity-header-item title="Fee" icon="app-fee" text="0.09447035 ARK" />
                    <x-general.entity-header-item title="Amount" icon="app-votes" text="23,097.37265146 ARK" />
                    <x-general.entity-header-item title="Confirmations" icon="app-confirmations" text="512,189" />
                </div>
            </x-slot>
        </x-general.entity-header>
    </div>
</div>
