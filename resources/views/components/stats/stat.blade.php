@props([
    'icon',
    'label',
    'disabled' => false,
])

<div {{ $attributes->merge(['class' => 'flex py-4 bg-white rounded-lg px-7']) }}>
    <div class="flex items-center space-x-4">
        <span
            class="flex items-center justify-center w-10 h-10 border-2 rounded-full @if($disabled) border-theme-secondary-500 text-theme-secondary-500 @else border-theme-secondary-900 text-theme-secondary-900 @endif"
            @unless($disabled)
                wire:loading.class.remove="border-theme-secondary-900 text-theme-secondary-900"
            @endunless
            wire:loading.class="border-theme-secondary-500 text-theme-secondary-500"
        >
            <x-ark-icon :name="$icon" />
        </span>
        <span class="flex flex-col justify-between h-full">
            <span class="text-sm font-semibold leading-none whitespace-nowrap text-theme-secondary-500">{{$label}}:</span>
            @if ($disabled)
                <span class="font-semibold leading-none whitespace-nowrap text-theme-secondary-500">
                    @lang('general.not_available')
                </span>
            @else
                <span
                    class="font-semibold leading-none whitespace-nowrap text-theme-secondary-900"
                    wire:loading.class.remove="text-theme-secondary-900"
                    wire:loading.class="text-theme-secondary-500"
                >
                    {{ $slot }}
                </span>
            @endif
        </span>
    </div>

    @isset($side)
        {{ $side }}
    @endisset
</div>
