{{-- <div id="network-list" class="w-full" wire:poll.8s> --}}
<div id="network-list" class="w-full">
    <x-delegates.table-desktop-monitor :delegates="$delegates" />

    {{-- <x-delegates.list-mobile-monitor :delegates="$delegates" /> --}}
</div>
