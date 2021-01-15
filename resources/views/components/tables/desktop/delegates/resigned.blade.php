<div class="hidden w-full table-container md:block">
    <table>
        <thead>
            <tr>
                <x-tables.headers.desktop.id name="general.delegates.id" wire:click="$emit('orderDelegatesBy', '{{ OrderingTypeEnum::ID }}')" />
                <x-tables.headers.desktop.address name="general.delegates.name" wire:click="$emit('orderDelegatesBy', '{{ OrderingTypeEnum::ADDRESS }}')" />
                <x-tables.headers.desktop.number name="general.delegates.votes" responsive wire:click="$emit('orderDelegatesBy', '{{ OrderingTypeEnum::VOTE }}')" />
            </tr>
        </thead>
        <tbody>
            @foreach($delegates as $delegate)
                <x-ark-tables.row>
                    <x-ark-tables.cell>
                        <x-tables.rows.desktop.resignation-id :model="$delegate" />
                    </x-ark-tables.cell>
                    <x-ark-tables.cell last-on="lg">
                        <x-tables.rows.desktop.username :model="$delegate" />
                    </x-ark-tables.cell>
                    <x-ark-tables.cell class="text-right" responsive>
                        <x-tables.rows.desktop.votes :model="$delegate" />
                    </x-ark-tables.cell>
                </x-ark-tables.row>
            @endforeach
        </tbody>
    </table>
</div>
