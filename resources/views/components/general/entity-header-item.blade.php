<div class="entity-header-item w-full {{ $wrapperClass ?? false }}">
    @unless($withoutIcon ?? false)
        <div class="{{ $iconBreakpoint ?? 'flex' }} items-center">
            <div class="circled-icon {{ $iconColors ?? 'text-theme-secondary-900 border-theme-secondary-900 dark:text-theme-secondary-600 dark:border-theme-secondary-600' }}">
                @if ($icon ?? false)
                    @if ($iconSize ?? false)
                        <x-ark-icon :name="$icon" :size="$iconSize" />
                    @else
                        <x-ark-icon :name="$icon" />
                    @endif
                @elseif ($avatar ?? false)
                    <x-general.avatar-small :identifier="$avatar" />
                @endif
            </div>
        </div>
    @endunless

    <div class="flex flex-col flex-1 justify-between ml-4 font-semibold truncate md:pr-4 @if($withoutIcon ?? false) md:pl-11 lg:pl-0 @endif">
        <div class="flex items-center">
            <div class="text-sm leading-tight text-theme-secondary-600 dark:text-theme-secondary-700">{{ $title }}</div>

            @if($tooltip ?? false)
                <x-ark-info :tooltip="$tooltip" class="ml-2 p-1.5" type="info" />
            @endif
        </div>

        @if ($url ?? false)
            <a href="{{ $url }}" class="flex leading-tight link">
                <span class="truncate">{{ $text }}</span>
            </a>
        @else
            <span class="leading-tight truncate text-theme-secondary-900 dark:text-theme-secondary-200">{{ $text }}</span>
        @endif
    </div>
</div>
