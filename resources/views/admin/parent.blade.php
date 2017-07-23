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

  <!-- Bootstrap 3 -->
  <link rel="stylesheet" href="/node_modules/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/node_modules/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="/node_modules/ionicons/css/ionicons.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="/node_modules/select2/dist/css/select2.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="/node_modules/icheck/skins/flat/red.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="/node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Sweet Alert 2 -->
  <link rel="stylesheet" href="/node_modules/sweetalert2/dist/sweetalert2.min.css">
  <!-- Full Calendar -->
  <link rel="stylesheet" href="/node_modules/fullcalendar/dist/fullcalendar.min.css">
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
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <!-- Menu toggle button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">4</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 4 messages</li>
              <li>
                <!-- inner menu: contains the messages -->
                <ul class="menu">
                  <li><!-- start message -->
                    <a href="#">
                      <div class="pull-left">
                        <!-- User Image -->
                        <img src="{{ admin_asset('img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
                      </div>
                      <!-- Message title and timestamp -->
                      <h4>
                        Support Team
                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                      </h4>
                      <!-- The message -->
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <!-- end message -->
                </ul>
                <!-- /.menu -->
              </li>
              <li class="footer"><a href="#">See All Messages</a></li>
            </ul>
          </li>
          <!-- /.messages-menu -->

          <!-- Notifications Menu -->
          <li class="dropdown notifications-menu">
            <!-- Menu toggle button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">10</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 10 notifications</li>
              <li>
                <!-- Inner Menu: contains the notifications -->
                <ul class="menu">
                  <li><!-- start notification -->
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i> 5 new members joined today
                    </a>
                  </li>
                  <!-- end notification -->
                </ul>
              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li>
          <!-- Tasks Menu -->
          <li class="dropdown tasks-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger">9</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 9 tasks</li>
              <li>
                <!-- Inner menu: contains the tasks -->
                <ul class="menu">
                  <li><!-- Task item -->
                    <a href="#">
                      <!-- Task title and progress text -->
                      <h3>
                        Design some buttons
                        <small class="pull-right">20%</small>
                      </h3>
                      <!-- The progress bar -->
                      <div class="progress xs">
                        <!-- Change the css width attribute to simulate progress -->
                        <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">20% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                </ul>
              </li>
              <li class="footer">
                <a href="#">View all tasks</a>
              </li>
            </ul>
          </li>
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <img src="{{ admin_asset('img/user2-160x160.jpg') }}" class="user-image" alt="User Image">
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs">Enes Çakır</span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                <img src="{{ admin_asset('img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">

                <p>
                  Enes Çakır - Site Sorumlusu
                  <small>1 yıldır üye</small>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="{{ url('/admin/logout') }}" class="btn btn-default btn-flat"
                      onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
                      <i class="fa fa-sign-out"></i> Çıkış Yap
                  </a>
                  <form id="logout-form" action="{{ url('/admin/logout') }}" method="POST" style="display: none;">
                      {{ csrf_field() }}
                  </form>

                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ admin_asset('img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Enes Çakır</p>
          <!-- Status -->
          <a href="#"><i class="fa fa-black-tie"></i> Site Sorumlusu</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li><a href="#"><i class="fa fa-compass"></i> <span>Kontrol Paneli</span></a></li>
        <li><a href="#"><i class="fa fa-address-book-o"></i> <span>Arkadaşlarım</span></a></li>
        <li class="treeview">
          <a href="#"><i class="fa fa-child"></i> <span>Çocuklar</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-plus"></i> <span>Yeni Çocuk Ekle</span></a></li>
            <li><a href="#"><i class="fa fa-heart"></i> <span>Kendi Çocuklarım</span></a></li>
            <li><a href="#"><i class="fa fa-bars"></i> <span>Fakülte Çocukları</span></a></li>
            <li><a href="#"><i class="fa fa-list"></i> <span>Bütün Çocukları</span></a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#"><i class="fa fa-university"></i> <span>Fakülteler</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-plus"></i> <span>Yeni Fakülte Ekle</span></a></li>
            <li><a href="#"><i class="fa fa-fort-awesome"></i> <span>Bütün Fakülteler</span></a></li>
            <li><a href="#"><i class="fa fa-file-text-o"></i> <span>Onam Formu Oluştur</span></a></li>
          </ul>
        </li>
        <li class="treeview {{ set_active('*blood*', 'menu-open active') }}">
          <a href="#"><i class="fa fa-tint"></i> <span>Kan Bağışı</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ set_active('*admin/blood/create*') }}"><a href="{{ route('admin.blood.create') }}"><i class="fa fa-plus"></i> <span>Yeni Bağışçı Ekle</span></a></li>
            <li class="{{ set_active('*admin/blood') }}"><a href="{{ route('admin.blood.index') }}"><i class="fa fa-users"></i> <span>Tüm Bağışçılar</span></a></li>
            <li><a href="#"><i class="fa fa-paper-plane"></i> <span>SMS Gönder</span></a></li>
            <li><a href="#"><i class="fa fa-user-circle-o"></i> <span>Görevliler</span></a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#"><i class="fa fa-pencil"></i> <span>Yazılar</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-folder-o"></i> <span>Fakülte Yazılar</span></a></li>
            <li><a href="#"><i class="fa fa-thumbs-o-up"></i> <span>Onay Bekleyenler</span></a></li>
            <li><a href="#"><i class="fa fa-folder-open-o"></i> <span>Tüm Yazılar</span></a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#"><i class="fa fa-trophy"></i> <span>Gönüllüler</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-plus"></i> <span>Yeni Gönüllü Oluştur</span></a></li>
            <li><a href="#"><i class="fa fa-commenting-o"></i> <span>Açık Sohbetler</span></a></li>
            <li><a href="#"><i class="fa fa-comment-o"></i> <span>Fakülte Sohbetleri</span></a></li>
            <li><a href="#"><i class="fa fa-comments"></i> <span>Tüm Sohbetler</span></a></li>
            <li><a href="#"><i class="fa fa-bell-o"></i> <span>Bildirim Gönder</span></a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#"><i class="fa fa-users"></i> <span>Üyeler</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-thumbs-o-up"></i> <span>Onay Bekleyenler</span></a></li>
            <li><a href="#"><i class="fa fa-user"></i> <span>Fakülte Üyeleri</span></a></li>
            <li><a href="#"><i class="fa fa-users"></i> <span>Tüm Üyeler</span></a></li>
            <li><a href="#"><i class="fa fa-paper-plane"></i> <span>E-posta Gönder</span></a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#"><i class="fa fa-cog"></i> <span>Ayarlar</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-flask"></i> <span>Tanılar</span></a></li>
            <li><a href="#"><i class="fa fa-hospital-o"></i> <span>Departmanlar</span></a></li>
          </ul>
        </li>

        <li class="header">Site</li>
        <li class="treeview">
          <a href="#"><i class="fa fa-newspaper-o"></i> <span>Basında Biz</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-plus"></i> <span>Yeni Haber Ekle</span></a></li>
            <li><a href="#"><i class="fa fa-list-alt"></i> <span>Tüm Haberler</span></a></li>
            <li><a href="#"><i class="fa fa-television"></i> <span>Kanallar</span></a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#"><i class="fa fa-book"></i> <span>Blog</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-plus"></i> <span>Yeni Yazı Ekle</span></a></li>
            <li><a href="#"><i class="fa fa-folder-open-o"></i> <span>Tüm Yazılar</span></a></li>
            <li><a href="#"><i class="fa fa-tags"></i> <span>Yazı Kategorileri</span></a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#"><i class="fa fa-comment-o"></i> <span>Referanslar</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-plus"></i> <span>Yeni Referans Ekle</span></a></li>
            <li><a href="#"><i class="fa fa-comments-o"></i> <span>Tüm Referanslar</span></a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#"><i class="fa fa-briefcase"></i> <span>Destekçiler</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-plus"></i> <span>Yeni Destekçi Ekle</span></a></li>
            <li><a href="#"><i class="fa fa-suitcase"></i> <span>Tüm Destekçiler</span></a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#"><i class="fa fa-wrench"></i> <span>Hata Girdileri</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-tachometer"></i> <span>Genel Görünüm</span></a></li>
            <li><a href="#"><i class="fa fa-list"></i> <span>Ayrıntılı Liste</span></a></li>
          </ul>
        </li>
        <li class="header">Diğer</li>
        <li class="treeview">
          <a href="#"><i class="fa fa-bar-chart"></i> <span>İstatistikler</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-child"></i> <span>Çocuklar</span></a></li>
            <li><a href="#"><i class="fa fa-university"></i> <span>Fakülteler</span></a></li>
            <li><a href="#"><i class="fa fa-trophy"></i> <span>Gönüllüler</span></a></li>
            <li><a href="#"><i class="fa fa-tint"></i> <span>Kan Bağışçıları</span></a></li>
            <li><a href="#"><i class="fa fa-users"></i> <span>Üyeler</span></a></li>
            <li><a href="#"><i class="fa fa-globe"></i> <span>Site Ziyareti</span></a></li>
          </ul>
        </li>
        <li><a href="#"><i class="fa fa-bullhorn"></i> <span>Tanıtım Materyalleri</span></a></li>
        <li><a href="#"><i class="fa fa-envelope-open-o"></i> <span>E-posta Örnekleri</span></a></li>
        <li><a href="#"><i class="fa fa-graduation-cap"></i> <span>Kullanma Kılavuzu</span></a></li>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @yield('header')
    <!-- Main content -->
    <section class="content container-fluid">
      @if (session()->has('success_message'))
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          {!! session()->get('success_message') !!}
        </div>
      @endif

      @if (session()->has('error_message'))
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          {!! session()->get('error_message') !!}
        </div>
      @endif

      @if (session()->has('info_message'))
        <div class="alert alert-info alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          {!! session()->get('info_message') !!}
        </div>
      @endif
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

<!-- jQuery 3 -->
<script src="/node_modules/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="/node_modules/icheck/icheck.min.js"></script>
<!-- Select2 -->
<script src="/node_modules/select2/dist/js/select2.full.min.js"></script>
<!-- Moment -->
<script src="/node_modules/moment/min/moment-with-locales.min.js"></script>
<!-- Date Picker -->
<script src="/node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="/node_modules/bootstrap-datepicker/dist/locales/bootstrap-datepicker.tr.min.js"></script>
<!-- Input Mask -->
<script src="/node_modules/inputmask/dist/min/inputmask/inputmask.min.js"></script>
<script src="/node_modules/inputmask/dist/min/inputmask/jquery.inputmask.min.js"></script>
<script src="/node_modules/inputmask/dist/min/inputmask/inputmask.extensions.min.js"></script>
<script src="/node_modules/inputmask/dist/min/inputmask/inputmask.date.extensions.min.js"></script>
<!-- Slimscroll -->
<script src="/node_modules/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="/node_modules/fastclick/lib/fastclick.js"></script>
<!-- Sweet Alert 2 -->
<script src="/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
<!-- AdminLTE App -->
<script src="{{ admin_asset('js/adminlte.min.js') }}"></script>

<script>
  $(function () {
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
    $('.date-mask').inputmask('dd.mm.yyyy', { 'placeholder': 'GG.AA.YYYY' })
    $('.mobile').inputmask('(999) 999 99 99', { 'placeholder': '(___) ___ __ __' })
    moment.locale('tr');
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


</script>
@yield('scripts')
</body>
</html>
