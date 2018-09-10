let mix = require('laravel-mix');


/*
 |--------------------------------------------------------------------------
 | AdminLTE Resource
 |--------------------------------------------------------------------------
 */
mix.less('resources/admin/adminlte/less/AdminLTE.less', 'public/admin/css/AdminLTE.min.css');
mix.js('resources/admin/adminlte/js/AdminLTE.js', 'public/admin/js/AdminLTE.min.js');


/*
 |--------------------------------------------------------------------------
 | 3rd Party Libraries
 |--------------------------------------------------------------------------
 */
mix.less('resources/admin/css/vendor.less', 'public/admin/css/vendor.min.css');
// mix.js('resources/admin/js/vendor.js', 'public/admin/js/vendor.min.js').autoload({
//   jquery: ['$', 'window.jQuery', 'jQuery'],
// });;
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
  'node_modules/bootstrap-filestyle/src/bootstrap-filestyle.min.js', // Bootstrap File Style
  'node_modules/chart.js/dist/Chart.min.js', // Chart.js
  'node_modules/cropperjs/dist/cropper.min.js', // CropperJS
  'node_modules/clipboard/dist/clipboard.min.js', // Clipboard JS
  'node_modules/summernote/dist/summernote.js' // Summernote
 ], 'public/admin/js/vendor.min.js');


 // Custom

mix.styles('resources/admin/css/app.css', 'public/admin/css/app.min.css');
mix.babel('resources/admin/js/functions.js', 'public/admin/js/app.min.js');
mix.copy('resources/admin/img/*', 'public/admin/img/');


// JQVMap
mix.scripts([
  'node_modules/jqvmap/dist/jquery.vmap.min.js',
  'node_modules/jqvmap/dist/maps/jquery.vmap.turkey.js',
], 'public/admin/js/jqvmap.min.js');

// Full Calendar
mix.scripts([
  'node_modules/fullcalendar/dist/fullcalendar.min.js',
  'node_modules/fullcalendar/dist/locale/tr.js',
], 'public/admin/js/fullcalendar.min.js');
