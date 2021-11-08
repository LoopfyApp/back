const mix = require('laravel-mix');
mix.setPublicPath('../theme/')
mix.js('resources/js/app.js', 'js') 
    .vue();
 
mix.sass('resources/css/sass/themes/dore.light.red.scss', 'theme/css/all.css')
.minify('../theme/css/all.css');
