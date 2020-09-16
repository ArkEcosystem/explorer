const mix = require('laravel-mix');
const tailwindCss = require('tailwindcss');
const glob = require('glob-all');
const purgeCss = require('purgecss-webpack-plugin');
const importCss = require('postcss-import');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

const tailwindExtractor = content => content.match(/[\w-/.:]+(?<!:)/g) || [];

mix
    .options({
        processCssUrls: false,
    })
    .ts('resources/js/app.ts', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [importCss(), tailwindCss('tailwind.config.js')])
    .copyDirectory('resources/images', 'public/images')
    .copyDirectory('resources/fonts', 'public/fonts')
    .extract();

if (mix.inProduction()) {
    mix.webpackConfig({
        plugins: [
            new purgeCss({
                paths: glob.sync([
                    path.join(__dirname, 'resources/views/**/*.blade.php'),
                    path.join(__dirname, 'vendor/arkecosystem/frontend/src/resources/views/**/*.blade.php'),
                    path.join(__dirname, 'resources/js/**/*.ts'),
                    path.join(__dirname, 'resources/js/**/*.js'),
                    path.join(__dirname, 'resources/js/**/*.vue'),
                    path.join(__dirname, 'app/**/*.php'),
                ]),
                extractors: [{
                    extractor: tailwindExtractor,
                    extensions: ['html', 'js', 'ts', 'vue', 'php'],
                }],
                whitelistPatterns: [/horizontal$/, /alert-/, /swiper-/],
            }),
        ],
    });

    mix.version();
}
