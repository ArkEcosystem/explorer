@isset($responsive)
    <th
        class="hidden {{ $breakpoint ?? 'lg' }}:table-cell text-left cursor-pointer"
        {{ $attributes->except(['class', 'breakpoint', 'responsive']) }}
    >
        @lang($name)
    </th>
@else
    <th
        class="text-left cursor-pointer"
        {{ $attributes->except(['class', 'breakpoint', 'responsive']) }}
    >
        @lang($name)
    </th>
@endisset
