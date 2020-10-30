<x-details.generic :title="trans('general.transaction.smartbridge')" icon="app-smartbridge" :without-border="$withoutBorder ?? false">
    {{ $model->vendorField() }}
</x-details.generic>
