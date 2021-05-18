<div class="flex space-x-5"  wire:poll.{{ Network::blockTime() }}s>
    <x-stats.stat :label="trans('general.height')" icon="app-block_height">
        <x-number>{{ $height }}</x-number>
    </x-stats.stat>

    <x-stats.stat :label="trans('general.total_supply')" icon="app-block_height">
        <x-currency :currency="Network::currency()">{{ $supply }}</x-currency>
    </x-stats.stat>

    <x-stats.stat :label="trans('general.market_cap')" icon="app-block_height">
        <x-currency :currency="Network::currency()">{{ $marketCap }}</x-currency>
    </x-stats.stat>

    <x-stats.stat :label="trans('general.price')" icon="app-block_height" :disabled="! Network::canBeExchanged()">
        <livewire:price-ticker />

        <x-slot name="side">
            <livewire:price-stats />
        </x-slot>
    </x-stats.stat>

</div>
