<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="tr">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>Onam Formu {{ $random }}</title>
    <style>
        p {
            text-indent: 40px;
            font-size: 15px;
            line-height: 1.5;
        }

        .title {
            font-weight: bold;
            font-size: 21px;
            text-align: center;
            margin-bottom: 0px;
        }

        .strong {
            font-weight: bold;
        }

        .desc {
            padding-top: -10px;
            font-size: 13px;
            font-style: italic;
        }

        .nomargin {
            padding-top: -20px;
        }

        .noindent {
            text-indent: 0px;
        }

        .text-justify {
            text-align: justify;
        }

        .text-right {
            text-align: right;
        }

        .signature {
            padding-top: -20px;
            line-height: 1.3;
        }

        img {
            width: 50%;
            margin-left: 100px;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            padding: -40px -20px;
        }
    </style>

</head>
<body>
<h1 class="title noindent">LEYLA'DAN SONRA PROJESİ ONAY FORMU</h1>
<p class="text-justify">{{ $text }}</p>
<p class="desc noindent">[Kutucuğu <span class="strong">✔</span> (evet) olarak işaretlerseniz o bilginin paylaşılmasını
    onaylamış,<br><span class="strong">✘</span> (hayır) olarak işaretlerseniz onaylamamış olursunuz.]
    <img src="{{ admin_asset('img/form_options.jpg') }}">
<p class="nomargin noindent text-justify">Leyla'dan Sonra Projesi'nde yer almayı ve iznim dahilindeki bilgilerin
    internet sitesi
    (www.leyladansonra.com), ilişkili sosyal medya hesaplarında (Facebook, Twitter, Instagram, Youtube)
    ve tanıtım amaçlı mecralarda (sunumlar, haberler, vb...) gizlilik esasları dikkate alınarak,
    toplumda farkındalık yaratılması adına paylaşılmasını onaylıyor; bilgilerin projeye dahil olmayan
    şahıslarca kullanılması durumunda bu sosyal sorumluluk projesinde görevli kişileri
    sorumlu tutmayacağımı beyan ediyorum.</p>
<p class="noindent text-justify">İşbu onay formu velisi/vasisi bulunduğum ................................ T.C kimlik
    numaralı
    ............................................ adına tarafımdan imzalanmıştır.</p>
<p class="text-right noindent signature">
    …/…/……<br>
    (..İMZA...…………….……………….)<br>
    (..İSİM………………….……………..)<br>
    (..TCKN………….….………..………)<br>
</p>
</body>
</html>
