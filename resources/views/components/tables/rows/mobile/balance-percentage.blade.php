<div>
    @lang('labels.balance_percentage')

    <x-general.loading-state.text :text="$model->balancePercentage()" />

        {{ $model->balancePercentage() }}
</div>
