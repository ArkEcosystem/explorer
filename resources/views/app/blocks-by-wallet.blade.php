@component('layouts.app', ['isLanding' => true, 'fullWidth' => true])

    @push('metatags')
        <meta property="og:title" content="@lang('metatags.blocks_by_wallet.title')" />
        <meta property="og:description" content="@lang('metatags.blocks_by_wallet.description')">
    @endpush

    @push('scripts')
        <script src="{{ mix('js/clipboard.js')}}"></script>
    @endpush

    @section('content')
        <x-wallet.header-blocks :wallet="$wallet" />

        <livewire:wallet-qr-code :address="$wallet->address()" />

        <div class="bg-white border-t-20 border-theme-secondary-100 dark:border-black dark:bg-theme-secondary-900">
            <div class="py-16 content-container md:px-8">
                <div x-cloak class="w-full">
                    <div class="relative flex items-center justify-between">
                        <h2 class="text-xl sm:text-2xl">@lang('metatags.blocks_by_wallet.title')</h2>
                    </div>

                    <livewire:wallet-block-table :public-key="$wallet->publicKey()" />
                </div>
            </div>
        </div>
    @endsection

@endcomponent
