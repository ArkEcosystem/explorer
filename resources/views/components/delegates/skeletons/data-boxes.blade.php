<div class="flex w-full space-x-4 h-18 md:flex-col xl:flex-row md:space-x-0 xl:space-x-4 md:space-y-4 xl:space-y-0">
    <div class="flex flex-row px-6 py-3 bg-white rounded-xl dark:bg-theme-secondary-900">
        <div class="flex w-full mr-2 lg:w-1/2 xl:w-full">
            <div class="flex items-center pr-6 space-x-4 border-r border-theme-secondary-300 dark:border-theme-secondary-800">
                <div class="border-none h-11 rounded-xl loading-state circled-icon"></div>

                <div class="flex flex-col justify-center p-1 space-y-2">
                    <div class="flex items-center">
                        <div class="w-12 h-4 rounded-md loading-state"></div>
                    </div>

                    <span class="w-5 h-5 rounded-md loading-state"></span>
                </div>
            </div>

            <div class="flex items-center pr-6 ml-6 space-x-4 border-r border-theme-secondary-300 dark:border-theme-secondary-800">
                <div class="border-none h-11 rounded-xl loading-state circled-icon"></div>

                <div class="flex flex-col justify-center p-1 space-y-2">
                    <div class="flex items-center">
                        <div class="w-12 h-4 rounded-md loading-state"></div>
                    </div>

                    <span class="w-5 h-5 rounded-md loading-state"></span>
                </div>
            </div>

            <div class="flex items-center ml-6 space-x-4">
                <div class="border-none h-11 rounded-xl loading-state circled-icon"></div>

                <div class="flex flex-col justify-center p-1 space-y-2">
                    <div class="flex items-center">
                        <div class="w-20 h-4 rounded-md loading-state"></div>
                    </div>

                    <span class="w-5 h-5 rounded-md loading-state"></span>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-row w-full space-x-4">
        <div class="flex flex-grow px-6 py-3 bg-white rounded-xl dark:bg-theme-secondary-900">
            <div class="flex items-center mr-4 space-x-4">
                <div
                    class="border-none h-11 rounded-xl loading-state circled-icon">
                </div>

                <div class="flex flex-col justify-center p-1 space-y-2">
                    <div class="flex items-center">
                        <div class="h-4 rounded-md w-25 loading-state"></div>
                    </div>

                    <span class="h-5 rounded-md w-25 loading-state"></span>
                </div>
            </div>
        </div>

        <div class="flex flex-grow px-6 py-3 bg-white rounded-xl dark:bg-theme-secondary-900">
            <x-delegates.skeletons.data-boxes-next-delegate />
        </div>
    </div>
</div>
