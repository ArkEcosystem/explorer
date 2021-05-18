<div
    class="flex flex-row justify-between h-full"
    wire:poll.1m
>
    <div class="flex flex-col justify-between h-full">
        <a class="pl-3 text-sm font-semibold leading-none border-l link border-theme-secondary-300 whitespace-nowrap" href="#">View Stadistics</a>

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
            <span class="flex items-center pl-3 space-x-1 text-sm font-semibold text-theme-success-600">
                <span>
                    <x-ark-icon name="triangle-up" size="2xs" />
                </span>
                <span>
                    <x-percentage>{{ $priceChange * 100 }}</x-percentage>
                </span>
            </span>
        @endif
    </div>


    <span
        class="flex h-10 ml-6"
        x-data="{
            time: {{ time() }},
            init(chart = null) {
                const ctx = this.$refs.chart.getContext('2d');

                this.$watch('time', () => {
                    const chart = Object.values(Chart.instances).find(i => i.ctx === ctx);
                    this.init(chart);
                });

                const green = 'rgba(40, 149, 72, 1)';
                const red = 'rgba(222, 88, 70, 1)';

                const greenGradient = ctx.createLinearGradient(0, 0, 0, 40);
                greenGradient.addColorStop(0, green);
                greenGradient.addColorStop(1, 'rgba(40, 149, 72, 0)');

                const redGradient = ctx.createLinearGradient(0, 0, 0, 40);
                redGradient.addColorStop(0, red);
                redGradient.addColorStop(1, 'rgba(222, 88, 70, 0)');

                const values = {{ $historical->values()->toJson() }};

                const datasets = [{
                    backgroundColor: {{ $priceChange >= 0 ? 'greenGradient' : 'redGradient' }},
                    borderColor: {{ $priceChange >= 0 ? 'green' : 'red' }},
                    data: values,
                    pointRadius: 0,
                    borderWidth: '2',
                    lineTension: 0.25,
                }];

                const labels = {{ $historical->keys()->toJson() }};

                const data = {
                    labels,
                    datasets,
                }

                if (chart) {
                    data.labels.forEach((label, index) => {
                        chart.data.labels.splice(index, 1, label);
                    });

                    data.datasets[0].data.forEach((value, index) => {
                        chart.data.datasets[0].data.splice(index, 1, value);
                    });

                    chart.data.datasets[0].backgroundColor = {{ $priceChange >= 0 ? 'greenGradient' : 'redGradient' }};
                    chart.data.datasets[0].borderColor = {{ $priceChange >= 0 ? 'green' : 'red' }};

                    chart.options.scales.yAxes[0].ticks.max = {{ $historical->values()->max() }};

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
                                max: {{ $historical->values()->max() }}
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
        <canvas wire:ignore x-ref="chart" class="block" style="height: 40px; width: 120px;"></canvas>
    </span>
</div>
