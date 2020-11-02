<x-grid.generic :title="trans('general.transaction.smartbridge')" icon="app-smartbridge" :without-border="$withoutBorder ?? false" :responsive-border="$responsiveBorder ?? false">
    {{ $model->vendorField() }}
</x-grid.generic>
