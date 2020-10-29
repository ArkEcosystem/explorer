<div class="flex pt-16 space-y-6 content-container">
    <div class="p-8 flex flex-row w-full justify-center sm:justify-between h-30 lg:h-32 bg-theme-primary-600 dark:bg-theme-secondary-900 rounded-lg">
        <div class="flex flex-row justify-between items-center space-x-4">
            <div class="items-center flex">
                <div class="circled-icon text-theme-secondary-400 border-white w-12 h-12">
                    @svg('app-marketsquare', 'w-4 h-4 text-white')
                </div>
            </div>

            <div class="flex flex-col justify-between font-semibold md:ml-4 space-y-2">
                <div class="text-sm leading-tight text-theme-primary-300 dark:text-theme-secondary-700">For more {{ $transaction->typeLabel() }} details</div>

                <div class="flex items-center space-x-2 leading-tight">
                    <span class="text-white dark:text-theme-secondary-200">Learn more <span class="hidden sm:contents">at MarketSquare</span></span>
                    <a href="#" class="mx-auto link">
                        @svg('link', 'h-4 w-4 text-white')
                    </a>
                </div>
            </div>
        </div>

        <div class="hidden lg:flex flex-row items-center">
            <div class="relative inline-block text-white">
                @svg('app-marketsquare', 'h-6 ml-2 md:h-8 lg:h-12 lg:ml-0 text-white')
            </div>
            <span class="ml-4 text-3xl">
                <span class="font-bold text-white">Market</span><span class="text-white">Square</span>
            </span>
        </div>
    </div>
</div>
