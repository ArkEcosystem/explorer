<div class="flex flex-col space-y-5 w-full">
    <div class="flex items-center justify-between">
        <div class="hidden text-2xl text-theme-secondary-900 font-bold whitespace-no-wrap lg:block dark:text-theme-secondary-200">
            @lang('general.search_explorer')
        </div>

        <livewire:network-status-block />
    </div>

    <div class="px-8 md:px-0">
        <livewire:search-module />
    </div>
</div>
