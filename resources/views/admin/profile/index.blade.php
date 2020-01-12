@extends('admin.parent')

@section('title', 'Arkadaşlarım')

@section('styles')
    <style>
        .users-list img {
            border: 5px solid #309A9A;
        }

        .users-list > li {
            width: 20%;
        }

        @media (max-width: 550px) {
            .users-list > li {
                width: 50%;
            }
        }

        .dropdown-menu {
            left: auto;
            right: 0;
        }

        .user-container {
            position: relative;
        }

        .user-container .overlay {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            opacity: 0;
            transition: .3s ease;
            border-radius: 50%;
            z-index: 1;
        }

        .user-container:hover .overlay {
            opacity: 1;
        }

        .user-container .icon {
            color: #287F7F;
            font-size: 72px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            text-align: center;
        }

    </style>
@endsection

@section('header')
    <section class="content-header">
        <h1>
            Arkadaşlarım
            <small>Fakültendeki bütün üyeleri burada görüntüleyebilirsin</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
            <li class="active">Arkadaşlarım</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Sayfa {{ $users->currentPage() . "/" . $users->lastPage() }}
                    </h3>
                    <div class="box-tools">
                        <div class="input-group input-group-sm search-group">
                            <input id="search-input" type="text"
                                   class="form-control table-search-bar pull-right search-input" name="search"
                                   placeholder="Arama"
                                   value="{{ request()->search }}">
                            <div class="input-group-btn">
                                <button id="search-btn" class="btn btn-default" type="submit">
                                    <i class="fa fa-search"></i> Ara
                                </button>
                            </div>
                        </div>
                        <div class="btn-group btn-group-sm filter-group">
                            @include('admin.partials.selectors.role')
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                    <ul class="users-list clearfix">
                        @forelse($users as $user)
                            <li>
                                <div class="user-container">
                                    <img src="{{ $user->photo_url }}" class="img-circle" alt="{{ $user->full_name }}">
                                    <div class="overlay">
                                        <a href="mailto:{{ $user->email }}" class="icon" title="E-posta Gönder"
                                           target="_blank">
                                            <i class="fa fa-envelope"></i>
                                        </a>
                                    </div>
                                </div>
                                <a class="users-list-name" href="#">{{ $user->full_name }}</a>
                                <span class="users-list-date">{{ $user->role_display }}</span>
                            </li>

                        @empty
                            <div class="text-center">
                                <p style="font-size: 80px; line-height: 1; margin: 10px;"><i
                                            class="fa fa-exclamation-triangle"></i></p>
                                <p style="font-size: 24px;">Aradığınız kriterlerde veri bulunamadı</p>
                            </div>
                        @endforelse
                    </ul>
                    <!-- /.users-list -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer text-center">
                    {{ $users->appends(App\Filters\UserFilter::getAppends())->links() }}
                </div>
                <!-- /.box-footer -->
            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
@endsection
