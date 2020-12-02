<div class="hidden w-full table-container @if($compact)table-compact @endif md:block">
    <table>
        <thead>
            <tr>
                <x-tables.headers.desktop.address name="general.wallet.address" />
                <x-tables.headers.desktop.icon name="general.wallet.info" />
                <x-tables.headers.desktop.number name="general.wallet.balance" />
                @if ($compact)
                    <x-tables.headers.desktop.number name="general.wallet.supply" />
                @else
                    <x-tables.headers.desktop.number name="general.wallet.supply" responsive />
                @endif
            </tr>
        </thead>
        <tbody>

            @foreach($wallets as $wallet)
                <x-ark-tables.row>
                    @if ($compact)
                        <x-ark-tables.cell wire:key="{{ $wallet->address() }}-address">
                            <x-tables.rows.desktop.address :model="$wallet" :without-truncate="$withoutTruncate ?? false" :compact="$compact" />
                        </x-ark-tables.cell>
                    @else
                        <x-ark-tables.cell wire:key="{{ $wallet->address() }}-address">
                            <x-tables.rows.desktop.address :model="$wallet" :without-truncate="$withoutTruncate ?? false" />
                        </x-ark-tables.cell>
                    @endif
                    <x-ark-tables.cell class="text-center" wire:key="{{ $wallet->address() }}-type">
                        <x-tables.rows.desktop.wallet-type :model="$wallet" />
                    </x-ark-tables.cell>
                    <x-ark-tables.cell class="text-right" last-on="lg">
                        <x-tables.rows.desktop.balance :model="$wallet" />
                    </x-ark-tables.cell>
                    <x-ark-tables.cell responsive class="text-right">
                        @isset($useVoteWeight)
                            <x-tables.rows.desktop.vote-percentage :model="$wallet" />
                        @else
                            <x-tables.rows.desktop.balance-percentage :model="$wallet" />
                        @endif
                    </x-ark-tables.cell>
                </x-ark-tables.row>
            @endforeach
        </tbody>
    </table>
</div>
