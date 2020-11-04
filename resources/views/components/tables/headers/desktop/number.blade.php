@isset($responsive)
    <th class="hidden text-right lg:table-cell">@lang($name)</th>
@else
    <th class="text-right">@lang($name)</th>
@endisset
