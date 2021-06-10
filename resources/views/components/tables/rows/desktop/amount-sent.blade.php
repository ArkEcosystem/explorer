@if($model->isMultiPayment())
    <x-general.amount-fiat-tooltip :amount="$model->amountExcludingMyself()" :fiat="$model->amountFiatExcludingMyself()" is-sent />

    <span data-tippy-content="Excluding <x-currency :currency='Network::currency()'>{{ $model->amountForMyself() }}</x-currency> sent to itself">
        <x-ark-icon name="info" />
    </span>
@else
    <x-general.amount-fiat-tooltip :amount="$model->amount()" :fiat="$model->amountFiat()" is-sent />
@endif

