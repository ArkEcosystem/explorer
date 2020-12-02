<div id="transaction-list" class="w-full">
    <x-skeletons.transactions :compact="Settings::usesCompactTables()">
        <x-tables.desktop.transactions :transactions="$transactions" :compact="Settings::usesCompactTables()"/>

        <x-tables.mobile.transactions :transactions="$transactions" compact="false" />

        <x-general.pagination :results="$transactions" class="mt-8" />

        <script>
            window.addEventListener('livewire:load', () => window.livewire.on('pageChanged', () => scrollToQuery('#transaction-list')));
        </script>
    </x-skeletons.transactions>
</div>
