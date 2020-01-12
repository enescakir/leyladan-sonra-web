@extends('admin.layouts.app')

@section('title', 'Gönüllü Ekle')

@section('header')
    <section class="content-header">
        <h1>
            Gönüllü Ekle
            <small>Bu sayfadan sisteme gönüllü ekleyebilirsiniz</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
            <li><a href="{{ route('admin.volunteer.index') }}">Gönüllüler</a></li>
            <li class="active">Gönüllü Ekle</li>
        </ol>
    </section>
@endsection

@section('content')
    {!! Form::open(['method' => 'POST', 'route' => 'admin.volunteer.store', 'class' => '']) !!}
    <div class="row">
        <div class="col-md-8">
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">Temel Bilgiler</h4>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6 form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            {!! Form::label('first_name', 'Ad *', ['class' => 'control-label']) !!}
                            {!! Form::text('first_name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('first_name') }}</small>
                        </div>
                        <div class="col-md-6 form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            {!! Form::label('last_name', 'Soyad *', ['class' => 'control-label']) !!}
                            {!! Form::text('last_name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('last_name') }}</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            {!! Form::label('email', 'E-posta *', ['class' => 'control-label']) !!}
                            {!! Form::email('email', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('email') }}</small>
                        </div>
                        <div class="col-md-6 form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
                            {!! Form::label('mobile', 'Telefon', ['class' => 'control-label']) !!}
                            {!! Form::text('mobile', null, ['class' => 'form-control mobile']) !!}
                            <small class="text-danger">{{ $errors->first('mobile') }}</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                            {!! Form::label('city', 'Şehir', ['class' => 'control-label']) !!}
                            {!! Form::text('city', null, ['class' => 'form-control']) !!}
                            <small class="text-danger">{{ $errors->first('city') }}</small>
                        </div>
                    </div>
                    {!! Form::submit("Ekle", ['class' => 'btn btn-ls btn-block btn-lg']) !!}
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>

    {!! Form::close() !!}
@endsection