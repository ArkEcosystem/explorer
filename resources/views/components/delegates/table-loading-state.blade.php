<x-loading.visible>
    @switch($this->state['status'])
        @case('standby')
            <x-tables.desktop.skeleton.delegates.standby />
            @break

        @case('resigned')
            <x-tables.desktop.skeleton.delegates.resigned />
            @break

        @default
            <x-tables.desktop.skeleton.delegates.active />
    @endswitch
</x-loading.visible>
