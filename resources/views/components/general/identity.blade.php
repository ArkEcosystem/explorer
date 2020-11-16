<div>
    <div class="flex {{ ($withoutReverse ?? false) ? 'space-x-3' : 'flex-row-reverse md:space-x-3' }} items-center md:flex-row md:justify-start">
        @unless ($icon ?? false)
            <x-general.avatar :identifier="$model->address()" />
        @else
            {{ $icon }}
        @endunless

        <div class="flex items-center mr-4 md:mr-0">
            @if ($prefix ?? false)
                {{ $prefix }}
            @endif

            <a href="{{ route('wallet', $model->address()) }}" class="font-semibold link sm:hidden md:flex">
                @if ($model->username())
                    <div class="{{ ($prefix ?? false) ? 'delegate-name-truncate-prefix' : 'delegate-name-truncate' }}">
                        {{ $model->username() }}
                    </div>
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
