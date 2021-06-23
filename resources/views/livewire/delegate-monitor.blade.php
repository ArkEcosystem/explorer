<div>
    @if(! count($delegates))
        <div wire:key="poll_delegates_skeleton">
            <x-tables.desktop.skeleton.delegates.monitor />
        </div>
    @else
        <div id="network-list" class="w-full" wire:key="poll_delegates_real">
            <x-tables.desktop.delegates.monitor :delegates="$delegates" :round="$round" />
        </div>
    @endif
</div>
