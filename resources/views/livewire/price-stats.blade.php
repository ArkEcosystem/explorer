<div
    class="flex flex-grow justify-between ml-3 h-full"
    @unless ($placeholder)
        wire:poll.1m
    @endunless
>
    @unless ($placeholder)
        <div class="flex flex-col justify-between h-full">
            <a class="pl-3 text-sm font-semibold leading-none whitespace-nowrap border-l link border-theme-secondary-300" href="#">
                @lang('actions.view_statistics')
            </a>

            @if ($priceChange < 0)
                <span class="flex items-center pl-3 space-x-1 text-sm font-semibold text-theme-danger-400">
                    <span>
                        <x-ark-icon name="triangle-down" size="2xs" />
                    </span>
                    <span>
                        <x-percentage>{{ $priceChange * 100 * -1 }}</x-percentage>
                    </span>
                </span>
            @else
                <span class="flex items-center pl-3 space-x-1 text-sm font-semibold leading-none text-theme-success-600">
                    <span>
                        <x-ark-icon name="triangle-up" size="2xs" />
                    </span>
                    <span>
                        <x-percentage>{{ $priceChange * 100 }}</x-percentage>
                    </span>
                </span>
            @endif
        </div>
    @endunless


    <div class="hidden flex-grow justify-end lg:flex" >
        <div
            class="ml-6 h-10"
            style="width: 120px;"
            x-data="{
                time: {{ time() }},
                values: {{ $historical->values()->toJson() }},
                labels: {{ $historical->keys()->toJson() }},
                maxValue: {{ $historical->values()->max() }},
                init(chart = null) {
                    const ctx = this.$refs.chart.getContext('2d');

                    if (chart === null) {
                        this.$watch('time', () => {
                            const chart = Object.values(Chart.instances).find(i => i.ctx === ctx);
                            this.init(chart);
                        });
                    }

                    const gradient = ctx.createLinearGradient(0, 0, 0, 40);

                    @if($placeholder)
                        const border = 'rgba(196, 200, 207, 1)';
                        gradient.addColorStop(0, 'rgba(196, 200, 207, 1)');
                        gradient.addColorStop(1, 'rgb(196, 200, 207, 0)');
                    @elseif ($priceChange >= 0)
                        const border = 'rgba(40, 149, 72, 1)';
                        gradient.addColorStop(0, 'rgba(40, 149, 72, 0.5)');
                        gradient.addColorStop(1, 'rgba(40, 149, 72, 0)');
                    @else
                        const border = 'rgba(222, 88, 70, 1)';
                        gradient.addColorStop(0, 'rgba(222, 88, 70, 0.5)');
                        gradient.addColorStop(1, 'rgba(222, 88, 70, 0)');
                    @endif

                    const datasets = [{
                        backgroundColor: gradient,
                        borderColor: border,
                        data: this.values,
                        pointRadius: 0,
                        borderWidth: '2',
                        lineTension: 0.25,
                    }];

                    const data = {
                        labels: this.labels,
                        datasets,
                    }

                    if (chart) {
                        data.labels.forEach((label, index) => {
                            chart.data.labels.splice(index, 1, label);
                        });

                        data.datasets[0].data.forEach((value, index) => {
                            chart.data.datasets[0].data.splice(index, 1, value);
                        });

                        chart.data.datasets[0].backgroundColor = gradient;
                        chart.data.datasets[0].borderColor = border;

                        chart.options.scales.yAxes[0].ticks.max = this.maxValue;

                        chart.update();

                        return;
                    }

                    const options = {
                        animation: {
                            duration: 500,
                            easing: 'linear'
                        },
                        tooltips: {
                            enabled: false,
                        },
                        legend: {
                            display: false
                        },
                        scales: {
                            xAxes: [{
                                type: 'time',
                                ticks: {
                                    display: false
                                },
                                gridLines: {
                                    display: false,
                                    tickMarkLength: 0,
                                }
                            }],
                            yAxes: [{
                                ticks: {
                                    display: false,
                                    max: this.maxValue,
                                },
                                gridLines: {
                                    display: false,
                                    tickMarkLength: 0,
                                }
                            }]
                        },
                    }

                    const config = {
                        type: 'line',
                        data,
                        options,
                    }

                    new Chart(ctx, config);
                }
            }"
            x-init="init"
        >
            <div class="block" wire:ignore style="height: 40px; width: 120px;">
                <canvas x-ref="chart" class="w-full h-full" ></canvas>
            </div>
        </div>
    </div>
</div>
