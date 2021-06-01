import { getInfoFromThemeName, makeGradient } from "./chart-theme";

const ChartLine = (
    id,
    values,
    labels,
    grid,
    tooltips,
    theme,
    height,
    time
) => {
    return {
        time: time,

        getCanvasContext() {
            return this.$refs[id].getContext("2d");
        },

        getChartInstance(ctx) {
            return Object.values(Chart.instances).find((i) => i.ctx === ctx);
        },

        getFontConfig() {
            return {
                fontSize: 14,
                fontStyle: 600,
                fontColor: "#B0B0B8",
            };
        },

        updateChart() {
            const ctx = this.getCanvasContext();
            const chart = this.getChartInstance(ctx);

            chart.destroy();

            this.init();
        },

        loadData() {
            const datasets = [];

            values.forEach((value, key) => {
                let themeName = value.type === "bar" ? "grey" : theme.name;
                let graphic = getInfoFromThemeName(themeName, theme.mode);
                let backgroundColor = graphic.backgroundColor;
                if (backgroundColor.hasOwnProperty("gradient")) {
                    backgroundColor = makeGradient(
                        backgroundColor.gradient,
                        height
                    );
                }

                datasets.push({
                    scaleFactor: value.scaleFactor || null, // @TODO
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
            this.$watch("time", () => this.updateChart());

            const fontConfig = this.getFontConfig();

            const options = {
                showScale: grid === "true",
                animation: { duration: 500, easing: "linear" },
                legend: { display: false },
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
                    //@TODO: styling
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                let label = context.dataset.label || "";
                                let scaleFactor =
                                    context.dataset.scaleFactor || null;

                                if (scaleFactor) {
                                    return label / scaleFactor;
                                }

                                return label;
                            },
                        },
                    },
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
                labels: labels,
                datasets: this.loadData(),
            };

            new Chart(this.getCanvasContext(), { data, options });
        },
    };
};

export default ChartLine;
