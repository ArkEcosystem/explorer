<x-general.entity-header-item
    :title="trans('pages.transaction.amount')"
    icon="app-transactions-amount"
>
    <x-slot name="text">
        <x-currency>{{ $transaction->amount() }}</x-currency>
    </x-slot>
</x-general.entity-header-item>

<x-general.entity-header-item
    :title="trans('pages.transaction.fee')"
    icon="app-fee"
>
    <x-slot name="text">
        <x-currency>{{ $transaction->fee() }}</x-currency>
    </x-slot>
</x-general.entity-header-item>

<x-general.entity-header-item
    :title="trans('pages.transaction.confirmations')"
    icon="app-confirmations"
>
    <x-slot name="text">
        <x-number>{{ $transaction->confirmations() }}</x-number>
    </x-slot>
</x-general.entity-header-item>
