@extends('admin.parent')

@section('title', 'Üye Ekle')

@section('header')
    <section class="content-header">
        <h1>
            Üye Ekle
            <small>Bu sayfadan sisteme üye ekleyebilirsiniz</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
            <li><a href="{{ route('admin.user.index') }}">Üyeler</a></li>
            <li class="active">Üye Ekle</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-10">
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">İşlemi tamamlamak için yanında <strong class="text-danger">*</strong> bulunan
                        alanları doldurmanız gerekiyor.</h4>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {!! Form::open(['method' => 'POST', 'route' => 'admin.user.store', 'class' => '']) !!}
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6 form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            {!! Form::label('first_name', 'Ad *', ['class' => 'control-label']) !!}
                            {!! Form::text('first_name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('first_name') }}</small>
                        </div>
                        <div class="col-md-6 form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            {!! Form::label('last_name', 'Soyad *', ['class' => 'control-label']) !!}
                            {!! Form::text('last_name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('last_name') }}</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            {!! Form::label('email', 'E-posta *', ['class' => 'control-label']) !!}
                            {!! Form::email('email', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('email') }}</small>
                        </div>
                        <div class="col-md-6 form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
                            {!! Form::label('mobile', 'Telefon *', ['class' => 'control-label']) !!}
                            {!! Form::text('mobile', null, ['class' => 'form-control mobile', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('mobile') }}</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group{{ $errors->has('faculty_id') ? ' has-error' : '' }}">
                            {!! Form::label('faculty_id', 'Fakülte *', ['class' => 'control-label']) !!}
                            {!! Form::select('faculty_id', $faculties, null, ['class' => 'form-control select2', 'required' => 'required'])  !!}
                            <small class="text-danger">{{ $errors->first('faculty_id') }}</small>
                        </div>
                        <div class="col-md-6 form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                            {!! Form::label('role', 'Görev *', ['class' => 'control-label']) !!}
                            {!! Form::select('role', $roles, null, ['class' => 'form-control select2-no-search', 'required' => 'required'])  !!}
                            <small class="text-danger">{{ $errors->first('role') }}</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            {!! Form::label('password', 'Şifre *', ['class' => 'control-label']) !!}
                            {!! Form::password('password', ['class' => 'form-control', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('password') }}</small>
                        </div>
                        <div class="col-md-6 form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            {!! Form::label('password_confirmation', 'Şifre Doğrulama *', ['class' => 'control-label']) !!}
                            {!! Form::password('password_confirmation', ['class' => 'form-control', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('password_confirmation') }}</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group{{ $errors->has('year') ? ' has-error' : '' }}">
                            {!! Form::label('year', 'Sınıf *', ['class' => 'control-label']) !!}
                            <br>
                            <div class="btn-group" data-toggle="buttons">
                                @foreach(range(0, 6) as $key)
                                    <label class="btn btn-ls @if(old('year') == $key) active @endif">
                                        {!! Form::radio('year', $key,  null) !!} {{ $key }}
                                    </label>
                                @endforeach
                            </div>
                            <small class="text-danger">{{ $errors->first('year') }}</small>
                        </div>
                        <div class="col-md-6 form-group{{ $errors->has('birthday') ? ' has-error' : '' }}">
                            {!! Form::label('birthday', 'Doğum Tarihi *', ['class' => 'control-label']) !!}
                            {!! Form::text('birthday', null, ['class' => 'form-control birthday-picker date-mask', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('birthday') }}</small>
                        </div>

                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <a href="{{ route('admin.user.index') }}" class="btn btn-danger">Geri</a>
                    {!! Form::submit("Ekle", ['class' => 'btn btn-success pull-right']) !!}
                </div>
                <!-- /.box-footer -->
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection