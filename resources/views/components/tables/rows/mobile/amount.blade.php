<div>
    @lang('labels.amount')

    <x-general.loading-state.text :text="$model->amount()" />

    <x-general.amount-fiat-tooltip :amount="$model->amount()" :fiat="$model->amountFiat()" />
</div>
