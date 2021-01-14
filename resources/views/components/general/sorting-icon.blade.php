<div wire:key="{{ Str::random(8) }}">
    @isset($sortingDirection)
        @php($direction = $sortingDirection === 'desc' ? 'down' : 'up')
        @svg("chevron-{$direction}", 'ml-2 w-2 h-2')
    @endisset
</div>