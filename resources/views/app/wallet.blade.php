@component('layouts.app', ['isLanding' => true, 'fullWidth' => true])

    @push('metatags')
        <meta property="og:title" content="@lang('metatags.wallet.title')" />
        <meta property="og:description" content="@lang('metatags.wallet.description')">
    @endpush

    @push('scripts')
        <script src="{{ mix('js/clipboard.js')}}"></script>
    @endpush

    @section('content')
<<<<<<< HEAD
        <x-wallet.header :wallet="$wallet" />

        <livewire:wallet-qr-code :address="$wallet->address()" />
        <livewire:wallet-public-key :public-key="$wallet->publicKey()" />
=======
        <x-wallet.heading.wallet :wallet="$wallet" />
>>>>>>> develop

        @if($wallet->isDelegate())
            <x-wallet.delegate :wallet="$wallet" />
        @endif

        @if($wallet->hasRegistrations())
            <x-wallet.registrations :wallet="$wallet" />
        @endif

        <x-wallet.transactions :wallet="$wallet" />
    @endsection

@endcomponent
