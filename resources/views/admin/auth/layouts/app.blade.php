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
    <meta name="author" content="Enes Çakır"/>

    <!-- Plugin styles, Bootstrap etc. -->
    <link rel="stylesheet" href="{{ admin_css('vendor.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ admin_css('AdminLTE.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ admin_css('app.min.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic&amp;subset=latin-ext">
    <style>
        .login-box-body {
            border-radius: 5px;
            -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        }

        .btn-bottom {
            border-radius: 0 0 5px 5px !important;
        }
    </style>
    @yield('styles')
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="{{ url('/admin/login') }}">
            <img src="{{ admin_img('logo_login.png') }}" alt="Leyla'dan Sonra Giriş">
        </a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        @include('admin.layouts.messages')

        @yield('content')
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->


<!-- REQUIRED JS SCRIPTS -->
<!-- Plugins - JQuery, Bootstrap etc. -->
<script src="{{ admin_js('vendor.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ admin_js('AdminLTE.min.js') }}"></script>
<!-- App -->
<script src="{{ admin_js('app.min.js') }}"></script>

<script>
    // Reload page because of csrf token
    setTimeout(function () {
        window.location.reload(1);
    }, 3600000);
</script>
@yield('scripts')
</body>
</html>
