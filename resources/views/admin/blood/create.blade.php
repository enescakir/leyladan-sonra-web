@extends('admin.parent')

@section('title')
  Bağışçı Ekle
@endsection

@section('styles')
@endsection

@section('header')
  <section class="content-header">
    <h1>
      Bağışçı Ekle
      <small>Bu sayfadan sisteme kan bağışçısı ekleyebilirsiniz</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
      <li><a href="{{ route('admin.blood.index') }}">Bağışçılar</a></li>
      <li class="active">Bağışçı Ekle</li>
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
        {!! Form::open(['method' => 'POST', 'route' => 'admin.blood.create', 'class' => 'form-horizontal']) !!}
        <div class="box-body">
          <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
              {!! Form::label('mobile', 'Telefon Numarası *', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                  {!! Form::text('mobile', null, ['class' => 'form-control mobile', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('mobile') }}</small>
              </div>
          </div>
          <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
              {!! Form::label('city', 'Şehir *', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                  {!! Form::select('city', citiesToSelect(), null, ['class' => 'form-control select2', 'required' => 'required', 'placeholder' => 'Şehir seçiniz']) !!}
                  <small class="text-danger">{{ $errors->first('city') }}</small>
              </div>
          </div>
          <div class="form-group{{ $errors->has('blood_type') ? ' has-error' : '' }}">
              {!! Form::label('blood_type', 'Kan Grubu *', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                <div class="btn-group" data-toggle="buttons">
                  <label class="btn btn-ls">
                    <input type="radio" name="blood_type" value="A" autocomplete="off"> A
                  </label>
                  <label class="btn btn-ls">
                    <input type="radio" name="blood_type" value="B" autocomplete="off"> B
                  </label>
                  <label class="btn btn-ls">
                    <input type="radio" name="blood_type" value="AB" autocomplete="off"> AB
                  </label>
                  <label class="btn btn-ls">
                    <input type="radio" name="blood_type" value="0" autocomplete="off"> 0
                  </label>
                </div>
                <small class="text-danger">{{ $errors->first('blood_type') }}</small>
              </div>
          </div>
          <div class="form-group{{ $errors->has('rh') ? ' has-error' : '' }}">
              {!! Form::label('rh', 'RH *', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                <div class="btn-group" data-toggle="buttons">
                  <label class="btn btn-ls">
                    <input type="radio" name="rh" value="1" autocomplete="off"> Pozitif
                  </label>
                  <label class="btn btn-ls">
                    <input type="radio" name="rh" value="0" autocomplete="off"> Negatif
                  </label>
                </div>
                <small class="text-danger">{{ $errors->first('rh') }}</small>
              </div>
          </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          {!! Form::reset("İptal", ['class' => 'btn btn-danger']) !!}
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
