<div id="delegate-list" class="w-full">
    <span x-show="status !== 'active'">
        <x-loading.visible>
            <span x-show="status === 'active'">
                <x-tables.desktop.skeleton.delegates.active :compact="Settings::usesCompactTables()" />
                <x-tables.mobile.skeleton.delegates.active compact="false" />
            </span>

            <span x-show="status === 'standby'">
                <x-tables.desktop.skeleton.delegates.standby :compact="Settings::usesCompactTables()" />
                <x-tables.mobile.skeleton.delegates.standby compact="false" />
            </span>

            <span x-show="status === 'resigned'">
                <x-tables.desktop.skeleton.delegates.resigned :compact="Settings::usesCompactTables()" />
                <x-tables.mobile.skeleton.delegates.resigned compact="false" />
            </span>
        </x-loading.visible>
    </span>

    @if($this->state['status'] === 'active')
        <div wire:poll.{{ Network::blockTime() }}s wire:key="poll_active_delegates_skeleton">
            @if (count($delegates) && $state['status'] === 'active')
                <x-tables.desktop.delegates.active :delegates="$delegates" :compact="Settings::usesCompactTables()" />
                <x-tables.mobile.delegates.active :delegates="$delegates" compact="false" />
            @else
                <x-loading.hidden>
                    <x-tables.desktop.delegates.active :delegates="$delegates" :compact="Settings::usesCompactTables()"/>
                    <x-tables.mobile.delegates.active :delegates="$delegates" compact="false" />
                </x-loading.hidden>
            @endif
        </div>
    @elseif (! count($delegates) || $state['status'] !== 'active')
        <span x-show="status === 'active'">
            <x-tables.desktop.skeleton.delegates.active :compact="Settings::usesCompactTables()" />
            <x-tables.mobile.skeleton.delegates.active compact="false" />
        </span>
    @endif

    @if($this->state['status'] === 'standby')
        <x-loading.hidden>
            <x-tables.desktop.delegates.standby :delegates="$delegates" :compact="Settings::usesCompactTables()" />
            <x-tables.mobile.delegates.standby :delegates="$delegates" compact="false" />
        </x-loading.hidden>
    @endif

    @if($this->state['status'] === 'resigned')
        <x-loading.hidden>
            <x-tables.desktop.delegates.resigned :delegates="$delegates" :compact="Settings::usesCompactTables()" />
            <x-tables.mobile.delegates.resigned :delegates="$delegates" compact="false" />
        </x-loading.hidden>
    @endif

    <script>
        window.addEventListener('livewire:load', () => window.livewire.on('pageChanged', () => scrollToQuery('#transaction-list')));
    </script>
</div>
