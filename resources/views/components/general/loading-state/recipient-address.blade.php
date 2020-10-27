<div class="flex items-center justify-between flex-row-reverse md:flex-row md:space-x-3 md:justify-start">
    <div>
        <div wire:loading.class="w-6 h-6 rounded-full md:w-11 md:h-11 loading-state"></div>
    </div>

    <div
        wire:loading.class.remove="hidden"
        class="hidden text-transparent rounded-full loading-state mr-4 md:mr-0"
    >
        @if ($address ?? false)
            <x-truncate-middle :value="$address" />
        @else
            {{ $text }}
        @endif
    </div>
</div>
