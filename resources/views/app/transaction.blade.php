@component('layouts.app', ['isLanding' => true, 'fullWidth' => true])
    @push('scripts')
        <script src="{{ mix('js/clipboard.js')}}"></script>
    @endpush

    <x-ark-metadata page="transactions" />

    @section('content')
        <x-page-headers.transaction :transaction="$transaction" />

        <x-details.grid>
            <x-dynamic-component :component="$transaction->typeComponent()" :transaction="$transaction" />
        </x-details.grid>

        @if($transaction->hasExtraData())
            <x-dynamic-component :component="$transaction->extensionComponent()" :transaction="$transaction" />
        @endif
    @endsection
@endcomponent
