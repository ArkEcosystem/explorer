@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.9.1/dayjs.min.js"></script>
    <script src="{{ mix('js/chart.js')}}"></script>
@endpush

<div x-data="makeChart('{{ $identifier }}')" x-init="renderChart()" class="bg-white border-t-20 border-theme-secondary-100 dark:border-black dark:bg-theme-secondary-900">
    <div class="content-container-full-width md:py-16 md:px-8 flex flex-col">
        <div class="flex w-full flex-col">
            <div class="flex relative w-full justify-between items-center">
                <h2>@lang('pages.home.charts.price')</h2>

                <x-ark-dropdown dropdown-classes="left-0 w-32 mt-3" button-class="h-10 w-32 dropdown-button" :init-alpine="false">
                    @slot('button')
                        <div class="flex flex-inline items-center w-full justify-end font-semibold text-theme-secondary-700 space-x-2">
                            <span x-text="period"></span>
                            <span :class="{ 'rotate-180': open }" class="transition duration-150 ease-in-out">
                                @svg('chevron-up', 'h-3 w-3')
                            </span>
                        </div>
                    @endslot
                    <div class="py-3">
                        {{--<template x-for="(item, index) in getFormattedPeriods('{{ json_encode(trans('pages.home.charts.periods')) }}')" :key="index">
                            <div class="cursor-pointer dropdown-entry" @click="setPeriod(item.key)" x-text="item.display">
                            </div>
                        </template>--}}
                        @foreach (array_keys(trans('pages.home.charts.periods')) as $period)
                            <div class="cursor-pointer dropdown-entry" @click="setPeriod('{{ $period }}')">
                                @lang("pages.home.charts.periods." . $period)
                            </div>
                        @endforeach
                    </div>
                </x-ark-dropdown>
            </div>
            <div class="flex justify-between w-full mt-5">
                <div class="flex items-center pr-5 mr-5 border-r border-theme-secondary-200">
                   <div class="flex flex-col">
                        <span class="font-semibold text-theme-secondary-500">@lang('pages.home.charts.min_price')</span>
                        <span class="font-semibold" x-text="priceMin + ` ${currency}`"></span>
                    </div>
                </div>

                <div class="flex items-center pr-5 mr-5 border-r border-theme-secondary-200">
                    <div class="flex flex-col">
                        <span class="font-semibold text-theme-secondary-500">@lang('pages.home.charts.max_price')</span>
                        <span class="font-semibold" x-text="priceMax + ` ${currency}`">0.02477504 BTC</span>
                    </div>
                </div>

                <div class="flex items-center pr-5 mr-5">
                    <div class="flex flex-col">
                        <span class="font-semibold text-theme-secondary-500">@lang('pages.home.charts.avg_price')</span>
                        <span class="font-semibold" x-text="priceAvg + ` ${currency}`">0.01570092 BTC</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex w-full" style="height: 340px;">
            <canvas id="{{ $identifier ?? 'priceChart' }}"></canvas>
        </div>

        <hr class="mt-12 border-t border-dashed text-theme-secondary-300 border-theme-secondary-300" />
    </div>
</div>