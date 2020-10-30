<x-details.generic :title="trans('general.transaction.confirmations')" icon="app-confirmations" :without-border="$withoutBorder ?? false">
    <x-number>{{ $model->confirmations() }}</x-number>
</x-details.generic>
