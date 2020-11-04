<div id="delegate-list" class="w-full">
    <x-loading.visible>
        <span x-show="status === 'resigned'">
            <x-tables.desktop.skeleton.monitor.resigned />
            <x-tables.mobile.skeleton.monitor.resigned />
        </span>

        <span x-show="status === 'standby'">
            <x-tables.desktop.skeleton.monitor.standby />
            <x-tables.mobile.skeleton.monitor.standby />
        </span>

        <span x-show="status === 'active'">
            <x-tables.desktop.skeleton.monitor.active />
            <x-tables.mobile.skeleton.monitor.active />
        </span>
    </x-loading.visible>

    <span x-show="status === 'resigned'">
        <x-loading.hidden>
            <x-tables.desktop.monitor.resigned :delegates="$delegates" />
            <x-tables.mobile.monitor.resigned :delegates="$delegates" />
        </x-loading.hidden>
    </span>

    <span x-show="status === 'standby'">
        <x-loading.hidden>
            <x-tables.desktop.monitor.standby :delegates="$delegates" />
            <x-tables.mobile.monitor.standby :delegates="$delegates" />
        </x-loading.hidden>
    </span>

    <span x-show="status === 'active'">
        <x-loading.hidden>
            <x-tables.desktop.monitor.active :delegates="$delegates" />
            <x-tables.mobile.monitor.active :delegates="$delegates" />
        </x-loading.hidden>
    </span>

    <script>
        window.addEventListener('livewire:load', () => window.livewire.on('pageChanged', () => scrollToQuery('#transaction-list')));
    </script>
</div>
