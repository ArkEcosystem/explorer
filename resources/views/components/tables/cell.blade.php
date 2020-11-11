<td {{ $attributes->merge([
    'class' => (isset($breakpoint) ? $breakpoint.':table-cell hidden' : '')
        . (isset($last) && $last ? (' last-cell' . (is_string($last) ? ' last-cell-' . $last : '')) : '')
        . (isset($attributes['class']) ? ' ' . $attributes['class'] : '')
]) }}>
    {{ $slot }}
</td>
