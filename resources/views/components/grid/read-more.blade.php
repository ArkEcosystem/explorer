@props([
    'icon',
    'title',
    'content',
])

<x-grid.generic
    :title="$title"
    :icon="$icon"
    class="transition-none"
>
    <div
        x-data="{ showMore: false }"
        :class="{ 'flex': ! showMore }"
        x-cloak
    >
        <div :class="{ truncate: ! showMore }">
            {{ $content }}
        </div>

        <div @click="showMore = ! showMore" class="link inline-block whitespace-nowrap">
            <div
                x-show="showMore"
                class="mt-2"
            >
                Show Less
            </div>

            <div
                x-show="! showMore"
                class="ml-2"
            >
                Read More
            </div>
        </div>
    </div>
</x-grid.generic>
