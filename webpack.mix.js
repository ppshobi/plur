const mix = require('laravel-mix');
require('laravel-mix-auto-extract');

mix.sass('resources/sass/backend/backend.scss', 'css/backend.css')
   .sass('resources/sass/frontend/frontend.scss', 'css/frontend.css')
   .js('resources/js/frontend.js', 'js/frontend.js')
   .js('resources/js/backend.js', 'js/backend.js')
   .copyDirectory('node_modules/datatables.net-dt/images', 'public/images')
   .version();

mix.setPublicPath('public')
   .autoExtract()
   .options({
      autoprefixer: false,
      processCssUrls: false,
   });

if (!mix.inProduction()) {
    mix.webpackConfig({
          devtool: 'source-map',
       })
       .sourceMaps()
       .browserSync({
           open: 'external',
           host: 'plur.test',
           proxy: 'plur.test',
           port: 3000
       })
}
