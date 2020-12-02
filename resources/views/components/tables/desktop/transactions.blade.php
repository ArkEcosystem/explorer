<div class="hidden table-container @if(isset($compact))table-compact @endif md:block">
    <table>
        <thead>
            <tr>
                <x-tables.headers.desktop.id name="general.transaction.id" />

                @if (!isset($compact))
                    <x-tables.headers.desktop.text name="general.transaction.timestamp" responsive />
                @else
                    <x-tables.headers.desktop.text name="general.transaction.timestamp" />
                @endif

                @isset($useDirection)
                    <x-tables.headers.desktop.address name="general.transaction.sender" icon use-direction />
                @else
                    <x-tables.headers.desktop.address name="general.transaction.sender" icon />
                @endif

                <x-tables.headers.desktop.address name="general.transaction.recipient" />

                <x-tables.headers.desktop.number name="general.transaction.amount" />

                @if (!isset($compact))
                    <x-tables.headers.desktop.number name="general.transaction.fee" responsive breakpoint="xl" />
                @else
                    <x-tables.headers.desktop.number name="general.transaction.fee" />
                @endif

                @isset($useConfirmations)
                    @if(!isset($compact))
                        <x-tables.headers.desktop.number name="general.transaction.confirmations" responsive breakpoint="xl" />
                    @else
                        <x-tables.headers.desktop.number name="general.transaction.confirmations" />
                    @endif
                @endisset
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <x-ark-tables.row>
                    <x-ark-tables.cell wire:key="{{ $transaction->id() }}-id">
                        <x-tables.rows.desktop.transaction-id :model="$transaction" />
                    </x-ark-tables.cell>

                    @if(!isset($compact))
                        <x-ark-tables.cell responsive>
                            <x-tables.rows.desktop.timestamp :model="$transaction" shortened />
                        </x-ark-tables.cell>
                    @else
                        <x-ark-tables.cell>
                            <x-tables.rows.desktop.timestamp :model="$transaction" shortened />
                        </x-ark-tables.cell>
                    @endif

                    <x-ark-tables.cell wire:key="{{ $transaction->id() }}-sender">
                        @isset($useDirection)
                            <x-tables.rows.desktop.sender-with-direction :model="$transaction" :wallet="$wallet" />
                        @else
                            <x-tables.rows.desktop.sender :model="$transaction" />
                        @endif
                    </x-ark-tables.cell>

                    <x-ark-tables.cell wire:key="{{ $transaction->id() }}-recipient">
                        <x-tables.rows.desktop.recipient :model="$transaction" :compact="$compact" />
                    </x-ark-tables.cell>

                    <x-ark-tables.cell
                        class="text-right"
                        last-on="xl"
                    >
                        @isset($useDirection)
                            @if($transaction->isSent($wallet->address()))
                                <x-tables.rows.desktop.amount-sent :model="$transaction" />
                            @else
                                <x-tables.rows.desktop.amount-received :model="$transaction" />
                            @endif
                        @else
                            <x-tables.rows.desktop.amount :model="$transaction" />
                        @endisset
                    </x-ark-tables.cell>

                    @if(!isset($compact))
                        <x-ark-tables.cell
                            class="text-right"
                            responsive
                            breakpoint="xl"
                        >
                            <x-tables.rows.desktop.fee :model="$transaction" />
                        </x-ark-tables.cell>
                    @else
                        <x-ark-tables.cell
                            class="text-right"
                        >
                            <x-tables.rows.desktop.fee :model="$transaction" />
                        </x-ark-tables.cell>
                    @endif

                    @isset($useConfirmations)
                        @if(!isset($compact))
                            <x-ark-tables.cell
                                class="text-right"
                                responsive
                                breakpoint="xl"
                                wire:key="{{ $transaction->id() }}-confirmations"
                            >
                                <x-tables.rows.desktop.confirmations :model="$transaction" />
                            </x-ark-tables.cell>
                        @else
                            <x-ark-tables.cell
                                class="text-right"
                                wire:key="{{ $transaction->id() }}-confirmations"
                            >
                                <x-tables.rows.desktop.confirmations :model="$transaction" />
                            </x-ark-tables.cell>
                        @endif
                    @endisset
                </x-ark-tables.row>
            @endforeach
        </tbody>
    </table>
</div>
