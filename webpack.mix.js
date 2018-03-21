let mix = require('laravel-mix');
let tailwindcss = require('tailwindcss');

mix.setPublicPath('build/');
mix.setResourceRoot('resources/');

mix.options({
    processCssUrls: false,
    postCss: [tailwindcss('./tailwind.js')],
});

// mix.autoload({
//     jquery: ['$', 'window.jQuery', 'jQuery']
// });

mix.js('resources/scripts/app.js', 'build/scripts/');

mix.sass('resources/styles/app.scss', 'build/styles/');

mix.sourceMaps(true, 'cheap-source-map');

mix.version();

mix.browserSync({
    proxy: process.env.MIX_APP_URL,
    files: ['**/*.php', '!vendor/**/*.php', 'build/**/*']
});
