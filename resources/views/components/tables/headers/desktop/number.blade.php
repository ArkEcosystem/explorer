@isset($responsive)
    <th
        class="hidden {{ $breakpoint ?? 'lg'}}:table-cell text-right cursor-pointer"
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
        class="text-right cursor-pointer"
        @isset($onClick)
            wire:click="{{ $onClick }}"
        @endisset
    >
        @isset ($slot)
            <div class="inline-flex items-center space-x-2">
                <div>@lang($name)</div>

                {{ $slot }}

                @isset($sortingDirection)
                    <x-general.sorting-icon :sorting-direction="$sortingDirection" />
                @endisset
            </div>
        @else
            <div class="flex items-center">
                @lang($name)

                @isset($sortingDirection)
                    <x-general.sorting-icon :sorting-direction="$sortingDirection" />
                @endisset
            </div>
        @endisset
    </th>
@endisset
