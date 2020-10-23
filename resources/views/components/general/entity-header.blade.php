<div class="flex flex-col rounded-lg overflow-hidden border border-theme-secondary-300 dark:border-theme-secondary-800">
    <div class="bg-black dark:bg-theme-secondary-900 p-8">
        <div class="flex flex-col md:flex-row">
            <div class="hidden items-center md:flex">
                <div class="circled-icon text-theme-secondary-400 border-theme-danger-400">
                    {{ $logo }}
                </div>
            </div>

            <div class="flex flex-col flex-1 justify-between font-semibold md:ml-4">
                <div class="text-sm leading-tight text-theme-secondary-600 dark:text-theme-secondary-700">{{ $title }}</div>

                <div class="flex items-center space-x-2 leading-tight">
                    <span class="truncate text-theme-secondary-400 dark:text-theme-secondary-200">{{ $value }}</span>

                    <x-ark-clipboard :value="$value" class="flex items-center w-auto h-auto text-theme-secondary-600" no-styling />
                </div>
            </div>

            @if ($extra ?? false)
                {{ $extra }}
            @endif
        </div>
    </div>

    <div class="bg-theme-secondary-100 border-t border-theme-secondary-300 dark:border-theme-secondary-800 dark:bg-theme-secondary-900 p-8">
        {{ $bottom }}
    </div>
</div>
