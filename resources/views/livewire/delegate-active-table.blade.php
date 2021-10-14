<div class="w-full">
    <x-loading.visible>
        <x-tables.desktop.skeleton.delegates.active />
    </x-loading.visible>

    <x-loading.hidden>
        @if (! count($delegates))
            <x-tables.desktop.skeleton.delegates.active />
        @else
            <div wire:poll.{{ Network::blockTime() }}s wire:key="poll_active_delegates">
                <x-tables.desktop.delegates.active :delegates="$delegates" />
            </div>
        @endif
    </x-loading.hidden>
</div>
