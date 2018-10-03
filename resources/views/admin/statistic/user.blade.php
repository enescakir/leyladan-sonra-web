@extends('admin.parent')

@section('title', 'Üye İstatistikleri')

@section('styles')
@endsection

@section('header')
    <section class="content-header">
        <h1>
            Üye İstatistikleri
            {{--<small>Optional description</small>--}}
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
            <li class="active">İstatistik</li>
            <li class="active">Üye</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ $oldestUser->birthday->format('d.m.Y') }}</h3>
                    <p>En Yaşlı Üye</p>
                </div>
                <div class="icon">
                    <i class="fa fa-user"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{ $youngestUser->birthday->format('d.m.Y') }}</h3>
                    <p>En Genç Üye</p>
                </div>
                <div class="icon">
                    <i class="fa fa-child"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ $ageAverage->average }}</h3>
                    <p>Yaş Ortalaması</p>
                </div>
                <div class="icon">
                    <i class="fa fa-calculator"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">En Fazla Bulunan Üye İsimleri</h4>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body no-padding">
                    <div class="table-responsive table-fixed" style="max-height: 380px">
                        <table class="table table-condensed table-striped">
                            <thead>
                            <tr>
                                <th>İsim</th>
                                <th>Üye Sayısı</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($userByName as $name => $count)
                                <tr>
                                    <th>{{ $name }}</th>
                                    <td>{{ $count }} üye</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">Burçlara Dağılımı</h4>
                </div>
                <div class="box-body">
                    <canvas id="horoscopeChart" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">Fakülte Üye Dağılımı</h4>
                </div>
                <div class="box-body">
                    <canvas id="facultyChart" width="400" height="310"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">Üye Görev Dağılımı</h4>
                </div>
                <div class="box-body">
                    <canvas id="roleChart" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">En Çok Ziyaret Edenler
                        <small>'Ziyaret ettim' düğmesi</small>
                    </h4>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body no-padding">
                    <div class="table-responsive table-fixed">
                        <table class="table table-condensed table-striped">
                            <thead>
                            <tr>
                                <th>Üye</th>
                                <th>Fakülte</th>
                                <th>Sayı</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($mostVisits as $user)
                                <tr>
                                    <th>{{ $user->full_name }}</th>
                                    <td>{{ $user->faculty->name }}</td>
                                    <td>{{ $user->visits_count }} ziyaret</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-4">
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">En Çok Çocuklular
                        <small>Sorumlu olduğu çocuk sayısı</small>
                    </h4>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body no-padding">
                    <div class="table-responsive table-fixed">
                        <table class="table table-condensed table-striped">
                            <thead>
                            <tr>
                                <th>Üye</th>
                                <th>Fakülte</th>
                                <th>Sayı</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($mostChildren as $user)
                                <tr>
                                    <th>{{ $user->full_name }}</th>
                                    <td>{{ $user->faculty->name }}</td>
                                    <td>{{ $user->children_count }} çocuk</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">En Çok Mesaj Cevaplayanlar
                    </h4>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body no-padding">
                    <div class="table-responsive table-fixed">
                        <table class="table table-condensed table-striped">
                            <thead>
                            <tr>
                                <th>Üye</th>
                                <th>Fakülte</th>
                                <th>Sayı</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($mostAnswers as $user)
                                <tr>
                                    <th>{{ $user->full_name }}</th>
                                    <td>{{ $user->faculty->name }}</td>
                                    <td>{{ $user->answers_count }} mesaj</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-4">
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">En Çok Yazı Onaylayanlar
                    </h4>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body no-padding">
                    <div class="table-responsive table-fixed">
                        <table class="table table-condensed table-striped">
                            <thead>
                            <tr>
                                <th>Üye</th>
                                <th>Fakülte</th>
                                <th>Sayı</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($mostApprovals as $user)
                                <tr>
                                    <th>{{ $user->full_name }}</th>
                                    <td>{{ $user->faculty->name }}</td>
                                    <td>{{ $user->approved_posts_count }} yazı</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-4">
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">En Çok Hediye Karşılayanlar
                        <small>'Hediyesi geldi' düğmesi</small>
                    </h4>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body no-padding">
                    <div class="table-responsive table-fixed">
                        <table class="table table-condensed table-striped">
                            <thead>
                            <tr>
                                <th>Üye</th>
                                <th>Fakülte</th>
                                <th>Sayı</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($mostArrivals as $user)
                                <tr>
                                    <th>{{ $user->full_name }}</th>
                                    <td>{{ $user->faculty->name }}</td>
                                    <td>{{ $user->arrivals_count }} hediye</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var horoscopes = {!! json_encode($userByHoroscope) !!};
        var faculties = {!! json_encode($userByFaculty) !!};
        var roles = {!! json_encode($userByRole) !!};

        initPieChart("horoscopeChart", Object.keys(horoscopes), Object.values(horoscopes));
        initChart("facultyChart", 'bar', Object.keys(faculties), Object.values(faculties), 'Üye Sayısı');
        initPieChart("roleChart", Object.keys(roles), Object.values(roles));

    </script>
@endsection
