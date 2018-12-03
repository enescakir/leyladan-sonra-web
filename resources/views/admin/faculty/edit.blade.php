@extends('admin.parent')

@section('title', 'Fakülte Güncelle')

@section('header')
    <section class="content-header">
        <h1>
            Fakülte Güncelle
            <small>Bu sayfadan sistemdeki fakülteyi güncelleyebilirsiniz</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
            <li><a href="{{ route('admin.faculty.index') }}">Fakülteler</a></li>
            <li class="active">Fakülte Güncelle</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        {!! Form::model($faculty, ['method' => 'PUT', 'route' => ['admin.faculty.update', $faculty->id], 'class' => '', 'files' => true]) !!}
        <div class="col-md-6">
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">Temel Bilgiler</h4>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body form-horizontal">
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        {!! Form::label('name', 'Ad *', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                            {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('name') }}</small>
                            <small class="help-block">Örn: Çukurova, Akdeniz, Meram... 'Tıp Fakültesi' yazmayınız
                            </small>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
                        {!! Form::label('slug', 'Kısa Ad *', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                            {!! Form::text('slug', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('slug') }}</small>
                            <small class="help-block">Örn: istanbultip, cukurova, suleymandemirel</small>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                        {!! Form::label('city', 'Şehir *', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                            {!! Form::select('city', citiesToSelect(false, 'Şehir seçiniz'), null, ['class' => 'form-control select2', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('city') }}</small>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
                        {!! Form::label('code', 'Plaka Kodu *', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                            {!! Form::text('code', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('code') }}</small>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('started_at') ? ' has-error' : '' }}">
                        {!! Form::label('started_at', 'Başlama Günü', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                            {!! Form::text('started_at', $faculty->started_at_label, ['class' => 'form-control date-picker date-mask']) !!}
                            <small class="text-danger">{{ $errors->first('started_at') }}</small>
                            <small class="help-block">Bu tarihi belirledikten sonra fakülte anasayfada gözükecektir.
                                Eğer fakülte daha başlamadıysa boş bırakın.
                            </small>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('stopped_at') ? ' has-error' : '' }}">
                        {!! Form::label('stopped_at', 'Durdurulma Tarihi', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                            {!! Form::text('stopped_at', $faculty->stopped_at_label, ['class' => 'form-control date-picker date-mask']) !!}
                            <small class="text-danger">{{ $errors->first('stopped_at') }}</small>
                            <small class="help-block">Bu tarihi belirlerseniz fakülte üyeleri hesaplarına giriş yapamazlar.
                            </small>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('latitude') ? ' has-error' : '' }}">
                        {!! Form::label('latitude', 'Enlem', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                            {!! Form::text('latitude', null, ['class' => 'form-control']) !!}
                            <small class="text-danger">{{ $errors->first('latitude') }}</small>
                            <small class="help-block">Google Maps'teki enlemi</small>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('longitude') ? ' has-error' : '' }}">
                        {!! Form::label('longitude', 'Boylam', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                            {!! Form::text('longitude', null, ['class' => 'form-control']) !!}
                            <small class="text-danger">{{ $errors->first('longitude') }}</small>
                            <small class="help-block">Google Maps'teki boylamı</small>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                        {!! Form::label('address', 'Adres', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                            {!! Form::textarea('address', null, ['class' => 'form-control', 'rows' => 3]) !!}
                            <small class="text-danger">{{ $errors->first('address') }}</small>
                        </div>
                    </div>

                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <a href="{{ route('admin.faculty.index') }}" class="btn btn-danger">Geri</a>
                    {!! Form::submit("Güncelle", ['class' => 'btn btn-success pull-right']) !!}
                </div>
                <!-- /.box-footer -->
            </div>
        </div>
        <div class="col-md-6">
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">Fakülte Sorumluları</h4>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <div class="form-group{{ $errors->has('users[]') ? ' has-error' : '' }}">
                        {!! Form::select('users[]', $users, $managers, ['class' => 'multi-select form-control', 'multiple' => 'multiple' ]) !!}
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                </div>
                <!-- /.box-footer -->
            </div>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">Fakülte Logosu</h4>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <div class="form-group{{ $errors->has('logo') ? ' has-error' : '' }}">
                        {!! Form::label('logo', 'Logo *', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                            <p>
                                <img class="table-img-lg" src="{{ $faculty->logo_url }}" alt="{{ $faculty->full_name }}">
                            </p>
                            {!! Form::file('logo', []) !!}
                            <p class="help-block">Fakültenin logosu en az 320x240 piksel boyutunda olmalıdır</p>
                            <small class="text-danger">{{ $errors->first('logo') }}</small>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                </div>
                <!-- /.box-footer -->
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection

@section('scripts')
@endsection
