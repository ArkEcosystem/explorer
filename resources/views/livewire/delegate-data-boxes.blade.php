@if(! count($statistics))
    <div wire:poll="pollStatistics" wire:key="poll_statistics_skeleton">
        <div class="flex w-full md:flex-col xl:flex-row md:space-y-4 xl:space-y-0 xl:space-x-4">
            <div class="flex flex-row py-3 px-6 bg-white rounded-xl dark:dark:bg-theme-secondary-900">
                <div class="flex lg:w-1/2 xl:w-full space-x-4">
                    <div class="flex flex-grow rounded-xl dark:bg-theme-secondary-900">
                        <div class="h-11 rounded-xl circled-icon border-theme-secondary-300 bg-theme-secondary-100"></div>
                        <div class="flex flex-col justify-between ml-4">
                            <div class="w-24 h-2 bg-theme-secondary-100"></div>
                            <div class="w-24 h-2 bg-theme-secondary-100"></div>
                        </div>
                    </div>

                    <div class="flex flex-grow rounded-xl dark:bg-theme-secondary-900">
                        <div class="h-11 rounded-xl circled-icon border-theme-secondary-300 bg-theme-secondary-100"></div>
                        <div class="flex flex-col justify-between ml-4">
                            <div class="w-24 h-2 bg-theme-secondary-100"></div>
                            <div class="w-24 h-2 bg-theme-secondary-100"></div>
                        </div>
                    </div>

                    <div class="flex flex-grow rounded-xl dark:bg-theme-secondary-900">
                        <div class="h-11 rounded-xl circled-icon border-theme-secondary-300 bg-theme-secondary-100"></div>
                        <div class="flex flex-col justify-between ml-4">
                            <div class="w-24 h-2 bg-theme-secondary-100"></div>
                            <div class="w-24 h-2 bg-theme-secondary-100"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-row space-x-4 w-full">
                <div class="flex flex-grow py-3 px-6 bg-white rounded-xl dark:bg-theme-secondary-900">
                    <div class="h-11 rounded-xl circled-icon border-theme-secondary-300 bg-theme-secondary-100"></div>
                    <div class="flex flex-col justify-between ml-4">
                        <div class="w-24 h-2 bg-theme-secondary-100"></div>
                        <div class="w-24 h-2 bg-theme-secondary-100"></div>
                    </div>
                </div>

                <div class="flex flex-grow py-3 px-6 bg-white rounded-xl dark:bg-theme-secondary-900">
                    <div class="h-11 rounded-xl circled-icon border-theme-secondary-300 bg-theme-secondary-100"></div>
                    <div class="flex flex-col justify-between ml-4">
                        <div class="w-24 h-2 bg-theme-secondary-100"></div>
                        <div class="w-24 h-2 bg-theme-secondary-100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div id="statistics-list" class="overflow-auto w-full" wire:poll.{{ Network::blockTime() }}s="pollStatistics" wire:key="poll_statistics_real">
        <div class="flex w-full md:flex-col xl:flex-row md:space-y-4 xl:space-y-0 xl:space-x-4">
            {{--TODO: Replace the text and progress of the 3 boxes below with real data once implemented--}}
            <div class="flex flex-row py-3 px-6 bg-white rounded-xl dark:bg-theme-secondary-900">
                <div class="flex lg:w-1/2 xl:w-full">
                    <x-general.entity-header-item
                        title="Forging"
                        text="49"
                        progress-circle
                        progress-circle-icon="checkmark-smooth"
                        progress="98"
                        progress-color="success-600"
                        progress-circle-icon-class="rotate-90 text-theme-success-600 border-theme-success-600"
                        icon-size="sm"
                    />

                    <x-general.entity-header-item
                        title="Missed"
                        text="1"
                        wrapper-class="pl-6 border-r border-theme-secondary-300"
                        progress-circle
                        progress-circle-icon="pause"
                        progress="1"
                        progress-color="warning-500"
                        progress-circle-icon-class="rotate-90 text-theme-warning-500 border-theme-warning-500"
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
                        progress-circle-icon-class="rotate-90 text-theme-danger-400 border-theme-danger-400"
                        icon-size="xs"
                    />
                </div>
            </div>

            <div class="flex flex-row space-x-4 w-full">
                <div class="flex flex-grow py-3 px-6 bg-white rounded-xl dark:bg-theme-secondary-900">
                    <x-general.entity-header-item
                        :title="trans('pages.delegates.statistics.block_count')"
                        :text="$statistics['blockCount']"
                        icon="app-block-id"
                        wrapper-class="border-r-0 border-none"
                    />
                </div>

                <div class="flex flex-grow py-3 px-6 bg-white rounded-xl dark:bg-theme-secondary-900">
                    <x-general.entity-header-item
                        :title="trans('pages.delegates.statistics.next_slot')"
                        :text="$statistics['nextDelegate']->username()"
                        :url="route('wallet', $statistics['nextDelegate']->address())"
                        without-single-icon
                        with-multiple-icons
                        first-icon="app-forged"
                        first-icon-colors="text-theme-secondary-900"
                        first-icon-breakpoints="flex"
                        second-icon="app-next-delegate"
                        second-icon-colors="text-theme-secondary-900 dark:text-theme-secondary-600 dark:border-theme-secondary-600"
                        second-icon-breakpoints="flex"
                        wrapper-class="border-r-0 border-none"
                    />
                </div>
            </div>
        </div>
    </div>
@endif
