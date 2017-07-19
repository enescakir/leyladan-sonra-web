<!DOCTYPE html>
<!--
  Developer: Enes CAKIR
  Website: http://www.enescakir.com/
-->

<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Leyla'dan Sonra | @yield('page-title')</title>

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
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ admin_asset('css/AdminLTE.min.css') }}">

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic&amp;subset=latin-ext">

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
      ]); ?>
  </script>
</head>

<body class="hold-transition skin-ls sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">
    <!-- Logo -->
    <a href="index2.html" class="logo">
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
        <li class="treeview">
          <a href="#"><i class="fa fa-tint"></i> <span>Kan Bağışı</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-plus"></i> <span>Yeni Bağışçı Ekle</span></a></li>
            <li><a href="#"><i class="fa fa-users"></i> <span>Tüm Bağışçılar</span></a></li>
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
    <section class="content-header">
      <h1>
        Page Header
        <small>Optional description</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
      @yield('content')
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header">
              <i class="fa fa-edit"></i>

              <h3 class="box-title">Buttons</h3>
            </div>
            <div class="box-body pad table-responsive">
              <p>Various types of buttons. Using the base class <code>.btn</code></p>
              <table class="table table-bordered text-center">
                <tr>
                  <th>Normal</th>
                  <th>Large <code>.btn-lg</code></th>
                  <th>Small <code>.btn-sm</code></th>
                  <th>X-Small <code>.btn-xs</code></th>
                  <th>Flat <code>.btn-flat</code></th>
                  <th>Disabled <code>.disabled</code></th>
                </tr>
                <tr>
                  <td>
                    <button type="button" class="btn btn-block btn-default">Default</button>
                  </td>
                  <td>
                    <button type="button" class="btn btn-block btn-default btn-lg">Default</button>
                  </td>
                  <td>
                    <button type="button" class="btn btn-block btn-default btn-sm">Default</button>
                  </td>
                  <td>
                    <button type="button" class="btn btn-block btn-default btn-xs">Default</button>
                  </td>
                  <td>
                    <button type="button" class="btn btn-block btn-default btn-flat">Default</button>
                  </td>
                  <td>
                    <button type="button" class="btn btn-block btn-default disabled">Default</button>
                  </td>
                </tr>
                <tr>
                  <td>
                    <button type="button" class="btn btn-block btn-primary">Primary</button>
                  </td>
                  <td>
                    <button type="button" class="btn btn-block btn-primary btn-lg">Primary</button>
                  </td>
                  <td>
                    <button type="button" class="btn btn-block btn-primary btn-sm">Primary</button>
                  </td>
                  <td>
                    <button type="button" class="btn btn-block btn-primary btn-xs">Primary</button>
                  </td>
                  <td>
                    <button type="button" class="btn btn-block btn-primary btn-flat">Primary</button>
                  </td>
                  <td>
                    <button type="button" class="btn btn-block btn-primary disabled">Primary</button>
                  </td>
                </tr>
                <tr>
                  <td>
                    <button type="button" class="btn btn-block btn-success">Success</button>
                  </td>
                  <td>
                    <button type="button" class="btn btn-block btn-success btn-lg">Success</button>
                  </td>
                  <td>
                    <button type="button" class="btn btn-block btn-success btn-sm">Success</button>
                  </td>
                  <td>
                    <button type="button" class="btn btn-block btn-success btn-xs">Success</button>
                  </td>
                  <td>
                    <button type="button" class="btn btn-block btn-success btn-flat">Success</button>
                  </td>
                  <td>
                    <button type="button" class="btn btn-block btn-success disabled">Success</button>
                  </td>
                </tr>
                <tr>
                  <td>
                    <button type="button" class="btn btn-block btn-info">Info</button>
                  </td>
                  <td>
                    <button type="button" class="btn btn-block btn-info btn-lg">Info</button>
                  </td>
                  <td>
                    <button type="button" class="btn btn-block btn-info btn-sm">Info</button>
                  </td>
                  <td>
                    <button type="button" class="btn btn-block btn-info btn-xs">Info</button>
                  </td>
                  <td>
                    <button type="button" class="btn btn-block btn-info btn-flat">Info</button>
                  </td>
                  <td>
                    <button type="button" class="btn btn-block btn-info disabled">Info</button>
                  </td>
                </tr>
                <tr>
                  <td>
                    <button type="button" class="btn btn-block btn-danger">Danger</button>
                  </td>
                  <td>
                    <button type="button" class="btn btn-block btn-danger btn-lg">Danger</button>
                  </td>
                  <td>
                    <button type="button" class="btn btn-block btn-danger btn-sm">Danger</button>
                  </td>
                  <td>
                    <button type="button" class="btn btn-block btn-danger btn-xs">Danger</button>
                  </td>
                  <td>
                    <button type="button" class="btn btn-block btn-danger btn-flat">Danger</button>
                  </td>
                  <td>
                    <button type="button" class="btn btn-block btn-danger disabled">Danger</button>
                  </td>
                </tr>
                <tr>
                  <td>
                    <button type="button" class="btn btn-block btn-warning">Warning</button>
                  </td>
                  <td>
                    <button type="button" class="btn btn-block btn-warning btn-lg">Warning</button>
                  </td>
                  <td>
                    <button type="button" class="btn btn-block btn-warning btn-sm">Warning</button>
                  </td>
                  <td>
                    <button type="button" class="btn btn-block btn-warning btn-xs">Warning</button>
                  </td>
                  <td>
                    <button type="button" class="btn btn-block btn-warning btn-flat">Warning</button>
                  </td>
                  <td>
                    <button type="button" class="btn btn-block btn-warning disabled">Warning</button>
                  </td>
                </tr>
              </table>
            </div>
            <!-- /.box -->
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- ./row -->
      <div class="row">
        <div class="col-md-6">
          <!-- Block buttons -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Block Buttons</h3>
            </div>
            <div class="box-body">
              <button type="button" class="btn btn-default btn-block">.btn-block</button>
              <button type="button" class="btn btn-default btn-block btn-flat">.btn-block .btn-flat</button>
              <button type="button" class="btn btn-default btn-block btn-sm">.btn-block .btn-sm</button>
            </div>
          </div>
          <!-- /.box -->

          <!-- Horizontal grouping -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Horizontal Button Group</h3>
            </div>
            <div class="box-body table-responsive pad">
              <p>
                Horizontal button groups are easy to create with bootstrap. Just add your buttons
                inside <code>&lt;div class="btn-group"&gt;&lt;/div&gt;</code>
              </p>

              <table class="table table-bordered">
                <tr>
                  <th>Button</th>
                  <th>Icons</th>
                  <th>Flat</th>
                  <th>Dropdown</th>
                </tr>
                <!-- Default -->
                <tr>
                  <td>
                    <div class="btn-group">
                      <button type="button" class="btn btn-default">Left</button>
                      <button type="button" class="btn btn-default">Middle</button>
                      <button type="button" class="btn btn-default">Right</button>
                    </div>
                  </td>
                  <td>
                    <div class="btn-group">
                      <button type="button" class="btn btn-default"><i class="fa fa-align-left"></i></button>
                      <button type="button" class="btn btn-default"><i class="fa fa-align-center"></i></button>
                      <button type="button" class="btn btn-default"><i class="fa fa-align-right"></i></button>
                    </div>
                  </td>
                  <td>
                    <div class="btn-group">
                      <button type="button" class="btn btn-default btn-flat"><i class="fa fa-align-left"></i></button>
                      <button type="button" class="btn btn-default btn-flat"><i class="fa fa-align-center"></i></button>
                      <button type="button" class="btn btn-default btn-flat"><i class="fa fa-align-right"></i></button>
                    </div>
                  </td>
                  <td>
                    <div class="btn-group">
                      <button type="button" class="btn btn-default">1</button>
                      <button type="button" class="btn btn-default">2</button>

                      <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                          <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                          <li><a href="#">Dropdown link</a></li>
                          <li><a href="#">Dropdown link</a></li>
                        </ul>
                      </div>
                    </div>
                  </td>
                </tr>
                <!-- ./default -->
                <!-- Info -->
                <tr>
                  <td>
                    <div class="btn-group">
                      <button type="button" class="btn btn-info">Left</button>
                      <button type="button" class="btn btn-info">Middle</button>
                      <button type="button" class="btn btn-info">Right</button>
                    </div>
                  </td>
                  <td>
                    <div class="btn-group">
                      <button type="button" class="btn btn-info"><i class="fa fa-align-left"></i></button>
                      <button type="button" class="btn btn-info"><i class="fa fa-align-center"></i></button>
                      <button type="button" class="btn btn-info"><i class="fa fa-align-right"></i></button>
                    </div>
                  </td>
                  <td>
                    <div class="btn-group">
                      <button type="button" class="btn btn-info btn-flat"><i class="fa fa-align-left"></i></button>
                      <button type="button" class="btn btn-info btn-flat"><i class="fa fa-align-center"></i></button>
                      <button type="button" class="btn btn-info btn-flat"><i class="fa fa-align-right"></i></button>
                    </div>
                  </td>
                  <td>
                    <div class="btn-group">
                      <button type="button" class="btn btn-info">1</button>
                      <button type="button" class="btn btn-info">2</button>

                      <div class="btn-group">
                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                          <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                          <li><a href="#">Dropdown link</a></li>
                          <li><a href="#">Dropdown link</a></li>
                        </ul>
                      </div>
                    </div>
                  </td>
                </tr>
                <!-- /. info -->
                <!-- /.danger -->
                <tr>
                  <td>
                    <div class="btn-group">
                      <button type="button" class="btn btn-danger">Left</button>
                      <button type="button" class="btn btn-danger">Middle</button>
                      <button type="button" class="btn btn-danger">Right</button>
                    </div>
                  </td>
                  <td>
                    <div class="btn-group">
                      <button type="button" class="btn btn-danger"><i class="fa fa-align-left"></i></button>
                      <button type="button" class="btn btn-danger"><i class="fa fa-align-center"></i></button>
                      <button type="button" class="btn btn-danger"><i class="fa fa-align-right"></i></button>
                    </div>
                  </td>
                  <td>
                    <div class="btn-group">
                      <button type="button" class="btn btn-danger btn-flat"><i class="fa fa-align-left"></i></button>
                      <button type="button" class="btn btn-danger btn-flat"><i class="fa fa-align-center"></i></button>
                      <button type="button" class="btn btn-danger btn-flat"><i class="fa fa-align-right"></i></button>
                    </div>
                  </td>
                  <td>
                    <div class="btn-group">
                      <button type="button" class="btn btn-danger">1</button>
                      <button type="button" class="btn btn-danger">2</button>

                      <div class="btn-group">
                        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
                          <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                          <li><a href="#">Dropdown link</a></li>
                          <li><a href="#">Dropdown link</a></li>
                        </ul>
                      </div>
                    </div>
                  </td>
                </tr>
                <!-- /.danger -->
                <!-- warning -->
                <tr>
                  <td>
                    <div class="btn-group">
                      <button type="button" class="btn btn-warning">Left</button>
                      <button type="button" class="btn btn-warning">Middle</button>
                      <button type="button" class="btn btn-warning">Right</button>
                    </div>
                  </td>
                  <td>
                    <div class="btn-group">
                      <button type="button" class="btn btn-warning"><i class="fa fa-align-left"></i></button>
                      <button type="button" class="btn btn-warning"><i class="fa fa-align-center"></i></button>
                      <button type="button" class="btn btn-warning"><i class="fa fa-align-right"></i></button>
                    </div>
                  </td>
                  <td>
                    <div class="btn-group">
                      <button type="button" class="btn btn-warning btn-flat"><i class="fa fa-align-left"></i></button>
                      <button type="button" class="btn btn-warning btn-flat"><i class="fa fa-align-center"></i></button>
                      <button type="button" class="btn btn-warning btn-flat"><i class="fa fa-align-right"></i></button>
                    </div>
                  </td>
                  <td>
                    <div class="btn-group">
                      <button type="button" class="btn btn-warning">1</button>
                      <button type="button" class="btn btn-warning">2</button>

                      <div class="btn-group">
                        <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
                          <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                          <li><a href="#">Dropdown link</a></li>
                          <li><a href="#">Dropdown link</a></li>
                        </ul>
                      </div>
                    </div>
                  </td>
                </tr>
                <!-- /.warning -->
                <!-- success -->
                <tr>
                  <td>
                    <div class="btn-group">
                      <button type="button" class="btn btn-success">Left</button>
                      <button type="button" class="btn btn-success">Middle</button>
                      <button type="button" class="btn btn-success">Right</button>
                    </div>
                  </td>
                  <td>
                    <div class="btn-group">
                      <button type="button" class="btn btn-success"><i class="fa fa-align-left"></i></button>
                      <button type="button" class="btn btn-success"><i class="fa fa-align-center"></i></button>
                      <button type="button" class="btn btn-success"><i class="fa fa-align-right"></i></button>
                    </div>
                  </td>
                  <td>
                    <div class="btn-group">
                      <button type="button" class="btn btn-success btn-flat"><i class="fa fa-align-left"></i></button>
                      <button type="button" class="btn btn-success btn-flat"><i class="fa fa-align-center"></i></button>
                      <button type="button" class="btn btn-success btn-flat"><i class="fa fa-align-right"></i></button>
                    </div>
                  </td>
                  <td>
                    <div class="btn-group">
                      <button type="button" class="btn btn-success">1</button>
                      <button type="button" class="btn btn-success">2</button>

                      <div class="btn-group">
                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                          <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                          <li><a href="#">Dropdown link</a></li>
                          <li><a href="#">Dropdown link</a></li>
                        </ul>
                      </div>
                    </div>
                  </td>
                </tr>
                <!-- /.success -->
              </table>
            </div>
          </div>
          <!-- /.box -->

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Button Addon</h3>
            </div>
            <div class="box-body">
              <p>With dropdown</p>

              <div class="input-group margin">
                <div class="input-group-btn">
                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Action
                    <span class="fa fa-caret-down"></span></button>
                  <ul class="dropdown-menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                  </ul>
                </div>
                <!-- /btn-group -->
                <input type="text" class="form-control">
              </div>
              <!-- /input-group -->
              <p>Normal</p>

              <div class="input-group margin">
                <div class="input-group-btn">
                  <button type="button" class="btn btn-danger">Action</button>
                </div>
                <!-- /btn-group -->
                <input type="text" class="form-control">
              </div>
              <!-- /input-group -->
              <p>Flat</p>

              <div class="input-group margin">
                <input type="text" class="form-control">
                    <span class="input-group-btn">
                      <button type="button" class="btn btn-info btn-flat">Go!</button>
                    </span>
              </div>
              <!-- /input-group -->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          <!-- split buttons box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Split buttons</h3>
            </div>
            <div class="box-body">
              <!-- Split button -->
              <p>Normal split buttons:</p>

              <div class="margin">
                <div class="btn-group">
                  <button type="button" class="btn btn-default">Action</button>
                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                  </ul>
                </div>
                <div class="btn-group">
                  <button type="button" class="btn btn-info">Action</button>
                  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                  </ul>
                </div>
                <div class="btn-group">
                  <button type="button" class="btn btn-danger">Action</button>
                  <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                  </ul>
                </div>
                <div class="btn-group">
                  <button type="button" class="btn btn-success">Action</button>
                  <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                  </ul>
                </div>
                <div class="btn-group">
                  <button type="button" class="btn btn-warning">Action</button>
                  <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                  </ul>
                </div>
              </div>
              <!-- flat split buttons -->
              <p>Flat split buttons:</p>

              <div class="margin">
                <div class="btn-group">
                  <button type="button" class="btn btn-default btn-flat">Action</button>
                  <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                  </ul>
                </div>
                <div class="btn-group">
                  <button type="button" class="btn btn-info btn-flat">Action</button>
                  <button type="button" class="btn btn-info btn-flat dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                  </ul>
                </div>
                <div class="btn-group">
                  <button type="button" class="btn btn-danger btn-flat">Action</button>
                  <button type="button" class="btn btn-danger btn-flat dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                  </ul>
                </div>
                <div class="btn-group">
                  <button type="button" class="btn btn-success btn-flat">Action</button>
                  <button type="button" class="btn btn-success btn-flat dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                  </ul>
                </div>
                <div class="btn-group">
                  <button type="button" class="btn btn-warning btn-flat">Action</button>
                  <button type="button" class="btn btn-warning btn-flat dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                  </ul>
                </div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- end split buttons box -->

          <!-- social buttons -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Social Buttons (By <a href="https://github.com/lipis/bootstrap-social">Lipis</a>)
              </h3>
            </div>
            <div class="box-body">
              <a class="btn btn-block btn-social btn-bitbucket">
                <i class="fa fa-bitbucket"></i> Sign in with Bitbucket
              </a>
              <a class="btn btn-block btn-social btn-dropbox">
                <i class="fa fa-dropbox"></i> Sign in with Dropbox
              </a>
              <a class="btn btn-block btn-social btn-facebook">
                <i class="fa fa-facebook"></i> Sign in with Facebook
              </a>
              <a class="btn btn-block btn-social btn-flickr">
                <i class="fa fa-flickr"></i> Sign in with Flickr
              </a>
              <a class="btn btn-block btn-social btn-foursquare">
                <i class="fa fa-foursquare"></i> Sign in with Foursquare
              </a>
              <a class="btn btn-block btn-social btn-github">
                <i class="fa fa-github"></i> Sign in with GitHub
              </a>
              <a class="btn btn-block btn-social btn-google">
                <i class="fa fa-google-plus"></i> Sign in with Google
              </a>
              <a class="btn btn-block btn-social btn-instagram">
                <i class="fa fa-instagram"></i> Sign in with Instagram
              </a>
              <a class="btn btn-block btn-social btn-linkedin">
                <i class="fa fa-linkedin"></i> Sign in with LinkedIn
              </a>
              <a class="btn btn-block btn-social btn-tumblr">
                <i class="fa fa-tumblr"></i> Sign in with Tumblr
              </a>
              <a class="btn btn-block btn-social btn-twitter">
                <i class="fa fa-twitter"></i> Sign in with Twitter
              </a>
              <a class="btn btn-block btn-social btn-vk">
                <i class="fa fa-vk"></i> Sign in with VK
              </a>
              <br>

              <div class="text-center">
                <a class="btn btn-social-icon btn-bitbucket"><i class="fa fa-bitbucket"></i></a>
                <a class="btn btn-social-icon btn-dropbox"><i class="fa fa-dropbox"></i></a>
                <a class="btn btn-social-icon btn-facebook"><i class="fa fa-facebook"></i></a>
                <a class="btn btn-social-icon btn-flickr"><i class="fa fa-flickr"></i></a>
                <a class="btn btn-social-icon btn-foursquare"><i class="fa fa-foursquare"></i></a>
                <a class="btn btn-social-icon btn-github"><i class="fa fa-github"></i></a>
                <a class="btn btn-social-icon btn-google"><i class="fa fa-google-plus"></i></a>
                <a class="btn btn-social-icon btn-instagram"><i class="fa fa-instagram"></i></a>
                <a class="btn btn-social-icon btn-linkedin"><i class="fa fa-linkedin"></i></a>
                <a class="btn btn-social-icon btn-tumblr"><i class="fa fa-tumblr"></i></a>
                <a class="btn btn-social-icon btn-twitter"><i class="fa fa-twitter"></i></a>
                <a class="btn btn-social-icon btn-vk"><i class="fa fa-vk"></i></a>
              </div>
            </div>
          </div>
          <!-- /.box -->

        </div>
        <!-- /.col -->
        <div class="col-md-6">
          <!-- Application buttons -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Application Buttons</h3>
            </div>
            <div class="box-body">
              <p>Add the classes <code>.btn.btn-app</code> to an <code>&lt;a></code> tag to achieve the following:</p>
              <a class="btn btn-app">
                <i class="fa fa-edit"></i> Edit
              </a>
              <a class="btn btn-app">
                <i class="fa fa-play"></i> Play
              </a>
              <a class="btn btn-app">
                <i class="fa fa-repeat"></i> Repeat
              </a>
              <a class="btn btn-app">
                <i class="fa fa-pause"></i> Pause
              </a>
              <a class="btn btn-app">
                <i class="fa fa-save"></i> Save
              </a>
              <a class="btn btn-app">
                <span class="badge bg-yellow">3</span>
                <i class="fa fa-bullhorn"></i> Notifications
              </a>
              <a class="btn btn-app">
                <span class="badge bg-green">300</span>
                <i class="fa fa-barcode"></i> Products
              </a>
              <a class="btn btn-app">
                <span class="badge bg-purple">891</span>
                <i class="fa fa-users"></i> Users
              </a>
              <a class="btn btn-app">
                <span class="badge bg-teal">67</span>
                <i class="fa fa-inbox"></i> Orders
              </a>
              <a class="btn btn-app">
                <span class="badge bg-aqua">12</span>
                <i class="fa fa-envelope"></i> Inbox
              </a>
              <a class="btn btn-app">
                <span class="badge bg-red">531</span>
                <i class="fa fa-heart-o"></i> Likes
              </a>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          <!-- Various colors -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Different colors</h3>
            </div>
            <div class="box-body">
              <p>Mix and match with various background colors. Use base class <code>.btn</code> and add any available
                <code>.bg-*</code> class</p>
              <!-- You may notice a .margin class added
              here but that's only to make the content
              display correctly without having to use a table-->
              <p>
                <button type="button" class="btn bg-maroon btn-flat margin">.btn.bg-maroon.btn-flat</button>
                <button type="button" class="btn bg-purple btn-flat margin">.btn.bg-purple.btn-flat</button>
                <button type="button" class="btn bg-navy btn-flat margin">.btn.bg-navy.btn-flat</button>
                <button type="button" class="btn bg-orange btn-flat margin">.btn.bg-orange.btn-flat</button>
                <button type="button" class="btn bg-olive btn-flat margin">.btn.bg-olive.btn-flat</button>
              </p>

              <p>
                <button type="button" class="btn bg-maroon margin">.btn.bg-maroon</button>
                <button type="button" class="btn bg-purple margin">.btn.bg-purple</button>
                <button type="button" class="btn bg-navy margin">.btn.bg-navy</button>
                <button type="button" class="btn bg-orange margin">.btn.bg-orange</button>
                <button type="button" class="btn bg-olive margin">.btn.bg-olive</button>
              </p>
            </div>
          </div>
          <!-- /.box -->

          <!-- Vertical grouping -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Vertical Button Group</h3>
            </div>
            <div class="box-body table-responsive pad">

              <p>
                Vertical button groups are easy to create with bootstrap. Just add your buttons
                inside <code>&lt;div class="btn-group-vertical"&gt;&lt;/div&gt;</code>
              </p>

              <table class="table table-bordered">
                <tr>
                  <th>Button</th>
                  <th>Icons</th>
                  <th>Flat</th>
                  <th>Dropdown</th>
                </tr>
                <!-- Default -->
                <tr>
                  <td>
                    <div class="btn-group-vertical">
                      <button type="button" class="btn btn-default">Top</button>
                      <button type="button" class="btn btn-default">Middle</button>
                      <button type="button" class="btn btn-default">Bottom</button>
                    </div>
                  </td>
                  <td>
                    <div class="btn-group-vertical">
                      <button type="button" class="btn btn-default"><i class="fa fa-align-left"></i></button>
                      <button type="button" class="btn btn-default"><i class="fa fa-align-center"></i></button>
                      <button type="button" class="btn btn-default"><i class="fa fa-align-right"></i></button>
                    </div>
                  </td>
                  <td>
                    <div class="btn-group-vertical">
                      <button type="button" class="btn btn-default btn-flat"><i class="fa fa-align-left"></i></button>
                      <button type="button" class="btn btn-default btn-flat"><i class="fa fa-align-center"></i></button>
                      <button type="button" class="btn btn-default btn-flat"><i class="fa fa-align-right"></i></button>
                    </div>
                  </td>
                  <td>
                    <div class="btn-group-vertical">
                      <button type="button" class="btn btn-default">1</button>
                      <button type="button" class="btn btn-default">2</button>

                      <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                          <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                          <li><a href="#">Dropdown link</a></li>
                          <li><a href="#">Dropdown link</a></li>
                        </ul>
                      </div>
                    </div>
                  </td>
                </tr>
                <!-- ./default -->
                <!-- Info -->
                <tr>
                  <td>
                    <div class="btn-group-vertical">
                      <button type="button" class="btn btn-info">Top</button>
                      <button type="button" class="btn btn-info">Middle</button>
                      <button type="button" class="btn btn-info">Bottom</button>
                    </div>
                  </td>
                  <td>
                    <div class="btn-group-vertical">
                      <button type="button" class="btn btn-info"><i class="fa fa-align-left"></i></button>
                      <button type="button" class="btn btn-info"><i class="fa fa-align-center"></i></button>
                      <button type="button" class="btn btn-info"><i class="fa fa-align-right"></i></button>
                    </div>
                  </td>
                  <td>
                    <div class="btn-group-vertical">
                      <button type="button" class="btn btn-info btn-flat"><i class="fa fa-align-left"></i></button>
                      <button type="button" class="btn btn-info btn-flat"><i class="fa fa-align-center"></i></button>
                      <button type="button" class="btn btn-info btn-flat"><i class="fa fa-align-right"></i></button>
                    </div>
                  </td>
                  <td>
                    <div class="btn-group-vertical">
                      <button type="button" class="btn btn-info">1</button>
                      <button type="button" class="btn btn-info">2</button>

                      <div class="btn-group">
                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                          <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                          <li><a href="#">Dropdown link</a></li>
                          <li><a href="#">Dropdown link</a></li>
                        </ul>
                      </div>
                    </div>
                  </td>
                </tr>
                <!-- /. info -->
                <!-- /.danger -->
                <tr>
                  <td>
                    <div class="btn-group-vertical">
                      <button type="button" class="btn btn-danger">Top</button>
                      <button type="button" class="btn btn-danger">Middle</button>
                      <button type="button" class="btn btn-danger">Bottom</button>
                    </div>
                  </td>
                  <td>
                    <div class="btn-group-vertical">
                      <button type="button" class="btn btn-danger"><i class="fa fa-align-left"></i></button>
                      <button type="button" class="btn btn-danger"><i class="fa fa-align-center"></i></button>
                      <button type="button" class="btn btn-danger"><i class="fa fa-align-right"></i></button>
                    </div>
                  </td>
                  <td>
                    <div class="btn-group-vertical">
                      <button type="button" class="btn btn-danger btn-flat"><i class="fa fa-align-left"></i></button>
                      <button type="button" class="btn btn-danger btn-flat"><i class="fa fa-align-center"></i></button>
                      <button type="button" class="btn btn-danger btn-flat"><i class="fa fa-align-right"></i></button>
                    </div>
                  </td>
                  <td>
                    <div class="btn-group-vertical">
                      <button type="button" class="btn btn-danger">1</button>
                      <button type="button" class="btn btn-danger">2</button>

                      <div class="btn-group">
                        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
                          <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                          <li><a href="#">Dropdown link</a></li>
                          <li><a href="#">Dropdown link</a></li>
                        </ul>
                      </div>
                    </div>
                  </td>
                </tr>
                <!-- /.danger -->
                <!-- warning -->
                <tr>
                  <td>
                    <div class="btn-group-vertical">
                      <button type="button" class="btn btn-warning">Top</button>
                      <button type="button" class="btn btn-warning">Middle</button>
                      <button type="button" class="btn btn-warning">Bottom</button>
                    </div>
                  </td>
                  <td>
                    <div class="btn-group-vertical">
                      <button type="button" class="btn btn-warning"><i class="fa fa-align-left"></i></button>
                      <button type="button" class="btn btn-warning"><i class="fa fa-align-center"></i></button>
                      <button type="button" class="btn btn-warning"><i class="fa fa-align-right"></i></button>
                    </div>
                  </td>
                  <td>
                    <div class="btn-group-vertical">
                      <button type="button" class="btn btn-warning btn-flat"><i class="fa fa-align-left"></i></button>
                      <button type="button" class="btn btn-warning btn-flat"><i class="fa fa-align-center"></i></button>
                      <button type="button" class="btn btn-warning btn-flat"><i class="fa fa-align-right"></i></button>
                    </div>
                  </td>
                  <td>
                    <div class="btn-group-vertical">
                      <button type="button" class="btn btn-warning">1</button>
                      <button type="button" class="btn btn-warning">2</button>

                      <div class="btn-group">
                        <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
                          <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                          <li><a href="#">Dropdown link</a></li>
                          <li><a href="#">Dropdown link</a></li>
                        </ul>
                      </div>
                    </div>
                  </td>
                </tr>
                <!-- /.warning -->
                <!-- success -->
                <tr>
                  <td>
                    <div class="btn-group-vertical">
                      <button type="button" class="btn btn-success">Top</button>
                      <button type="button" class="btn btn-success">Middle</button>
                      <button type="button" class="btn btn-success">Bottom</button>
                    </div>
                  </td>
                  <td>
                    <div class="btn-group-vertical">
                      <button type="button" class="btn btn-success"><i class="fa fa-align-left"></i></button>
                      <button type="button" class="btn btn-success"><i class="fa fa-align-center"></i></button>
                      <button type="button" class="btn btn-success"><i class="fa fa-align-right"></i></button>
                    </div>
                  </td>
                  <td>
                    <div class="btn-group-vertical">
                      <button type="button" class="btn btn-success btn-flat"><i class="fa fa-align-left"></i></button>
                      <button type="button" class="btn btn-success btn-flat"><i class="fa fa-align-center"></i></button>
                      <button type="button" class="btn btn-success btn-flat"><i class="fa fa-align-right"></i></button>
                    </div>
                  </td>
                  <td>
                    <div class="btn-group-vertical">
                      <button type="button" class="btn btn-success">1</button>
                      <button type="button" class="btn btn-success">2</button>

                      <div class="btn-group">
                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                          <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                          <li><a href="#">Dropdown link</a></li>
                          <li><a href="#">Dropdown link</a></li>
                        </ul>
                      </div>
                    </div>
                  </td>
                </tr>
                <!-- /.success -->
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /. row -->
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
<!-- Slimscroll -->
<script src="/node_modules/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="/node_modules/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="{{ admin_asset('js/adminlte.min.js') }}"></script>

@yield('scripts')

</body>
</html>
