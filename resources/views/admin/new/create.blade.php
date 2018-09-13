@extends('admin.parent')

@section('title', 'Haber Ekle')

@section('header')
  <section class="content-header">
    <h1>
      Haber Ekle
      <small>Bu sayfadan sisteme haber ekleyebilirsiniz</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
      <li><a href="{{ route('admin.new.index') }}">Haberler</a></li>
      <li class="active">Haber Ekle</li>
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
        {!! Form::open(['method' => 'POST', 'route' => 'admin.new.store', 'class' => 'form-horizontal']) !!}
        <div class="box-body">
          <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
              {!! Form::label('title', 'Başlık *', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                  {!! Form::text('title', null, ['class' => 'form-control', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('title') }}</small>
              </div>
          </div>
          <div class="form-group{{ $errors->has('desc') ? ' has-error' : '' }}">
              {!! Form::label('desc', 'Kısa Açıklama *', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                  {!! Form::textarea('desc', null, ['class' => 'form-control', 'required' => 'required', 'rows' => '3']) !!}
                  <small class="text-danger">{{ $errors->first('desc') }}</small>
              </div>
          </div>
          <div class="form-group{{ $errors->has('link') ? ' has-error' : '' }}">
              {!! Form::label('link', 'Bağlantı *', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                  {!! Form::text('link', null, ['class' => 'form-control url-mask', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('link') }}</small>
              </div>
          </div>
          <div class="form-group{{ $errors->has('channel_id') ? ' has-error' : '' }}">
              {!! Form::label('channel_id', 'Kanal *', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                  {!! Form::select('channel_id', $channels, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('channel_id') }}</small>
              </div>
          </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <a href="{{ route('admin.new.index') }}" class="btn btn-danger">Geri</a>
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
