<div class="w-full" wire:loading>
    <x-wallets.table-desktop-skeleton />

    <x-wallets.table-mobile-skeleton />
</div>

<div class="w-full" wire:loading.remove>
    {{ $slot }}
</div>
