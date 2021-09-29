<div id="delegate-list" class="w-full">

    <x-delegates.table-loading-state />

    <x-loading.hidden>
        @switch($this->state['status'])
            @case('standby')
                <x-tables.desktop.delegates.standby :delegates="$delegates" />
                <x-general.pagination :results="$delegates" class="mt-8" />
                @break

            @case('resigned')
                <x-tables.desktop.delegates.resigned :delegates="$delegates" />
                <x-general.pagination :results="$delegates" class="mt-8" />
                @break

            @default
                @if($delegates->isEmpty())
                    <x-tables.desktop.skeleton.delegates.active />
                @else
                    <x-tables.desktop.delegates.active :delegates="$delegates" />
                @endif
        @endswitch
    </x-loading.hidden>

    <script>
        window.addEventListener('livewire:load', () => window.livewire.on('pageChanged', () => scrollToQuery('#delegate-list')));
    </script>
</div>
