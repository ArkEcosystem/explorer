@props([
    'model',
    'wallet' => null,
])

<p>{{ $model->isMultiPayment() ? 'true' : 'false' }}</p>
<x-general.amount-fiat-tooltip
    :amount="$model->amountReceived($wallet?->address())"
    :fiat="$model->amountReceivedFiat($wallet?->address())"
    is-received
/>
