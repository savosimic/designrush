const mix = require('laravel-mix');
require('laravel-mix-criticalcss');

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css')
    .criticalCss({
        enabled: mix.inProduction(),
        paths: { base: 'public/' },
        urls: ['/', '/providers'],
        options: { width: 1300, height: 900 },
    });
