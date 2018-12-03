let mix = require('laravel-mix');
require('laravel-mix-tailwind');
require('@ayctor/laravel-mix-svg-sprite');

mix.setPublicPath('build/');
mix.setResourceRoot('resources/');

mix.autoload({
    jquery: [
        '$',
        'window.jQuery',
        'jQuery',
    ],
});

mix.js('resources/scripts/app.js', 'build/scripts/');

mix.sass('resources/styles/app.scss', 'build/styles/');

mix.tailwind();

mix.svgSprite('resources/svg/*.svg');

mix.sourceMaps(true, 'cheap-source-map');

mix.version();

mix.browserSync({
    proxy: process.env.MIX_APP_URL,
    watch: true,
    ignore: [
        /vendor/,
        /docs/
    ]
});
