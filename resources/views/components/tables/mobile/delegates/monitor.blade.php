<div class="w-full table-container md:hidden">
    <table>
        <thead>
            <tr>
                <x-tables.headers.mobile.number name="pages.delegates.order" alignment="text-left" />
                <x-tables.headers.mobile.address name="pages.delegates.name" />
                <x-tables.headers.mobile.text name="pages.delegates.forging_at" alignment="text-center" responsive/>
                <x-tables.headers.mobile.status name="pages.delegates.status" alignment="text-left" />
            </tr>
        </thead>
        <tbody>
            @foreach($delegates as $delegate)
                <tr
                    wire:key="$delegate->publicKey()"
                    @if ($delegate->keepsMissing())
                        class="bg-theme-danger-50"
                    @elseif ($delegate->justMissed())
                        class="bg-theme-warning-50"
                    @endif
                >
                    <td>
                        <x-tables.rows.mobile.slot-id :model="$delegate" />
                    </td>

                    {{-- Have to suffix it with a -2 to avoid issues with the other same wire:key for the desktop component --}}
                    <td wire:key="{{ $delegate->publicKey() }}-username-2">
                        <x-tables.rows.mobile.username-with-avatar :model="$delegate->wallet()" />
                    </td>

                    <td class="hidden sm:table-cell">
                        <x-tables.rows.mobile.slot-time :model="$delegate" />
                    </td>

                    {{-- Have to suffix it with a -2 to avoid issues with the other same wire:key for the desktop component --}}
                    <td wire:key="{{ $delegate->publicKey() }}-round-status-{{ $delegate->status() }}-2">
                        <x-tables.rows.mobile.round-status :model="$delegate" />
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
