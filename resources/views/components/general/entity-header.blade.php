<div class="flex flex-col rounded-lg overflow-hidden border border-theme-secondary-300">
    <div class="bg-black p-8">
        <div class="flex flex-col md:flex-row">
            <div class="hidden items-center md:flex">
                <div class="circled-icon text-theme-secondary-400 border-theme-danger-400">
                    {{ $logo }}
                </div>
            </div>

            <div class="flex flex-col flex-1 justify-between font-semibold md:ml-4">
                <div class="text-sm leading-tight text-theme-secondary-600">{{ $title }}</div>

                <div class="flex items-center space-x-2 leading-tight text-theme-secondary-400">
                    <span class="truncate">{{ $value }}</span>

                    <x-ark-clipboard :value="$value" class="w-auto h-auto" no-styling />
                </div>
            </div>

            @if ($extra ?? false)
                {{ $extra }}
            @endif
        </div>
    </div>

    <div class="bg-theme-secondary-100 p-8">
        {{ $bottom }}
    </div>
</div>
