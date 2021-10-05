<div id="delegate-list" class="w-full">

    <code><pre>
    Alpine: <span x-text="selected"></span><span x-show="!Boolean(selected)">null</span>
    Livewire: <span>{{ $this->state['status'] }}</span>
    Delegates: <span>{{ count($delegates) }}</span>
    Loading: <span wire:loading>Yes</span><span wire:loading.remove>NO</span>
    </pre></code>

    @if ($this->state['status'] !== 'active' || ! count($delegates))
        <div x-show="selected === 'active'" x-cloak>
            1
            <x-tables.desktop.skeleton.delegates.active />
        </div>
    @endif

    @if ($this->state['status'] !== 'standby')
        <div x-show="selected === 'standby'" x-cloak>
            2
            <x-tables.desktop.skeleton.delegates.standby />
        </div>
    @endif

    @if ($this->state['status'] !== 'resigned')
        <span x-show="selected === 'resigned'" x-cloak>
            3
            <x-tables.desktop.skeleton.delegates.resigned />
        </span>
    @endif

    @if($this->state['status'] === 'active')
        <div wire:poll.{{ Network::blockTime() }}s wire:key="poll_active_delegates_skeleton">
            @if ($this->state['status'] === 'active' && count($delegates))
                <span x-show="selected === 'active'">
                    <x-tables.desktop.delegates.active :delegates="$delegates" />
                </span>
            @else
                <x-loading.hidden>
                    <x-tables.desktop.delegates.active :delegates="$delegates" />
                </x-loading.hidden>
            @endif
        </div>
    @endif

    @if($this->state['status'] === 'standby')
        <x-loading.hidden>
            <x-tables.desktop.delegates.standby :delegates="$delegates" />
            <x-general.pagination :results="$delegates" class="mt-8" />
        </x-loading.hidden>

        <div x-show="selected === 'standby'" x-cloak>
            <x-loading.visible>
            4
                <x-tables.desktop.skeleton.delegates.standby />
            </x-loading.visible>
        </div>

        <div x-show="!Boolean(selected)">
            <x-loading.visible>
            5
                <x-tables.desktop.skeleton.delegates.standby />
            </x-loading.visible>
        </div>
    @endif

    @if($this->state['status'] === 'resigned')
        <x-loading.hidden>
            <x-tables.desktop.delegates.resigned :delegates="$delegates" />
            <x-general.pagination :results="$delegates" class="mt-8" />
        </x-loading.hidden>

        <div x-show="selected === 'resigned'" x-cloak>
            <x-loading.visible>
            6
                <x-tables.desktop.skeleton.delegates.resigned />
            </x-loading.visible>
        </div>

        <div x-show="!Boolean(selected)">
            <x-loading.visible>
            7
                <x-tables.desktop.skeleton.delegates.resigned />
            </x-loading.visible>
        </div>
    @endif

    <script>
        window.addEventListener('livewire:load', () => window.livewire.on('pageChanged', () => scrollToQuery('#delegate-list')));
    </script>
</div>
