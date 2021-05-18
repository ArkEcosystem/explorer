@props([
    'icon',
    'label',
    'disabled' => false,
])

<div class="flex items-center py-4 space-x-4 bg-white rounded-lg px-7">
    <span class="flex items-center justify-center w-10 h-10 border-2 rounded-full  @if($disabled) border-theme-secondary-500 text-theme-secondary-500 @else border-theme-secondary-900 text-theme-secondary-900 @endif">
        <x-ark-icon :name="$icon" />
    </span>
    <span class="flex flex-col justify-between h-full">
        <span class="text-sm font-semibold leading-none text-theme-secondary-500 whitespace-nowrap">{{$label}}:</span>
        <span class="text-lg font-semibold leading-none whitespace-nowrap @if($disabled) text-theme-secondary-500 @else text-theme-secondary-900 @endif">
            {{ $slot }}
        </span>
    </span>

    @isset($side)
        {{ $side }}
    @endisset
</div>
