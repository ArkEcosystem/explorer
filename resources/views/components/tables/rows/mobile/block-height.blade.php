<div>
    @lang('labels.block_height')

    <x-general.loading-state.text :text="$model->height()" />

    {{ $model->height() }}
</div>
