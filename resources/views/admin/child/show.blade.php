@extends('admin.layouts.app')

@section('title', $child->full_name)

@section('styles')
    <style>
        th {
            white-space: nowrap;
            vertical-align: middle !important;
        }

        td h4 {
            margin-top: 3px !important;
            margin-bottom: 3px !important;
        }

        #process-container {
            max-height: 200px;
        }
    </style>
@endsection

@section('header')
    <section class="content-header">
        <h1>
            {{ $child->full_name }}
            <small>isimli çocuğumuzu görüntülüyorsunuz</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
            <li class="active">{{ $child->full_name }}</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">Genel Bilgiler</h4>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body no-padding">
                    <table class="table table-striped table-bordered">
                        <tbody>
                        <tr>
                            <th>ID</th>
                            <td itemprop="id">{{ $child->id }}</td>
                        </tr>
                        <tr>
                            <th>Ad</th>
                            <td itemprop="first_name">{{ $child->first_name }}</td>
                        </tr>
                        <tr>
                            <th>Soyad</th>
                            <td itemprop="last_name">{{ $child->last_name }}</td>
                        </tr>
                        <tr>
                            <th>Fakülte</th>
                            <td>{{ $child->faculty->full_name }}</td>
                        </tr>
                        <tr>
                            <th>Departman</th>
                            <td>{{ $child->department }}</td>
                        </tr>
                        <tr>
                            <th>Tanı</th>
                            <td>{{ $child->diagnosis }}</td>
                        </tr>
                        <tr>
                            <th>Tanı Açıklama</th>
                            <td>{{ $child->diagnosis_desc }}</td>
                        </tr>
                        <tr>
                            <th>Durum</th>
                            <td>{{ $child->child_state }} - {{ $child->child_state_desc }}</td>
                        </tr>
                        <tr>
                            <th>Doğum Günü</th>
                            <td>{{ $child->birthday_label }}</td>
                        </tr>
                        <tr>
                            <th>Tanışma Günü</th>
                            <td>{{ $child->meeting_day_label }}</td>
                        </tr>
                        <tr>
                            <th>Son Yayın Tarihi</th>
                            <td>
                                @if ($child->until)
                                    @if ($child->until->isFuture())
                                        <h4><span class="label label-success"> {{$child->until_label}} </span></h4>
                                    @elseif ($child->until->isPast())
                                        <h4><span class="label label-warning"> {{$child->until_label}} </span></h4>
                                    @endif
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Alınan Tedaviler</th>
                            <td>{{ $child->taken_treatment }}</td>
                        </tr>
                        <tr>
                            <th>Bizden İsteği</th>
                            <td>{{ $child->wish }}</td>
                        </tr>
                        <tr>
                            <th>Dilek Kategorisi</th>
                            <td>{{ $child->wishCategory ? $child->wishCategory->name : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Sorumlular</th>
                            <td>{{ $child->users->implode('full_name', ', ') }}</td>
                        </tr>
                        <tr>
                            <th>Ekstra Bilgi</th>
                            <td>{{ $child->extra_info }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->

            </div>

            <a class="btn btn-success btn-block margin-bottom"
               target="_blank"
               href="{{ route("front.child", [$child->faculty->slug, $child->slug]) }}"
            >
                <i class="fa fa-globe"></i> Sitede Göster
            </a>
            @can('update', $child)
                <a href="{{ route('admin.child.edit', $child->id) }}" class="btn btn-primary btn-block margin-bottom">
                    <i class="fa fa-edit"></i> Düzenle
                </a>
            @endcan
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">Veli Bilgileri</h4>
                </div>
                <div class="box-body no-padding">
                    <table class="table table-striped table-bordered">
                        <tbody>
                        <tr>
                            <th>Ad</th>
                            <td>{{ $child->g_first_name }}</td>
                        </tr>
                        <tr>
                            <th>Soyad</th>
                            <td>{{ $child->g_last_name }}</td>
                        </tr>
                        <tr>
                            <th>Telefon</th>
                            <td>{{ $child->g_mobile}}</td>
                        </tr>
                        <tr>
                            <th>E-posta</th>
                            <td>{{ $child->g_email}}</td>
                        </tr>
                        <tr>
                            <th>İlçe</th>
                            <td>{{ $child->province}}</td>
                        </tr>
                        <tr>
                            <th>İl</th>
                            <td>{{ $child->city}}</td>
                        </tr>
                        <tr>
                            <th>Adres</th>
                            <td>{{ $child->address}}</td>
                        </tr>
                        <tr>
                            <th>Onam Formu</th>
                            <td>
                                <a href="{{ route('admin.child.verification.show', $child->id) }}" target="_blank">
                                    <img class="img-responsive"
                                         src="{{ route('admin.child.verification.show', $child->id) }}"
                                         alt="{{ "{$child->full_name} Onam Formu" }}">
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h4 class="box-title">
                                Durumu:
                                <span id="gift-state-label"> {!! $child->gift_state_label !!} </span>
                            </h4>
                            <div class="box-buttons">
                                <div class="btn-group btn-group-sm btn-group-blockable">
                                    @can('process', [$child, App\Enums\ProcessType::Visit])
                                        <button type="button" class="process-btn btn btn-default"
                                                process-type="{{ App\Enums\ProcessType::Visit }}">Ziyaret ettim
                                        </button>
                                    @endcan
                                    @if ($child->gift_state == App\Enums\GiftStatus::Waiting )
                                        @can('process', [$child, App\Enums\ProcessType::VolunteerFound])
                                            <button type="button" class="process-btn btn btn-default"
                                                    process-type="{{ App\Enums\ProcessType::VolunteerFound }}">
                                                Gönüllü bulundu
                                            </button>
                                        @endcan
                                    @endif
                                    @if(in_array($child->gift_state, [App\Enums\GiftStatus::Waiting, App\Enums\GiftStatus::OnRoad]))
                                        @can('process', [$child, App\Enums\ProcessType::GiftArrived])
                                            <button type="button" class="process-btn btn btn-default"
                                                    process-type="{{ App\Enums\ProcessType::GiftArrived }}">
                                                Hediyesi geldi
                                            </button>
                                        @endcan
                                    @endif
                                    @if(in_array($child->gift_state, [App\Enums\GiftStatus::Waiting, App\Enums\GiftStatus::OnRoad, App\Enums\GiftStatus::Arrived]))
                                        @can('process', [$child, App\Enums\ProcessType::GiftDelivered])
                                            <button type="button" class="process-btn btn btn-default"
                                                    process-type="{{ App\Enums\ProcessType::GiftDelivered }}">
                                                Teslim edildi
                                            </button>
                                        @endcan
                                    @endif
                                    @can('process', [$child, App\Enums\ProcessType::Reset])
                                        <button type="button" class="process-btn btn btn-danger btn-sm"
                                                process-type="{{ App\Enums\ProcessType::Reset }}">Bekleniyor yap
                                        </button>
                                    @endcan
                                </div>
                            </div>
                        </div>
                        <div class="box-body no-padding">
                            <div class="table-fixed">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>İşlem</th>
                                        <th>Kişi</th>
                                        <th>Tarih</th>
                                    </tr>
                                    </thead>
                                    <tbody id="process-container">
                                    @foreach($child->processes as $process)
                                        <tr>
                                            <td>{{ $process->text }}</td>
                                            <td>{{ $process->creator->full_name }}</td>
                                            <td>{{ $process->created_at_label }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h4 class="box-title">Tanışma Yazısı</h4>
                        </div>
                        <div class="box-body">
                            <h4>Fotoğraflar</h4>
                            <div class="post-images">
                                @forelse(optional($child->meetingPost)->media as $media)
                                    <div class="post-image-container" id="media-{{$media->id}}">
                                        <a href="{{ $media->getUrl('large') }}" target="_blank">
                                            <img class="post-image img-responsive" src="{{ $media->getUrl('thumb') }}"
                                                 alt="{{ $child->full_name }}">
                                        </a>
                                        @if($child->featured_media_id == $media->id)
                                            <span class="label label-warning"
                                                  style="position:absolute; top: 10px; right: 10px;"><i
                                                        class="fa fa-star"></i></span>
                                        @endif
                                    </div>
                                @empty
                                    <p>Yazının fotoğrafı bulunmamaktadır</p>
                                @endforelse
                            </div>
                            <h4>Metin</h4>
                            {!! optional($child->meetingPost)->text!!}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h4 class="box-title">Hediye Teslim Yazısı</h4>
                        </div>
                        <div class="box-body">
                            @if($child->deliveryPost->text)
                                <h4>Fotoğraflar</h4>
                                <div class="post-images">
                                    @forelse(optional($child->deliveryPost)->media as $media)
                                        <div class="post-image-container" id="media-{{$media->id}}">
                                            <a href="{{ $media->getUrl('large') }}" target="_blank">
                                                <img class="post-image img-responsive"
                                                     src="{{ $media->getUrl('thumb') }}"
                                                     alt="{{ $child->full_name }}">
                                            </a>
                                            @if($child->featured_media_id == $media->id)
                                                <span class="label label-warning"
                                                      style="position:absolute; top: 10px; right: 10px;"><i
                                                            class="fa fa-star"></i></span>
                                            @endif
                                        </div>
                                    @empty
                                        <p>Yazının fotoğrafı bulunmamaktadır</p>
                                    @endforelse
                                </div>
                                <h4>Metin</h4>
                                {!! optional($child->deliveryPost)->text!!}
                            @else
                                <h4>Bu miniğimizin hediye teslim yazısı bulunmamaktadır</h4>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var processMessages = {
            4: "isimli çocuğumuzun gönüllüsünün bulunduğuna emin misiniz?",
            6: "isimli çocuğumuzun hediyesinin geldiğinden emin misiniz?",
            7: "isimli çocuğumuzun hediyesinin teslim edildiğine emin misiniz?",
            8: "isimli çocuğumuzu ziyaret ettiğinize emin misiniz?",
            10: "isimli çocuğumuzu tekrardan \"Bekleniyor\" kategorisine almak istediğinize emin misiniz?"
        };
        var id = $('td[itemprop=id]').text();
        var name = $('td[itemprop=first_name]').text() + " " + $('td[itemprop=last_name]').text();

        $('.process-btn').on('click', function () {
            var type = $(this).attr('process-type');
            swal({
                title: "Emin misin?",
                text: "'" + name + "' " + processMessages[type],
                type: "warning",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Evet, eminim!",
                showCancelButton: true,
                cancelButtonText: "Hayır",
                showLoaderOnConfirm: true,
                preConfirm: function () {
                    return new Promise(function (resolve, reject) {
                        $.ajax({
                            url: "/admin/child/" + id + "/process",
                            method: "POST",
                            data: {type: type},
                            success: function (response) {
                                resolve(response)
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                ajaxError(xhr, ajaxOptions, thrownError);
                            }
                        });
                    })
                },
                allowOutsideClick: false,
            }).then(function (response) {
                $('#gift-state-label').html(response.data.label);
                var container = $('#process-container');
                container.prepend('<tr><td>' + response.data.process.text + '</td><td>' + response.data.process.creator.full_name + '</td><td>' + response.data.created_at_label + '</td></tr>');
            })
        });

    </script>
@endsection
