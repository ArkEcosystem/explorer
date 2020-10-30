<x-general.entity-header-item
    :title="trans('pages.transaction.vote')"
    :avatar="$transaction->unvoted()->username()"
>
    <x-slot name="text">
        <a href="{{ route('wallet', $transaction->unvoted()->address()) }}" class="font-semibold link">
            {{ $transaction->unvoted()->username() }}
        </a>
    </x-slot>
</x-general.amount-fiat-tooltip>
