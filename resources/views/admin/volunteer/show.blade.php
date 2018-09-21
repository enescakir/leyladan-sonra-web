@extends('admin.parent')

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
                                @foreach($volunteer->children as $child)
                                    <tr>
                                        <td>{{ $child->full_name }}</td>
                                        <td>{{ $child->faculty->full_name }}</td>
                                        <td>{{ $child->wish }}</td>
                                    </tr>
                                @endforeach
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
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Ad</th>
                                    <th>Fakülte</th>
                                    <th>Dilek</th>
                                    <th>Başlangıç</th>
                                    <th>Mesaj Sayısı</th>
                                </tr>
                                </thead>
                                <tbody id="process-container">
                                @foreach($volunteer->chats as $chat)
                                    <tr>
                                        <td>{{ $chat->child->full_name }}</td>
                                        <td>{{ $chat->faculty->full_name }}</td>
                                        <td>{{ $chat->child->wish }}</td>
                                        <td>{{ $chat->created_at_label }}</td>
                                        <td>{{ $chat->messages->count() }}</td>
                                    </tr>
                                @endforeach
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
