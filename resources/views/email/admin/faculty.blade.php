@extends('email.parent')

@section('message')
	{!! $text !!}
	<br>Leyla'dan Sonra ekibinden {{ $sender->full_name }}
@stop