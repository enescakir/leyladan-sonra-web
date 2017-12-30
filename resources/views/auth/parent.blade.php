<!DOCTYPE html>
<!--
Author: Enes Cakir
Website: http://www.enescakir.com/
Contact: enes@cakir.web.tr
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title') | Leyla'dan Sonra</title>

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- Meta-data -->
  <meta name="description" content="Leyla'dan Sonra Yönetim Paneli"/>
  <meta name="author" content="Enes Çakır" />

  <!-- Plugin styles, Bootstrap etc. -->
  <link rel="stylesheet" href="{{ admin_asset('css/plugins.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ admin_asset('css/AdminLTE.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ admin_asset('css/app.min.css') }}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic&amp;subset=latin-ext">
  @yield('styles')
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="{{ url('/admin/login') }}">
      <img src="{{ admin_asset('img/logo_login.png') }}" alt="Leyla'dan Sonrar Login Logo">
    </a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    @if (Session::has('success_message'))
        <div class="alert alert-success fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            {!! Session::get('success_message') !!}
        </div>
    @endif

    @if (Session::has('error_message'))
        <div class="alert alert-danger fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            {!! Session::get('error_message') !!}
        </div>
    @endif

    @if (Session::has('info_message'))
        <div class="alert alert-info fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            {!! Session::get('info_message') !!}
        </div>
    @endif

    @yield('content')
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->


<!-- REQUIRED JS SCRIPTS -->
<!-- Plugins - JQuery, Bootstrap etc. -->
<script src="{{ admin_asset('js/plugins.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ admin_asset('js/adminlte.min.js') }}"></script>
<!-- App -->
<script src="{{ admin_asset('js/app.min.js') }}"></script>

<script>
  // Reload page because of csrf token
  setTimeout(function(){
    window.location.reload(1);
  }, 3600000);
</script>
@yield('scripts')
</body>
</html>
