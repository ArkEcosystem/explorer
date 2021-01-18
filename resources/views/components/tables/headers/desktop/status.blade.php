@isset($responsive)
    <th class="hidden {{ $breakpoint ?? 'lg' }}:table-cell text-left cursor-pointer">@lang($name)</th>
@else
    <th class="text-left">
        @isset ($slot)
            <div class="inline-flex items-center space-x-2 cursor-pointer">
                <div>@lang($name)</div>

                {{ $slot }}
            </div>
        @else
            @lang($name)
        @endisset
    </th>
@endisset
