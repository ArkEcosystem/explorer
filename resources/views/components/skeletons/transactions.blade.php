<div class="w-full" wire:loading>
    <x-transactions.table-desktop-skeleton />

    <x-transactions.table-mobile-skeleton />
</div>

<div class="w-full" wire:loading.remove>
    {{ $slot }}
</div>
