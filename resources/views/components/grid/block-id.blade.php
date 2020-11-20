<x-grid.generic :title="trans('general.transaction.block_id')" icon="app-block-id">
    <span class="flex items-center flex-1 min-w-0">

        <a href="{{ route('block', $model->blockId()) }}" class="w-full max-w-full min-w-0 font-semibold link">
            <x-truncate>{{ $model->blockId() }}</x-truncate>
        </a>

        <x-clipboard :value="$model->blockId()" />
    </span>
</x-grid.generic>
