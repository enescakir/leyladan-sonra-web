@extends('admin.parent')

@section('title', 'Fakülte Ekle')

@section('header')
    <section class="content-header">
        <h1>
            Fakülte Ekle
            <small>Bu sayfadan sisteme fakülte ekleyebilirsiniz</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
            <li><a href="{{ route('admin.faculty.index') }}">Fakülteler</a></li>
            <li class="active">Fakülte Ekle</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <!-- Horizontal Form -->
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h4 class="box-title">İşlemi tamamlamak için yanında <strong class="text-danger">*</strong> bulunan
                        alanları doldurmanız gerekiyor.</h4>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {!! Form::open(['method' => 'POST', 'route' => 'admin.faculty.store', 'class' => 'form-horizontal', 'files' => true]) !!}
                <div class="box-body">
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
                    <div class="form-group{{ $errors->has('logo') ? ' has-error' : '' }}">
                        {!! Form::label('logo', 'Logo *', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                            {!! Form::file('logo', ['required' => 'required']) !!}
                            <p class="help-block">Fakültenin logosu en az 320x240 piksel boyutunda olmalıdır</p>
                            <small class="text-danger">{{ $errors->first('logo') }}</small>
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
                            {!! Form::text('started_at', null, ['class' => 'form-control date-picker date-mask']) !!}
                            <small class="text-danger">{{ $errors->first('started_at') }}</small>
                            <small class="help-block">Bu tarihi belirledikten sonra fakülte anasayfada gözükecektir. Eğer fakülte daha başlamadıysa boş bırakın.</small>
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
                    {!! Form::submit("Ekle", ['class' => 'btn btn-success pull-right']) !!}
                </div>
                <!-- /.box-footer -->
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
