<div class="{{ $firstIconBreakpoints ?? 'hidden lg:flex' }} ">
    <div class="-mr-2 circled-icon  {{ $firstIconColors ?? 'text-theme-secondary-900 border-theme-secondary-900' }} dark:text-theme-secondary-600 dark:border-theme-secondary-600">
        <x-ark-icon :name="$firstIcon" />
    </div>
</div>

<div class="{{ $secondIconBreakpoints ?? 'hidden md:flex' }} rounded-full border-4 border-theme-secondary-100 dark:border-theme-secondary-900">
    <div class="rounded-full circled-icon {{ $secondIconColors ?? 'text-theme-success-600 border-theme-success-600' }} bg-theme-secondary-100 dark:bg-theme-secondary-900">
        <x-ark-icon :name="$secondIcon" />
    </div>
</div>