@extends('admin.parent')

@section('title')
  Kontrol Paneli
@endsection

@section('styles')
  <!-- JQVMap -->
  <link rel="stylesheet" href="/node_modules/jqvmap/dist/jqvmap.min.css">
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
          <h3>2000</h3>
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
          <h3>53</h3>
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
          <h3>44</h3>
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
          <h3>65</h3>
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
          <h3>46</h3>
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
          <h3>35</h3>
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
      <!-- Map box -->
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
              <h3>65</h3>
              <div class="knob-label">Toplam Fakülte</div>
            </div>
            <!-- ./col -->
            <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
              <h3>88</h3>
              <div class="knob-label">Aktif Fakülte</div>
            </div>
            <!-- ./col -->
            <div class="col-xs-4 text-center">
              <h3>88</h3>
              <div class="knob-label">Görüşülen Fakülte</div>
            </div>
            <!-- ./col -->
          </div>
          <!-- /.row -->
        </div>
      </div>
      <!-- /.box -->
    </section>
    <!-- /.col -->
    <section class="col-lg-6">
      <!-- Map box -->
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
              <h3>65</h3>
              <div class="knob-label">Toplam Fakülte</div>
            </div>
            <!-- ./col -->
            <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
              <h3>88</h3>
              <div class="knob-label">Aktif Fakülte</div>
            </div>
            <!-- ./col -->
            <div class="col-xs-4 text-center">
              <h3>88</h3>
              <div class="knob-label">Görüşülen Fakülte</div>
            </div>
            <!-- ./col -->
          </div>
          <!-- /.row -->
        </div>
      </div>
      <!-- /.box -->
    </section>
    <!-- /.col -->
  </div>
  <!-- /.row -->
@endsection

@section('scripts')
  <!-- JQVMap -->
  <script src="/node_modules/jqvmap/dist/jquery.vmap.min.js" type="text/javascript"></script>
  <script src="/node_modules/jqvmap/dist/maps/jquery.vmap.turkey.js" type="text/javascript"></script>

  <!-- Chart.js -->
  <script src="/node_modules/chart.js/Chart.min.js"></script>

  <!-- Custom Scripts -->
  <script type="text/javascript">
    $(function () {
      'use strict';

      $.ajax({
        url: "/admin/faculty/cities",
        method: "GET",
        success: function(result){
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
@endsection
