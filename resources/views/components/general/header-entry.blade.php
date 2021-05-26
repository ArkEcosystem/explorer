@props([
    //'withoutBorder'    => false,
    //'borderBreakpoint' => 'sm:',
    'icon'             => null,
    'tooltip'          => null,
    'url'              => null,
    'textAlignment'    => null,
    'wrapperClass'     => null,
    'title',
    'text',
])

{{--<div class="flex @if (! $withoutBorder) {{ $borderBreakpoint }}border-r border-theme-secondary-300 dark:border-theme-secondary-800 sm:mr-5 lg:mr-0 lg:pr-5 @endif h-11 {{ $wrapperClass }}">--}}
<div class="flex h-11 {{ $wrapperClass }}">
    @if ($icon)
        {{ $icon }}
    @endif

    <div class="flex flex-col justify-between font-semibold truncate">
        <div class="flex items-center">
            <div class="text-sm leading-tight text-theme-secondary-600 dark:text-theme-secondary-700">{{ $title }}</div>

            @if($tooltip)
                <x-ark-info :tooltip="$tooltip" class="ml-2 p-1.5" type="info" />
            @endif
        </div>

        @if ($url)
            <a href="{{ $url }}" class="flex mt-2 leading-tight link">
                <span class="w-full truncate {{ $textAlignment }}">{{ $text }}</span>
            </a>
        @else
            <span class="mt-2 leading-tight truncate text-theme-secondary-900 dark:text-theme-secondary-200 {{ $textAlignment }}">{{ $text }}</span>
        @endif
    </div>
</div>
