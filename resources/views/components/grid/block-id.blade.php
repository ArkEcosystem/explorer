<x-details.generic :title="trans('general.transaction.block_id')" icon="app-block-id" :without-border="$withoutBorder ?? false">
    <span class="flex items-center">
        <a href="{{ route('block', $model->blockId()) }}" class="font-semibold link">
            <x-truncate-middle :value="$transaction->blockId()" :length="32" />
        </a>
        <x-ark-clipboard :value="$transaction->blockId()" class="flex items-center w-auto h-auto ml-2 text-theme-secondary-600" no-styling />
    </span>
</x-details.generic>
