let mix = require('laravel-mix');

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

 mix.less('resources/assets/adminlte/less/AdminLTE.less', 'public/admin/css/AdminLTE.min.css');


 mix.styles('resources/assets/admin/css/app.css', 'public/admin/css/app.min.css');
 mix.babel('resources/assets/admin/js/app.js', 'public/admin/js/app.min.js');

 /*
  |--------------------------------------------------------------------------
  | Plugins
  |--------------------------------------------------------------------------
  |
  */

 mix.styles([
  'node_modules/bootstrap/dist/css/bootstrap.min.css', // Bootstrap 3.3.7
  'node_modules/font-awesome/css/font-awesome.min.css', // Font Awesome
  'node_modules/ionicons/css/ionicons.min.css', // Ionicons
  'node_modules/icheck/skins/flat/red.css', // iCheck
  'node_modules/select2/dist/css/select2.min.css', // Select2
  'node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css', // Datepicker
  'node_modules/sweetalert2/dist/sweetalert2.min.css', // Sweet Alert 2
  'node_modules/fullcalendar/dist/fullcalendar.min.css', // Full Calendar
  'node_modules/multiselect/css/multi-select.css', // Multi Select
], 'public/admin/css/plugins.min.css');

 mix.scripts([
  'node_modules/jquery/dist/jquery.min.js', // jQuery 3
  'node_modules/bootstrap/dist/js/bootstrap.min.js', // Bootstrap 3.3.7
  'node_modules/icheck/icheck.min.js', // iCheck
  'node_modules/select2/dist/js/select2.full.min.js', // Select2
  'node_modules/moment/min/moment-with-locales.min.js', // Moment
  'node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js', // Datepicker
  'node_modules/bootstrap-datepicker/dist/locales/bootstrap-datepicker.tr.min.js', // Datepicker TR locale
  'node_modules/inputmask/dist/min/inputmask/inputmask.min.js', // Input Mask
  'node_modules/inputmask/dist/min/inputmask/jquery.inputmask.min.js', // Input Mask
  'node_modules/inputmask/dist/min/inputmask/inputmask.extensions.min.js', // Input Mask
  'node_modules/inputmask/dist/min/inputmask/inputmask.date.extensions.min.js', // Input Mask
  'node_modules/jquery-slimscroll/jquery.slimscroll.min.js', // Slimscroll
  'node_modules/fastclick/lib/fastclick.js', // FastClick
  'node_modules/sweetalert2/dist/sweetalert2.min.js', // Sweet Alert 2
  'node_modules/multiselect/js/jquery.multi-select.js', // Multi Select
  'node_modules/jquery.quicksearch/dist/jquery.quicksearch.min.js', // Quick Search
  'node_modules/bootstrap-maxlength/bootstrap-maxlength.min.js', // Max Length
  'node_modules/block-ui/jquery.blockUI.js', // JQuery Block UI
 ], 'public/admin/js/plugins.min.js');
