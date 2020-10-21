@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.9.1/dayjs.min.js"></script>
    <script src="{{ mix('js/chart.js')}}"></script>
@endpush

<div x-data="makeChart()" x-init="renderChart()" class="bg-white border-t-20 border-theme-secondary-100 dark:border-black dark:bg-theme-secondary-900">
    <div class="content-container-full-width md:py-16 md:px-8 flex flex-col">
        <div class="flex w-full flex-col">
            <div class="flex relative w-full justify-between items-center">
                <h2>Price</h2>

                <x-ark-dropdown dropdown-classes="left-0 w-32 mt-3" button-class="h-10 w-32 dropdown-button">
                    @slot('button')
                        <div class="flex flex-inline items-center w-full justify-end font-semibold text-theme-secondary-700 space-x-2">
                            <span>1 Week</span>
                            <span :class="{ 'rotate-180': open }" class="transition duration-150 ease-in-out">
                                @svg('chevron-up', 'h-3 w-3')
                            </span>
                        </div>
                    @endslot
                    <div class="py-3">
                        @foreach (['daily', 'weekly', 'monthly'] as $period)
                            {{-- TODO: Can't access `setPeriod` within that <x-ark-dropdown></x-ark-dropdown> component, so borked for now till I figure it out --}}
                            {{-- The commented line below "kinda" work, I get access to the `setPeriod` method but then blockchain would be undefined --}}
                            {{--<div class="cursor-pointer dropdown-entry" @click="window.makeChart().setPeriod('{{ $period }}')">--}}
                            <div class="cursor-pointer dropdown-entry" @click="setPeriod('{{ $period }}')">
                                {{ ucfirst($period) }}
                            </div>
                        @endforeach
                    </div>
                </x-ark-dropdown>
            </div>
            <div class="flex w-full justify-between mt-5">
                <div class="flex items-center pr-5 mr-5 border-r border-theme-secondary-200">
                   <div class="flex flex-col">
                        <span class="font-semibold text-theme-secondary-500">Min Price</span>
                        <span class="font-semibold" x-text="priceMin + ` ${currency}`"></span>
                    </div>
                </div>

                <div class="flex items-center pr-5 mr-5 border-r border-theme-secondary-200">
                    <div class="flex flex-col">
                        <span class="font-semibold text-theme-secondary-500">Max Price</span>
                        <span class="font-semibold" x-text="priceMax + ` ${currency}`">0.02477504 BTC</span>
                    </div>
                </div>

                <div class="flex items-center pr-5 mr-5">
                    <div class="flex flex-col">
                        <span class="font-semibold text-theme-secondary-500">Avg Price</span>
                        <span class="font-semibold" x-text="priceAvg + ` ${currency}`">0.01570092 BTC</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex w-full" style="height: 340px;">
            <canvas id="priceChart"></canvas>
        </div>

        <hr class="mt-12 border-t border-dashed text-theme-secondary-300 border-theme-secondary-300" />
    </div>
</div>