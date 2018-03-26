let mix = require('laravel-mix');
require('laravel-mix-tailwind');
require('@ayctor/laravel-mix-svg-sprite');

mix.setPublicPath('build/');
mix.setResourceRoot('resources/');

mix.autoload({
    jquery: ['$', 'window.jQuery', 'jQuery']
});

mix.js('resources/scripts/app.js', 'build/scripts/');

mix.sass('resources/styles/app.scss', 'build/styles/');

mix.tailwind();

mix.svgSprite({
    src: 'resources/svg/*.svg',
    filename: 'svg/sprite.svg',
    prefix: '',
    svgo: {
        plugins: [{
            cleanupIDs: false,
            removeEmptyAttrs: true,
            convertStyleToAttrs: true
        }]
    }
});

mix.sourceMaps(true, 'cheap-source-map');

mix.version();

mix.browserSync({
    proxy: process.env.MIX_APP_URL,
    files: ['**/*.php', '!vendor/**/*.php', 'build/**/*']
});
