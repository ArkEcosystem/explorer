@if($show)
    <div wire:poll.{{ $refreshInterval }}s>
        <x-general.card with-border class="flex flex-col lg:flex-row lg:flex-wrap lg:items-end">

            <div>
                <h2 class="mb-0 text-sm font-semibold leading-none sm:text-base sm:leading-none text-theme-secondary-500 dark:text-theme-secondary-700">
                    @lang('pages.statistics.chart.price') {{ $mainValue }}
                </h2>

                <p class="inline-flex items-center mt-3 space-x-2 sm:mt-2 sm:space-x-3">
                    <span class="text-lg font-bold sm:text-3xl text-theme-secondary-900 dark:text-theme-secondary-200">
                        {{ $mainValueFiat }}
                    </span>
                    <span class="inline-flex px-1.5 py-0.5 items-center text-xs font-semibold text-white rounded-sm
                        @if($mainValueVariation === 'up') bg-theme-success-600
                        @elseif($mainValueVariation === 'down') bg-theme-danger-400
                        @endif">
                        <x-ark-icon name="triangle-{{ $mainValueVariation }}" size="2xs" class="mr-1" />
                        <x-percentage>{{ $mainValuePercentage }}</x-percentage>
                    </span>
                </p>
            </div>

            <div class="pt-6 mt-6 border-t sm:border-t-0 sm:flex sm:pt-0 lg:mt-0 lg:flex-1 lg:justify-end border-theme-secondary-300 dark:border-theme-secondary-800">
                <x-stats.periods-selector wire:model="period" :selected="$period" :options="$options" class="sm:hidden" />

                <div class="mt-3 sm:mt-0">
                    <h3 class="mb-0 text-sm font-semibold leading-none text-theme-secondary-500 dark:text-theme-secondary-700">
                        @lang('pages.statistics.chart.market-cap')
                    </h3>
                    <p class="mt-2 text-base font-semibold text-theme-secondary-700 dark:text-theme-secondary-200">
                        {{ $marketCapValue }}
                    </p>
                </div>

                <div class="mt-4 sm:mt-0 sm:ml-6 sm:pl-6 sm:border-l sm:border-theme-secondary-300 dark:border-theme-secondary-800">
                    <h3 class="mb-0 text-sm font-semibold leading-none text-theme-secondary-500 dark:text-theme-secondary-700">
                        @lang('pages.statistics.chart.min-price')
                    </h3>
                    <p class="mt-2 text-base font-semibold text-theme-secondary-700 dark:text-theme-secondary-200">
                        {{ $minPriceValue }}
                    </p>
                </div>

                <div class="mt-4 sm:mt-0 sm:ml-6 sm:pl-6 sm:border-l sm:border-theme-secondary-300 dark:border-theme-secondary-800">
                    <h3 class="mb-0 text-sm font-semibold leading-none text-theme-secondary-500 dark:text-theme-secondary-700">
                        @lang('pages.statistics.chart.max-price')
                    </h3>
                    <p class="mt-2 text-base font-semibold text-theme-secondary-700 dark:text-theme-secondary-200">
                        {{ $maxPriceValue }}
                    </p>
                </div>
            </div>

            <div class="mt-5 sm:mt-6 sm:pt-6 sm:border-t lg:w-full border-theme-secondary-300 dark:border-theme-secondary-800">
                <x-stats.periods-selector wire:model="period" :selected="$period" :options="$options" class="hidden sm:block"/>
                {{-- on mobile display chart without grid --}}
                <div class="sm:hidden mt-6">
                    <x-linechart
                        id="stats-chart"
                        :data="$chartDatasets"
                        :labels="$chartLabels"
                        :theme="$chartTheme"
                        height="40"
                    />
                </div>

                <div class="hidden sm:block mt-6">
                    <x-linechart
                        id="stats-chart"
                        :data="$chartDatasets"
                        :labels="$chartLabels"
                        :theme="$chartTheme"
                        height="500"
                        grid="true"
                        tooltips="true"
                    />
                </div>
            </div>
        </x-general.card>
    </div>
@endif
