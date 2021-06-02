<div class="dark:bg-theme-secondary-900">
    <x-ark-container container-class="flex flex-col space-y-6">
        <h1 class="header-2">
            @lang('pages.block.title')
        </h1>

        <x-general.entity-header
            :title="trans('pages.block.block_id')"
            :value="$block->id()"
            is-block-page
        >
            <x-slot name="logo">
                <x-page-headers.circle>
                    <x-ark-icon name='app-block-id' />
                </x-page-headers.circle>
            </x-slot>

            @if ($block->previousBlockUrl() || $block->nextBlockUrl())
                <x-slot name="extension">
                    <div class="flex items-center mt-6 space-x-2 text-theme-secondary-400 lg:mt-0 lg:ml-3">
                        @if ($block->previousBlockUrl())
                            <a href="{{ $block->previousBlockUrl() }}" class="flex items-center justify-center flex-1 px-4 rounded cursor-pointer h-11 bg-theme-secondary-800 hover:bg-theme-secondary-700 transition-default lg:flex-none">
                                <x-ark-icon name="chevron-left" size="sm" />
                            </a>
                        @else
                            {{-- <span class="flex-1"></span> --}}
                        @endif

                        @if ($block->nextBlockUrl())
                            <a href="{{ $block->nextBlockUrl() }}" class="flex items-center justify-center flex-1 px-4 rounded cursor-pointer h-11 bg-theme-secondary-800 hover:bg-theme-secondary-700 transition-default lg:flex-none">
                                <x-ark-icon name="chevron-right" size="sm" />
                            </a>
                        @endif
                    </div>
                </x-slot>
            @endif

            <x-slot name="bottom">
                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 xl:grid-cols-4">
                    <x-general.entity-header-item
                        :title="trans('pages.block.generated_by')"
                        :avatar="$block->username()"
                        :text="$block->username()"
                        icon-size="md"
                        :url="route('wallet', $block->delegate()->address)"
                    />
                    <x-general.entity-header-item
                        :title="trans('pages.block.transactions')"
                        icon="app-transactions"
                        icon-size="md"
                        :text="$block->transactionCount()"
                    />
                    <x-general.entity-header-item
                        :title="trans('pages.block.transaction_volume')"
                        icon="app-transactions-amount"
                    >
                        <x-slot name="text">
                            <x-currency :currency="Network::currency()">{{ $block->amount() }}</x-currency>
                        </x-slot>
                    </x-general.entity-header-item>

                    <x-general.entity-header-item icon="app-reward" icon-size="md">
                        <x-slot name="title">
                            <span data-tippy-content="@lang('pages.block.total_rewards_tooltip', [$block->reward()])">
                                @lang('pages.block.total_rewards')
                            </span>
                        </x-slot>

                        <x-slot name="text">
                            <x-currency :currency="Network::currency()">{{ $block->totalReward() }}</x-currency>
                        </x-slot>
                    </x-general.entity-header-item>
                </div>
            </x-slot>
        </x-general.entity-header>
    </x-ark-container>
</div>
