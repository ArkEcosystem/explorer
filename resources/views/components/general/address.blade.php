<div class="flex items-center space-x-3" {{ $loadingAttribute ?? ''}} wire:loading.class="hidden">
    @unless ($icon ?? false)
        <x-general.avatar :identifier="$address" />
    @else
        {{ $icon }}
    @endunless

    <div class="flex items-center">
        @if ($prefix ?? false)
            {{ $prefix }}
        @endif

        <a href="{{ route('wallet', $address) }}" class="font-semibold link truncated-address">
            <x-truncate-middle :value="$address" />
        </a>

        <a href="{{ route('wallet', $address) }}" class="font-semibold link truncated-address md:hidden">
            {{ $address }}
        </a>
    </div>
</div>
