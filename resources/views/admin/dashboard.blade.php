@extends('admin.layouts.app')

@section('title', 'Kontrol Paneli')

@section('header')
    <section class="content-header">
        <h1>
            Kontrol Paneli
            <small>Genel Görünüm</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
            <li class="active">Kontrol Paneli</li>
        </ol>
    </section>
@endsection

@section('content')
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-2 col-xs-4">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ $generalCounts['child'] }}</h3>
                    <p>Çocuk</p>
                </div>
                <div class="icon">
                    <i class="ion ion-ios-body"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-2 col-xs-4">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{ $generalCounts['blood'] }}</h3>
                    <p>Bağışçı</p>
                </div>
                <div class="icon">
                    <i class="ion ion-waterdrop"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-2 col-xs-4">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ $generalCounts['volunteer'] }}</h3>
                    <p>Gönüllü</p>
                </div>
                <div class="icon">
                    <i class="ion ion-wand"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-2 col-xs-4">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $generalCounts['user'] }}</h3>
                    <p>Öğrenci</p>
                </div>
                <div class="icon">
                    <i class="ion ion-ios-people"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-2 col-xs-4">
            <!-- small box -->
            <div class="small-box bg-orange">
                <div class="inner">
                    <h3>{{ $generalCounts['faculty'] }}</h3>
                    <p>Fakülte</p>
                </div>
                <div class="icon">
                    <i class="ion ion-university"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-2 col-xs-4">
            <!-- small box -->
            <div class="small-box bg-purple">
                <div class="inner">
                    <h3>{{ $generalCounts['city'] }}</h3>
                    <p>Şehir</p>
                </div>
                <div class="icon">
                    <i class="ion ion-location"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <!-- /.row -->

    <!-- Main row -->
    <div class="row">
        <section class="col-lg-6">
            <!-- Map Box -->
            <div class="box bg-gray-light">
                <div class="box-header">
                    <i class="fa fa-map-marker"></i>
                    <h3 class="box-title">
                        Leyla'dan Sonra Türkiye
                    </h3>
                </div>
                <div class="box-body no-padding">
                    <div id="turkey-map" style="height: 300px; width: 100%;"></div>
                </div>
                <!-- /.box-body-->
                <div class="box-footer no-border text-black">
                    <div class="row">
                        <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                            <h3>{{ $facultyCounts['all'] }}</h3>
                            <div class="knob-label">Toplam Fakülte</div>
                        </div>
                        <!-- ./col -->
                        <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                            <h3>{{ $facultyCounts['started'] }}</h3>
                            <div class="knob-label">Aktif Fakülte</div>
                        </div>
                        <!-- ./col -->
                        <div class="col-xs-4 text-center">
                            <h3>{{ $facultyCounts['not-started'] }}</h3>
                            <div class="knob-label">Görüşülen Fakülte</div>
                        </div>
                        <!-- ./col -->
                    </div>
                    <!-- /.row -->
                </div>
                <div id="map-loading" class="overlay">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
            </div>
            <!-- /.box -->
        </section>
        <!-- /.col -->
        <section class="col-lg-6">
            <!-- Meeting Chart Box -->

            <div class="box box-solid bg-teal-gradient">
                <div class="box-header">
                    <i class="fa fa-line-chart"></i>
                    <h3 class="box-title">
                        Tanışılan Çocuklar
                    </h3>
                </div>
                <div class="box-body">
                    <canvas id="children-chart" height="300"></canvas>
                </div>
                <!-- /.box-body-->
                <div class="box-footer no-border text-black">
                    <div class="row">
                        <div class="col-xs-3 text-center" style="border-right: 1px solid #f4f4f4">
                            <h3>
                                {{ $childCounts['faculty'][App\Enums\GiftStatus::Waiting] ?? 0 }} /
                                {{ $childCounts['general'][App\Enums\GiftStatus::Waiting] ?? 0 }}
                            </h3>
                            <div class="knob-label label bg-red">Beklenen</div>
                        </div>
                        <!-- ./col -->
                        <div class="col-xs-3 text-center" style="border-right: 1px solid #f4f4f4">
                            <h3>
                                {{ $childCounts['faculty'][App\Enums\GiftStatus::OnRoad] ?? 0 }} /
                                {{ $childCounts['general'][App\Enums\GiftStatus::OnRoad] ?? 0 }}
                            </h3>
                            <div class="knob-label label bg-yellow">Yolda</div>
                        </div>
                        <!-- ./col -->
                        <div class="col-xs-3 text-center" style="border-right: 1px solid #f4f4f4">
                            <h3>
                                {{ $childCounts['faculty'][App\Enums\GiftStatus::Arrived] ?? 0 }} /
                                {{ $childCounts['general'][App\Enums\GiftStatus::Arrived] ?? 0 }}
                            </h3>
                            <div class="knob-label label bg-aqua">Bize Ulaşan</div>
                        </div>
                        <!-- ./col -->
                        <div class="col-xs-3 text-center">
                            <h3>
                                {{ $childCounts['faculty'][App\Enums\GiftStatus::Delivered] ?? 0 }} /
                                {{ $childCounts['general'][App\Enums\GiftStatus::Delivered] ?? 0 }}
                            </h3>
                            <div class="knob-label label bg-green">Teslim Edilen</div>
                        </div>
                        <!-- ./col -->
                    </div>
                    <!-- /.row -->
                </div>
                <div id="chart-loading" class="overlay">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
            </div>
            <!-- /.box -->
        </section>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    <div class="row">
        <section class="col-lg-6">
            <!-- TABLE: LATEST ORDERS -->
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Güncel Fakülte Bildirimleri</h3>
                    {{--                    <div class="box-tools pull-right">--}}
                    {{--                        <a type="button" class="btn btn-sm btn-primary">Tüm Bildirimler</a>--}}
                    {{--                    </div>--}}
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                    <div class="table-responsive">
                        <table class="table no-margin">
                            <tbody>
                            @forelse( App\CacheManagers\CacheManager::feeds(auth()->user()->faculty_id, 17)  as $feed)
                                <tr>
                                    <td style="display: flex;">
                                        <div style="margin-right: 8px;">{!! $feed->icon_label !!}</div>
                                        <div>{{ $feed->desc }}</div>
                                    </td>
                                    <td class="text-nowrap">{{ $feed->creator ? $feed->creator->full_name : '-' }}</td>
                                    <td class="text-nowrap text-muted text-sm">{{ $feed->created_at_human }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="20">
                                        <p style="font-size: 80px; line-height: 1; margin: 10px;"><i
                                                    class="fa fa-exclamation-triangle"></i></p>
                                        <p style="font-size: 24px;">Bildirim bulunmamaktadır</p>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </section>
        <!-- /.col -->
        <section class="col-lg-6">
            <!-- Calendar -->
            <div class="box box-default">
                <div class="box-header">
                    <i class="fa fa-calendar"></i>
                    <h3 class="box-title">Doğum Günleri</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                    <!--The calendar -->
                    <div id="calendar"></div>
                </div>
                <!-- /.box-body -->
                <div id="calendar-loading" class="overlay">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
            </div>
            <!-- /.box -->
        </section>
        <!-- /.col -->
    </div>
    <!-- /.row -->
@endsection

@section('scripts')
    <!-- Full Calendar -->
    <script src="{{ admin_js('fullcalendar.min.js') }}" type="text/javascript"></script>

    <!-- JQVMap -->
    <script src="{{ admin_js('jqvmap.min.js') }}" type="text/javascript"></script>

    <!-- Custom Scripts -->
    <script type="text/javascript">
        $(function () {
            setupMap();
            setupChart();
            setupCalendar();
        });
    </script>


    <script type="text/javascript">
        // MAP FUNCTIONS
        function setupMap() {
            $.ajax({
                url: "/admin/dashboard/data",
                data: {"type": "city-colors"},
                method: "GET",
            }).done(function (response) {
                if (response.status === "success") {
                    $('#map-loading').remove();
                    initMap(response.data);
                }
            }).fail(function (xhr, status, errorThrown) {
                console.log("Harita yüklenirken sorunla karşılaşıldı.");
                ajaxError(xhr, status, errorThrown, false);
            });
        }

        function initMap(selected) {
            $('#turkey-map').vectorMap({
                map: 'turkey',
                backgroundColor: 'transparent',
                borderColor: '#333333',
                borderOpacity: 0.5,
                borderWidth: 1,
                color: '#e5e5e5',
                colors: selected,
                enableZoom: true,
                hoverOpacity: 1,
                normalizeFunction: 'linear',
                selectedColor: '#f06d54',
                showTooltip: true,
                onRegionClick: function (element, code, region) {
                    $.ajax({
                        url: "/admin/dashboard/data",
                        data: {
                            "type": "city-faculties",
                            "parameter": code
                        },
                        method: "GET",
                    })
                        .done(function (response) {
                            var faculties = response.data;
                            if (faculties.length === 0) {
                                list_html = "Bu şehirde görüşülen fakültemiz bulunmamaktadır."
                            } else {
                                list_html = faculties.map(function (current, index) {
                                    var dateText = faculties[index]["started_at"]
                                        ? '<span class="label bg-green pull-right">' + moment(current["started_at"]).format("D MMMM YYYY") + '</span>'
                                        : '<span class="label bg-yellow pull-right">Görüşülüyor</span>';
                                    return '<li class="list-group-item text-left"> \
                          <a href="/admin/faculty/' + current["id"] + '">' + current["name"] + ' Tıp Fakültesi</a>' + dateText +
                                        '</li>';
                                }).join("");
                            }
                            swal({
                                title: region,
                                html: list_html,
                                confirmButtonText: 'Tamam',
                            })
                        })
                        .fail(function (xhr, status, errorThrown) {
                            console.log("Harita şehir bilgileri yüklenirken sorunla karşılaşıldı.");
                            console.log("Şehir Kodu: " + code);
                            ajaxError(xhr, status, errorThrown, false);
                        });
                }
            });
        }
    </script>
    <script type="text/javascript">
        // CHART FUNCTIONS
        function addData(chart, data, label, background, border) {
            chart.data.datasets.push({
                label: label,
                backgroundColor: background,
                borderColor: border,
                data: data,
                fill: false
            })
            chart.update()
        }

        function setupChart() {
            $.ajax({
                url: "/admin/dashboard/data",
                data: {
                    "parameter": AuthUser.faculty_id,
                    "type": "child-count-monthly"
                },
                method: "GET"
            }).done(function (response) {
                var labels = $.map(response.data.counts, function (value, index) {
                    return value.month;
                });
                var faculty = $.map(response.data.counts, function (value, index) {
                    return value.faculty;
                });
                var general = $.map(response.data.counts, function (value, index) {
                    return value.general;
                });
                $('#chart-loading').remove();
                childrenChart = new Chart(document.getElementById("children-chart").getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: []
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        tooltips: {
                            mode: 'index',
                            backgroundColor: 'rgba(0,0,0,0.6)',
                        },
                        legend: {
                            display: true,
                            labels: {
                                fontColor: 'rgb(255, 255, 255)'
                            }
                        },
                        scales: {
                            xAxes: [{
                                gridLines: {
                                    display: false,
                                },
                                ticks: {
                                    fontColor: "rgba(255,255,255,1)",
                                },
                            }],
                            yAxes: [{
                                gridLines: {
                                    color: "rgba(255,255,255,0.3)",
                                    drawTicks: true,
                                    tickMarkLength: 20,
                                    zeroLineWidth: 1,
                                    zeroLineColor: "rgba(255,255,255, 1)"
                                },
                                ticks: {
                                    fontColor: "rgba(255,255,255,1)",
                                    fontStyle: "oblique",
                                },
                            }],
                        }
                    }
                });
                addData(childrenChart, faculty, response.data.faculty, '#289090', '#289090');
                addData(childrenChart, general, 'Tüm Fakülteler', '#ccffff', '#ccffff');
            }).fail(function (xhr, status, errorThrown) {
                console.log("Tanışma grafiği sorunla karşılaşıldı.");
                ajaxError(xhr, status, errorThrown, false);
            });
        }
    </script>
    <script type="text/javascript">
        // CALENDAR FUNCTIONS

        function setupCalendar() {
            $.ajax({
                url: "/admin/dashboard/data",
                data: {"parameter": AuthUser.faculty_id, "type": "birthdays"},
                method: "GET",
                success: function (response) {
                    $('#calendar-loading').remove();
                    $('#calendar').fullCalendar({
                        contentHeight: 600,
                        events: response.data,
                        buttonIcons: {
                            prev: 'ion ion-chevron-left',
                            next: 'ion ion-chevron-right',
                        },
                        eventMouseover: function (calEvent, jsEvent, view) {
                            $(this).popover({
                                title: calEvent.title,
                                content: '<small>' + (calEvent.backgroundColor === '#1bbc9b' ? 'Çocuk' : 'Öğrenci') + '</small>',
                                trigger: 'hover',
                                container: 'body',
                                html: true,
                                placement: function () {
                                    if (calEvent.start.day() === 0) return 'left';
                                    else if (calEvent.start.day() === 1) return 'right';
                                    else return 'top';
                                },
                            });
                            $(this).popover('show');
                        }
                    })
                },
                error: function (xhr, status, errorThrown) {
                    console.log("Takvim yüklenirken sorunla karşılaşıldı.");
                    ajaxError(xhr, status, errorThrown, false);
                },
            });
        }
    </script>
@endsection
