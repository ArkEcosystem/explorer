@isset($responsive)
    <th
        class="hidden {{ $breakpoint ?? 'lg'}}:table-cell text-right cursor-pointer"
        @isset($onClick)
            wire:click="{{ $onClick }}"
        @endisset
    >
        @lang($name)
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
            </div>
        @else
            @lang($name)
        @endisset
    </th>
@endisset
