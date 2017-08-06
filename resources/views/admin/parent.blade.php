<!DOCTYPE html>
<!--
  Developer: Enes CAKIR
  Website: http://www.enescakir.com/
-->

<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Leyla'dan Sonra | @yield('title')</title>

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

  <!-- Meta-data -->
  <meta name="description" content="Leyla'dan Sonra Yönetim Paneli"/>
  <meta name="author" content="Enes Çakır" />

  <!-- Plugin styles, Bootstrap etc. -->
  <link rel="stylesheet" href="{{ admin_asset('css/plugins.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ admin_asset('css/AdminLTE.min.css') }}">

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic&amp;subset=latin-ext">

  <style>
    tr .four-button {
      width: 120px;
      min-width: 120px;
      max-width: 120px;
    }
    tr .three-button {
      width: 90px;
      min-width: 90px;
      max-width: 90px;
    }

    tr .two-button {
      width: 60px;
      min-width: 60px;
      max-width: 60px;
    }

    .scrollable-menu {
      height: auto;
      max-height: 200px;
      overflow-x: hidden;
    }
  </style>
  @yield('styles')

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- BEGIN FAVICONS -->
  <link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="/apple-touch-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon-180x180.png">
  <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
  <link rel="icon" type="image/png" href="/android-chrome-192x192.png" sizes="192x192">
  <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96">
  <link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
  <link rel="manifest" href="/manifest.json">
  <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="apple-mobile-web-app-title" content="Leyla'dan Sonra">
  <meta name="application-name" content="Leyla'dan Sonra">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="msapplication-TileImage" content="/mstile-144x144.png">
  <meta name="theme-color" content="#ffffff">
  <!-- END FAVICONS -->


  <!-- Scripts -->
  <script>
      window.Laravel = <?php echo json_encode([
          'csrfToken' => csrf_token(),
      ]); ?>;
      window.AuthUser = {!! json_encode($authUser->toArray()) !!};
  </script>
</head>

<body class="hold-transition skin-ls sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">
    <!-- Logo -->
    <a href="{{ route('admin.dashboard') }}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>L</b>S</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Leyla'dan</b> Sonra</span>
    </a>
    <!-- Header Navbar -->
    @include('admin.partials.navbar')
    <!-- /.navbar -->
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    @include('admin.partials.sidebar')
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @yield('header')
    <!-- Main content -->
    <section class="content container-fluid">
      @include('admin.partials.messages')
      @yield('content')
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    2017 &copy; <a href="http://www.enescakir.com" target="_blank">Enes Çakır</a>. Leyla'dan Sonra Yönetim Programı. v3.0.1
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->
<!-- Plugins - JQuery, Bootstrap etc. -->
<script src="{{ admin_asset('js/plugins.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ admin_asset('js/adminlte.min.js') }}"></script>

<script>
  $(function () {
    moment.locale('tr');
    $('.icheck').iCheck({
      checkboxClass: 'icheckbox_flat-red',
      radioClass: 'iradio_flat-red',
      increaseArea: '20%' // optional
    });

    $('.select2').select2();
    $('.select2-no-search').select2({
      minimumResultsForSearch: Infinity,
    });

    $('.birthday-picker').datepicker({
      language: "tr",
      startView: 2,
      autoclose: true
    })

    $('.date-picker').datepicker({
      language: "tr",
      autoclose: true
    })
    $('.max-length').maxlength({
        alwaysShow: true,
    });
    $('.date-mask').inputmask('dd.mm.yyyy', { 'placeholder': 'GG.AA.YYYY' })
    $('.mobile').inputmask('(999) 999 99 99', { 'placeholder': '(___) ___ __ __' })
    $('.multi-select').multiSelect({
      selectableHeader: "<input type='text' class='search-input' style='width: 100%; margin-bottom: 10px;' autocomplete='off' placeholder='Arama'>",
      selectionHeader: "<input type='text' class='search-input' style='width: 100%; margin-bottom: 10px;' autocomplete='off' placeholder='Arama'>",
      afterInit: function(ms){
        $('#multiselect-loading').remove();
        var that = this,
            $selectableSearch = that.$selectableUl.prev(),
            $selectionSearch = that.$selectionUl.prev(),
            selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
            selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

        that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
        .on('keydown', function(e){
          if (e.which === 40){
            that.$selectableUl.focus();
            return false;
          }
        });

        that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
        .on('keydown', function(e){
          if (e.which == 40){
            that.$selectionUl.focus();
            return false;
          }
        });
      },
      afterSelect: function(){
        this.qs1.cache();
        this.qs2.cache();
      },
      afterDeselect: function(){
        this.qs1.cache();
        this.qs2.cache();
      }
    });
  });
</script>
<script type="text/javascript">
  $.ajaxSetup({ headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') }});

  function deleteItem(slug, idAttr, nameAttr, message, deleteClass = "delete") {
    $('.' + deleteClass).on('click', function (e) {
      var id = $(this).attr(idAttr);
      var name = $(this).attr(nameAttr);

      swal({
        title: "Emin misin?",
        text:  "'" + name + "' " + message,
        type: "warning",
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Evet, sil!",
        showCancelButton: true,
        cancelButtonText: "Hayır",
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
        preConfirm: function (email) {
          return new Promise(function (resolve, reject) {
            $.ajax({
              url: "/admin/" + slug + "/" + id,
              method: "DELETE",
              dataType: "json",
              success: function(result){
                resolve()
              },
              error: function (xhr, ajaxOptions, thrownError) {
                reject('Bir hata ile karşılaşıldı.')
                ajaxError(xhr, ajaxOptions, thrownError);
              }
            });
          })
        },
        allowOutsideClick: false,
      }).then(function () {
        $("#" + slug + "-" + id).remove();
        swal({
          title: "Başarıyla Silindi!",
          type: "success",
          confirmButtonText: "Tamam",
        });
      })
    });
  }

  function ajaxError(xhr, ajaxOptions, thrownError) {
    console.log("XHR:");
    console.log(xhr);
    console.log("Ajax Options:");
    console.log(ajaxOptions);
    console.log("Thrown Error:");
    console.log(thrownError);
    swal({
      title: "Bir hata ile karşılaşıldı!",
      type: "error",
      confirmButtonText: "Tamam",
    });
  }

  function block(selector) {
    $(selector).block({
      message: null,
      // message: '<img style="width:100%; height:auto;" src="{{ asset('front/images/gifs/loading.gif') }}" />',
      // overlayCSS: { backgroundColor: 'rgb(255, 255, 255)' },
      // css: { border: 'none' },
    });
  }

  function unblock(selector) {
    $(selector).unblock();
  }

</script>
@yield('scripts')
</body>
</html>
