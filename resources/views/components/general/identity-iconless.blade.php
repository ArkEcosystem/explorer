<div class="flex items-center justify-between space-x-3">
    <div class="flex items-center">
        @if ($prefix ?? false)
            {{ $prefix }}
        @endif

        <a href="{{ route('wallet', $model->address()) }}" class="font-semibold link">
            @if ($model->username())
                {{ $model->username() }}
            @else
                @isset($withoutTruncate)
                    {{ $model->address() }}
                @else
                    <x-truncate-middle length="{{ $length ?? 8 }}">
                        {{ $model->address() }}
                    </x-truncate-middle>
                @endisset
            @endif
        </a>
    </div>
</div>
