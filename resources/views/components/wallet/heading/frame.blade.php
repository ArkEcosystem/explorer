<div class="dark:bg-theme-secondary-900">
    @dd($extension)
    <div class="flex-col pt-16 mb-16 space-y-6 content-container">
        <x-general.search.header-slim :title="trans($title)" />

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
                {{ $slot }}

                <div class="flex items-center mt-6 space-x-2 text-theme-secondary-200 lg:mt-0">
                    <x-wallet.heading.actions.public-key />

                    <x-wallet.heading.actions.qr-code :wallet="$wallet" />
                </div>
            </x-slot>

            @isset($extension)
                {{ $extension }}
            @endisset
        </x-general.entity-header>
    </div>
</div>
