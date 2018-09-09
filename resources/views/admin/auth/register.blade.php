@extends('admin.auth.parent')

@section('title', 'Kayıt Ol')

@section('content')
  <h2 class="login-box-msg">Kayıt Ol</h2>

  {!!	Form::open(['url' => '/admin/register', 'method' => 'POST']) !!}
    <div class="form-group has-feedback {{ $errors->has('first_name') ? ' has-error' : '' }}">
      {!! Form::text('first_name', null, ['class' => 'form-control', 'placeholder' => 'Ad', 'required' => 'required']) !!}
      <span class="glyphicon glyphicon-font form-control-feedback"></span>
      @if ($errors->has('first_name'))
          <span class="help-block"><strong>{{ $errors->first('first_name') }}</strong></span>
      @endif
    </div>
    <div class="form-group has-feedback {{ $errors->has('last_name') ? ' has-error' : '' }}">
      {!! Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => 'Soyad', 'required' => 'required']) !!}
      <span class="glyphicon glyphicon-bold form-control-feedback"></span>
      @if ($errors->has('last_name'))
          <span class="help-block"><strong>{{ $errors->first('last_name') }}</strong></span>
      @endif
    </div>
    <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
      {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'E-posta', 'required' => 'required']) !!}
      <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      @if ($errors->has('email'))
          <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
      @endif
    </div>
    <div class="form-group has-feedback {{ $errors->has('mobile') ? ' has-error' : '' }}">
      {!! Form::text('mobile', null, ['class' => 'form-control mobile', 'placeholder' => 'Telefon', 'required' => 'required']) !!}
      <span class="glyphicon glyphicon-earphone form-control-feedback"></span>
      @if ($errors->has('mobile'))
          <span class="help-block"><strong>{{ $errors->first('mobile') }}</strong></span>
      @endif
    </div>
    <div class="form-group has-feedback {{ $errors->has('year') ? ' has-error' : '' }}">
      {!! Form::label( 'year', 'Sınıfınız:',['class' => 'control-label']) !!}
      <div class="btn-group btn-group-justified" data-toggle="buttons">
        @foreach(range(0,6) as $key)
        <label class="btn btn-ls">
          <input type="radio" name="year" value="{{ $key }} " autocomplete="off"> {{ $key }}
        </label>
        @endforeach
      </div>
      @if ($errors->has('year'))
          <span class="help-block"><strong>{{ $errors->first('year') }}</strong></span>
      @endif
    </div>
    <div class="form-group has-feedback {{ $errors->has('birthday') ? 'has-error' : '' }}">
      {!! Form::text('birthday', null, ['class' => 'form-control birthday-picker date-mask', 'placeholder' => 'Doğum Tarihi', 'required' => 'required']) !!}
      <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
      @if ($errors->has('birthday'))
          <span class="help-block"><strong>{{ $errors->first('birthday') }}</strong></span>
      @endif
    </div>
    <div class="form-group {{ $errors->has('role') ? ' has-error' : '' }}">
        {!! Form::select('role', $roles, null, ['class' => 'form-control select2-no-search', 'required' => 'required', 'placeholder' => 'Görev']) !!}
          @if ($errors->has('role'))
              <span class="help-block"><strong>{{ $errors->first('role') }}</strong></span>
          @endif
    </div>
    <div class="form-group {{ $errors->has('faculty_id') ? 'has-error' : '' }}">
        {!! Form::select('faculty_id', $faculties, null, ['class' => 'form-control select2', 'required' => 'required', 'placeholder' => 'Fakülte']) !!}
        @if ($errors->has('faculty_id'))
            <span class="help-block"><strong>{{ $errors->first('faculty_id') }}</strong></span>
        @endif
    </div>
    <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
      {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Şifre', 'required' => 'required']) !!}
      <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      @if ($errors->has('password'))
          <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
      @endif
    </div>
    <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
      {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Tekrar şifre', 'required' => 'required']) !!}
      <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      @if ($errors->has('password_confirmation'))
          <span class="help-block"><strong>{{ $errors->first('password_confirmation') }}</strong></span>
      @endif
    </div>
    <div class="row">
      <div class="col-xs-6">
        <a href="{{ url('/admin/login') }}" class="btn btn-danger btn-block" > Geri</a>
      </div>
      <!-- /.col -->
      <div class="col-xs-6">
        {!! Form::submit('Kayıt ol', array('class' => 'btn btn-ls btn-block')) !!}
      </div>
      <!-- /.col -->
    </div>
  {!!	Form::close() !!}
  <p></p>
  <a href="{{ url('/admin/login') }}" class="btn btn-ls-dark btn-flat btn-full btn-bottom"> Zaten Üyeyim </a>
@endsection
