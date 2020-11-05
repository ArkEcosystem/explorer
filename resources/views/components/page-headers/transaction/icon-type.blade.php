<x-general.entity-header-item
    :title="trans('pages.transaction.transaction_type')"
    icon="app-transactions.{{ $model->iconType() }}"
    :text="$model->typeLabel()"
/>
