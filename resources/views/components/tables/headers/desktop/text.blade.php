@isset($responsive)
    <th
        class="hidden {{ $breakpoint ?? 'lg' }}:table-cell text-left cursor-pointer"
        @isset($onClick)
            wire:click="{{ $onClick }}"
        @endisset
    >
        <div class="flex items-center">
            @lang($name)

            @isset($sortingDirection)
                <x-general.sorting-icon :sorting-direction="$sortingDirection" />
            @endisset
        </div>
    </th>
@else
    <th
        class="text-left cursor-pointer"
        @isset($onClick)
            wire:click="{{ $onClick }}"
        @endisset
    >
        <div class="flex items-center">
            @lang($name)

            @isset($sortingDirection)
                <x-general.sorting-icon :sorting-direction="$sortingDirection" />
            @endisset
        </div>
    </th>
@endisset
