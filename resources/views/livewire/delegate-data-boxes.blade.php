<div class="flex md:flex-col xl:flex-row w-full md:space-y-4 xl:space-y-0 xl:space-x-4">
    {{--TODO: Replace the text of the 3 boxes below with real data once implemented --}}
    <div class="flex flex-row px-6 py-3 bg-white rounded-xl">
        <div class="flex lg:w-1/2 xl:w-full">
            <x-general.entity-header-item
                title="Forging"
                text="49"
                progress-circle
                progress-circle-icon="checkmark-smooth"
                progress="98"
                progress-color="success-600"
                progress-circle-icon-class="text-theme-success-600 border-theme-success-600 rotate-90"
                icon-size="sm"
            />

            <x-general.entity-header-item
                title="Missed"
                text="1"
                wrapper-class="border-r border-theme-secondary-300 pl-6"
                progress-circle
                progress-circle-icon="pause"
                progress="1"
                progress-color="warning-500"
                progress-circle-icon-class="text-theme-warning-500 border-theme-warning-500 rotate-90"
                icon-size="xs"
            />

            <x-general.entity-header-item
                title="Not Forging"
                text="1"
                wrapper-class="pl-6 border-r-0 border-none"
                progress-circle
                progress-circle-icon="cross"
                progress="1"
                progress-color="danger-400"
                progress-circle-icon-class="text-theme-danger-400 border-theme-danger-400 rotate-90"
                icon-size="xs"
            />
        </div>
    </div>

    <div class="flex flex-row w-full space-x-4">
        <div class="flex flex-grow px-6 py-3 bg-white dark:bg-theme-secondary-900 rounded-xl">
            <x-general.entity-header-item
                :title="trans('pages.delegates.statistics.block_count')"
                {{--:text="$statistics['blockCount']"--}}
                icon="app-block-id"
                wrapper-class="border-r-0 border-none"
            />
        </div>

        <div class="flex flex-grow px-6 py-3 bg-white dark:bg-theme-secondary-900 rounded-xl">
            <x-general.entity-header-item
                :title="trans('pages.delegates.statistics.next_slot')"
                {{--:text="$statistics['nextDelegate']->username()"--}}
                {{--:url="route('wallet', $statistics['nextDelegate']->address())"--}}
                without-single-icon
                with-multiple-icons
                first-icon="app-forged"
                first-icon-colors="text-theme-secondary-900"
                second-icon="app-next-delegate"
                second-icon-colors="text-theme-secondary-900"
                wrapper-class="border-r-0 border-none"
            />
        </div>
    </div>
</div>