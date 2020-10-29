<div>
    @lang('labels.fee')

    <x-general.loading-state.text :text="$model->fee()" />

    <x-general.amount-fiat-tooltip :amount="$model->fee()" :fiat="$model->feeFiat()" />
</div>
