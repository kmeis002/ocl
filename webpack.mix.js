const mix = require('laravel-mix');

mix.webpackConfig({
    externals: {
        "ChunkUpload": "ChunkUpload"
    }
});
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

mix.js('resources/js/app.js', 'public/js').js('resources/js/teacherresource.js', 'public/js/').js('resources/js/teacherclasses.js', 'public/js/')
.js('resources/js/teacherb2r.js', 'public/js/').js('resources/js/teacherlab.js', 'public/js/').js('resources/js/teacherassignments.js', 'public/js')
.js('resources/js/teacherenroll.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');
