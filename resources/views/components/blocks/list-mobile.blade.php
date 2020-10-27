<div class="space-y-8 divide-y table-list-mobile">
    @foreach ($blocks as $block)
        <div class="space-y-3 table-list-mobile-row">
            <div>
                @lang('general.block.id')

                <x-general.loading-state.text class="font-semibold">
                    <x-slot name="text">
                        <x-truncate-middle :value="$block->id()" />
                    </x-slot>
                </x-general.loading-state.text>

                <a href="{{ $block->url() }}" class="font-semibold link" wire:loading.class="hidden">
                    <x-truncate-middle :value="$block->id()" />
                </a>
            </div>

            <div>
                @lang('general.block.timestamp')

                <x-general.loading-state.text :text="$block->timestamp()" />

                <span wire:loading.class="hidden">{{ $block->timestamp() }}</span>
            </div>

            <div>
                @lang('general.block.generated_by')

                <x-general.address :address="$block->delegateUsername()" with-loading />
            </div>

            <div>
                @lang('general.block.height')

                <x-general.loading-state.text :text="$block->height()" />

                <span wire:loading.class="hidden">{{ $block->height() }}</span>
            </div>

            <div>
                @lang('general.block.transactions')

                <x-general.loading-state.text :text="$block->transactionCount()" />

                <span wire:loading.class="hidden">{{ $block->transactionCount() }}</span>
            </div>

            <div>
                @lang('general.block.amount')

                <x-general.loading-state.text :text="$block->amount()" />

                <div wire:loading.class="hidden">
                    <x-general.amount-fiat-tooltip :amount="$block->amount()" :fiat="$block->amountFiat()" />
                </div>
            </div>

            <div>
                @lang('general.block.fee')

                <x-general.loading-state.text :text="$block->fee()" />

                <div wire:loading.class="hidden">
                    <x-general.amount-fiat-tooltip :amount="$block->fee()" :fiat="$block->feeFiat()" />
                </div>
            </div>
        </div>
    @endforeach
</div>
