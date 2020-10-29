<div id="wallet-list" class="w-full">
    <x-skeletons.wallets>
        <x-wallets.table-desktop :wallets="$wallets" />

        <x-wallets.table-mobile :wallets="$wallets" />

        <x-general.pagination :results="$wallets" class="mt-8" />

        <script>
            window.addEventListener('livewire:load', () => window.livewire.on('pageChanged', () => scrollToQuery('#wallet-list')));
        </script>
    </x-skeletons.wallets>
</div>
