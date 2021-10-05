const mix = require('laravel-mix');

mix
    .vue()
    .js('resources/js/app.js', 'public/dist/js')
    .sass('resources/sass/app.scss', 'public/dist/sass');
