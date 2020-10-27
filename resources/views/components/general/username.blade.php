<div>
    <div
        class="flex flex-row-reverse items-center md:flex-row md:space-x-3 md:justify-start"
        @if ($withLoading ??false) wire:loading.class="hidden" {{ $loadingAttribute ?? ''}} @endif
    >
        @unless ($icon ?? false)
            <x-general.avatar :identifier="$transaction->address" />
        @else
            {{ $icon }}
        @endunless

        @php($username = $transaction->attributes['delegate']['username'])

        <div class="flex items-center mr-4 md:mr-0">
            @if ($prefix ?? false)
                {{ $prefix }}
            @endif

            <a href="{{ route('wallet', $transaction->address) }}" class="font-semibold link">
                {{ $username }}
            </a>
        </div>
    </div>

    @if ($withLoading ?? false)
        <x-general.loading-state.recipient-address :address="$transaction->address" />
    @endif
</div>