<div>
    <div class="flex {{ $withoutReverse ?? false ? '' : 'flex-row-reverse' }} items-center md:flex-row space-x-3 md:justify-start">
        @unless ($icon ?? false)
            <x-general.avatar :identifier="$model->address()" avatar-size="{{ $avatarSize ?? 'w-11 h-11' }}" />
        @else
            {{ $icon }}
        @endunless

        <div class="flex items-center mr-4 md:mr-0">
            @if ($prefix ?? false)
                {{ $prefix }}
            @endif

            <a href="{{ route('wallet', $model->address()) }}" class="font-semibold link sm:hidden md:flex">
                @if ($model->username())
                    <p class="w-20 truncate">{{ $model->username() }}</p>
                @else
                    @isset($withoutTruncate)
                        {{ $model->address() }}
                    @else
                        <x-truncate-middle :value="$model->address()" />
                    @endisset
                @endif
            </a>

            <a href="{{ route('wallet', $model->address()) }}" class="hidden font-semibold link sm:flex md:hidden">
                @if ($model->username())
                    {{ $model->username() }}
                @else
                    {{ $model->address() }}
                @endif
            </a>
        </div>
    </div>
</div>
