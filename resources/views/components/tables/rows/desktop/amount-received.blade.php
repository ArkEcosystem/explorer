<x-general.amount-fiat-tooltip is-received>
    <x-slot name="amount">
        <x-currency>{{ $model->balance() }}</x-currency>
    </x-slot>

    <x-slot name="fiat">
        {{ $model->balanceFiat() }}
    </x-slot>
</x-general.amount-fiat-tooltip>
