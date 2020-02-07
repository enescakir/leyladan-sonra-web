@extends('admin.layouts.app')

@section('title', 'SMS Önizleme')

@section('header')
    <section class="content-header">
        <h1>
            Kan Bağışı SMS Önizleme
            <small>Bu sayfadan oluşturduğunuz SMS bilgilerinin son kontrolünu yapabilirsiniz</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
            <li><a href="{{ route('admin.blood.index') }}">Bağışçılar</a></li>
            <li class="active">SMS Önizleme</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary" id="sms-send">
                <div class="box-header with-border">
                    <h4 class="box-title">SMS göndermeden önce tüm bilgileri kontrol ediniz</h4>
                    <div class="box-tools">
                        <div class="input-group input-group-sm">
                            <input type="text" id="test-number" class="form-control mobile pull-right"
                                   style="max-width:200px;" name="test-number" placeholder="Test Numarası">
                            <div class="input-group-btn">
                                <button id="send-test" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Test Et
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {!!	Form::open(['route' => ['admin.blood.sms.send'], 'class' => 'form-horizontal', 'method' => 'POST']) !!}
                <div class="box-body">
                    <h3 class="form-section">Gönderim Bilgileri</h3>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label col-md-2"><strong>Kan Grubu:</strong></label>
                                <div class="col-md-8">
                                    <p class="form-control-static"> {{ implode($blood_types, ', ') }} </p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2"><strong>RH:</strong></label>
                                <div class="col-md-8">
                                    <p class="form-control-static"> {{ implode($rhs, ', ') }} </p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2"><strong>Şehirler:</strong></label>
                                <div class="col-md-8">
                                    <p class="form-control-static"> {{ implode($cities, ', ') }} </p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2"><strong>Kişi Sayısı:</strong></label>
                                <div class="col-md-8">
                                    <p class="form-control-static"> {{ count($bloods) }} kişi </p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2"><strong>SMS Bakiye:</strong></label>
                                <div class="col-md-8">
                                    <p class="form-control-static" id="sms_balance"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2"><strong>Mesaj:</strong></label>
                                <div class="col-md-8">
                                    <p class="form-control-static"> {{ $message }} </p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                    </div>
                    <!--/row-->
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    @foreach ($bloods as $blood)
                        {!! Form::hidden('bloods[]', $blood->mobile) !!}
                    @endforeach
                    {!! Form::hidden('message', $message, ['id' => 'message']) !!}
                    <a href="{{ url()->previous() }}" class="btn btn-danger">Geri</a>
                    {!! Form::submit("Gönder", ['class' => 'btn btn-success pull-right']) !!}
                </div>
                <!-- /.box-footer -->
                {!! Form::close() !!}
            </div>
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">SMS Gönderilecek {{ count($bloods) }} Bağışçı</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-striped table-hover table-bordered table-condensed">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Telefon</th>
                            <th>Grup</th>
                            <th>RH</th>
                            <th>Şehir</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($bloods as $blood)
                            <tr>
                                <td>{{ $blood->id }}</td>
                                <td>{{ $blood->mobile }}</td>
                                <td>{{ $blood->blood_type }}</td>
                                <td>{{ $blood->rh }}</td>
                                <td>{{ $blood->city }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">Kan bağışçısı bulunmamaktadır.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <a href="#sms-send" class="btn btn-default pull-right"><i class="fa fa-arrow-up"></i> Yukarıya
                        Çık</a>
                </div>
                <!-- /.box-footer -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(function () {
            block('#sms_balance');
            $.ajax({
                url: "/admin/blood/sms/balance",
                method: "GET",
                dataType: "json",
                success: function (result) {
                    $('#sms_balance').html(result.data.balance + " adet SMS hakkınız kalmıştır.")
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    ajaxError(xhr, ajaxOptions, thrownError);
                }
            })
            ;
        });
        $('#send-test').click(function () {
            var message = $('#message').val();
            var number = $('#test-number').val();
            block('#test-number')
            $.ajax({
                url: "/admin/blood/sms/test",
                method: "POST",
                dataType: "json",
                data: {message: message, number: number},
                success: function (result) {
                    unblock('#test-number');
                    $('#test-number').val('')
                    swal({
                        title: 'Başarıyla Gönderildi!',
                        text: number + ' numaralı telefona deneme SMS\'i başarıyla gönderildi',
                        confirmButtonText: "Tamam",
                        timer: 2000
                    })
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    ajaxError(xhr, ajaxOptions, thrownError);
                }
            });
        });

    </script>
@endsection
