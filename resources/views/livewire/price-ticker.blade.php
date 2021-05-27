<div
    wire:poll.60s
    class="uppercase"
    x-data="{ to: '{{ $to }}', busy: false }"
    x-init="livewire.on('currencyChanged', () => busy = true);"
>
    <span :class="{ 'opacity-50': busy }">{{ $from }}/{{ $to }}: {{ $price }}</span>
</div>
