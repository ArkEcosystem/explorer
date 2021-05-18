<div class="hidden lg:flex">
    <div class="-mr-2 circled-icon text-theme-secondary-900 border-theme-secondary-900">
        <x-ark-icon :name="$firstIcon" />
    </div>
</div>

{{--TODO: bg-white was the only way to prevent the icons circles to be interlaced, was working previously cause the bg was black, but here it's a bit more
problematic, so will probably have to figure out a way of doing it in CSS instead --}}
<div class="hidden md:flex">
    <div class="bg-white rounded-full circled-icon text-theme-success-600 border-theme-success-600 dark:bg-theme-secondary-900">
        <x-ark-icon :name="$secondIcon" />
    </div>
</div>
