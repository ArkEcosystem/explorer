<div class="w-full" wire:loading>
    <x-blocks.table-desktop-skeleton />

    <x-blocks.table-mobile-skeleton />
</div>

<div class="w-full" wire:loading.remove>
    {{ $slot }}
</div>
