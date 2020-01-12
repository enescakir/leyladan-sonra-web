@extends('admin.layouts.app')

@section('title', 'Kan Bağışçısı İstatistikleri')

@section('styles')
@endsection

@section('header')
    <section class="content-header">
        <h1>
            Kan Bağışçısı İstatistikleri
            {{--<small>Optional description</small>--}}
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
            <li class="active">İstatistik</li>
            <li class="active">Kan Bağışçısı</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">Kan Türü Dağılımı</h4>
                </div>
                <div class="box-body">
                    <canvas id="typeChart" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">RH Dağılımı</h4>
                </div>
                <div class="box-body">
                    <canvas id="rhChart" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">Kan Grubu Dağılımı</h4>
                </div>
                <div class="box-body">
                    <canvas id="groupChart" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">Şehirlerin Dağılımı</h4>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body no-padding">
                    <div class="table-responsive table-fixed">
                        <table class="table table-condensed table-striped">
                            <thead>
                            <tr>
                                <th>Şehir</th>
                                <th>Bağışçı Sayısı</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($bloodByCity as $city => $count)
                                <tr>
                                    <th>{{ $city }}</th>
                                    <td>{{ $count }} bağışçı</td>
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
        var types = {!! json_encode($bloodByType) !!};
        var rhs = {!! json_encode($bloodByRh) !!};
        var groups = {!! json_encode($bloodByGroup) !!};

        initPieChart("typeChart", Object.keys(types), Object.values(types));
        initPieChart("rhChart", Object.keys(rhs), Object.values(rhs));
        initPieChart("groupChart", Object.keys(groups), Object.values(groups));
    </script>

@endsection
