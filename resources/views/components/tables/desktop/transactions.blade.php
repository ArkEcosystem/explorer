<div
    x-data="{
        addOverlayToRow(row, overlay) {
            const width = row.offsetWidth + 20;
            const height = row.offsetHeight - 4;
            const viewportOffset = row.getBoundingClientRect();
            const top = viewportOffset.top + window.scrollY + 2;
            const left = viewportOffset.left + window.scrollX - 10;
            overlay.style.width  = `${width}px`;
            overlay.style.height  = `${height}px`;
            overlay.style.left  = `${left}px`;
            overlay.style.top  = `${top}px`;
            overlay.style.display = 'block';
        },
        hoverin(e) {
            const overlay = this.$refs.hoverOverlay;
            const row = e.target;

            this.addOverlayToRow(row, overlay);
        },
        hoverout(e) {
            const hoveredAnotherRow = !! e.relatedTarget.closest('tbody')
            if (!hoveredAnotherRow) {
                const overlay = this.$refs.hoverOverlay;
                overlay.style.display = 'none';
            }
        },
        initTable() {
            const { table } = this.$refs;

            this.$nextTick(() => {
                const warningRows = table.querySelectorAll('tr[data-warning]');
                const errorRows = table.querySelectorAll('tr[data-error]');
                warningRows.forEach(row => {
                    const overlay = document.createElement('span');
                    overlay.className = 'absolute rounded-md pointer-events-none bg-theme-warning-50';
                    const firstChild = this.$refs.tableContainer.firstChild
                    this.$refs.tableContainer.insertBefore(overlay, firstChild)
                    this.addOverlayToRow(row, overlay);
                })
                errorRows.forEach(row => {
                    const overlay = document.createElement('span');
                    overlay.className = 'absolute rounded-md pointer-events-none bg-theme-danger-50';
                    const firstChild = this.$refs.tableContainer.firstChild
                    this.$refs.tableContainer.insertBefore(overlay, firstChild)
                    this.addOverlayToRow(row, overlay);
                })
            })
        },
    }"
    x-init="initTable()"
    class="hidden table-container md:block"
    x-ref="tableContainer"
>
    <span
        x-ref="hoverOverlay"
        wire:ignore
        class="absolute rounded-md pointer-events-none bg-theme-secondary-100"
        style="display: none"
    ></span>

    <table x-ref="table" class="relative">
        <thead>
            <tr>
                <x-tables.headers.desktop.text name="general.transaction.id" />
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
                <tr
                    @mouseenter="hoverin($event)"
                    @mouseout="hoverout($event)"
                    @if($loop->index === 2 || $loop->index === 6)
                    data-warning
                    @endif
                    @if($loop->index === 5)
                    data-error
                    @endif
                >
                    <td wire:key="{{ $transaction->id() }}-id">
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
