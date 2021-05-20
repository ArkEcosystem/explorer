@props([
    'wrapperClass'        => null,
    'withoutSingleIcon'   => false,
    'iconBreakpoint'      => 'flex',
    'iconColors'          => 'text-theme-secondary-900 border-theme-secondary-900 dark:text-theme-secondary-600 dark:border-theme-secondary-600',
    'icon'                => null,
    'iconSize'            => null,
    'avatar'              => null,
    'withMultipleIcons'   => false,
    'multipleIconsFirst'  => null,
    'multipleIconsSecond' => null,
    'title'               => null,
    'tooltip'             => null,
    'url'                 => null,
    'text'                => null,
    'firstIcon'           => null,
    'firstIconColors'     => null,
    'secondIcon'          => null,
    'secondIconColors'    => null,
    'textClass'           => null,
    'titleWrapperClass'   => null,
    'contentClass'        => null,
])

<div class="entity-header-item w-full h-full {{ $wrapperClass }}">
    @unless($withoutSingleIcon)
        <div class="{{ $iconBreakpoint }} items-center">
            <div class="circled-icon {{ $iconColors }}">
                @if ($icon)
                    @if ($iconSize)
                        <x-ark-icon :name="$icon" :size="$iconSize" />
                    @else
                        <x-ark-icon :name="$icon" />
                    @endif
                @elseif ($avatar)
                    <x-general.avatar-small :identifier="$avatar" />
                @endif
            </div>
        </div>
    @endunless

    @if($withMultipleIcons)
        <div class="{{ $iconBreakpoint }} items-center">
            <x-page-headers.icon-with-icon
                :first-icon="$firstIcon"
                :first-icon-colors="$firstIconColors"
                :second-icon="$secondIcon"
                :second-icon-colors="$secondIconColors"
            />
        </div>
    @endif

    <div class="{{ $contentClass ?? 'flex flex-col flex-1 justify-between ml-4 font-semibold truncate md:pr-4' }} @if($withoutSingleIcon && ! $withMultipleIcons && ! $contentClass) md:pl-11 lg:pl-0 @endif">
        <div class="flex items-center {{ $titleWrapperClass }}">
            <div class="items-end text-sm leading-tight text-theme-secondary-500 dark:text-theme-secondary-700">{{ $title }}</div>

            @if($tooltip)
                <x-ark-info :tooltip="$tooltip" class="ml-2 p-1.5" type="info" />
            @endif
        </div>

        @if ($url)
            <a href="{{ $url }}" class="flex leading-tight link">
                <span class="truncate {{ $textClass }}">{{ $text }}</span>
            </a>
        @else
            <span class="leading-tight truncate text-theme-secondary-900 dark:text-theme-secondary-200">{{ $text }}</span>
        @endif
    </div>
</div>
