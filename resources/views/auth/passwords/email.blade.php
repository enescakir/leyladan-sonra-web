@extends('auth.parent')

@section('title')
    Şifremi Unuttum?
@stop

@section('content')
  <h3 class="login-box-msg">Şifreni mi unuttun?</h3>
  {!!	Form::open(['url' => '/admin/password/email', 'method' => 'POST']) !!}
    <p> Sıfırlama bağlantısının gelebilmesi için sisteme kayıtlı olduğun e-posta adresini yazmalısın: </p>
    <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
        {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'E-Posta', 'required' => 'required']) !!}
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        @if ($errors->has('email'))
            <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
        @endif
    </div>
    <div class="row">
      <div class="col-xs-6">
        <a href="{{ url('/admin/login') }}" class="btn btn-danger btn-block" > Geri</a>
      </div>
      <!-- /.col -->
      <div class="col-xs-6">
        {!! Form::submit('Gönder', array('class' => 'btn btn-ls btn-block')) !!}
      </div>
      <!-- /.col -->
    </div>
  {!!	Form::close() !!}
@endsection
