<nav class="navbar navbar-static-top" role="navigation">
  <!-- Sidebar toggle button-->
  <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
    <span class="sr-only">Menüyü Değiştir</span>
  </a>
  <!-- Navbar Right Menu -->
  <div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
      <!-- Messages: style can be found in dropdown.less-->
      <li class="dropdown messages-menu">
        <!-- Menu toggle button -->
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <i class="fa fa-envelope-o"></i>
          <span class="label label-danger">4</span>
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
                    <img src="{{ $authUser->photo_small_url }}" class="img-circle" alt="User Image">
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

      <!-- User Account Menu -->
      <li class="dropdown user user-menu">
        <!-- Menu Toggle Button -->
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <!-- The user image in the navbar-->
          <img src="{{ $authUser->photo_small_url }}" class="user-image" alt="User Image">
          <!-- hidden-xs hides the username on small devices so only the image appears. -->
          <span class="hidden-xs">{{ $authUser->full_name }}</span>
        </a>
        <ul class="dropdown-menu">
          <!-- The user image in the menu -->
          <li class="user-header">
            <img src="{{ $authUser->photo_small_url }}" class="img-circle" alt="{{ $authUser->full_name }}">

            <p>
              {{ $authUser->full_name }}
              <small>{{ $authUser->role_display }}</small>
            </p>
          </li>
          <!-- Menu Body -->
          <li class="user-body">
            <div class="row">
              <div class="col-xs-6 text-center">
                <a href="{{ route('admin.child.create') }}">Çocuk Ekle</a>
              </div>
              <div class="col-xs-6 text-center">
                <a href="{{ route('admin.profile.show') }}">Çocuklarım</a>
              </div>
            </div>
            <!-- /.row -->
          </li>
          <!-- Menu Footer-->
          <li class="user-footer">
            <div class="pull-left">
              <a href="{{ route('admin.profile.show') }}" class="btn btn-default btn-flat">Profilim</a>
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
