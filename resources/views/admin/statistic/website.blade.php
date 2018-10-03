@extends('admin.parent')

@section('title', 'İnternet Sitesi İstatistikleri')

@section('styles')
@endsection

@section('header')
    <section class="content-header">
        <h1>
            İnternet Sitesi İstatistikleri
            {{--<small>Optional description</small>--}}
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
            <li class="active">İstatistik</li>
            <li class="active">İnternet Sitesi</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3 class="active-users-count">0</h3>
                    <p>Aktif Kişi</p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
                <div class="overlay">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3 class="today-visitors-count">0</h3>
                    <p>Ziyaretçi <i>(Bugün)</i></p>
                </div>
                <div class="icon">
                    <i class="fa fa-user-plus"></i>
                </div>
                <div class="overlay">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-orange">
                <div class="inner">
                    <h3 class="today-pageviews-count">0</h3>
                    <p>Sayfa Görüntüleme <i>(Bugün)</i></p>
                </div>
                <div class="icon">
                    <i class="fa fa-columns"></i>
                </div>
                <div class="overlay">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">
                        Siteye Gelme Dağılımı
                        <small>son 1 yıl</small>
                    </h4>
                </div>
                <div class="box-body">
                    <canvas id="referrerChart" width="400" height="400"></canvas>
                </div>
                <div class="overlay">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">
                        Tarayıcı Dağılımı
                        <small>son 1 yıl</small>
                    </h4>
                </div>
                <div class="box-body">
                    <canvas id="browserChart" width="400" height="400"></canvas>
                </div>
                <div class="overlay">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">
                        Ziyaretçi Dağılımı
                        <small>son 1 yıl</small>
                    </h4>
                </div>
                <div class="box-body">
                    <canvas id="typeChart" width="400" height="400"></canvas>
                </div>
                <div class="overlay">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">Popüler Sayfalar
                        <small>son 1 yıl</small>
                    </h4>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body no-padding">
                    <div class="table-responsive table-fixed">
                        <table class="table table-condensed table-striped">
                            <thead>
                            <tr>
                                <th>Sayfa</th>
                                <th>Ziyaret Sayısı</th>
                            </tr>
                            </thead>
                            <tbody id="page-visit-container">
                            @foreach([] as $city => $count)
                                <tr>
                                    <th>{{ $city }}</th>
                                    <td>{{ $count }} bağışçı</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="overlay">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">
                        İnternet Sitesinin 2 Aylık Trafiği
                    </h4>
                </div>
                <div class="box-body">
                    <canvas id="dailyChart" height="150"></canvas>
                </div>
                <div class="overlay">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        $.ajax({
            url: '/admin/statistic/website',
            method: 'GET',
            data: {type: 'top-referrers'}
        }).done(function (response) {
            initPieChart("referrerChart", Object.keys(response.data), Object.values(response.data));
            $("#referrerChart").parent().next().remove();
        });

        $.ajax({
            url: '/admin/statistic/website',
            method: 'GET',
            data: {type: 'top-browsers'}
        }).done(function (response) {
            initPieChart("browserChart", response.data.map(o => o['browser']), response.data.map(o => o['sessions']));
            $("#browserChart").parent().next().remove();
        });

        $.ajax({
            url: '/admin/statistic/website',
            method: 'GET',
            data: {type: 'user-types'}
        }).done(function (response) {
            initPieChart("typeChart", response.data.map(o => o['type']), response.data.map(o => o['sessions']));
            $("#typeChart").parent().next().remove();
        });

        $.ajax({
            url: '/admin/statistic/website',
            method: 'GET',
            data: {type: 'most-visited-pages'}
        }).done(function (response) {
            var rows = response.data.reduce(function (carry, element) {
                return carry + '<tr><td>' + element['pageTitle'] + '</td><td>' + element['pageViews'] + '</td></tr>'
            }, '');
            $("#page-visit-container").html(rows).parent().parent().parent().next().remove();
        });

        $.ajax({
            url: '/admin/statistic/website',
            method: 'GET',
            data: {type: 'today-visits-pageviews'}
        }).done(function (response) {
            var data = response.data[0];
            $('.today-visitors-count').text(data['visitors']).parent().next().next().remove();
            $('.today-pageviews-count').text(data['pageViews']).parent().next().next().remove();
        });

        $.ajax({
            url: '/admin/statistic/website',
            method: 'GET',
            data: {type: 'total-visits-pageviews'}
        }).done(function (response) {
            var ctx = document.getElementById('dailyChart').getContext('2d');
            var dailyChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: response.data.map(o => moment(o['date']['date']).format('DD.MM.YYYY')),
                    datasets: [{
                        label: 'Ziyaretçi',
                        data: response.data.map(o => o['visitors']),
                        backgroundColor: 'rgba(255, 206, 86, 1)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 2,
                        pointRadius: 2,
                        fill: false
                    }, {
                        label: 'Sayfa Görüntüleme',
                        data: response.data.map(o => o['pageViews']),
                        backgroundColor: 'rgba(153, 102, 255, 1)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 2,
                        pointRadius: 2,
                        fill: false
                    }]
                },
                // options: {
                //     scales: {
                //         xAxes: [{
                //             type: 'time',
                //             time: {
                //                 unit: 'day',
                //                 displayFormats: {
                //                     day: 'DD MMM'
                //                 }
                //             }
                //         }]
                //     }
                // }
            });
            $("#dailyChart").parent().next().remove();
        });

        fetchActiveUsers();
        setInterval(function () {
            fetchActiveUsers();
        }, 3000);

        function fetchActiveUsers() {
            $.ajax({
                url: '/admin/statistic/website',
                method: 'GET',
                data: {type: 'active-users'}
            }).done(function (response) {
                $('.active-users-count').text(response.data).parent().next().next().remove();
            });
        }
    </script>

@endsection
