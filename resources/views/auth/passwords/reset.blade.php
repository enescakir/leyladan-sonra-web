@extends('auth.parent')

@section('title')
    Şifre Sıfırlama
@stop

@section('content')
  <h3 class="login-box-msg">Şifreni mi unuttun?</h3>
  {!!	Form::open(['url' => '/admin/password/reset', 'method' => 'POST']) !!}
  {!! Form::hidden('token', $token ) !!}
    <p> Sıfırlama bağlantısının gelebilmesi için sisteme kayıtlı olduğun e-posta adresini yazmalısın: </p>
    <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
        {!! Form::text('email', $email ?? '', ['class' => 'form-control', 'placeholder' => 'E-Posta', 'required' => 'required']) !!}
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        @if ($errors->has('email'))
            <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
        @endif
    </div>
    <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
      {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Yeni Şifre', 'required' => 'required']) !!}
      <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      @if ($errors->has('password'))
          <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
      @endif
    </div>
    <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
      {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Tekrar yeni şifre', 'required' => 'required']) !!}
      <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      @if ($errors->has('password_confirmation'))
          <span class="help-block"><strong>{{ $errors->first('password_confirmation') }}</strong></span>
      @endif
    </div>
    <div class="row">
      <div class="col-xs-6">
        <a href="{{ url('/admin/login') }}" class="btn btn-danger btn-block" > Giriş Yap</a>
      </div>
      <!-- /.col -->
      <div class="col-xs-6">
        {!! Form::submit('Sıfırla', array('class' => 'btn btn-ls btn-block')) !!}
      </div>
      <!-- /.col -->
    </div>
  {!!	Form::close() !!}
@endsection
