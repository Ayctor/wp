let mix = require('laravel-mix');
let StyleLintPlugin = require('stylelint-webpack-plugin');

mix.setPublicPath('build/');
mix.setResourceRoot('resources/');

mix.webpackConfig({
    devServer: {
        overlay: true,
    },
    module: {
        rules: [
            {
                test: /.(js)$/,
                loader: 'eslint-loader',
                enforce: 'pre',
                exclude: /node_modules/
            }
        ]
    },
    plugins: [
        new StyleLintPlugin({
            context: 'resources/styles',
            lintDirtyModulesOnly: true,
            syntax: 'scss'
        }),
    ],
});

mix.options({
    processCssUrls: false
});

mix.js('resources/scripts/app.js', 'build/scripts/');

mix.sass('resources/styles/app.scss', 'build/styles/');

mix.sourceMaps(true, 'cheap-source-map');

mix.version();

mix.browserSync({
    proxy: 'https://wordpress.dev',
    files: ['**/*.php', '!vendor/**/*.php', 'build/**/*']
});
