<div>
    @lang('labels.balance')

    <x-general.loading-state.text :text="$model->balance()" />

    <x-general.amount-fiat-tooltip :amount="$model->balance()" :fiat="$model->balanceFiat()" />
</div>
