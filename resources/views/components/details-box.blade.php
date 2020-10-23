<div class="flex detail-box">
    @if(isset($icon))
        <div
            class="flex items-center justify-center p-2 rounded-full h-12 w-12 mr-3 bg-theme-secondary-200 {{ $iconWrapperClass ?? 'border border-theme-secondary-300' }}"
        >
            @svg($icon, 'h-4 w-4 text-theme-secondary-900'.($iconClass ?? ''))
        </div>
    @endif
    <div class="flex flex-col">
        <span class="font-semibold text-theme-secondary-500 text-sm">{{ $title }}</span>
        @if($value || is_numeric($value) ?? false)
            <span class="font-semibold text-lg text-theme-secondary-700">{{ $value }} @if($extraValue ?? false) <span class="text-theme-secondary-500">{{ $extraValue }}</span> @endif</span>
        @else
            <span class="font-semibold text-theme-secondary-500">@lang('generic.not_specified')</span>
        @endif
    </div>
</div>