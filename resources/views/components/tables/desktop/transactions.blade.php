<div x-data="{
    hoverin(row) {
        const overlay = this.$refs.hoverOverlay;
        const width = row.offsetWidth + 20;
        const height = row.offsetHeight - 10;
        const viewportOffset = row.getBoundingClientRect();
        const top = viewportOffset.top + window.scrollY + 5;
        const left = viewportOffset.left + window.scrollX - 10;
        overlay.style.width  = `${width}px`;
        overlay.style.height  = `${height}px`;
        overlay.style.left  = `${left}px`;
        overlay.style.top  = `${top}px`;
        overlay.style.display = 'block';
    },
    hoverout(row) {
        const overlay = this.$refs.hoverOverlay;
        overlay.style.display = 'none';
    },

}" class="hidden table-container md:block">
    <div
        x-ref="hoverOverlay"
        wire:ignore
        class="absolute block border-l-4 border-r-4 pointer-events-none rounded-xl border-theme-primary-50 bg-theme-primary-50"
    ></div>

    <table class="relative">
        <thead>
            <tr>
                <x-tables.headers.desktop.text name="general.transaction.id" />
                <x-tables.headers.desktop.text name="general.transaction.timestamp" />
                <x-tables.headers.desktop.address name="general.transaction.sender" />
                <x-tables.headers.desktop.address name="general.transaction.recipient" />
                <x-tables.headers.desktop.number name="general.transaction.amount" />
                <x-tables.headers.desktop.number name="general.transaction.fee" />
                @isset($useConfirmations)
                    <x-tables.headers.desktop.number name="general.transaction.confirmations" />
                @endisset
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <tr
                    @mouseenter="hoverin($event.target)"
                    @mouseout="hoverout($event.target)"
                >
                    <td @if ($loop->first) class=""  @endif wire:key="{{ $transaction->id() }}-id">
                        <x-tables.rows.desktop.transaction-id :model="$transaction" />
                    </td>
                    <td class="hidden lg:table-cell">
                        <x-tables.rows.desktop.timestamp :model="$transaction" />
                    </td>
                    <td wire:key="{{ $transaction->id() }}-sender">
                        @isset($useDirection)
                            <x-tables.rows.desktop.sender-with-direction :model="$transaction" :wallet="$wallet" />
                        @else
                            <x-tables.rows.desktop.sender :model="$transaction" />
                        @endif
                    </td>
                    <td wire:key="{{ $transaction->id() }}-recipient">
                        <x-tables.rows.desktop.recipient :model="$transaction" />
                    </td>
                    <td class="text-right">
                        @isset($useDirection)
                            @if($transaction->isSent($wallet->address()))
                                <x-tables.rows.desktop.amount-sent :model="$transaction" />
                            @else
                                <x-tables.rows.desktop.amount-received :model="$transaction" />
                            @endif
                        @else
                            <x-tables.rows.desktop.amount :model="$transaction" />
                        @endisset
                    </td>
                    <td class="hidden text-right xl:table-cell">
                        <x-tables.rows.desktop.fee :model="$transaction" />
                    </td>
                    @isset($useConfirmations)
                    <td class="hidden text-right xl:table-cell" wire:key="{{ $transaction->id() }}-confirmations">
                        <x-tables.rows.desktop.confirmations :model="$transaction" />
                    </td>
                    @endisset
                </tr>
            @endforeach
        </tbody>
    </table>


</div>
