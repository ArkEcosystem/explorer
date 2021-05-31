@if(! count($statistics))
    <div wire:poll="pollStatistics" wire:key="poll_statistics_skeleton">
        <x-delegates.skeletons.data-boxes />
    </div>
@else
    <div id="statistics-list" class="w-full" wire:poll.{{ Network::blockTime() }}s="pollStatistics" wire:key="poll_statistics_real">
        <div class="flex space-x-4 w-full md:flex-col xl:flex-row md:space-x-0 xl:space-x-4 md:space-y-4 xl:space-y-0">
            <div class="flex flex-row py-3 px-6 bg-white rounded-xl dark:bg-theme-secondary-900">
                <div class="flex w-full lg:w-1/2 xl:w-full">
                    <x-general.header-entry
                        :title="trans('pages.delegates.statistics.forging')"
                        :text="$statistics['performances']['forging']"
                        wrapper-class="pr-5 border-r border-theme-secondary-300 dark:border-theme-secondary-800"
                    >
                        <x-slot name="icon">
                            <div class="flex items-center mr-2">
                                <x-delegates.progress-circle
                                    circle-color="success-600"
                                    progress="{{ Percentage::calculate($statistics['performances']['forging'], Network::delegateCount()) }}"
                                >
                                    <x-ark-icon class="rotate-90 text-theme-success-600 border-theme-success-600" name="checkmark-smooth" size="sm" />
                                </x-delegates.progress-circle>
                            </div>
                        </x-slot>
                    </x-general.header-entry>

                    <x-general.header-entry
                        :title="trans('pages.delegates.statistics.missed')"
                        :text="$statistics['performances']['missed']"
                        wrapper-class="pr-5 ml-5 border-r border-theme-secondary-300 dark:border-theme-secondary-800"
                    >
                        <x-slot name="icon">
                            <div class="flex items-center mr-2">
                                <x-delegates.progress-circle
                                    circle-color="warning-500"
                                    progress="{{ Percentage::calculate($statistics['performances']['missed'], Network::delegateCount()) }}"
                                >
                                    <x-ark-icon class="rotate-90 text-theme-warning-500 border-theme-warning-500" name="pause" size="xs" />
                                </x-delegates.progress-circle>
                            </div>
                        </x-slot>
                    </x-general.header-entry>

                    <x-general.header-entry
                        :title="trans('pages.delegates.statistics.not_forging')"
                        :text="$statistics['performances']['missing']"
                        wrapper-class="ml-5"
                        without-border
                    >
                        <x-slot name="icon">
                            <div class="flex items-center mr-2">
                                <x-delegates.progress-circle
                                    circle-color="danger-400"
                                    progress="{{ Percentage::calculate($statistics['performances']['missing'], Network::delegateCount()) }}"
                                >
                                    <x-ark-icon class="rotate-90 text-theme-danger-400 border-theme-danger-400" name="cross" size="xs" />
                                </x-delegates.progress-circle>
                            </div>
                        </x-slot>
                    </x-general.header-entry>
                </div>
            </div>

            <div class="flex flex-row space-x-4 w-full">
                <div class="flex flex-grow py-3 px-6 bg-white rounded-xl dark:bg-theme-secondary-900">
                    <x-general.header-entry
                        :title="trans('pages.delegates.statistics.block_count')"
                        :text="$statistics['blockCount']"
                        without-border
                    >
                        <x-slot name="icon">
                            <div class="flex items-center mr-2 circled-icon border-theme-secondary-900 dark:border-theme-secondary-600">
                                <x-ark-icon class="rotate-90 text-theme-secondary-900 dark:text-theme-secondary-600" name="app-block-id" />
                            </div>
                        </x-slot>
                    </x-general.header-entry>
                </div>

                <div class="flex flex-grow py-3 px-6 bg-white rounded-xl dark:bg-theme-secondary-900">
                    <x-general.header-entry
                        :title="trans('pages.delegates.statistics.next_slot')"
                        :text="$statistics['nextDelegate']->username()"
                        :url="route('wallet', $statistics['nextDelegate']->address())"
                        without-border
                    >
                        <x-slot name="icon">
                            <div class="flex items-center mr-2">
                                <x-page-headers.icon-with-icon
                                    first-icon="app-forged"
                                    first-icon-colors="text-theme-secondary-900"
                                    first-icon-breakpoints="flex"
                                    second-icon="app-next-delegate"
                                    second-icon-colors="text-theme-secondary-900 dark:text-theme-secondary-600 dark:border-theme-secondary-600"
                                    second-icon-breakpoints="flex"
                                />
                            </div>
                        </x-slot>
                    </x-general.header-entry>
                </div>
            </div>
        </div>
    </div>
@endif