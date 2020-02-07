@extends('admin.layouts.app')

@section('title', 'Üye Güncelleme')

@section('header')
    <section class="content-header">
        <h1>
            Üye Güncelleme
            <small>Bu sayfadan sistemdeki üyeleri güncelleyebilirsiniz</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
            <li><a href="{{ route('admin.user.index') }}">Üyeler</a></li>
            <li class="active">Üye Güncelleme</li>
        </ol>
    </section>
@endsection

@section('content')
    {!! Form::model($user, ['method' => 'PUT', 'route' => ['admin.user.update', $user->id], 'class' => '']) !!}
    <div class="row">
        <div class="col-md-8">
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">Üyelik Bilgileri</h4>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
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
                        <div class="col-md-6 form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                            {!! Form::label('gender', 'Cinsiyet *', ['class' => 'control-label']) !!}
                            <br>
                            <div class="btn-group btn-group-justified" data-toggle="buttons">
                                @foreach(['Kadın', 'Erkek'] as $key)
                                    <label class="btn btn-ls @if($user->gender == $key) active @endif">
                                        {!! Form::radio('gender', $key,  ($user->gender == $key)) !!} {{ $key }}
                                    </label>
                                @endforeach
                            </div>
                            <small class="text-danger">{{ $errors->first('year') }}</small>
                        </div>
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
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">Kurum Bilgileri</h4>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6 form-group{{ $errors->has('faculty_id') ? ' has-error' : '' }}">
                            {!! Form::label('faculty_id', 'Fakülte *', ['class' => 'control-label']) !!}
                            {!! Form::select('faculty_id', $faculties, null, ['class' => 'form-control select2', 'required' => 'required'])  !!}
                            <small class="text-danger">{{ $errors->first('faculty_id') }}</small>
                            <small class="help-block">Eğer üyenin fakültesini değiştirirseniz ilişik olduğu bütün
                                çocuklarla ilişkisi kesilir
                            </small>
                        </div>
                        <div class="col-md-6 form-group{{ $errors->has('roles') ? ' has-error' : '' }}">
                            {!! Form::label('roles[]', 'Görevler *', ['class' => 'control-label']) !!}
                            {!! Form::select('roles[]', $roles, $user->roles->pluck('name'), ['class' => 'form-control select2-no-search', 'required' => 'required', 'multiple' => 'multiple'])  !!}
                            <small class="text-danger">{{ $errors->first('roles') }}</small>
                        </div>

                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">Tarihler</h4>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12 form-group{{ $errors->has('birthday') ? ' has-error' : '' }}">
                            {!! Form::label('birthday', 'Doğum Tarihi *', ['class' => 'control-label']) !!}
                            {!! Form::text('birthday', $user->birthday_label, ['class' => 'form-control birthday-picker date-mask', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('birthday') }}</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group{{ $errors->has('left_at') ? ' has-error' : '' }}">
                            {!! Form::label('left_at', 'Ayrılık Tarihi', ['class' => 'control-label']) !!}
                            {!! Form::text('left_at', $user->left_at_label, ['class' => 'form-control date-picker date-mask']) !!}
                            <small class="text-danger">{{ $errors->first('left_at') }}</small>
                            <small class="help-block">Eğer üye mezuniyetinden dolayı projeden ayrıldıysa sadece
                                mezuniyet tarihi doldurun. Burayı boş bırakın
                            </small>
                            <small class="help-block">Bu tarihi doldurduğunuzda üye otomatik olarak "Ayrılmış Üye"
                                olarak yetkilendirilir
                            </small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group{{ $errors->has('graduated_at') ? ' has-error' : '' }}">
                            {!! Form::label('graduated_at', 'Mezuniyet Tarihi', ['class' => 'control-label']) !!}
                            {!! Form::text('graduated_at', $user->graduated_at_label, ['class' => 'form-control date-picker date-mask']) !!}
                            <small class="text-danger">{{ $errors->first('graduated_at') }}</small>
                            <small class="help-block">Bu tarihi doldurduğunuzda üye otomatik olarak "Mezun Üye" olarak
                                yetkilendirilir
                            </small>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
    {!! Form::submit("Güncelle", ['class' => 'btn btn-success btn-block btn-lg']) !!}

    {!! Form::close() !!}
@endsection