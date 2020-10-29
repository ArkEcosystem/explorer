<div>
    @lang('labels.timestamp')

    <x-general.loading-state.text :text="$model->timestamp()" />

    {{ $model->timestamp() }}
</div>
