@props([
    'transactions',
    'wallet' => null,
    'useDirection' => false,
    'excludeItself' => false,
    'useConfirmations' => false,
    'isSent' => null,
    'isReceived' => null,
    'params' => [],
])

<div class="divide-y table-list-mobile">
    @foreach ($transactions as $transaction)
        <div class="table-list-mobile-row" wire:key="{{ Helpers::generateId('mobile', $transaction->id(), Settings::currency(), ...$params) }}">
            <x-tables.rows.mobile.transaction-id :model="$transaction" />

            <x-tables.rows.mobile.timestamp :model="$transaction" />

            <x-tables.rows.mobile.sender :model="$transaction" />

            <x-tables.rows.mobile.recipient :model="$transaction" />

            @isset($useDirection)
                @if($transaction->isSent($wallet->address()))
                    <x-tables.rows.mobile.amount-sent :model="$transaction" />
                @else
                    <x-tables.rows.mobile.amount-received
                        :model="$transaction"
                        :wallet="$wallet"
                    />
                @endif
            @else
                <x-tables.rows.mobile.amount :model="$transaction" />
            @endisset

            <x-tables.rows.mobile.fee :model="$transaction" />

            @isset($useConfirmations)
                <x-tables.rows.mobile.confirmations :model="$transaction" />
            @endisset
        </div>
    @endforeach
</div>
