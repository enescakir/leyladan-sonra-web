@extends('admin.layouts.app')

@section('title', 'Haber Kanalını Güncelle')
 
@section('header')
  <section class="content-header">
    <h1>
      Haber Kanalını Güncelle
      <small>Bu sayfadan sisteme haber kanalı ekleyebilirsiniz</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
      <li><a href="{{ route('admin.channel.index') }}">Haber Kanalları</a></li>
      <li class="active">Haber Kanalını Güncelle</li>
    </ol>
  </section>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-8">
      <!-- Horizontal Form -->
      <div class="box box-primary">
        <!-- form start -->
        {!! Form::model($channel, [ 'method' => 'PUT', 'route' => ['admin.channel.update', $channel->id] , 'class' => 'form-horizontal', 'files' => true ]) !!}
        <div class="box-body">
          <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            {!! Form::label('name', 'Kanalın adı *', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
              {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
              <small class="text-danger">{{ $errors->first('name') }}</small>
            </div>
          </div>
          <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
            {!! Form::label('category', 'Kategori *', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
              {!! Form::text('category', null, ['class' => 'form-control', 'required' => 'required']) !!}
              <p class="help-block">örn.: İnternet, Radyo, Gazete, Dergi</p>
              <small class="text-danger">{{ $errors->first('category') }}</small>
            </div>
          </div>
          <div class="form-group{{ $errors->has('logo') ? ' has-error' : '' }}">
            {!! Form::label('logo', 'Logo', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
              <p>
                <img class="table-img-lg" src="{{ $channel->logo_url }}" alt="{{ $channel->name }}">
              </p>
              {!! Form::file('logo') !!}
              <p class="help-block">Haber kanalının logosu 400x300 piksel boyutunda ve JPEG formatında olmalıdır</p>
              <small class="text-danger">{{ $errors->first('logo') }}</small>
            </div>
          </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <a href="{{ route('admin.channel.index') }}" class="btn btn-danger">Geri</a>
          {!! Form::submit("Güncelle", ['class' => 'btn btn-success pull-right']) !!}
        </div>
        <!-- /.box-footer -->
        {!! Form::close() !!}
      </div>
    </div>
  </div>
@endsection