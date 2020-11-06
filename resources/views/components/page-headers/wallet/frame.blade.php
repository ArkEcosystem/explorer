<div class="dark:bg-theme-secondary-900">
    <div class="flex-col pt-16 mb-16 space-y-6 content-container">
        <x-general.search.header-slim :title="trans($title)" />

        <x-general.entity-header :value="$wallet->address()">
            <x-slot name="title">
                @isset($useGenerator)
                    @lang('pages.wallet.address_generator', [$wallet->username()])
                @else
                    @if($wallet->isDelegate())
                        @lang('pages.wallet.address_delegate', [$wallet->username()])
                    @else
                        @lang('pages.wallet.address')
                    @endif

                    @if ($wallet->isKnown())
                        <x-icon name="app-verified" size="sm" />
                    @endif
                        <x-icon name="app.transactions-multi-signature" size="sm" />
                    @if ($wallet->isOwnedByExchange())
                        <x-icon name="app-exchange" size="sm" />
                    @endif
                    <x-icon name="app.transactions-second-signature" size="sm" />
                @endif
            </x-slot>

            <x-slot name="logo">
                @if($wallet->isDelegate())
                    @if ($wallet->isResigned())
                        <x-page-headers.avatar-with-icon :model="$wallet" icon="app.transactions-delegate-resignation" />
                    @else
                        <x-page-headers.avatar-with-icon :model="$wallet" icon="app-delegate" />
                    @endif
                @else
                    <x-page-headers.avatar :model="$wallet" />
                @endif
            </x-slot>

            <x-slot name="extension">
                {{ $slot }}

                <div class="flex items-center mt-6 space-x-2 text-theme-secondary-200 lg:mt-0">
                    @unless($wallet->isCold())
                        <x-page-headers.wallet.actions.public-key :public-key="$wallet->publicKey()" />
                    @endunless

                    <x-page-headers.wallet.actions.qr-code :wallet="$wallet" />
                </div>
            </x-slot>

            @isset($extension)
                <x-slot name="bottom">
                    {{ $extension }}
                </x-slot>
            @endisset
        </x-general.entity-header>
    </div>
</div>
