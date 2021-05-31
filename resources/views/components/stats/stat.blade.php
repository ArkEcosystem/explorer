@props([
    'icon',
    'label',
    'disabled' => false,
])

<div {{ $attributes->merge(['class' => 'flex py-4 bg-white dark:bg-theme-secondary-900 rounded-xl px-7']) }}>
    <div class="flex items-center flex-grow space-x-4">
        <span
            class="flex items-center justify-center w-10 h-10 border-2 rounded-full @if($disabled) dark:border-theme-secondary-600 border-theme-secondary-500 dark:text-theme-secondary-600 text-theme-secondary-500 @else border-theme-secondary-900 text-theme-secondary-900 dark:text-theme-secondary-700 dark:border-theme-secondary-700 @endif"
        >
            <x-ark-icon :name="$icon" />
        </span>
        <span class="flex flex-col justify-between flex-grow h-full">
            <span class="text-sm font-semibold leading-none whitespace-nowrap dark:text-theme-secondary-600 text-theme-secondary-500">{{$label}}</span>

            @if ($disabled)
                <span class="font-semibold leading-none whitespace-nowrap dark:text-theme-secondary-600 text-theme-secondary-500">
                    @lang('general.not_available')
                </span>
            @else
                <span class="font-semibold leading-none whitespace-nowrap text-theme-secondary-900 dark:text-white">
                    {{ $slot }}
                </span>
            @endif
        </span>
    </div>

    @isset($side)
        {{ $side }}
    @endisset
</div>
