<div class="hidden table-container md:block">
    <table>
        <thead>
            <tr>
                <x-tables.headers.desktop.id name="general.block.id" on-click="$emit('orderBlocksBy', 'id')" />
                <x-tables.headers.desktop.text name="general.block.timestamp" responsive on-click="$emit('orderBlocksBy', 'timestamp')" />
                @if(!isset($withoutGenerator))
                    <x-tables.headers.desktop.address name="general.block.generated_by" on-click="$emit('orderBlocksBy', 'generated_by')" />
                @endif
                <x-tables.headers.desktop.number name="general.block.height" on-click="$emit('orderBlocksBy', 'height')" />
                <x-tables.headers.desktop.number name="general.block.transactions" on-click="$emit('orderBlocksBy', 'transactions')" />
                <x-tables.headers.desktop.number name="general.block.amount" on-click="$emit('orderBlocksBy', 'amount')" />
                <x-tables.headers.desktop.number name="general.block.fee" responsive on-click="$emit('orderBlocksBy', 'fee')" />
            </tr>
        </thead>
        <tbody>
            @foreach($blocks as $block)
                <x-ark-tables.row>
                    <x-ark-tables.cell wire:key="{{ $block->id() }}-id">
                        <x-tables.rows.desktop.block-id :model="$block" />
                    </x-ark-tables.cell>
                    <x-ark-tables.cell responsive>
                        <x-tables.rows.desktop.timestamp :model="$block" />
                    </x-ark-tables.cell>
                    @if(!isset($withoutGenerator))
                        <x-ark-tables.cell wire:key="{{ $block->id() }}-forger">
                            <x-tables.rows.desktop.block-forger :model="$block" />
                        </x-ark-tables.cell>
                    @endif
                    <x-ark-tables.cell class="text-right">
                        <x-tables.rows.desktop.block-height :model="$block" />
                    </x-ark-tables.cell>
                    <x-ark-tables.cell class="text-right">
                        <x-tables.rows.desktop.transaction-count :model="$block" />
                    </x-ark-tables.cell>
                    <x-ark-tables.cell
                        class="text-right"
                        last-on="lg"
                    >
                        <x-tables.rows.desktop.amount :model="$block" />
                    </x-ark-tables.cell>
                    <x-ark-tables.cell class="text-right" responsive>
                        <x-tables.rows.desktop.fee :model="$block" />
                    </x-ark-tables.cell>
                </x-ark-tables.row>
            @endforeach
        </tbody>
    </table>
</div>
