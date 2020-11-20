<div class="flex items-center justify-between space-x-3">
    <div class="flex items-center max-w-full">
        @if ($prefix ?? false)
            {{ $prefix }}
        @endif

        <a href="{{ route('wallet', $model->address()) }}" class="max-w-full font-semibold link">
            @if ($model->username())
                {{ $model->username() }}
            @else
                @isset($withoutTruncate)
                    {{ $model->address() }}
                @else
                    <x-truncate>{{ $model->address() }}</x-truncate>
                @endisset
            @endif
        </a>
    </div>
</div>
