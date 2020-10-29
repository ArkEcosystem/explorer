<div class="w-full" wire:loading>
    <x-transactions.table-desktop-skeleton use-confirmations use-direction />

    <x-transactions.table-mobile-skeleton use-confirmations use-direction />
</div>

<div class="w-full" wire:loading.remove>
    {{ $slot }}
</div>
