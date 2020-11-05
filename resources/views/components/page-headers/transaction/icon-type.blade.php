<x-general.entity-header-item :title="trans('pages.transaction.transaction_type')" icon="app-transactions.{{ $model->iconType() }}">
    @isset($asEntity)
        @lang('pages.transaction.'.$transaction->entityType())
    @else
        {{ $model->typeLabel() }}
    @endisset
</x-general.entity-header-item>
