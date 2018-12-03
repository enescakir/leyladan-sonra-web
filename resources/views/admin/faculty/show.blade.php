@extends('admin.parent')

@section('title', $faculty->full_name)

@section('header')
    <section class="content-header">
        <h1>
            {{ $faculty->full_name }}
            <small>Bu sayfadan fakültenin ayrıntılı bilgilerini görüntüleyebilirsiniz</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
            <li><a href="{{ route('admin.faculty.index') }}">Fakülteler</a></li>
            <li class="active">{{ $faculty->full_name }}</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="{{ $faculty->thumb_url}}"
                         alt="{{ $faculty->full_name }}">

                    <h3 class="profile-username text-center">{{ $faculty->full_name }}</h3>

                    <p class="text-muted text-center">{{ $faculty->city }}</p>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Çocuk Sayısı</b> <a class="pull-right">{{ $faculty->children()->count() }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Öğrenci Sayısı</b> <a class="pull-right">{{ $faculty->users()->count() }}</a>
                        </li>
                    </ul>

                    <a href="{{ route('admin.faculty.edit', $faculty->id) }}" class="btn btn-warning btn-block"><b>Düzenle</b></a>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

            <!-- About Me Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Sorumlular</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    @foreach($faculty->managers as $manager)
                        {{ $manager->full_name }}
                        <small class="text-muted pull-right"><a
                                    href="{{ "mailto:{$manager->email}" }}">{{ $manager->email }}</a></small>
                        <hr>
                    @endforeach
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">Fakültenin Ayrıntılı Bilgileri</h4>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body no-padding">
                    <table class="table table-striped table-bordered">
                        <tbody>
                        <tr>
                            <th>Tam Ad</th>
                            <td>{{ $faculty->full_name }}</td>
                        </tr>
                        <tr>
                            <th>Kısa Ad</th>
                            <td>{{ $faculty->slug }}</td>
                        </tr>
                        <tr>
                            <th>Durum</th>
                            <td>
                                @if($faculty->isStopped())
                                    <span class="label bg-red">Durduruldu - {{ $faculty->stopped_at_label }}</span>
                                @elseif($faculty->isStarted())
                                    <span class="label bg-green">Aktif - {{ $faculty->started_at_label }}</span>
                                @else
                                    <span class="label bg-yellow">Görülüşüyor</span>
                                @endif

                            </td>
                        </tr>
                        <tr>
                            <th>Şehir</th>
                            <td>{{ $faculty->city }}</td>
                        </tr>
                        <tr>
                            <th>Plaka Kodu</th>
                            <td>{{ $faculty->code }}</td>
                        </tr>
                        <tr>
                            <th>Enlem</th>
                            <td>{{ $faculty->latitude }}</td>
                        </tr>
                        <tr>
                            <th>Boylam</th>
                            <td>{{ $faculty->longitude }}</td>
                        </tr>
                        <tr>
                            <th>Adres</th>
                            <td>{{ $faculty->address }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>

        </div>
        <!-- /.col -->
    </div>
@endsection

@section('scripts')
@endsection
