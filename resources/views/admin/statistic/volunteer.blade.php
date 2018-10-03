@extends('admin.parent')

@section('title', 'Gönüllü İstatistikleri')

@section('styles')
    <style>
        td.counts {
            padding-right: 0 !important;
            padding-left: 0 !important;
        }

        table.nowrap td {
            white-space: nowrap;
        }
    </style>
@endsection

@section('header')
    <section class="content-header">
        <h1>
            Gönüllü İstatistikleri
            {{--<small>Optional description</small>--}}
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
            <li class="active">İstatistik</li>
            <li class="active">Gönüllü</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ $messageCount['today'] }}</h3>
                    <p>Mesaj <i>(Bugün)</i></p>
                </div>
                <div class="icon">
                    <i class="fa fa-envelope"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $messageCount['total'] }}</h3>
                    <p>Mesaj <i>(Toplam)</i></p>
                </div>
                <div class="icon">
                    <i class="fa fa-envelope-open"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ $volunteerCount['today'] }}</h3>
                    <p>Gönüllü <i>(Bugün)</i></p>
                </div>
                <div class="icon">
                    <i class="ion ion-wand"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{ $volunteerCount['total'] }}</h3>
                    <p>Gönüllü <i>(Toplam)</i></p>
                </div>
                <div class="icon">
                    <i class="ion ion-ios-people"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">Son 12 Ay - Yeni Mesaj ve Gönüllüler</h4>
                </div>
                <div class="box-body">
                    <canvas id="dailyChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">Fakülte Mesaj Sayıları ve Ortalamalar</h4>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body no-padding">
                    <div class="table-responsive table-fixed">
                        <table class="table table-condensed table-striped text-center nowrap">
                            <thead>
                            <tr>
                                <th>Fakülte</th>
                                <th>Mesaj</th>
                                <th>Ort. Cevap Süresi</th>
                                <th>Açık Sohbet</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($facultyAverageTimes as $faculty)
                                <tr>
                                    <th>{{ $faculty['name'] }}</th>
                                    <td>{{ $faculty['messages_count'] }} mesaj</td>
                                    <td>{{ $faculty['time'] }} saat</td>
                                    <td>{{ $faculty['open_chats_count'] }} sohbet</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-3">
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">En Çok Mesaj Gönderen Gönüllüler</h4>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body no-padding">
                    <div class="table-responsive table-fixed">
                        <table class="table table-striped table-condensed nowrap">
                            <thead>
                            <tr>
                                <th>Gönüllü</th>
                                <th>Şehir</th>
                                <th>Sayı</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($mostChats as $volunteer)
                                <tr>
                                    <th>{{ $volunteer->full_name }}</th>
                                    <td>{{ $volunteer->city }}</td>
                                    <td>{{ $volunteer->chats_count }} sohbet</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-3">
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">En Çok Hediye Alan Gönüllüler</h4>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body no-padding">
                    <div class="table-responsive table-fixed">
                        <table class="table table-striped table-condensed nowrap">
                            <thead>
                            <tr>
                                <th>Gönüllü</th>
                                <th>Şehir</th>
                                <th>Sayı</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($mostChildren as $volunteer)
                                <tr>
                                    <th>{{ $volunteer->full_name }}</th>
                                    <td>{{ $volunteer->city }}</td>
                                    <td>{{ $volunteer->children_count }} hediye</td>
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
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">Bekleyen Çocuklarımıza Gelen Mesajlar</h4>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body no-padding">
                    <div class="table-responsive table-fixed">
                        <table class="table table-striped table-hover table-bordered table-condensed text-center">
                            <thead>
                            <tr>
                                <th>Çocuk</th>
                                <th>Fakülte</th>
                                <th>Tanışma</th>
                                <th>Dilek</th>
                                <th colspan="3">Sohbet Sayısı</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($waitingChildren as $child)
                                <tr>
                                    <th>{{ $child->full_name }}</th>
                                    <td>{{ $child->faculty->name }}</td>
                                    <td>{{ $child->meeting_day->format('d.m.Y') }}</td>
                                    <td>{{ $child->wish }}</td>
                                    <td class="counts">
                                        <span class="label label-sm label-danger" data-toggle="tooltip"
                                              title="Açık"> {{ $child->open_count }} </span>
                                    </td>
                                    <td class="counts">
                                        <span class="label label-sm label-primary" data-toggle="tooltip"
                                              title="Cevaplanmış"> {{ $child->answered_count }} </span>
                                    </td>
                                    <td class="counts">
                                        <span class="label label-sm label-success" data-toggle="tooltip"
                                              title="Kapalı"> {{ $child->closed_count }} </span>
                                    </td>
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
        var dailyCount = {!! json_encode($dailyCount) !!};
        var ctx = document.getElementById('dailyChart').getContext('2d');
        var dailyChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: dailyCount.message.map(o => moment(o['date'], "YYYY-MM-DD").format('DD.MM.YYYY')),
                datasets: [{
                    label: 'Mesaj Sayısı',
                    data: dailyCount.message.map(o => o['count']),
                    backgroundColor: 'rgba(255, 206, 86, 1)',
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 2,
                    pointRadius: 2,
                    fill: false
                }, {
                    label: 'Yeni Gönüllü',
                    data: dailyCount.volunteer.map(o => o['count']),
                    backgroundColor: 'rgba(153, 102, 255, 1)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 2,
                    pointRadius: 2,
                    fill: false
                }]
            },
            options: {
                scales: {
                    xAxes: [{
                        // type: 'time',
                        // time: {
                        //     // unit: 'day',
                        //     // displayFormats: {
                        //     //     day: 'DD MMM'
                        //     // }
                        // }
                    }]
                }
            }
        });
    </script>
@endsection
