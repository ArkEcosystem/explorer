<div>
    @lang('labels.transaction_count')

    <x-general.loading-state.text :text="$model->transactionCount()" />

    {{ $model->transactionCount() }}
</div>
