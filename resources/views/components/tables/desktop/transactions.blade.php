<div class="hidden table-container md:block">
    <table>
        <thead>
            <tr>
                <x-tables.headers.desktop.id name="general.transaction.id" />
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
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <tr class="group">
                    <x-tables.cell wire:key="{{ $transaction->id() }}-id">
                        <x-tables.rows.desktop.transaction-id :model="$transaction" />
                    </x-tables.cell>
                    <x-tables.cell class="hidden lg:table-cell">
                        <x-tables.rows.desktop.timestamp :model="$transaction" />
                    </x-tables.cell>
                    <x-tables.cell wire:key="{{ $transaction->id() }}-sender">
                        @isset($useDirection)
                            <x-tables.rows.desktop.sender-with-direction :model="$transaction" :wallet="$wallet" />
                        @else
                            <x-tables.rows.desktop.sender :model="$transaction" />
                        @endif
                    </x-tables.cell>
                    <x-tables.cell wire:key="{{ $transaction->id() }}-recipient">
                        <x-tables.rows.desktop.recipient :model="$transaction" />
                    </x-tables.cell>
                    <x-tables.cell class="text-right">
                        @isset($useDirection)
                            @if($transaction->isSent($wallet->address()))
                                <x-tables.rows.desktop.amount-sent :model="$transaction" />
                            @else
                                <x-tables.rows.desktop.amount-received :model="$transaction" />
                            @endif
                        @else
                            <x-tables.rows.desktop.amount :model="$transaction" />
                        @endisset
                    </x-tables.cell>
                    <x-tables.cell class="hidden text-right xl:table-cell">
                        <x-tables.rows.desktop.fee :model="$transaction" />
                    </x-tables.cell>
                    @isset($useConfirmations)
                    <x-tables.cell class="hidden text-right xl:table-cell" wire:key="{{ $transaction->id() }}-confirmations">
                        <x-tables.rows.desktop.confirmations :model="$transaction" />
                    </x-tables.cell>
                    @endisset
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
