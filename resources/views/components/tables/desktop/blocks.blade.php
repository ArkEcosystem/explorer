<div class="hidden table-container md:block">
    <table>
        <thead>
            <tr>
                <x-tables.headers.desktop.id name="general.block.id" />
                <x-tables.headers.desktop.text name="general.block.timestamp" responsive wire:click="$emit('orderBlocksBy', '{{ OrderingTypeEnum::TIMESTAMP }}')" />
                @if(!isset($withoutGenerator))
                    <x-tables.headers.desktop.address name="general.block.generated_by" wire:click="$emit('orderBlocksBy', '{{ OrderingTypeEnum::GENERATOR_PUBLIC_KEY }}')" />
                @endif
                <x-tables.headers.desktop.number name="general.block.height" wire:click="$emit('orderBlocksBy', '{{ OrderingTypeEnum::HEIGHT }}')" />
                <x-tables.headers.desktop.number name="general.block.transactions" wire:click="$emit('orderBlocksBy', '{{ OrderingTypeEnum::TRANSACTIONS_AMOUNT }}')" />
                <x-tables.headers.desktop.number name="general.block.amount" wire:click="$emit('orderBlocksBy', '{{ OrderingTypeEnum::AMOUNT }}')" />
                <x-tables.headers.desktop.number name="general.block.fee" responsive wire:click="$emit('orderBlocksBy', '{{ OrderingTypeEnum::BLOCK_FEE }}')" />
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
