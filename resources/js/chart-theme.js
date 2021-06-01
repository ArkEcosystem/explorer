function themes() {
    const lineTension = "0.25";
    const borderWidth = "2";
    const pointRadius = "0";

    const colors = {

        black: {
            dark: {},
            light: {
                backgroundColor: {
                    gradient: [
                        { stop: 0, alpha: 1, value: "" },
                        { stop: 1, alpha: 0, value: "" },
                    ],
                },
                borderColor: "",
                borderWidth: borderWidth,
                lineTension: lineTension,
                pointRadius: pointRadius,
            },
        },

        grey: {},

        yellow: {},

        green: {},

        red: {},
    };

    return {
        placeholder: colors.grey,
        black: colors.black,
        yellow: colors.yellow,
        green: colors.green,
        red: colors.red,
    };
}

export function hexToRgb(hex) {
    const re = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;

    hex = hex.replace(re, (m, r, g, b) => r + r + g + g + b + b);
    const result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);

    return result ? {
        r: parseInt(result[1], 16),
        g: parseInt(result[2], 16),
        b: parseInt(result[3], 16)
    } : null;
}

export function makeGradient(ctx, options) {
    options.forEach((grad) => {
        const stop = parseInt(grad.stop);
        const color = hexToRgb(grad.value);
        const alpha = parseFloat(grad.alpha);

        ctx.addColorStop(stop, `rgba(${color.r}, ${color.g}, ${color.b}, ${alpha})`);
    });

    return ctx;
}

export function getInfoFromThemeName(name, mode) {
    const theme = themes()[name][mode];

    return {
        backgroundColor: theme.backgroundColor,
        borderColor: theme.borderColor,
        borderWidth: theme.borderWidth,
        lineTension: theme.lineTension,
        pointRadius: theme.pointRadius,
    };
}
