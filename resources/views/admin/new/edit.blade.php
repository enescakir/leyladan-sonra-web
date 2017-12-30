@extends('admin.parent')

@section('title')
  Haber Güncelleme
@endsection

@section('styles')
@endsection

@section('header')
  <section class="content-header">
    <h1>
      Haber Güncelleme
      <small>Bu sayfadan sistemdeki haberi güncelleyebilirsiniz</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
      <li><a href="{{ route('admin.new.index') }}">Haberler</a></li>
      <li class="active">Haber Güncelleme</li>
    </ol>
  </section>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-8">
      <!-- Horizontal Form -->
      <div class="box box-danger">
        <!-- /.box-header -->
        <!-- form start -->
        {!! Form::model($new, [ 'method' => 'PUT', 'route' => ['admin.new.update', $new->id] , 'class' => 'form-horizontal' ]) !!}
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
                  {!! Form::select('channel_id', $channels, [$new->channel_id], ['class' => 'form-control select2', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('channel_id') }}</small>
              </div>
          </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <a href="{{ route('admin.new.index') }}" class="btn btn-danger">Geri</a>
          {!! Form::submit("Güncelle", ['class' => 'btn btn-success pull-right']) !!}
        </div>
        <!-- /.box-footer -->
        {!! Form::close() !!}
      </div>
    </div>
  </div>
@endsection

@section('scripts')
@endsection
