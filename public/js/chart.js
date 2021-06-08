import {
    getInfoFromThemeName,
    makeGradient,
    getFontConfig,
} from "./chart-theme";

const CustomChart = (
    id,
    values,
    labels,
    grid,
    tooltips,
    theme,
    time,
    currency
) => {
    return {
        time: time,
        chart: null,
        currency: currency || "USD",
        fontConfig: {},

        getCanvas() {
            return this.$refs[id];
        },

        getCanvasContext() {
            return this.getCanvas().getContext("2d");
        },

        getRangeFromValues(values, margin = 0) {
            const max = Math.max.apply(Math, values);
            const min = Math.min.apply(Math, values);
            const _margin = max * margin;

            return {
                min: min - _margin,
                max: max + _margin,
            };
        },

        getCurrencyValue(value) {
            return new Intl.NumberFormat("en-US", {
                style: "currency",
                currency: this.currency,
            }).format(value);
        },

        resizeChart() {
            this.updateChart();
        },

        updateChart() {
            this.chart.datasets = this.loadData();
            this.chart.labels = labels;
            this.chart.update();
        },

        loadFontConfig() {
            this.fontConfig = getFontConfig();
        },

        loadData() {
            const datasets = [];

            if (values.length === 0) {
                values = [0, 0];
                labels = [0, 1];
            }

            if (Array.isArray(values) && !values[0].hasOwnProperty("data")) {
                values = [values];
            }

            values.forEach((value, key) => {
                let themeName = value.type === "bar" ? "grey" : theme.name;
                let graphic = getInfoFromThemeName(themeName, theme.mode);
                let backgroundColor = graphic.backgroundColor;
                if (backgroundColor.hasOwnProperty("gradient")) {
                    backgroundColor = makeGradient(
                        this.getCanvas(),
                        backgroundColor.gradient
                    );
                }

                datasets.push({
                    stack: "combined",
                    label: value.name || "default",
                    data: value.data || value,
                    type: value.type || "line",
                    backgroundColor:
                        value.type === "bar"
                            ? graphic.borderColor
                            : backgroundColor,
                    borderColor:
                        value.type === "bar"
                            ? "transparent"
                            : graphic.borderColor,
                    borderWidth:
                        value.type === "bar"
                            ? "transparent"
                            : graphic.borderWidth,
                    cubicInterpolationMode: "monotone",
                    tension: graphic.lineTension,
                    pointRadius: graphic.pointRadius,
                    pointBackgroundColor: graphic.pointBackgroundColor,
                    pointHoverRadius: graphic.pointHoverRadius,
                    pointHoverBorderWidth: graphic.pointHoverBorderWidth,
                    pointHoverBorderColor: graphic.borderColor,
                    pointHoverBackgroundColor:
                        graphic.pointHoverBackgroundColor,
                });
            });

            return datasets;
        },

        loadYAxes() {
            const axes = [];

            values.forEach((value, key) => {
                let range = this.getRangeFromValues(value, 0.01);

                axes.push({
                    display: grid === "true" && key === 0,
                    type: "linear",
                    position: "right",
                    ticks: {
                        ...this.fontConfig.axis,
                        padding: 15,
                        suggestedMax: range.max,
                        callback: (value, index, data) =>
                            this.getCurrencyValue(value),
                    },
                    gridLines: {
                        drawBorder: false,
                    },
                });
            });

            return axes;
        },

        init() {
            if (this.chart) {
                this.chart.destroy();
            }

            this.$watch("time", () => this.updateChart());
            window.addEventListener("resize", () => this.resizeChart());

            this.loadFontConfig();

            const data = {
                type: "line",
                labels: labels,
                datasets: this.loadData(),
            };

            const yAxes = this.loadYAxes();

            const options = {
                spanGaps: true,
                parsing: false,
                normalized: true,
                responsive: true,
                maintainAspectRatio: false,
                showScale: grid === "true",
                animation: { duration: 300, easing: "easeOutQuad" },
                legend: { display: false },
                onResize: () => this.resizeChart(),
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 0,
                        bottom: 0,
                    },
                },
                hover: {
                    mode: "nearest",
                    intersect: false,
                    axis: "x",
                },
                tooltips: {
                    enabled: tooltips === "true",
                    mode: "nearest",
                    intersect: false,
                    axis: "x",
                    external: this.tooltip,
                    displayColors: false,
                    stacked: false,
                    callbacks: {
                        title: (items) => {},
                        label: (context) =>
                            this.getCurrencyValue(context.value),
                        labelTextColor: (context) =>
                            this.fontConfig.tooltip.fontColor,
                    },
                    backgroundColor: this.fontConfig.tooltip.backgroundColor,
                },
                scales: {
                    xAxes: [
                        {
                            display: grid === "true",
                            type: "category",
                            labels: labels,
                            ticks: {
                                padding: 10,
                                ...this.fontConfig.axis,
                            },
                            gridLines: {
                                drawBorder: false,
                            },
                        },
                    ],
                    yAxes: yAxes,
                },
            };

            this.chart = new Chart(this.getCanvasContext(), { data, options });
        },
    };
};

export default CustomChart;
