@extends('admin.layouts.app')

@section('title', 'Tanıtım Materyali Ekle')

@section('header')
  <section class="content-header">
    <h1>
      Tanıtım Materyali Ekle
      <small>Bu sayfadan sisteme tanıtım materyali ekleyebilirsiniz</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
      <li><a href="{{ route('admin.material.index') }}">Tantım Materyalleri</a></li>
      <li class="active">Tanıtım Materyali Ekle</li>
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
        {!! Form::open(['method' => 'POST', 'route' => 'admin.material.store', 'class' => 'form-horizontal', 'files' => true]) !!}
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
                  {!! Form::text('category', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'örn.: Kupa, Baskı, Rozet, Slayt, Poster vb.']) !!}
                  <small class="text-danger">{{ $errors->first('category') }}</small>
              </div>
          </div>
          <div class="form-group{{ $errors->has('link') ? ' has-error' : '' }}">
              {!! Form::label('link', 'Bağlantı *', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                  {!! Form::text('link', null, ['class' => 'form-control url-mask', 'required' => 'required']) !!}
                  <p class="help-block">Google Drive, Dropbox gibi bir depolayıcıda bulunan indirme dosyasının bağlantısı</p>
                  <small class="text-danger">{{ $errors->first('link') }}</small>
              </div>
          </div>
          <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
              {!! Form::label('image', 'Öne çıkan görsel *', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                      {!! Form::file('image', ['required' => 'required']) !!}
                      <p class="help-block">Tanıtım materyalinin öne çıkan görseli 300x300 piksel boyutunda olmalıdır</p>
                      <small class="text-danger">{{ $errors->first('image') }}</small>
                  </div>
          </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <a href="{{ route('admin.material.index') }}" class="btn btn-danger">Geri</a>
          {!! Form::submit("Ekle", ['class' => 'btn btn-success pull-right']) !!}
        </div>
        <!-- /.box-footer -->
        {!! Form::close() !!}
      </div>
    </div>
  </div>
@endsection