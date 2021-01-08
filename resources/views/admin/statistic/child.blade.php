@extends('admin.layouts.app')

@section('title', 'Çocuk İstatistikleri')

@section('styles')
<style>
    .date-range-input {
        float:right;
        display:flex;
        margin-bottom: 10px;
    }

    .date-range-input .input-group-btn {
        width:auto;
    }

    @media (max-width: 768px) {
        .date-range-input {
            width: 100%;
            max-width: 100%;
        }
    }

</style>
@endsection

@section('header')
    <section class="content-header">
        <h1>
            Çocuk İstatistikleri
            {{--<small>Optional description</small>--}}
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
            <li class="active">İstatistik</li>
            <li class="active">Çocuk</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        {!!	Form::open(['method' => 'GET', 'class' => 'col-md-12']) !!}
            <div class="input-group input-group-sm date-range-input">
                {!! Form::text('start_at', request()->get('start_at'), ['class' => 'form-control date-picker', 'placeholder' => 'Başlangıç']) !!}
                {!! Form::text('end_at', request()->get('end_at'), ['class' => 'form-control date-picker', 'placeholder' => 'Bitiş']) !!}
                <div class="input-group-btn">
                    <button id="search-btn" class="btn btn-default" type="submit">
                        <i class="fa fa-search"></i> Uygula
                    </button>
                </div>
            </div>
        {!!	Form::close() !!}
    </div>
    <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ $oldestChild != null ? $oldestChild ->birthday->format('d.m.Y') : 'Yok' }}</h3>
                    <p>En Büyük Çocuk</p>
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
                    <h3>{{ $youngestChild != null ? $youngestChild ->birthday->format('d.m.Y') : 'Yok' }}</h3>
                    <p>En Küçük Çocuk</p>
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
                    <h3>{{ $ageAverage->average ?? 'Yok' }}</h3>
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
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">Departmanların Dağılımı</h4>
                </div>
                <div class="box-body">
                    <canvas id="departmentChart" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">Hediye Durumu Dağılımı</h4>
                </div>
                <div class="box-body">
                    <canvas id="giftChart" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">Hediye Kategori Dağılımı</h4>
                </div>
                <div class="box-body">
                    <canvas id="giftCategoryChart" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
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
                                <th>Çocuk Sayısı</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($childByCity as $city => $count)
                                <tr>
                                    <th>{{ $city }}</th>
                                    <td>{{ $count }} çocuk</td>
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
                    <h4 class="box-title table-condensed">Tanıların Dağılımı</h4>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body no-padding">
                    <div class="table-responsive table-fixed">
                        <table class="table table-condensed table-striped">
                            <thead>
                            <tr>
                                <th>Tanı</th>
                                <th style="white-space: nowrap;">Çocuk Sayısı</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($childByDiagnosis as $diagnosis => $count)
                                <tr>
                                    <th style="white-space: normal;">{{ $diagnosis }}</th>
                                    <td>{{ $count }} çocuk</td>
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
                    <h4 class="box-title">En Fazla Bulunan Çocuk İsimleri</h4>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body no-padding">
                    <div class="table-responsive table-fixed">
                        <table class="table table-condensed table-striped">
                            <thead>
                            <tr>
                                <th>İsim</th>
                                <th>Çocuk Sayısı</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($childByName as $name => $count)
                                <tr>
                                    <th>{{ $name }}</th>
                                    <td>{{ $count }} çocuk</td>
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
        <div class="col-md-5">
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">En Çok Mesaj Gelen Çocuklar</h4>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body no-padding">
                    <div class="table-responsive table-fixed">
                        <table class="table table-condensed table-striped">
                            <thead>
                            <tr>
                                <th>Çocuk</th>
                                <th>Fakülte</th>
                                <th>Dilek</th>
                                <th>Sayı</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($mostChats as $child)
                                <tr>
                                    <th>{{ $child->full_name }}</th>
                                    <td>{{ $child->faculty->name }}</td>
                                    <td>{{ $child->wish }}</td>
                                    <td style="white-space: nowrap">{{ $child->chats_count }} gönüllü</td>
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
        var departments = {!! json_encode($childByDepartment) !!};
        var gifts = {!! json_encode($childByGift) !!};
        var giftCategories = {!! json_encode($childByGiftCategory) !!};

        initPieChart("departmentChart", Object.keys(departments), Object.values(departments));
        initPieChart("giftChart", Object.keys(gifts), Object.values(gifts));
        initPieChart("giftCategoryChart", Object.keys(giftCategories), Object.values(giftCategories));
    </script>
@endsection
