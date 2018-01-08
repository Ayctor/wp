let mix = require('laravel-mix');
let StyleLintPlugin = require('stylelint-webpack-plugin');

mix.setPublicPath('build/');
mix.setResourceRoot('ressources/');

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
            context: 'ressources/styles',
            lintDirtyModulesOnly: true,
            syntax: 'scss'
        }),
    ],
});

mix.options({
    processCssUrls: false
});

mix.js('ressources/scripts/app.js', 'build/scripts/');

mix.sass('ressources/styles/app.scss', 'build/styles/');

mix.sourceMaps(true, 'cheap-source-map');

mix.version();

mix.browserSync({
    proxy: 'https://wordpress.dev',
    files: ['**/*.php', '!vendor/**/*.php', 'build/**/*']
});
