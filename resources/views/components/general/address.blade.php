<div>
    <div
        class="flex items-center flex-row-reverse md:flex-row md:space-x-3 md:justify-start"
        @if ($withLoading ?? false)
            wire:loading.class="hidden"
            {{ $loadingAttribute ?? ''}}
        @endif
    >
        @unless ($icon ?? false)
            <x-general.avatar :identifier="$address" />
        @else
            {{ $icon }}
        @endunless

        <div class="mr-4 md:mr-0 flex items-center">
            @if ($prefix ?? false)
                {{ $prefix }}
            @endif

            <a href="{{ route('wallet', $address) }}" class="font-semibold link sm:hidden md:flex">
                <x-truncate-middle :value="$address" />
            </a>

            <a href="{{ route('wallet', $address) }}" class="hidden font-semibold link sm:flex md:hidden">
                {{ $address }}
            </a>
        </div>
    </div>

    @if ($withLoading ?? false)
        <x-general.loading-state.recipient-address :address="$address" />
    @endif
</div>
