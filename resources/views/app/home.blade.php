@component('layouts.app', ['isLanding' => true, 'fullWidth' => true])

    @push('metatags')
        <meta property="og:title" content="@lang('metatags.home.title')" />
        <meta property="og:description" content="@lang('metatags.home.description')">
        <meta property="og:image" content="@lang('metatags.home.image')" />
    @endpush

    @section('breadcrumbs')
        <x-breadcrumbs :crumbs="[
            ['label' => trans('menus.home')],
        ]" />
    @endsection

    @section('content')

    @endsection

@endcomponent
