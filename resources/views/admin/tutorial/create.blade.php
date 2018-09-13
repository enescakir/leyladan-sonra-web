@extends('admin.parent')

@section('title', 'Eğitim Ekle')

@section('header')
  <section class="content-header">
    <h1>
      Eğitim Ekle
      <small>Bu sayfadan sisteme eğitim videosu ekleyebilirsiniz</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
      <li><a href="{{ route('admin.tutorial.index') }}">Eğitimler</a></li>
      <li class="active">Eğitim Ekle</li>
    </ol>
  </section>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-8">
      <!-- Horizontal Form -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h4 class="box-title">İşlemi tamamlamak için yanında <strong class="text-danger">*</strong> bulunan alanları doldurmanız gerekiyor.</h4>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        {!! Form::open(['method' => 'POST', 'route' => 'admin.tutorial.store', 'class' => 'form-horizontal', 'files' => true]) !!}
        <div class="box-body">
          <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
              {!! Form::label('name', 'Ad *', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                  {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('name') }}</small>
              </div>
          </div>
          <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
              {!! Form::label('category', 'Kategori *', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                  {!! Form::text('category', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'örn.: Genel, İletişim, Hediye vb.']) !!}
                  <small class="text-danger">{{ $errors->first('category') }}</small>
              </div>
          </div>
          <div class="form-group{{ $errors->has('link') ? ' has-error' : '' }}">
              {!! Form::label('link', 'Bağlantı *', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                  {!! Form::text('link', null, ['class' => 'form-control url-mask', 'required' => 'required']) !!}
                  <p class="help-block">Videonun Youtube bağlantısı</p>
                  <small class="text-danger">{{ $errors->first('link') }}</small>
              </div>
          </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <a href="{{ route('admin.tutorial.index') }}" class="btn btn-danger">Geri</a>
          {!! Form::submit("Ekle", ['class' => 'btn btn-success pull-right']) !!}
        </div>
        <!-- /.box-footer -->
        {!! Form::close() !!}
      </div>
    </div>
  </div>
@endsection