@extends('admin.parent')

@section('title', 'Soru Güncelleme')
  
@section('header')
  <section class="content-header">
    <h1>
      Soru Güncelleme
      <small>Bu sayfadan sistemdeki soruyu güncelleyebilirsiniz</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
      <li><a href="{{ route('admin.question.index') }}">Sorular</a></li>
      <li class="active">Soru Güncelleme</li>
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
        {!! Form::model($question, [ 'method' => 'PUT', 'route' => ['admin.question.update', $question->id] , 'class' => 'form-horizontal' ]) !!}
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
                {!! Form::number('order', null, ['class' => 'form-control number', 'required' => 'required']) !!}
                <small class="text-danger">{{ $errors->first('order') }}</small>
            </div>
          </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <a href="{{ route('admin.question.index') }}" class="btn btn-danger">Geri</a>
          {!! Form::submit("Güncelle", ['class' => 'btn btn-success pull-right']) !!}
        </div>
        <!-- /.box-footer -->
        {!! Form::close() !!}
      </div>
    </div>
  </div>
@endsection