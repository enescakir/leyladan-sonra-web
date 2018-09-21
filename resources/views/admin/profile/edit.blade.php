@extends('admin.profile.profile')

@section('title', 'Üye Güncelleme')

@section('header')
    <section class="content-header">
        <h1>
            Profilim
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
            <li><a href="{{ route('admin.profile.show') }}"> Profilim</a></li>
            <li class="active">Ayarlarım</li>
        </ol>
    </section>
@endsection

@section('profileContent')
    <div class="row">
        <div class="col-md-10">
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">Profil Bilgilerim</h4>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {!! Form::model($user, ['method' => 'PUT', 'route' => ['admin.profile.update'], 'files' => true]) !!}
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
                        <div class="col-md-6 form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            {!! Form::label('password', 'Şifre', ['class' => 'control-label']) !!}
                            {!! Form::password('password', ['class' => 'form-control']) !!}
                            <small class="text-danger">{{ $errors->first('password') }}</small>
                        </div>
                        <div class="col-md-6 form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            {!! Form::label('password_confirmation', 'Şifre Doğrulama', ['class' => 'control-label']) !!}
                            {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                            <small class="text-danger">{{ $errors->first('password_confirmation') }}</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group{{ $errors->has('birthday') ? ' has-error' : '' }}">
                            {!! Form::label('birthday', 'Doğum Tarihi *', ['class' => 'control-label']) !!}
                            {!! Form::text('birthday', $user->birthday_label, ['class' => 'form-control birthday-picker date-mask', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('birthday') }}</small>
                        </div>
                        <div class="col-md-6 form-group{{ $errors->has('profile') ? ' has-error' : '' }}">
                            {!! Form::label('profile', 'Profil Fotoğrafı', ['class' => 'control-label']) !!}
                            {!! Form::file('profile') !!}
                            <small class="text-danger">{{ $errors->first('profile') }}</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group{{ $errors->has('year') ? ' has-error' : '' }}">
                            {!! Form::label('year', 'Sınıf *', ['class' => 'control-label']) !!}
                            <br>
                            <div class="btn-group btn-group-justified" data-toggle="buttons">
                                @foreach(range(0, 6) as $key)
                                    <label class="btn btn-ls @if($user->year == $key) active @endif">
                                        {!! Form::radio('year', $key,  ($user->year == $key)) !!} {{ $key }}
                                    </label>
                                @endforeach
                            </div>
                            <small class="text-danger">{{ $errors->first('year') }}</small>
                        </div>

                        <div class="col-md-6 form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                            {!! Form::label('gender', 'Cinsiyet *', ['class' => 'control-label']) !!}
                            <br>
                            <div class="btn-group btn-group-justified" data-toggle="buttons">
                                @foreach(['Kadın', 'Erkek'] as $key)
                                    <label class="btn btn-ls @if($user->gender == $key) active @endif">
                                        {!! Form::radio('gender', $key, $user->gender == $key) !!} {{ $key }}
                                    </label>
                                @endforeach
                            </div>
                            <small class="text-danger">{{ $errors->first('year') }}</small>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    {!! Form::submit("Güncelle", ['class' => 'btn btn-success btn-block btn-lg']) !!}
                </div>
                <!-- /.box-footer -->
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection