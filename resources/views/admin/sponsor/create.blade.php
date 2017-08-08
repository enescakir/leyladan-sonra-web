@extends('admin.parent')

@section('title')
  Destekçi Ekle
@endsection

@section('styles')
@endsection

@section('header')
  <section class="content-header">
    <h1>
      Destekçi Ekle
      <small>Bu sayfadan sisteme destekçi ekleyebilirsiniz</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
      <li><a href="{{ route('admin.sponsor.index') }}">Destekçiler</a></li>
      <li class="active">Destekçi Ekle</li>
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
        {!! Form::open(['method' => 'POST', 'route' => 'admin.sponsor.store', 'class' => 'form-horizontal', 'files' => true]) !!}
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
                  {!! Form::text('link', null, ['class' => 'form-control', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('link') }}</small>
              </div>
          </div>
          <div class="form-group{{ $errors->has('order') ? ' has-error' : '' }}">
              {!! Form::label('order', 'Öncelik *', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                <div class="btn-group" data-toggle="buttons">
                  <label class="btn btn-ls @if(old('order') == '10') active @endif">
                    {!! Form::radio('order', '10',  null) !!} 10
                  </label>
                  <label class="btn btn-ls @if(old('order') == '9') active @endif">
                    {!! Form::radio('order', '9',  null) !!} 9
                  </label>
                  <label class="btn btn-ls @if(old('order') == '8') active @endif">
                    {!! Form::radio('order', '8',  null) !!} 8
                  </label>
                  <label class="btn btn-ls @if(old('order') == '7') active @endif">
                    {!! Form::radio('order', '7',  null) !!} 7
                  </label>
                  <label class="btn btn-ls @if(old('order') == '6') active @endif">
                    {!! Form::radio('order', '6',  null) !!} 6
                  </label>
                  <label class="btn btn-ls @if(old('order') == '5') active @endif">
                    {!! Form::radio('order', '5',  null) !!} 5
                  </label>
                  <label class="btn btn-ls @if(old('order') == '4') active @endif">
                    {!! Form::radio('order', '4',  null) !!} 4
                  </label>
                  <label class="btn btn-ls @if(old('order') == '3') active @endif">
                    {!! Form::radio('order', '3',  null) !!} 3
                  </label>
                  <label class="btn btn-ls @if(old('order') == '2') active @endif">
                    {!! Form::radio('order', '2',  null) !!} 2
                  </label>
                  <label class="btn btn-ls @if(old('order') == '1') active @endif">
                    {!! Form::radio('order', '1',  null) !!} 1
                  </label>
                </div>
                <small class="text-danger">{{ $errors->first('order') }}</small>
                <p class="help-block">Yüksek sayılar önceliğe sahiptir</p>
              </div>
          </div>
          <div class="form-group{{ $errors->has('logo') ? ' has-error' : '' }}">
              {!! Form::label('logo', 'Logo *', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                      {!! Form::file('logo', ['required' => 'required']) !!}
                      <p class="help-block">Destekçinin logosu 400x300 piksel boyutunda ve JPEG formatında olmalıdır</p>
                      <small class="text-danger">{{ $errors->first('logo') }}</small>
                  </div>
          </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <a href="{{ route('admin.blood.index') }}" class="btn btn-danger">Geri</a>
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
