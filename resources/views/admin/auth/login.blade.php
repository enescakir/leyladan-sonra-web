@extends('admin.auth.parent')

@section('title', 'Giriş Yap')

@section('content')
    <h3 class="login-box-msg">Hesaba Giriş</h3>
    {!!	Form::open(['url' => '/admin/login', 'method' => 'POST']) !!}
      <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
          {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'E-Posta', 'required' => 'required']) !!}
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          @if ($errors->has('email'))
              <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
          @endif
      </div>
      <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
          {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Şifre', 'required' => 'required']) !!}
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          @if ($errors->has('password'))
              <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
          @endif
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox" name="remember"> Beni Hatırla
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          {!! Form::submit('Giriş', ['class' => 'btn btn-ls btn-block']) !!}
        </div>
        <!-- /.col -->
      </div>
    {!!	Form::close() !!}
    <p><a href="{{ url('/admin/password/reset') }}">Şifremi unuttum?</a></p>
    <a href="{{ url('/admin/register') }}" class="btn btn-ls-dark btn-flat btn-full btn-bottom"> Yeni hesap oluştur </a>
@endsection
