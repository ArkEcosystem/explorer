<div class="hidden table-container @if($compact)table-compact @endif md:block">
    <table>
        <thead>
            <tr>
                <x-tables.headers.desktop.id name="general.transaction.id" />

                @if ($compact)
                    <x-tables.headers.desktop.text name="general.transaction.timestamp" />

                    @isset($useDirection)
                        <x-tables.headers.desktop.address name="general.transaction.sender" :compact="$compact" icon />
                    @else
                        <x-tables.headers.desktop.address name="general.transaction.sender" icon />
                    @endif

                    <x-tables.headers.desktop.address name="general.transaction.recipient" />
                    <x-tables.headers.desktop.number name="general.transaction.amount" />
                    <x-tables.headers.desktop.number name="general.transaction.fee" />

                    @isset($useConfirmations)
                        <x-tables.headers.desktop.number name="general.transaction.confirmations" />
                    @endisset
                @else
                    <x-tables.headers.desktop.text name="general.transaction.timestamp" responsive />

                    @isset($useDirection)
                        <x-tables.headers.desktop.address name="general.transaction.sender" icon use-direction />
                    @else
                        <x-tables.headers.desktop.address name="general.transaction.sender" icon />
                    @endif

                    <x-tables.headers.desktop.address name="general.transaction.recipient" />
                    <x-tables.headers.desktop.number name="general.transaction.amount" />
                    <x-tables.headers.desktop.number name="general.transaction.fee" responsive breakpoint="xl" />

                    @isset($useConfirmations)
                        <x-tables.headers.desktop.number name="general.transaction.confirmations" responsive breakpoint="xl" />
                    @endisset
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <x-ark-tables.row>
                    <x-ark-tables.cell wire:key="{{ $transaction->id() }}-id">
                        <x-tables.rows.desktop.transaction-id :model="$transaction" />
                    </x-ark-tables.cell>
                    @if ($compact)
                        <x-ark-tables.cell>
                            <x-tables.rows.desktop.timestamp :model="$transaction" shortened />
                        </x-ark-tables.cell>

                        <x-ark-tables.cell wire:key="{{ $transaction->id() }}-sender">
                            @isset($useDirection)
                                <x-tables.rows.desktop.sender-with-direction :model="$transaction" :wallet="$wallet" :compact="$compact" />
                            @else
                                <x-tables.rows.desktop.sender :model="$transaction" :compact="$compact" />
                            @endif
                        </x-ark-tables.cell>

                        <x-ark-tables.cell wire:key="{{ $transaction->id() }}-recipient">
                            <x-tables.rows.desktop.recipient :model="$transaction" :compact="$compact" />
                        </x-ark-tables.cell>

                        <x-ark-tables.cell class="text-right" last-on="xl">
                            @isset($useDirection)
                                @if($transaction->isSent($wallet->address()))
                                    <x-tables.rows.desktop.amount-sent :model="$transaction" :compact="$compact" />
                                @else
                                    <x-tables.rows.desktop.amount-received :model="$transaction" :compact="$compact" />
                                @endif
                            @else
                                <x-tables.rows.desktop.amount :model="$transaction" :compact="$compact" />
                            @endisset
                        </x-ark-tables.cell>

                        <x-ark-tables.cell class="text-right">
                            <x-tables.rows.desktop.fee :model="$transaction" />
                        </x-ark-tables.cell>

                        @isset($useConfirmations)
                            <x-ark-tables.cell class="text-right" wire:key="{{ $transaction->id() }}-confirmations">
                                <x-tables.rows.desktop.confirmations :model="$transaction" :compact="$compact" />
                            </x-ark-tables.cell>
                        @endisset
                    @else
                        <x-ark-tables.cell responsive>
                            <x-tables.rows.desktop.timestamp :model="$transaction" shortened />
                        </x-ark-tables.cell>

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

                        <x-ark-tables.cell class="text-right" last-on="xl">
                            @isset($useDirection)
                                @if($transaction->isSent($wallet->address()))
                                    <x-tables.rows.desktop.amount-sent :model="$transaction" compact="false" />
                                @else
                                    <x-tables.rows.desktop.amount-received :model="$transaction" compact="false" />
                                @endif
                            @else
                                <x-tables.rows.desktop.amount :model="$transaction" compact="false" />
                            @endisset
                        </x-ark-tables.cell>

                        <x-ark-tables.cell class="text-right" responsive breakpoint="xl">
                            <x-tables.rows.desktop.fee :model="$transaction" />
                        </x-ark-tables.cell>

                        @isset($useConfirmations)
                            <x-ark-tables.cell class="text-right" responsive breakpoint="xl" wire:key="{{ $transaction->id() }}-confirmations">
                                <x-tables.rows.desktop.confirmations :model="$transaction" compact="false" />
                            </x-ark-tables.cell>
                        @endisset
                    @endif
                </x-ark-tables.row>
            @endforeach
        </tbody>
    </table>
</div>
