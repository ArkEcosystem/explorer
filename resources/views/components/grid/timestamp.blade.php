<x-grid.generic :title="trans('general.transaction.timestamp')" icon="calendar">
    <x-time
        :datetime="$model->datetime()"
        :format="DateFormat::TIME_JS"
    />
</x-grid.generic>
