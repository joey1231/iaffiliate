const { mix } = require('laravel-mix');

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

mix.js('resources/assets/vue/lander.js', 'public/js/vue/lander.js');
mix.js('resources/assets/vue/campaigns.js', 'public/js/vue/campaigns.js');
mix.js('resources/assets/vue/reports.js', 'public/js/vue/reports.js');
mix.js('resources/assets/vue/users.js', 'public/js/vue/users.js');