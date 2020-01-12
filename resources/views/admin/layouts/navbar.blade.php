<nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Menüyü Değiştir</span>
    </a>
    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="{{ $authUser->photo_small_url }}" class="user-image" alt="User Image">
                    <span class="hidden-xs">{{ $authUser->full_name }}</span>
                </a>
                <ul class="dropdown-menu">
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
                            @can('create', App\Models\Child::class)
                                <div class="col-xs-6 text-center">
                                    <a href="{{ route('admin.child.create') }}">Çocuk Ekle</a>
                                </div>
                            @endcan
                            @can('list', App\Models\Child::class)
                                <div class="col-xs-6 text-center">
                                    <a href="{{ route('admin.profile.show') }}">Çocuklarım</a>
                                </div>
                            @endcan
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
                            <form id="logout-form" action="{{ url('/admin/logout') }}" method="POST"
                                  style="display: none;">
                                {{ csrf_field() }}
                            </form>

                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
