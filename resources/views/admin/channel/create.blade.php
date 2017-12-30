@extends('admin.parent')

@section('title')
  Haber Kanalı Ekle
@endsection

@section('styles')
@endsection

@section('header')
  <section class="content-header">
    <h1>
      Haber Kanalı Ekle
      <small>Bu sayfadan sisteme haber kanalı ekleyebilirsiniz</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
      <li><a href="{{ route('admin.channel.index') }}">Haber Kanalları</a></li>
      <li class="active">Haber Kanalı Ekle</li>
    </ol>
  </section>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-8">
      <!-- Horizontal Form -->
      <div class="box box-danger">
        <div class="box-header with-border">
          <h4 class="box-title">İşlemi tamamlamak için yanında <strong class="text-danger">*</strong> bulunan alanları doldurmanız gerekiyor.</h4>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        {!! Form::open(['method' => 'POST', 'route' => 'admin.channel.store', 'class' => 'form-horizontal', 'files' => true]) !!}
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
              {!! Form::label('logo', 'Logo *', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                      {!! Form::file('logo', ['required' => 'required']) !!}
                      <p class="help-block">Haber kanalının logosu 400x300 piksel boyutunda ve JPEG formatında olmalıdır</p>
                      <small class="text-danger">{{ $errors->first('logo') }}</small>
                  </div>
          </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <a href="{{ route('admin.channel.index') }}" class="btn btn-danger">Geri</a>
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
