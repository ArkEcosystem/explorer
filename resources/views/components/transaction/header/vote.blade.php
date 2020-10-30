<x-general.entity-header-item
    :title="trans('pages.transaction.transaction_type')"
    icon="app-transactions.transfer"
    :text="$transaction->typeLabel()"
/>

<x-general.entity-header-item
    :title="trans('pages.transaction.vote')"
    :avatar="$transaction->voted()->username()"
>
    <x-slot name="text">
        <a href="{{ route('wallet', $transaction->voted()->address()) }}" class="font-semibold link">
            {{ $transaction->voted()->username() }}
        </a>
    </x-slot>
</x-general.amount-fiat-tooltip>

<x-general.entity-header-item
    :title="trans('pages.transaction.fee')"
    icon="app-fee"
>
    <x-slot name="text">
        <x-currency>{{ $transaction->fee() }}</x-currency>
    </x-slot>
</x-general.amount-fiat-tooltip>

<x-general.entity-header-item
    :title="trans('pages.transaction.confirmations')"
    icon="app-confirmations"
>
    <x-slot name="text">
        <x-number>{{ $transaction->confirmations() }}</x-number>
    </x-slot>
</x-general.amount-fiat-tooltip>
