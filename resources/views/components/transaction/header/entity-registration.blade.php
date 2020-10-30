<x-general.entity-header-item
    :title="trans('pages.transaction.amount')"
    icon="app-transactions-amount"
>
    <x-slot name="text">
        <x-currency>{{ $transaction->amount() }}</x-currency>
    </x-slot>
</x-general.entity-header-item>
