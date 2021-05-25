<x-ark-tables.table sticky class="hidden md:block">
    <thead>
        <tr>
            <x-tables.headers.desktop.text name="general.delegates.rank" />
            <x-tables.headers.desktop.address name="general.delegates.name" />
            <x-tables.headers.desktop.status name="general.delegates.status">
                <x-ark-info :tooltip="trans('pages.delegates.info.status')" />
            </x-tables.headers.desktop.status>
            <x-tables.headers.desktop.number name="general.delegates.votes" responsive />
            <x-tables.headers.desktop.number name="general.delegates.productivity">
                <x-ark-info :tooltip="trans('pages.delegates.info.productivity')" />
            </x-tables.headers.desktop.number>
        </tr>
    </thead>
    <tbody>
        @foreach($delegates as $delegate)
            <x-ark-tables.row
                :danger="$delegate->keepsMissing()"
                :warning="$delegate->justMissed()"
            >
                <x-ark-tables.cell>
                    <x-tables.rows.desktop.rank :model="$delegate" />
                </x-ark-tables.cell>
                <x-ark-tables.cell wire:key="{{ $delegate->username() }}-username">
                    <x-tables.rows.desktop.username :model="$delegate" />
                </x-ark-tables.cell>
                <x-ark-tables.cell wire:key="{{ $delegate->username() }}-round-status-history">
                    <x-tables.rows.desktop.round-status-history :model="$delegate" />
                </x-ark-tables.cell>
                <x-ark-tables.cell class="text-right" responsive>
                    <x-tables.rows.desktop.votes :model="$delegate" />
                </x-ark-tables.cell>
                <x-ark-tables.cell class="text-right">
                    <x-tables.rows.desktop.productivity :model="$delegate" />
                </x-ark-tables.cell>
            </x-ark-tables.row>
        @endforeach
    </tbody>
</x-ark-tables.table>
