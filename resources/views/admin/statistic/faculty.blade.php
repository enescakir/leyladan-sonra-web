@extends('admin.layouts.app')

@section('title', 'Fakülte İstatistikleri')

@section('styles')
@endsection

@section('header')
    <section class="content-header">
        <h1>
            Fakülte İstatistikleri
            {{--<small>Optional description</small>--}}
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
            <li class="active">İstatistik</li>
            <li class="active">Fakülte</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">Fakülte Çocuk Sayıları</h4>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body no-padding">
                    <div class="table-responsive">
                        <table class="table table-condensed table-bordered table-hover table-striped">
                            <thead>
                            <tr>
                                <th rowspan="2" style="text-align: center; vertical-align: middle; font-size: 18px;">Fakülte</th>
                                <th colspan="5" class="text-center">Hediye Durumu</th>
                                <th></th>
                                <th colspan="6" class="text-center">Son 6 Ay</th>
                            </tr>
                            <tr>
                                <th class="danger text-center">Beklenen</th>
                                <th class="warning text-center">Yolda</th>
                                <th class="info text-center">Ulaşan</th>
                                <th class="success text-center">Teslim</th>
                                <th class="active text-center">Toplam</th>
                                <th></th>
                                @foreach($lastMonths as $month)
                                    <th class="text-center">{{ $month->formatLocalized('%h') }}</th>
                                @endforeach

                            </tr>
                            </thead>
                            <tbody class="text-center">
                            @foreach($faculties as $faculty)
                                <tr>
                                    <th class="text-center">{{ $faculty['name'] }}</th>
                                    <td class="danger">{{ $faculty['gift_state'][\App\Enums\GiftStatus::Waiting] ?? 0}}</td>
                                    <td class="warning">{{ $faculty['gift_state'][\App\Enums\GiftStatus::OnRoad] ?? 0}}</td>
                                    <td class="info">{{ $faculty['gift_state'][\App\Enums\GiftStatus::Arrived] ?? 0}}</td>
                                    <td class="success">{{ $faculty['gift_state'][\App\Enums\GiftStatus::Delivered] ?? 0}}</td>
                                    <td class="active">{{ $faculty['gift_state']->sum() ?? 0}}</td>
                                    <td></td>
                                    @foreach($lastMonths as $month)
                                        <td class="text-center">{{ $faculty['monthly'][$month->month] }}</td>
                                    @endforeach
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
@endsection
