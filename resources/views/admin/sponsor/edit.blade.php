@extends('admin.parent')
@section('title')
Destekçi Güncelleme
@endsection
@section('styles')
@endsection
@section('header')
<section class="content-header">
  <h1>
  Destekçi Güncelleme
  <small>Bu sayfadan sistemdeki destekçileri güncelleyebilirsiniz</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
    <li><a href="{{ route('admin.sponsor.index') }}">Destekçiler</a></li>
    <li class="active">Destekçi Güncelle</li>
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
      {!! Form::model($sponsor, ['method' => 'PUT', 'route' => ['admin.sponsor.update', $sponsor->id], 'class' => 'form-horizontal', 'files' => true]) !!}
      <div class="box-body">
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
          {!! Form::label('name', 'Ad *', ['class' => 'col-sm-3 control-label']) !!}
          <div class="col-sm-9">
            {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
            <small class="text-danger">{{ $errors->first('name') }}</small>
          </div>
        </div>
        <div class="form-group{{ $errors->has('link') ? ' has-error' : '' }}">
          {!! Form::label('link', 'Bağlantı *', ['class' => 'col-sm-3 control-label']) !!}
          <div class="col-sm-9">
            {!! Form::text('link', null, ['class' => 'form-control url-mask', 'required' => 'required']) !!}
            <small class="text-danger">{{ $errors->first('link') }}</small>
          </div>
        </div>
        <div class="form-group{{ $errors->has('order') ? ' has-error' : '' }}">
          {!! Form::label('order', 'Öncelik *', ['class' => 'col-sm-3 control-label']) !!}
          <div class="col-sm-9">
            <div class="btn-group" data-toggle="buttons">
              @foreach(range(10, 1) as $key)
              <label class="btn btn-ls @if(old('order') == $key || $sponsor->order == $key) active @endif">
                {!! Form::radio('order', $key,  null) !!} {{ $key }}
              </label>
              @endforeach
            </div>
            <small class="text-danger">{{ $errors->first('order') }}</small>
            <p class="help-block">Yüksek sayılar önceliğe sahiptir</p>
          </div>
        </div>
        <div class="form-group{{ $errors->has('logo') ? ' has-error' : '' }}">
          {!! Form::label('logo', 'Logo *', ['class' => 'col-sm-3 control-label']) !!}
          <div class="col-sm-9">
            <p>
              <img class="table-img-lg" src="/{{ upload_path( "sponsor", $sponsor->logo ) }}" alt="{{ $sponsor->name }}">
            </p>
            {!! Form::file('logo') !!}
            <p class="help-block">Destekçinin logosu 400x300 piksel boyutunda ve PNG formatında olmalıdır</p>
            <small class="text-danger">{{ $errors->first('logo') }}</small>
          </div>
        </div>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <a href="{{ route('admin.sponsor.index') }}" class="btn btn-danger">Geri</a>
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
