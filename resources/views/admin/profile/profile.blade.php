@extends('admin.layouts.app')

@section('title', 'Profilim')

@section('styles')
@endsection

@section('header')
    <section class="content-header">
        <h1>
            Profilim
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
            <li class="active">Profilim</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3">
            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="{{ $user->photo_url }}"
                         alt="{{ $user->full_name }}">

                    <h3 class="profile-username text-center">{{ $user->full_name }}</h3>

                    <p class="text-muted text-center">{{ $user->role_display }}</p>

                    <a href="{{ route('admin.profile.show') }}"
                       class="btn btn-default {{ set_active('*admin/profile/child', 'btn-ls') }} btn-block">Çocuklarım</a>
                    <a href="{{ route('admin.profile.edit') }}"
                       class="btn btn-default {{ set_active('*admin/profile/setting', 'btn-ls') }} btn-block">Ayarlarım</a>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Çocuk</b> <a class="pull-right">{{ $user->children()->count() }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Ziyaret</b> <a class="pull-right">{{ $user->visits()->count() }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Teslim</b> <a class="pull-right">{{ $user->deliveredChildren()->count() }}</a>
                        </li>
                    </ul>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

            <!-- About Me Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Hakkımda</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                    <table class="table table-striped table-bordered">
                        <tbody>
                        <tr>
                            <th><i class="fa fa-university margin-r-5"></i> Fakülte</th>
                            <td>{{ $user->faculty->full_name }}</td>
                        </tr>
                        <tr>
                            <th><i class="fa fa-graduation-cap margin-r-5"></i> Yıl</th>
                            <td>{{ $user->year }}</td>
                        </tr>
                        <tr>
                            <th><i class="fa fa-calendar margin-r-5"></i> Doğum Günü</th>
                            <td>{{ $user->birthday_label }}</td>
                        </tr>
                        <tr>
                            <th><i class="fa fa-child margin-r-5"></i> Cinsiyet</th>
                            <td>{{ $user->gender }}</td>
                        </tr>
                        <tr>
                            <th><i class="fa fa-envelope margin-r-5"></i> E-posta</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th><i class="fa fa-phone margin-r-5"></i> Telefon</th>
                            <td>{{ $user->mobile }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            @yield('profileContent')
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
@endsection
