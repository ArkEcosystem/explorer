<div class="flex flex-col w-full space-y-5">
    <div
        x-data="{ searchFocused: false }"
        @search-slim-expand="searchFocused = true"
        @search-slim-close="searchFocused = false"
        class="relative flex items-center justify-between"
    >
        <h1
            class="header-2"
            :class="{ hidden: searchFocused }"
        >
            {{ $title }}
        </h1>
    </div>
</div>
