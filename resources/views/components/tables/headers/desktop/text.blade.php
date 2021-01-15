@isset($responsive)
    <th
        class="hidden {{ $breakpoint ?? 'lg' }}:table-cell text-left cursor-pointer"
        @isset($onClick)
            wire:click="{{ $onClick }}"
        @endisset
    >
        @lang($name)
    </th>
@else
    <th
        class="text-left cursor-pointer"
        @isset($onClick)
            wire:click="{{ $onClick }}"
        @endisset
    >
        @lang($name)
    </th>
@endisset
