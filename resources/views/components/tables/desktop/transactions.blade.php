<div class="hidden table-container md:block">
    <table>
        <thead>
            <tr>
                <x-tables.headers.desktop.id name="general.transaction.id" on-click="$emit('orderTransactionsBy', '{{ OrderingTypeEnum::ID }}')" />
                <x-tables.headers.desktop.text name="general.transaction.timestamp" on-click="$emit('orderTransactionsBy', '{{ OrderingTypeEnum::TIMESTAMP }}')" responsive />
                @isset($useDirection)
                    <x-tables.headers.desktop.address name="general.transaction.sender" on-click="$emit('orderTransactionsBy', '{{ OrderingTypeEnum::SENDER }}')" icon use-direction />
                @else
                    <x-tables.headers.desktop.address name="general.transaction.sender" on-click="$emit('orderTransactionsBy', '{{ OrderingTypeEnum::SENDER }}')" icon />
                @endif
                <x-tables.headers.desktop.address name="general.transaction.recipient" on-click="$emit('orderTransactionsBy', '{{ OrderingTypeEnum::RECIPIENT }}')" />
                <x-tables.headers.desktop.number name="general.transaction.amount" on-click="$emit('orderTransactionsBy', '{{ OrderingTypeEnum::AMOUNT }}')" />
                <x-tables.headers.desktop.number name="general.transaction.fee" on-click="$emit('orderTransactionsBy', '{{ OrderingTypeEnum::FEE }}')" responsive breakpoint="xl" />
                @isset($useConfirmations)
                    <x-tables.headers.desktop.number name="general.transaction.confirmations" on-click="$emit('orderTransactionsBy', '{{ OrderingTypeEnum::CONFIRMATIONS }}')" responsive breakpoint="xl" />
                @endisset
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <x-ark-tables.row>
                    <x-ark-tables.cell wire:key="{{ $transaction->id() }}-id">
                        <x-tables.rows.desktop.transaction-id :model="$transaction" />
                    </x-ark-tables.cell>
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
                        <x-tables.rows.desktop.recipient :model="$transaction" />
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
                    <x-ark-tables.cell
                        class="text-right"
                        responsive
                        breakpoint="xl"
                    >
                        <x-tables.rows.desktop.fee :model="$transaction" />
                    </x-ark-tables.cell>
                    @isset($useConfirmations)
                        <x-ark-tables.cell
                            class="text-right"
                            responsive
                            breakpoint="xl"
                            wire:key="{{ $transaction->id() }}-confirmations"
                        >
                            <x-tables.rows.desktop.confirmations :model="$transaction" />
                        </x-ark-tables.cell>
                    @endisset
                </x-ark-tables.row>
            @endforeach
        </tbody>
    </table>
</div>
