<x-grid.generic :title="trans('general.transaction.timestamp')" icon="calendar">
    <x-ark-local-time
        :datetime="$model->datetime()"
        :format="DateFormat::TIME_JS"
        :placeholder="$model->timestamp()"
    />
</x-grid.generic>
