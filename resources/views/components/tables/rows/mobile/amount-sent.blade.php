<div class="items-center">
    @lang('labels.amount')


    <p>{{ $model->isMultiPayment() ? 'true' : 'false' }}</p>
    <x-general.amount-fiat-tooltip :amount="$model->amount()" :fiat="$model->amountFiat()" is-sent />
</div>
