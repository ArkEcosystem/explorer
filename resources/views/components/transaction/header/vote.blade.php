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
