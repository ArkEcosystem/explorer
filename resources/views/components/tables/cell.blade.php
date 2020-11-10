<td {{ $attributes->merge(['class' => 'group-hover:bg-theme-secondary-100 relative'. (isset($attributes['class']) ? $attributes['class'] : '') ]) }}>
    {{ $slot }}
</td>
