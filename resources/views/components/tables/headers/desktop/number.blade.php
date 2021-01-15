@isset($responsive)
    <th
        class="hidden {{ $breakpoint ?? 'lg'}}:table-cell text-right cursor-pointer"
        {{ $attributes->except(['class', 'breakpoint', 'responsive']) }}
    >
        @lang($name)
    </th>
@else
    <th
        class="text-right cursor-pointer"
        {{ $attributes->except(['class', 'breakpoint', 'responsive']) }}
    >
        @isset ($slot)
            <div class="inline-flex items-center space-x-2">
                <div>@lang($name)</div>

                {{ $slot }}
            </div>
        @else
            <div class="flex items-center">
                @lang($name)
            </div>
        @endisset
    </th>
@endisset
