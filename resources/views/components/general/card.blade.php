@props(['withBorder' => false])

<div {{ $attributes->class([
        'rounded-xl',
        'px-7 py-4 bg-white dark:bg-theme-secondary-900' => ! $withBorder,
        'p-8 border border-theme-secondary-300 dark:border-theme-secondary-800' => $withBorder,
    ]) }}>
    {{ $slot }}
</div>
