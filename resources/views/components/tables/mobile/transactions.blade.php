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
        <div class="table-list-mobile-row" wire:key="{{ Helpers::blend($transaction->id(), ...$params) }}">
            <x-tables.rows.mobile.transaction-id :model="$transaction" />

            <x-tables.rows.mobile.timestamp :model="$transaction" />

            <x-tables.rows.mobile.sender :model="$transaction" />

            <x-tables.rows.mobile.recipient :model="$transaction" />

            @if($useDirection)
                @if(($transaction->isSent($wallet->address()) || $isSent === true) && $isReceived !== true)
                    <x-tables.rows.mobile.amount-sent :model="$transaction" :exclude-itself="$excludeItself" />
                @else
                    <x-tables.rows.mobile.amount-received
                        :model="$transaction"
                        :wallet="$wallet"
                    />
                @endif
            @else
                <x-tables.rows.mobile.amount :model="$transaction" />
            @endif

            <x-tables.rows.mobile.fee :model="$transaction" />

            @isset($useConfirmations)
                <x-tables.rows.mobile.confirmations :model="$transaction" />
            @endisset
        </div>
    @endforeach
</div>
