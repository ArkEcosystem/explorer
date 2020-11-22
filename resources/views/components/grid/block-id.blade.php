<x-grid.generic :title="trans('general.transaction.block_id')" icon="app-block-id">
    <span class="flex items-center">

        <a href="{{ route('block', $model->blockId()) }}" class="font-semibold sm:hidden md:inline lg:hidden link">
            <x-truncate-middle :length="10">
                {{ $model->blockId() }}
            </x-truncate-middle>
        </a>

        <a href="{{ route('block', $model->blockId()) }}" class="hidden font-semibold sm:inline md:hidden lg:inline link">
            <x-truncate-middle :length="32">
                {{ $model->blockId() }}
            </x-truncate-middle>
        </a>

        <x-clipboard :value="$model->blockId()" />
    </span>
</x-grid.generic>
