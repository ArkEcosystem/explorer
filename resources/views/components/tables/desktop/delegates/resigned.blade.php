<div class="hidden w-full table-container @if($compact)table-compact @endif md:block">
    <table>
        <thead>
            <tr>
                <x-tables.headers.desktop.id name="general.delegates.id" />
                <x-tables.headers.desktop.address name="general.delegates.name" />
                @if($compact)
                    <x-tables.headers.desktop.number name="general.delegates.votes" />
                @else
                    <x-tables.headers.desktop.number name="general.delegates.votes" responsive/>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($delegates as $delegate)
                <x-ark-tables.row>
                    <x-ark-tables.cell>
                        <x-tables.rows.desktop.resignation-id :model="$delegate" />
                    </x-ark-tables.cell>
                    @if($compact)
                        <x-ark-tables.cell>
                            <x-tables.rows.desktop.username :model="$delegate" :compact="$compact" />
                        </x-ark-tables.cell>

                        <x-ark-tables.cell class="text-right">
                            <x-tables.rows.desktop.votes :model="$delegate" />
                        </x-ark-tables.cell>
                    @else
                        <x-ark-tables.cell last-on="lg">
                            <x-tables.rows.desktop.username :model="$delegate" />
                        </x-ark-tables.cell>

                        <x-ark-tables.cell class="text-right" responsive>
                            <x-tables.rows.desktop.votes :model="$delegate" />
                        </x-ark-tables.cell>
                    @endif
                </x-ark-tables.row>
            @endforeach
        </tbody>
    </table>
</div>
