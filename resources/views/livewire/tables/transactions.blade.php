<div id="transaction-list" class="w-full">
    <div class="w-full" wire:loading>
        <x-transactions.table-desktop-skeleton />

        <x-transactions.table-mobile-skeleton />
    </div>

    <div class="w-full" wire:loading.remove>
        <x-transactions.table-desktop :transactions="$transactions" />

        <x-transactions.table-mobile :transactions="$transactions" />

        <x-general.pagination :results="$transactions" class="mt-8" />

        <script>
            window.addEventListener('livewire:load', () => window.livewire.on('pageChanged', () => scrollToQuery('#transaction-list')));
        </script>
    </div>
</div>
