<div>
    <div
        class="flex items-center space-x-3"
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

        <div class="flex items-center">
            @if ($prefix ?? false)
                {{ $prefix }}
            @endif

        <a href="{{ route('wallet', $address) }}" class="font-semibold link sm:hidden md:flex">
            <x-truncate-middle :value="$address" />
        </a>

        <a href="{{ route('wallet', $address) }}" class="font-semibold link hidden sm:flex md:hidden">
            {{ $address }}
        </a>
    </div>

    @if ($withLoading ?? false)
        <x-general.loading-state.recipient-address :address="$address" />
    @endif
</div>
