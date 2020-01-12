@extends('admin.layouts.app')

@section('title', 'Soru Ekle')
  
@section('header')
  <section class="content-header">
    <h1>
      Soru Ekle
      <small>Bu sayfadan sisteme soru ekleyebilirsiniz</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
      <li><a href="{{ route('admin.question.index') }}">Sorular</a></li>
      <li class="active">Soru Ekle</li>
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
        {!! Form::open(['method' => 'POST', 'route' => 'admin.question.store', 'class' => 'form-horizontal']) !!}
        <div class="box-body">
          <div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
              {!! Form::label('text', 'Soru *', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                  {!! Form::textarea('text', null, ['class' => 'form-control', 'required' => 'required', 'rows' => 3]) !!}
                  <small class="text-danger">{{ $errors->first('text') }}</small>
              </div>
          </div>
          <div class="form-group{{ $errors->has('answer') ? ' has-error' : '' }}">
              {!! Form::label('answer', 'Cevap *', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                  {!! Form::textarea('answer', null, ['class' => 'form-control', 'required' => 'required', 'rows' => 3]) !!}
                  <small class="text-danger">{{ $errors->first('answer') }}</small>
              </div>
          </div>
          <div class="form-group{{ $errors->has('order') ? ' has-error' : '' }}">
              {!! Form::label('order', 'Sıralama *', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                  {!! Form::number('order', 1, ['class' => 'form-control number', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('order') }}</small>
              </div>
          </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <a href="{{ route('admin.question.index') }}" class="btn btn-danger">Geri</a>
          {!! Form::submit("Ekle", ['class' => 'btn btn-success pull-right']) !!}
        </div>
        <!-- /.box-footer -->
        {!! Form::close() !!}
      </div>
    </div>
  </div>
@endsection