function themes() {
    const _default = {
        borderWidth: 2,
        lineTension: 0.25,
        pointRadius: 0,
        pointHoverRadius: 6,
        pointHoverBorderWidth: 2,
    };

    return {
        black: {
            dark: {
                ..._default,
                borderColor: "#eef3f5",
                pointHoverBorderColor: "#eef3f5",
                backgroundColor: {
                    gradient: [
                        { stop: 0, alpha: 0.5, value: "#eef3f5" },
                        { stop: 1, alpha: 0, value: "#eef3f5" },
                    ],
                },
                pointBackgroundColor: "#ffffff",
                pointHoverBackgroundColor: "#ffffff",
            },
            light: {
                ..._default,
                borderColor: "#212225",
                pointHoverBorderColor: "#212225",
                backgroundColor: {
                    gradient: [
                        { stop: 0, alpha: 10.5, value: "#212225" },
                        { stop: 1, alpha: 0, value: "#212225" },
                    ],
                },
                pointBackgroundColor: "#ffffff",
                pointHoverBackgroundColor: "#ffffff",
            },
        },

        grey: {
            dark: {
                ..._default,
                borderColor: "#7e8a9c",
                pointHoverBorderColor: "#7e8a9c",
                backgroundColor: {
                    gradient: [
                        { stop: 0, alpha: 1, value: "#7e8a9c" },
                        { stop: 1, alpha: 0, value: "#7e8a9c" },
                    ],
                },
                pointBackgroundColor: "#ffffff",
                pointHoverBackgroundColor: "#ffffff",
            },
            light: {
                ..._default,
                borderColor: "#c4c8cf",
                pointHoverBorderColor: "#c4c8cf",
                backgroundColor: {
                    gradient: [
                        { stop: 0, alpha: 1, value: "#c4c8cf" },
                        { stop: 1, alpha: 0, value: "#c4c8cf" },
                    ],
                },
                pointBackgroundColor: "#ffffff",
                pointHoverBackgroundColor: "#ffffff",
            },
        },

        yellow: {
            dark: {
                ..._default,
                borderColor: "#ffae10",
                pointHoverBorderColor: "#ffae10",
                backgroundColor: {
                    gradient: [
                        { stop: 0, alpha: 0.5, value: "#ffae10" },
                        { stop: 1, alpha: 0, value: "#ffae10" },
                    ],
                },
                pointBackgroundColor: "#ffffff",
                pointHoverBackgroundColor: "#ffffff",
            },
            light: {
                ..._default,
                borderColor: "#ffae10",
                pointHoverBorderColor: "#ffae10",
                backgroundColor: {
                    gradient: [
                        { stop: 0, alpha: 0.5, value: "#ffae10" },
                        { stop: 1, alpha: 0, value: "#ffae10" },
                    ],
                },
                pointBackgroundColor: "#ffffff",
                pointHoverBackgroundColor: "#ffffff",
            },
        },

        green: {
            dark: {
                ..._default,
                borderColor: "#289548",
                pointHoverBorderColor: "#289548",
                backgroundColor: {
                    gradient: [
                        { stop: 0, alpha: 0.5, value: "#289548" },
                        { stop: 1, alpha: 0, value: "#289548" },
                    ],
                },
                pointBackgroundColor: "#ffffff",
                pointHoverBackgroundColor: "#ffffff",
            },
            light: {
                ..._default,
                borderColor: "#289548",
                pointHoverBorderColor: "#289548",
                backgroundColor: {
                    gradient: [
                        { stop: 0, alpha: 0.5, value: "#289548" },
                        { stop: 1, alpha: 0, value: "#289548" },
                    ],
                },
                pointBackgroundColor: "#ffffff",
                pointHoverBackgroundColor: "#ffffff",
            },
        },

        red: {
            dark: {
                ..._default,
                borderColor: "#de5846",
                pointHoverBorderColor: "#de5846",
                backgroundColor: {
                    gradient: [
                        { stop: 0, alpha: 0.5, value: "#de5846" },
                        { stop: 1, alpha: 0, value: "#de5846" },
                    ],
                },
                pointBackgroundColor: "#ffffff",
                pointHoverBackgroundColor: "#ffffff",
            },
            light: {
                ..._default,
                borderColor: "#de5846",
                pointHoverBorderColor: "#de5846",
                backgroundColor: {
                    gradient: [
                        { stop: 0, alpha: 0.5, value: "#de5846" },
                        { stop: 1, alpha: 0, value: "#de5846" },
                    ],
                },
                pointBackgroundColor: "#ffffff",
                pointHoverBackgroundColor: "#ffffff",
            },
        },
    };
}

export function hexToRgb(hex) {
    const re = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;

    hex = hex.replace(re, (m, r, g, b) => r + r + g + g + b + b);
    const result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);

    return result
        ? {
              r: parseInt(result[1], 16),
              g: parseInt(result[2], 16),
              b: parseInt(result[3], 16),
          }
        : null;
}

export function makeGradient(canvas, options) {
    const ctx = canvas.getContext("2d");
    const height = canvas.parentElement.clientHeight / 1.3;
    const gradient = ctx.createLinearGradient(0, 0, 0, height);

    options.forEach((item) => {
        const color = hexToRgb(item.value);

        gradient.addColorStop(
            item.stop,
            `rgba(${color.r}, ${color.g}, ${color.b}, ${item.alpha})`
        );
    });

    return gradient;
}

export function getInfoFromThemeName(name, mode) {
    return themes()[name][mode];
}

export function getFontConfig() {
    return {
        axis: {
            fontSize: 14,
            fontStyle: 600,
            fontColor: "#B0B0B8",
        },
        tooltip: {
            fontColor: "#637282",
            backgroundColor: "#ffffff",
        },
    };
}
