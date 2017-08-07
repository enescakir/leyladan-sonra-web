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
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ admin_asset('css/app.min.css') }}">

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic&amp;subset=latin-ext">

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
<!-- App -->
<script src="{{ admin_asset('js/app.min.js') }}"></script>

@yield('scripts')
</body>
</html>
