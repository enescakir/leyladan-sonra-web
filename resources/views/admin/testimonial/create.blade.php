@extends('admin.parent')

@section('title', 'Referans Ekle')
  
@section('header')
  <section class="content-header">
    <h1>
      Referans Ekle
      <small>Bu sayfadan sisteme referans ekleyebilirsiniz</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
      <li><a href="{{ route('admin.testimonial.index') }}">Referanslar</a></li>
      <li class="active">Referans Ekle</li>
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
        {!! Form::open(['method' => 'POST', 'route' => 'admin.testimonial.store', 'class' => 'form-horizontal']) !!}
        <div class="box-body">
          <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
              {!! Form::label('name', 'Ad *', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                  {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('name') }}</small>
              </div>
          </div>
          <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
              {!! Form::label('email', 'E-posta', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                  {!! Form::text('email', null, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('email') }}</small>
              </div>
          </div>
          <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
              {!! Form::label('via', 'Kaynak *', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                {!! Form::select('via', [
                  'Site'         => 'Site',
                  'E-posta'      => 'E-posta',
                  'ekşisözlük'   => 'ekşisözlük',
                  'Sosyal Medya' => 'Sosyal Medya'
                ], null, ['class' => 'form-control select2-no-search', 'required' => 'required'])  !!}
                <small class="text-danger">{{ $errors->first('via') }}</small>
              </div>
          </div>
          <div class="form-group{{ $errors->has('priority') ? ' has-error' : '' }}">
            {!! Form::label('priority', 'Öncelik *', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
              <div class="btn-group" data-toggle="buttons">
                @foreach(range(10, 1) as $key)
                <label class="btn btn-ls @if(old('priority') == $key) active @endif">
                  {!! Form::radio('priority', $key,  null) !!} {{ $key }}
                </label>
                @endforeach
              </div>
              <small class="text-danger">{{ $errors->first('priority') }}</small>
              <p class="help-block">Yüksek sayılar önceliğe sahiptir</p>
            </div>
          </div>
          <div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
              {!! Form::label('text', 'Metin *', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
                {!! Form::textarea('text', null, ['class' => 'form-control', 'required' => 'required']) !!}
                <small class="text-danger">{{ $errors->first('text') }}</small>
            </div>
          </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <a href="{{ route('admin.testimonial.index') }}" class="btn btn-danger">Geri</a>
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
