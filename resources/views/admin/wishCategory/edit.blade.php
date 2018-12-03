@extends('admin.parent')

@section('title', 'Dilek Kategorisi Güncelleme')
  
@section('header')
  <section class="content-header">
    <h1>
      Dilek Kategorisi Güncelleme
      <small>Bu sayfadan sistemdeki dilek kategorisini güncelleyebilirsiniz</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
      <li><a href="{{ route('admin.diagnosis.index') }}">Dilek Kategorileri</a></li>
      <li class="active">Dilek Kategorisi Güncelleme</li>
    </ol>
  </section>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-8">
      <!-- Horizontal Form -->
      <div class="box box-primary">
        <!-- form start -->
        {!! Form::model($wish_category, [ 'method' => 'PUT', 'route' => ['admin.wish-category.update', $wish_category->id] , 'class' => 'form-horizontal' ]) !!}
        <div class="box-body">
          <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
              {!! Form::label('name', 'Ad *', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                  {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('name') }}</small>
              </div>
          </div>
          <div class="form-group{{ $errors->has('desc') ? ' has-error' : '' }}">
              {!! Form::label('desc', 'Açıklama', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                  {!! Form::textarea('desc', null, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('desc') }}</small>
              </div>
          </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <a href="{{ route('admin.wish-category.index') }}" class="btn btn-danger">Geri</a>
          {!! Form::submit("Güncelle", ['class' => 'btn btn-success pull-right']) !!}
        </div>
        <!-- /.box-footer -->
        {!! Form::close() !!}
      </div>
    </div>
  </div>
@endsection