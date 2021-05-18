<div class="hidden lg:flex">
    <div class="-mr-2 circled-icon  {{ $firstIconColors ?? 'text-theme-secondary-900 border-theme-secondary-900' }}">
        <x-ark-icon :name="$firstIcon" />
    </div>
</div>

<div class="hidden md:flex">
    <div class="rounded-full circled-icon {{ $secondIconColors ?? 'text-theme-success-600 border-theme-success-600' }} bg-white dark:bg-theme-secondary-900">
        <x-ark-icon :name="$secondIcon" />
    </div>
</div>
