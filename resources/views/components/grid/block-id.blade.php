<x-grid.generic :title="trans('general.transaction.block_id')" icon="app-block-id" :without-border="$withoutBorder ?? false">
    <span class="flex items-center">

        <a href="{{ route('block', $model->blockId()) }}" class="sm:hidden md:contents lg:hidden font-semibold link">
            <x-truncate-middle :value="$model->blockId()" :length="10" />
        </a>

        <a href="{{ route('block', $model->blockId()) }}" class="hidden sm:contents md:hidden lg:contents font-semibold link">
            <x-truncate-middle :value="$model->blockId()" :length="32" />
        </a>

        <x-ark-clipboard :value="$model->blockId()" class="flex items-center w-auto h-auto ml-2 text-theme-secondary-600" no-styling />
    </span>
</x-grid.generic>
