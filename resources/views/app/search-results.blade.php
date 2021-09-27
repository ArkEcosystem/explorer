@component('layouts.app', ['isLanding' => true, 'fullWidth' => true])
    <x-ark-metadata page="search" />

    @section('content')
        <livewire:search-page />
    @endsection
@endcomponent
