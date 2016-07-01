@extends('email.parent')

@section('message')
	Fakültenizden <strong>"{{$child->full_name}}"</strong> için <strong>{{ $volunteer->first_name . " " . $volunteer->last_name }}</strong> isimli gönüllüden mesaj var.<br>
	</br>Sisteme giriş yaparak "Gönüllüler > Açık Sohbetler" sayfasından mesajı görüntüleyebilirsin.
	</br> Eğer başka bir arkadaşın cevaplamadıysa mesajın üstüne gelerek 'Cevapladım' butonuna tıkla ve fakülte e-posta adresinden gönüllüye e-posta at.
	</br> Çocuğumuzun hediyesine bir an önce kavuşabilmesi için mesajı cevaplaman gerekiyor.
@stop