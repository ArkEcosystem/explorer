<div class="entity-header-item">
    <div class="flex items-center">
        <div class="circled-icon text-theme-secondary-900 border-theme-secondary-900">
            @if ($icon ?? false)
                @svg($icon, 'w-5 h-5')
            @elseif ($avatar ?? false)
                <x-general.avatar :identifier="$avatar" size="w-8 h-8" />
            @endif
        </div>
    </div>

    <div class="flex flex-col flex-1 justify-between font-semibold ml-4">
        <div class="text-sm leading-tight text-theme-secondary-600">{{ $title }}</div>

        @if ($url ?? false)
            <a href="{{ $url }}" class="link flex leading-tight">
                <span class="truncate">{{ $text }}</span>
            </a>
        @else
            <span class="truncate leading-tight text-theme-secondary-900">{{ $text }}</span>
        @endif
    </div>
</div>
