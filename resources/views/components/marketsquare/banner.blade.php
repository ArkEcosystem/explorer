<div class="flex pt-16 space-y-6 content-container">
    <div class="flex flex-row justify-center w-full p-8 rounded-lg sm:justify-between h-30 lg:h-32 bg-theme-primary-600">
        <div class="flex flex-row items-center justify-between space-x-4">
            <div class="flex items-center">
                <div class="w-12 h-12 border-white circled-icon text-theme-secondary-400">
                    @svg('app-marketsquare', 'w-4 h-4 text-white')
                </div>
            </div>

            <div class="flex flex-col justify-between space-y-2 font-semibold md:ml-4">
                <div class="text-sm leading-tight text-theme-primary-300 dark:text-theme-secondary-700">
                    @lang('general.more_details', ['transactionType' => $transaction->typeLabel()])
                </div>

                <div class="flex items-center space-x-2 leading-tight">
                    <span class="text-white dark:text-theme-secondary-200">@lang('general.learn_more') <span class="hidden sm:contents">@lang('generic.at') MarketSquare</span></span>
                    <a href="#" class="mx-auto link">
                        @svg('link', 'h-4 w-4 text-white')
                    </a>
                </div>
            </div>
        </div>

        <div class="flex-row items-center hidden lg:flex">
            <div class="relative inline-block text-white">
                @svg('app-marketsquare', 'h-6 ml-2 md:h-8 lg:h-12 lg:ml-0 text-white')
            </div>
            <span class="ml-4 text-3xl">
                <span class="font-bold text-white">Market</span><span class="text-white">Square</span>
            </span>
        </div>
    </div>
</div>
