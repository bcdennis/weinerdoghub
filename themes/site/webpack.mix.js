const mix = require('laravel-mix');

mix
    .setPublicPath('../../public')
    .js('resources/assets/js/app.js', 'themes/site/assets/js');
