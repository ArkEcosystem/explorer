<div
    class="flex w-full space-x-5"
    wire:poll.{{ Network::blockTime() }}s
>
    <x-stats.stat :label="trans('general.height')" icon="app-block_height">
        <x-number>{{ $height }}</x-number>
    </x-stats.stat>

    <x-stats.stat :label="trans('general.total_supply')" icon="app-supply">
        <x-currency :currency="Network::currency()">{{ $supply }}</x-currency>
    </x-stats.stat>

    <x-stats.stat :label="trans('general.market_cap')" icon="app-market_cap">
        {{ $marketCap }}
    </x-stats.stat>

    <x-stats.stat class="justify-between flex-grow" :label="trans('general.price')" icon="app-price" :disabled="! Network::canBeExchanged()">
        {{ $price }}

        <x-slot name="side">
            <livewire:price-stats :placeholder=" ! Network::canBeExchanged()" />
        </x-slot>
    </x-stats.stat>

</div>
