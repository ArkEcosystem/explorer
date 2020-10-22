<div id="transaction-list" class="w-full">
    <x-transactions.table-desktop :transactions="$transactions" />

    <x-transactions.list-mobile :transactions="$transactions" />

    <x-general.pagination :results="$transactions" class="mt-8" />
</div>
