@extends('admin.parent')

@section('title', 'Onam Formu Oluştur')


@section('header')
    <section class="content-header">
        <h1>
            Yeni Onam Formu Oluştur
            <small>buradan yeni onam formu oluşturabilirsiniz</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
            <li class="active">Onam Formu Oluştur</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <!-- /.box-header -->
                <!-- form start -->
                {!! Form::open(['method' => 'POST', 'route' => 'admin.form.store', 'class' => '']) !!}
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
                                {!! Form::label('text', 'Metin *', ['class' => 'control-label']) !!}
                                <div class="form-group">
                                    <div class="btn-group">
                                        <button class="btn-club btn btn-default" type="button">Kulüplü Metin</button>
                                        <button class="btn-no-club btn btn-default" type="button">Kulüpsüz Metin
                                        </button>
                                    </div>

                                </div>
                                {!! Form::textarea('text', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                <small class="text-danger">{{ $errors->first('text') }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h4>
                                Örnek Onam Formu
                            </h4>
                            <img style="width: 100%;" src="{{ admin_asset("img/form_sample.jpg") }}">

                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <a href="{{ route('admin.form.create') }}" class="btn btn-danger">Sıfırla</a>
                    {!! Form::submit("Oluştur", ['class' => 'btn btn-success pull-right']) !!}
                </div>
                <!-- /.box-footer -->
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(".btn-club").on('click', function () {
            $('#text').val('Leyla\'dan Sonra, hastanemizde tedavi görmekte olan çocuklarla tanışmayı, iletişim kurmayı, iyileşme süreçlerinde onlara manevi destek olmayı ve bir dileklerini yerine getirmeyi hedef alan; T.C. İstanbul Üniversitesi Sağlık, Kültür ve Spor Daire Başkanlığına bağlı Gönüllü Hekimler Kulübü adlı öğrenci kulübünün mensubu tıp fakültesi öğrencilerinin yürüttüğü bir projedir.');
        });

        $(".btn-no-club").on('click', function () {
            $('#text').val('Leyla\'dan Sonra, hastanemizde tedavi görmekte olan çocuklarla tanışmayı, iletişim kurmayı, iyileşme süreçlerinde onlara manevi destek olmayı ve bir dileklerini yerine getirmeyi hedef alan; T.C. İzmir Katip Çelebi Üniversitesi Tıp Fakültesi öğrencilerinin yürüttüğü bir projedir.');
        });

    </script>
@endsection
