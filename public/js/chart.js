import { getInfoFromThemeName, makeGradient } from "./chart-theme";

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

        getCanvas() {
            return this.$refs[id];
        },

        getCanvasContext() {
            return this.getCanvas().getContext("2d");
        },

        getFontConfig() {
            return {
                fontSize: 14,
                fontStyle: 600,
                fontColor: "#B0B0B8",
            };
        },

        getRangeFromValues(values, margin = 0) {
            const max = Math.max.apply(Math, values);
            const min = Math.min.apply(Math, values);
            margin = max * margin;

            return {
                min: min - margin,
                max: max + margin,
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
                    label: value.name || "",
                    data: value.data || value,
                    type: value.type || "line",
                    fill: false,
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
                    lineTension: graphic.lineTension,
                    pointRadius: graphic.pointRadius,
                    pointHoverRadius: graphic.pointHoverRadius,
                    pointHoverBorderWidth: graphic.pointHoverBorderWidth,
                    pointHoverBackgroundColor:
                        graphic.pointHoverBackgroundColor,
                    pointHitRadius: graphic.pointHitRadius,
                    pointBackgroundColor: graphic.pointBackgroundColor,
                });
            });

            return datasets;
        },

        loadYAxes() {
            const axes = [];

            const fontConfig = this.getFontConfig();

            values.forEach((value, key) => {
                let range = this.getRangeFromValues(value, 0.01);

                axes.push({
                    type: "linear",
                    position: "right",
                    stacked: true,
                    ticks: {
                        ...fontConfig,
                        padding: 15,
                        display: grid === "true" && key === 0,
                        suggestedMax: range.max,
                        callback: (value, index, data) =>
                            this.getCurrencyValue(value),
                    },
                    gridLines: {
                        display: grid === "true" && key === 0,
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

            const fontConfig = this.getFontConfig();

            const data = {
                type: "line",
                labels: labels,
                datasets: this.loadData(),
            };

            const yAxes = this.loadYAxes();

            const options = {
                parsing: false,
                normalized: true,
                responsive: true,
                maintainAspectRatio: false,
                showScale: grid === "true",
                animation: { duration: 100, easing: "easeInOutQuad" },
                legend: { display: false },
                onResize: () => this.resizeChart(),
                onHover: (e) => {
                    console.log("hover", e);
                },
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 0,
                        bottom: 0,
                    },
                },
                interaction: {
                    axis: "x",
                    mode: "nearest",
                    intersect: false,
                },
                tooltips: {
                    enabled: tooltips === "true",
                    displayColors: false,
                    mode: "nearest",
                    intersect: false,
                    axis: "x",
                    callbacks: {
                        title: (items, data) => {},
                        label: (context) =>
                            this.getCurrencyValue(context.value),
                    },
                    backgroundColor: "rgba(0, 0, 0, 0.8)",
                    bodyColor: "#ffffff",
                    bodyFont: fontConfig,
                    padding: 12,
                    position: "nearest",
                },
                scales: {
                    xAxes: [
                        {
                            type: "category",
                            labels: labels,
                            ticks: {
                                display: grid === "true",
                                includeBounds: true,
                                padding: 10,
                                ...fontConfig,
                            },
                            gridLines: {
                                display: grid === "true",
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
