@component('layouts.app', ['containerClass' => 'flex items-center'])
    @push('metatags')
        <meta property="og:title" content="404 - Error | ARK Documentation" />
    @endpush

    @section('content')
        <div class="flex flex-col items-center justify-center space-y-8">
            <img src="/images/errors/404_entity.svg" class="max-w-sm dark:hidden"/>
            <img src="/images/errors/404_entity_dark.svg" class="hidden max-w-sm dark:block"/>
            <div class="text-lg font-semibold text-center text-theme-secondary-900 dark:text-theme-secondary-600">
                {{ $exception->getPrevious()->getCustomMessage() }}
            </div>
            <div class="space-x-3">
                <a href="{{ route('home') }}" class="button-primary">@lang('menus.home')</a>
                <a href="{{ url()->current() }}" class="button-secondary">@lang('general.reload')</a>
            </div>
        </div>
    @endsection
@endcomponent
