<div class="w-full">
    @if (! $load)
        <x-tables.desktop.skeleton.delegates.active />
    @else
        <div wire:poll.{{ Network::blockTime() }}s wire:key="poll_active_delegates">
            <x-tables.desktop.delegates.active :delegates="$delegates" />
        </div>
    @endif
</div>
