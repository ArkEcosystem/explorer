import { getInfoFromThemeName, makeGradient } from "./chart-theme";

const CustomChart = (id, values, labels, grid, tooltips, theme, time) => {
    return {
        time: time,
        chart: null,

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

        resizeChart() {
            this.updateChart();
        },

        updateChart() {
            this.chart.datasets = this.loadData();
            this.chart.update();
        },

        loadData() {
            const datasets = [];

            if (values.length === 0) {
                values = [0,0];
                labels = [0,1];
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
                });
            });

            return datasets;
        },

        init() {
            if (this.chart) {
                this.chart.destroy();
            }

            this.$watch("time", () => this.updateChart());
            window.addEventListener("resize", () => this.resizeChart());

            const fontConfig = this.getFontConfig();

            const options = {
                parsing: false,
                normalized: true,
                responsive: true,
                maintainAspectRatio: false,
                showScale: grid === "true",
                animation: { duration: 500, easing: "linear" },
                legend: { display: false },
                onResize: () => this.resizeChart(),
                intersection: {
                    axis: "xy",
                    mode: "index",
                    intersect: false,
                },
                tooltips: {
                    enabled: tooltips === "true",
                    padding: 10,
                    displayColors: false,
                    intersect: false,
                },
                scales: {
                    xAxes: [
                        {
                            type: "time",
                            ticks: {
                                display: grid === "true",
                                padding: 10,
                                ...fontConfig,
                            },
                            gridLines: {
                                display: grid === "true",
                                drawBorder: false,
                            },
                        },
                    ],
                    yAxes: [
                        {
                            type: "linear",
                            position: "right",
                            stacked: true,
                            ticks: {
                                padding: 15,
                                ...fontConfig,
                                display: grid === "true",
                                suggestedMin: 0,
                                callback: function (value, index, values) {
                                    return "$" + parseFloat(value).toFixed(2);
                                },
                            },
                            gridLines: {
                                display: grid === "true",
                                drawBorder: false,
                            },
                        },
                    ],
                },
            };

            const data = {
                type: "line",
                datasets: this.loadData(),
                labels: labels,
            };

            this.chart = new Chart(this.getCanvasContext(), { data, options });
        },
    };
};

export default CustomChart;
