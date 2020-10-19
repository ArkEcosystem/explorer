<div class="flex flex-col w-full space-y-5">
    <div class="flex items-center justify-between relative">
        <h1 class="header-2 font-bold whitespace-no-wrap text-theme-secondary-900 dark:text-theme-secondary-200">
            {{ $title }}
        </h1>

        <div
            x-data="{ searchFocused: false }"
            @search-slim-expand="searchFocused = true"
            @search-slim-close="searchFocused = false"
            class="hidden absolute top-0 right-0 md:block"
            :class="{
                'w-full': searchFocused,
                'w-1/2 lg:w-5/12 xl:w-7/12': ! searchFocused,
            }"
            x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="width-auto transform"
            x-transition:enter-end="width-full transform"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="width-full transform"
            x-transition:leave-end="width-auto transform"
            x-cloak
        >
            <livewire:search-module :is-slim="true" />
        </div>
    </div>
</div>
