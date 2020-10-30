<div class="dark:bg-theme-secondary-900">
    <div class="flex-col pt-16 mb-16 space-y-6 content-container">
        <x-general.search.header-slim :title="trans('pages.wallet.title')" />

        <x-general.entity-header :value="$wallet->address()">
            <x-slot name="title">
                @if($wallet->isDelegate())
                    @lang('pages.wallet.address_delegate', [$wallet->username()])
                @else
                    @lang('pages.wallet.address')
                @endif
            </x-slot>

            <x-slot name="logo">
                @if($wallet->isDelegate())
                    <x-headings.avatar-with-icon :model="$wallet" icon="app-delegate" />
                @else
                    <x-headings.avatar :model="$wallet" />
                @endif
            </x-slot>

            <x-slot name="extra">
                <div class="flex flex-col flex-1 font-semibold md:flex-row lg:pl-4 md:space-x-4 lg:space-x-4 lg:border-l lg:ml-8 border-theme-secondary-800">
                    <div class="items-center hidden md:flex">
                        <div class="w-12 h-12 border-theme-secondary-700 circled-icon text-theme-secondary-700">
                            @svg('wallet', 'w-4 h-4')
                        </div>
                    </div>

                    <div class="flex flex-col space-y-4">
                        <div class="text-sm leading-tight text-theme-secondary-600 dark:text-theme-secondary-700">
                            @lang('pages.wallet.balance')
                        </div>

                        <div class="flex items-center space-x-2 leading-tight">
                            <span class="truncate text-theme-secondary-400 dark:text-theme-secondary-200">
                                <x-currency>{{ $wallet->balance() }}</x-currency>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center mt-6 space-x-2 text-theme-secondary-200 lg:mt-0">
                    <button @click="livewire.emit('togglePublicKey')" type="button" class="flex items-center justify-center flex-1 w-16 px-3 rounded cursor-pointer bg-theme-secondary-800 hover:bg-theme-primary-600 transition-default lg:flex-none h-11">
                        @svg('key', 'w-6 h-6')
                    </button>

                    <button @click="livewire.emit('toggleQrCode')" type="button" class="flex items-center justify-center flex-1 w-16 px-3 rounded cursor-pointer bg-theme-primary-600 hover:bg-theme-primary-700 transition-default lg:flex-none h-11">
                        @svg('app-qr-code', 'w-6 h-6')
                    </button>
                </div>
            </x-slot>

            @if($wallet->isVoting())
                @php($vote = $wallet->vote())

                <x-slot name="bottom">
                    <div class="grid grid-cols-1 gap-8 md:grid-cols-2 xl:grid-cols-4">
                        <x-general.entity-header-item
                            :title="trans('pages.wallet.voting_for')"
                            :avatar="$vote->username()"
                            :text="$vote->username()"
                            :url="route('wallet', $vote->address())"
                        />
                        <x-general.entity-header-item
                            :title="trans('pages.wallet.rank')"
                            icon="app-votes"
                        >
                            <x-slot name="text">
                                @lang('pages.wallet.vote_rank', [$vote->rank()])
                            </x-slot>
                        </x-general.entity-header-item>
                        @if (Network::usesMarketSquare())
                            <x-general.entity-header-item
                                :title="trans('pages.wallet.commission')"
                                icon="exchange"
                                :text="$vote->commission()"
                            />
                        @endif
                    </div>
                </x-slot>
            @endif
        </x-general.entity-header>
    </div>
</div>
