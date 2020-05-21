@extends('admin.layouts.app')

@section('title', $volunteer->full_name)

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
    </style>
@endsection

@section('header')
    <section class="content-header">
        <h1>
            {{ $volunteer->full_name }}
            <small>isimli gönüllüyü görüntülüyorsunuz</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
            <li class="active">{{ $volunteer->full_name }}</li>
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
                            <td itemprop="id">{{ $volunteer->id }}</td>
                        </tr>
                        <tr>
                            <th>Ad</th>
                            <td itemprop="first_name">{{ $volunteer->first_name }}</td>
                        </tr>
                        <tr>
                            <th>Soyad</th>
                            <td itemprop="last_name">{{ $volunteer->last_name }}</td>
                        </tr>
                        <tr>
                            <th>E-posta</th>
                            <td itemprop="email">{{ $volunteer->email }}</td>
                        </tr>
                        <tr>
                            <th>Telefon</th>
                            <td>{{ $volunteer->mobile }}</td>
                        </tr>
                        <tr>
                            <th>Şehir</th>
                            <td>{{ $volunteer->city }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h4 class="box-title">
                                Hediye Aldığı Çocuklar
                            </h4>
                        </div>
                        <div class="box-body no-padding">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Ad</th>
                                    <th>Fakülte</th>
                                    <th>Dilek</th>
                                </tr>
                                </thead>
                                <tbody id="process-container">
                                @forelse($volunteer->children as $child)
                                    <tr>
                                        <td>{{ $child->full_name }}</td>
                                        <td>{{ $child->faculty->full_name }}</td>
                                        <td>{{ $child->wish }}</td>
                                    </tr>
                                @empty
                                    @include("admin.partials.noDataRow", ["message" => "Hediye aldığı çocuk bulunmamaktadır"])
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h4 class="box-title">
                                Mesaj Attığı Çocuklar
                            </h4>
                        </div>
                        <div class="box-body no-padding">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Ad</th>
                                    <th>Fakülte</th>
                                    <th>Dilek</th>
                                    <th>Başlangıç</th>
                                    <th class="five-button">Mesaj Sayısı</th>
                                </tr>
                                </thead>
                                <tbody id="process-container">
                                @forelse($volunteer->chats as $chat)
                                    <tr>
                                        <td class="text-nowrap">{{ $chat->child->full_name }}</td>
                                        <td class="text-nowrap">{{ $chat->faculty->full_name }}</td>
                                        <td>{{ $chat->child->wish }}</td>
                                        <td class="text-nowrap">{{ $chat->created_at_label }}</td>
                                        <td>
                                            {{ $chat->messages->count() }}
                                            <button class="btn btn-primary btn-xs" title="Görüntüle"
                                                    data-toggle="collapse" data-target=".chat-{{$chat->id}}">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @foreach($chat->messages as $message)
                                        <tr class="active collapse chat-{{$chat->id}}">
                                            <td colspan="4">
                                                {{ $message->text }}
                                            </td>
                                            <td>
                                                @if($message->isAnswered)
                                                    <strong>Cevaplayan: </strong><br>
                                                    {{ optional($message->answerer)->full_name ?? "-" }}
                                                    <br>
                                                    <strong>Tarih: </strong><br>
                                                    {{ $message->answered_at->format("d.m.Y H:i") }}
                                                @else
                                                    Cevaplanmadı
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @empty
                                    @include("admin.partials.noDataRow", ["message" => "Mesaj attığı çocuk bulunmamaktadır"])
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection
