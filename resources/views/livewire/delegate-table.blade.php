<div id="delegate-list" class="w-full">
    <x-loading.visible>

        {{--Alpine loading state--}}
        <span x-show="selected === 'active'" x-cloak>
            <x-tables.desktop.skeleton.delegates.active />
        </span>

        <span x-show="selected === 'standby'" x-cloak>
            <x-tables.desktop.skeleton.delegates.standby />
        </span>

        <span x-show="selected === 'resigned'" x-cloak>
            <x-tables.desktop.skeleton.delegates.resigned />
        </span>

        {{--Livewire loading state--}}
        @if($this->state['status'] === 'active')
            <x-tables.desktop.skeleton.delegates.active />
        @endif

        @if($this->state['status'] === 'standby')
            <x-tables.desktop.skeleton.delegates.standby />
        @endif

        @if($this->state['status'] === 'resigned')
            <x-tables.desktop.skeleton.delegates.resigned />
        @endif
    </x-loading.visible>

    @if($this->state['status'] === 'active')
        <div wire:poll.{{ Network::blockTime() }}s wire:key="poll_active_delegates_skeleton">
            @if (count($delegates) && $state['status'] === 'active')
                <span x-show="selected === 'active'">
                    <x-tables.desktop.delegates.active :delegates="$delegates" />
                </span>
            @else
                <x-loading.hidden>
                    <x-tables.desktop.delegates.active :delegates="$delegates" />
                </x-loading.hidden>
            @endif
        </div>
    @elseif (! count($delegates) || $state['status'] !== 'active')
        <span x-show="selected === 'active'" x-cloak>
            <x-tables.desktop.skeleton.delegates.active />
        </span>
    @endif

    @if($this->state['status'] === 'standby')
        <x-loading.hidden>
            <x-tables.desktop.delegates.standby :delegates="$delegates" />

            <x-general.pagination :results="$delegates" class="mt-8" />
        </x-loading.hidden>
    @endif

    @if($this->state['status'] === 'resigned')
        <x-loading.hidden>
            <x-tables.desktop.delegates.resigned :delegates="$delegates" />

            <x-general.pagination :results="$delegates" class="mt-8" />
        </x-loading.hidden>
    @endif

    <script>
        window.addEventListener('livewire:load', () => window.livewire.on('pageChanged', () => scrollToQuery('#delegate-list')));
    </script>
</div>
