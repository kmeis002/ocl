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

mix.js('resources/js/app.js', 'public/js').js('resources/js/teacher/teacherresource.js', 'public/js/')
.js('resources/js/teacher/teacherclasses.js', 'public/js/')
.js('resources/js/teacher/teacherb2r.js', 'public/js/')
.js('resources/js/teacher/teacherlab.js', 'public/js/')
.js('resources/js/teacher/teacherassignments.js', 'public/js')
.js('resources/js/teacher/teacherenroll.js', 'public/js')
.js('resources/js/student/studentlabs.js', 'public/js')
.js('resources/js/student/studentb2rs.js', 'public/js')
.js('resources/js/student/studentmachinelist.js', 'public/js')
.js('resources/js/student/studentctflist.js', 'public/js')
 .sass('resources/sass/app.scss', 'public/css');
