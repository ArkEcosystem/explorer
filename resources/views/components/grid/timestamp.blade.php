<x-details.generic :title="trans('general.transaction.timestamp')" icon="app-timestamp" :without-border="$withoutBorder ?? false">
    {{ $model->timestamp() }}
</x-details.generic>
