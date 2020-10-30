<x-general.amount-fiat-tooltip is-sent>
    <x-slot name="amount">
        <x-currency>{{ $model->balance() }}</x-currency>
    </x-slot>

    <x-slot name="fiat">
        {{ $model->balanceFiat() }}
    </x-slot>
</x-general.amount-fiat-tooltip>
