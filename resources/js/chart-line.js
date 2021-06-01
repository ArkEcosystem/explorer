/**
 * Render a line chart.
 *
 * @param data            Contains "values" object and an optional "labels" object
 * @param variation       A floating number that represent the price variation. It can be negative.
 * @param grid
 * @param tooltips
 * @param theme           Object containing "mode" (light|dark) and theme name (black|yellow|grey|dynamic)
 * @param time            Current timestamp
 */
const ChartLine = (data, variation, grid, tooltips, theme, time) => {

    const margin = Math.max.apply(Math, data.values) * 0.01;
    const maxValue = Math.max.apply(Math, data.values) + margin;
    const minValue = Math.min.apply(Math, data.values) - margin;

    return {
        time: time,
        isDarkMode: theme.mode === "dark",

        toggleDarkMode() {
            this.isDarkMode = !this.isDarkMode;
            this.updateChart();
        },

        getCanvasContext() {
            return this.$refs.chart.getContext("2d");
        },

        getChartInstance(ctx) {
            return Object.values(Chart.instances).find((i) => i.ctx === ctx);
        },

        updateChart() {
            const ctx = this.getCanvasContext();
            const chart = this.getChartInstance(ctx);

            this.init(chart);
        },

        getLabelsFromValues(values) {
            const labels = [];

            data.values.forEach((value, index) => labels.push(index));

            return labels;
        },

        init(chart = null) {
            if (chart === null) {
                this.$watch("time", () => this.updateChart());
            }

            // get colors info from theme name
            const graphic = this.getInfoFromThemeName(theme);

            const ctx = this.getCanvasContext();

            // apply gradients to ctx

            const datasets = [
                {
                    backgroundColor: graphic.backgroundColor,
                    borderColor: graphic.borderColor,
                    borderWidth: graphic.borderWidth,
                    data: data.values,
                    lineTension: graphic.lineTension,
                    pointRadius: graphic.pointRadius,
                },
            ];

            // get labels
            const data = {
                labels: data.labels || this.getLabelsFromValues(data.values),
                datasets,
            };

            if (chart) {
                data.labels.forEach((label, index) => {
                    chart.data.labels.splice(index, 1, label);
                });

                data.datasets[0].data.forEach((value, index) => {
                    chart.data.datasets[0].data.splice(index, 1, value);
                });

                chart.data.datasets[0].backgroundColor = graphic.backgroundColor;
                chart.data.datasets[0].borderColor = graphic.borderColor;

                chart.options.scales.yAxes[0].ticks.max = maxValue;
                chart.options.scales.yAxes[0].ticks.min = minValue;

                chart.update();

                return;
            }

            const options = {
                animation: { duration: 500, easing: "linear" },
                tooltips: { enabled: false },
                legend: { display: false },
                scales: {
                    xAxes: [
                        {
                            type: "time",
                            ticks: { display: false },
                            gridLines: { display: false, tickMarkLength: 0 },
                        },
                    ],
                    yAxes: [
                        {
                            ticks: { display: false, max: maxValue, min: minValue },
                            gridLines: { display: false, tickMarkLength: 0 },
                        },
                    ],
                },
            };

            new Chart(ctx, { type: "line", data, options });
        },

    };
};

export default ChartLine;
