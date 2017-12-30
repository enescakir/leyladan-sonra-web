@extends('admin.parent')

@section('title')
Kontrol Paneli
@endsection

@section('styles')
<!-- JQVMap -->
<link rel="stylesheet" href="{{ admin_asset('css/jqvmap.min.css') }}">
@endsection

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
        <h3>{{ DataManager::childCount() }}</h3>
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
        <h3>{{ DataManager::bloodCount() }}</h3>
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
        <h3>{{ DataManager::volunteerCount() }}</h3>
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
        <h3>{{ DataManager::userCount() }}</h3>
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
        <h3>{{ DataManager::facultyCount() }}</h3>
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
        <h3>{{ DataManager::cityCount() }}</h3>
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
      <div class="box-body">
        <div id="turkey-map" style="height: 250px; width: 100%;"></div>
      </div>
      <!-- /.box-body-->
      <div class="box-footer no-border text-black">
        <div class="row">
          <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
            <h3>{{ DataManager::facultyCount('all') }}</h3>
            <div class="knob-label">Toplam Fakülte</div>
          </div>
          <!-- ./col -->
          <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
            <h3>{{ DataManager::facultyCount() }}</h3>
            <div class="knob-label">Aktif Fakülte</div>
          </div>
          <!-- ./col -->
          <div class="col-xs-4 text-center">
            <h3>{{ DataManager::facultyCount('not-started') }}</h3>
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
        {{-- <div id="" class="chart" style="height: 250px; width: 100%;"></div> --}}
        <canvas id="myChart" width="400" height="300"></canvas>
      </div>
      <!-- /.box-body-->
      <div class="box-footer no-border text-black">
        <div class="row">
          <div class="col-xs-3 text-center" style="border-right: 1px solid #f4f4f4">
            <h3>
              {{ DataManager::childCount($authUser->faculty_id, App\Enums\GiftStatus::Waiting) }} /
              {{ DataManager::childCount(null, App\Enums\GiftStatus::Waiting) }}
            </h3>
            <div class="knob-label">Beklenen</div>
          </div>
          <!-- ./col -->
          <div class="col-xs-3 text-center" style="border-right: 1px solid #f4f4f4">
            <h3>
              {{ DataManager::childCount($authUser->faculty_id, App\Enums\GiftStatus::OnRoad) }} /
              {{ DataManager::childCount(null, App\Enums\GiftStatus::OnRoad) }}
            </h3>
            <div class="knob-label">Yolda</div>
          </div>
          <!-- ./col -->
          <div class="col-xs-3 text-center" style="border-right: 1px solid #f4f4f4">
            <h3>
              {{ DataManager::childCount($authUser->faculty_id, App\Enums\GiftStatus::Arrived) }} /
              {{ DataManager::childCount(null, App\Enums\GiftStatus::Arrived) }}
            </h3>
            <div class="knob-label">Bize Ulaşan</div>
          </div>
          <!-- ./col -->
          <div class="col-xs-3 text-center">
            <h3>
              {{ DataManager::childCount($authUser->faculty_id, App\Enums\GiftStatus::Delivered) }} /
              {{ DataManager::childCount(null, App\Enums\GiftStatus::Delivered) }}
            </h3>
            <div class="knob-label">Teslim Edilen</div>
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
      <div class="box-header with-border">
        <h3 class="box-title">Güncel Fakülte Bildirimleri</h3>
        <div class="box-tools pull-right">
          <a type="button" class="btn btn-sm btn-primary">Tüm Bildirimler</a>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="table-responsive">
          <table class="table no-margin">
            <thead>
              <tr>
                <th>Bildirim</th>
                <th>Kişi</th>
                <th>Zaman</th>
              </tr>
            </thead>
            <tbody>
              @forelse( DataManager::feeds($authUser->faculty_id)  as $feed)
              <tr>
                <td>{!! $feed->icon_label !!} {{ $feed->desc }}</td>
                <td>{{ $feed->creator ? $feed->creator->full_name : '' }}</td>
                <td>{{ $feed->created_at_human }}</td>
              </tr>
              @empty
              <tr>
                <td colspan="3">Bildirim bulunmamaktadır.</td>
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
      <div class="box-body">
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
<div class="row">
  <div class="col-md-4">
    <!-- USERS LIST -->
    <div class="box box-danger">
      <div class="box-header with-border">
        <h3 class="box-title">Son Üyeler</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body no-padding">
        <ul class="users-list clearfix">
          <li>
            <img src="{{ admin_asset('img/user1-128x128.jpg') }}" alt="User Image">
            <a class="users-list-name" href="#">Alexander Pierce</a>
            <span class="users-list-date">Today</span>
          </li>
          <li>
            <img src="{{ admin_asset('img/user8-128x128.jpg') }}" alt="User Image">
            <a class="users-list-name" href="#">Norman</a>
            <span class="users-list-date">Yesterday</span>
          </li>
          <li>
            <img src="{{ admin_asset('img/user7-128x128.jpg') }}" alt="User Image">
            <a class="users-list-name" href="#">Jane</a>
            <span class="users-list-date">12 Jan</span>
          </li>
          <li>
            <img src="{{ admin_asset('img/user6-128x128.jpg') }}" alt="User Image">
            <a class="users-list-name" href="#">John</a>
            <span class="users-list-date">12 Jan</span>
          </li>
          <li>
            <img src="{{ admin_asset('img/user3-128x128.jpg') }}" alt="User Image">
            <a class="users-list-name" href="#">Alexander</a>
            <span class="users-list-date">13 Jan</span>
          </li>
          <li>
            <img src="{{ admin_asset('img/user5-128x128.jpg') }}" alt="User Image">
            <a class="users-list-name" href="#">Sarah</a>
            <span class="users-list-date">14 Jan</span>
          </li>
          <li>
            <img src="{{ admin_asset('img/user4-128x128.jpg') }}" alt="User Image">
            <a class="users-list-name" href="#">Nora</a>
            <span class="users-list-date">15 Jan</span>
          </li>
          <li>
            <img src="{{ admin_asset('img/user3-128x128.jpg') }}" alt="User Image">
            <a class="users-list-name" href="#">Nadia</a>
            <span class="users-list-date">15 Jan</span>
          </li>
        </ul>
        <!-- /.users-list -->
      </div>
      <!-- /.box-body -->
      <div class="box-footer text-center">
        <a href="javascript:void(0)" class="uppercase">Tüm Üyeleri Görüntele</a>
      </div>
      <!-- /.box-footer -->
    </div>
    <!--/.box -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->
@endsection

@section('scripts')
<!-- JQVMap -->
<script src="{{ admin_asset('js/jqvmap.min.js') }}" type="text/javascript"></script>

<!-- Full Calendar -->
<script src="{{ admin_asset('js/fullcalendar.min.js') }}" type="text/javascript"></script>

<!-- Custom Scripts -->
<script type="text/javascript">
  $(function () {
    'use strict';

    $.ajax({
      url: "/admin/faculty/cities",
      method: "GET",
      success: function(result){
        $('#map-loading').remove();
        setMap(result);
      },
      error: function( xhr, status, errorThrown ) {
        console.log("Harita yüklenirken sorunla karşılaşıldı.");
        ajaxError(xhr, status, errorThrown, false);
      },
    });
  });
</script>

<script type="text/javascript">
  var setMap = function(selected) {
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
      onRegionClick: function(element, code, region) {
        $.ajax({
          url: "/admin/faculty/city/" + code,
          method: "GET",
          success: function(result){
            var faculties = ""
            if (result.length == 0) {
              faculties = "Bu şehirde görüşülen fakülte bulunmamaktadır."
            } else {
              faculties = result.map( function(current, index) {
                var dateText = '<span class="label bg-yellow pull-right">Görüşülüyor</span>';
                if(result[index]["started_at"] != null){
                  dateText = '<span class="label bg-green pull-right">' + moment(current["started_at"]).format("D MMMM YYYY") + '</span>'
                }
                return '<li class="list-group-item text-left"><a href="/admin/faculty/' + current["id"] +'">' + current["full_name"] + ' Tıp Fakültesi</a>' + dateText + '</li>';
              }).join("");
            }
            swal({
              title: region,
              html: faculties,
              confirmButtonText: 'Tamam',
            })
          },
          error: function( xhr, status, errorThrown ) {
            console.log("Harita şehir bilgileri yüklenirken sorunla karşılaşıldı.");
            console.log("Şehir #: " + code);
            ajaxError(xhr, status, errorThrown, false);
          },
        });
      }
    });
  }
</script>
<script type="text/javascript">
  $(function() {
    $.ajax({
      url    : "/admin/dashboard/data",
      data   : { "faculty_id" : AuthUser.faculty_id , "type" : "child-count-monthly" },
      method : "GET",
      success: function(result){
        console.log(result)
        var data = $.map(result, function(value, index) {
          value.month   = index;
          value.faculty =  (value.faculty === undefined) ? 0 : value.faculty;
          value.general =  (value.general === undefined) ? 0 : value.general;
          return value;
        });
        console.log(data)
        $('#chart-loading').remove();
        var ctx = document.getElementById("myChart");
        var myChart = new Chart(ctx, {
          type: 'bar',
          data: {
            labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
            datasets: [{
              label: '# of Votes',
              data: [12, 19, 3, 5, 2, 3],
              backgroundColor: [
              'rgba(255, 99, 132, 0.2)',
              'rgba(54, 162, 235, 0.2)',
              'rgba(255, 206, 86, 0.2)',
              'rgba(75, 192, 192, 0.2)',
              'rgba(153, 102, 255, 0.2)',
              'rgba(255, 159, 64, 0.2)'
              ],
              borderColor: [
              'rgba(255,99,132,1)',
              'rgba(54, 162, 235, 1)',
              'rgba(255, 206, 86, 1)',
              'rgba(75, 192, 192, 1)',
              'rgba(153, 102, 255, 1)',
              'rgba(255, 159, 64, 1)'
              ],
              borderWidth: 1
            }]
          },
          options: {
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true
                }
              }]
            }
          }
        });
        //   var line = new Morris.Line({
        //     element          : 'meeting-chart',
        //     resize           : true,
        //     data             : data,
        //     xkey             : 'month',
        //     ykeys            : ['faculty', 'general'],
        //     labels           : ['Fakülte', 'Genel'],
        //     xLabels          : 'month',
        //     xLabelFormat     : function (x) { return moment(x).format('MMMM YYYY'); },
        //     hoverCallback: function (index, options, content, row) {
        //       return '<strong>' + moment(row.month).format('MMMM YYYY') + '</strong><br>Fakülte: ' + row.faculty  + '<br>Genel: ' + row.general;
        //     },
        //     lineColors       : ['#efefef', '#efefef'],
        //     lineWidth        : 2,
        //     hideHover        : 'auto',
        //     gridTextColor    : '#fff',
        //     gridStrokeWidth  : 0.4,
        //     pointSize        : 4,
        //     pointStrokeColors: ['#efefef', '#efefef'],
        //     gridLineColor    : '#efefef',
        //     gridTextFamily   : 'Open Sans',
        //     gridTextSize     : 10
        //   });
      },
      error: function( xhr, status, errorThrown ) {
        console.log("Tanışma grafiği sorunla karşılaşıldı.");
        ajaxError(xhr, status, errorThrown, false);
      },
    });
  });
</script>
<script type="text/javascript">
  $(function(){
    $.ajax({
      url    : "/admin/dashboard/data",
      data   : { "faculty_id" : AuthUser.faculty_id , "type" : "birthday" },
      method : "GET",
      success: function(result){
        $('#calendar-loading').remove();
        $('#calendar').fullCalendar({
          contentHeight: 500,
          events       : result,
          buttonIcons  : {
            prev     : 'ion ion-chevron-left',
            next     : 'ion ion-chevron-right',
          },
          validRange   : function(nowDate) {
            return {
              start: nowDate.clone().subtract(1, 'months').startOf('month'),
              end  : nowDate.clone().add(1, 'months').endOf('month')
            };
          },
          eventMouseover: function(calEvent, jsEvent, view) {
            $(this).popover({
              title     : function() {
                if (calEvent.backgroundColor == '#1bbc9b') return 'Çocuk';
                else if (calEvent.backgroundColor == '#F3565D') return 'Öğrenci';
                else return '';
              },
              content   : calEvent.title,
              trigger   : 'hover',
              container : 'body',
              placement : function() {
                if (calEvent.start.day() == 0) return 'left';
                else if (calEvent.start.day() == 1) return 'right';
                else return 'top';
              },
            });
            $(this).popover('show');
          }
        })
      },
      error: function( xhr, status, errorThrown ) {
        console.log("Takvim yüklenirken sorunla karşılaşıldı.");
        ajaxError(xhr, status, errorThrown, false);
      },
    });
  });
</script>
@endsection
