@extends('email.parent')

@section('message')
	Fakültenizden <strong>"{{$newUser->full_name}}"</strong> sistemimize <strong><em>{{$newUser->title}}</strong></em> olarak {{$newUser->email}} e-posta adresi ile kayıt oldu.
	</br></br>Sisteme giriş yaparak "Üyeler > Onay Bekleyen Üyeler" sayfasından üyeliği onaylayabilirsiniz.
@stop