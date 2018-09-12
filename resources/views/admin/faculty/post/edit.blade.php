@extends('admin.parent')

@section('title', $post->child->full_name)

@section('header')
    <section class="content-header">
        <h1>
            {{ $post->child->full_name }}
            <small><strong>{{ $post->type}}</strong> yazısını düzenliyorsunuz</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
            <li><a href="{{ route('admin.faculty.post.index', $faculty->id) }}">{{ $faculty->full_name }} Yazıları</a></li>
            <li>Yazı Düzenleme</li>
            <li class="active">{{ $post->child->full_name }}</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">Çocuğun Ayrıntılı Bilgileri</h4>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body no-padding">
                    <table class="table table-striped table-bordered">
                        <tbody>
                        <tr>
                            <th>Ad</th>
                            <td>{{ $post->child->first_name }}</td>
                        </tr>
                        <tr>
                            <th>Soyad</th>
                            <td>{{ $post->child->last_name }}</td>
                        </tr>
                        <tr>
                            <th>Fakülte</th>
                            <td>{{ $post->child->faculty->name }}</td>
                        </tr>
                        <tr>
                            <th>Tanı</th>
                            <td>{{ $post->child->diagnosis }}</td>
                        </tr>
                        <tr>
                            <th>Tanı Açıklama</th>
                            <td>{{ $post->child->diagnosis_desc }}</td>
                        </tr>
                        <tr>
                            <th>Alınan Tedaviler</th>
                            <td>{{ $post->child->taken_treatment }}</td>
                        </tr>
                        <tr>
                            <th>Doğum Günü</th>
                            <td>{{ $post->child->birthday_label }}</td>
                        </tr>
                        <tr>
                            <th>Bizden İsteği</th>
                            <td>{{ $post->child->wish }}</td>
                        </tr>
                        <tr>
                            <th>Departman</th>
                            <td>{{ $post->child->department }}</td>
                        </tr>
                        <tr>
                            <th>Sorumlular</th>
                            <td>{{ $post->child->users->implode('full_name', ', ') }}</td>
                        </tr>
                        <tr>
                            <th>Ekstra Bilgi</th>
                            <td>{{ $post->child->extra_info }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-8">
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">Fotoğraflar</h4>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <div class="post-images">
                        @forelse($post->media as $media)
                            <div class="post-image-container" id="media-{{$media->id}}">
                                <a href="{{ $media->getUrl('large') }}" target="_blank">
                                    <img class="post-image img-responsive" src="{{ $media->getUrl('thumb') }}"
                                         alt="{{ $post->child->full_name }}">
                                </a>
                                <button class="delete-btn img-btn btn btn-sm btn-danger" title="Fotoğrafı Sil"
                                        delete-name="{{ $post->child->full_name }}"
                                        delete-id="{{ $media->id }}"><i
                                            class="fa fa-trash"></i></button>
                                <button class="feature-btn img-btn btn btn-sm btn-default" title="Fotoğrafı Öne Çıkar"
                                        feature-id="{{ $media->id }}">
                                    <i class="fa fa-star-o"></i></button>
                            </div>
                        @empty
                            <p>Yazının fotoğrafı bulunmamaktadır</p>
                        @endforelse
                        <div class="img-add-container">
                            <a class="btn btn-app" id="add-img-btn">
                                <i class="fa fa-plus"></i> Fotoğraf Eke
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">Metin</h4>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {!! Form::model($post, ['method' => 'PUT', 'route' => ['admin.post.update', $post->id], 'class' => 'form-horizontal', 'files' => true]) !!}
                <div class="box-body">
                    {!! Form::textarea('text', null, ['class' => 'form-control summernote', 'required' => 'required']) !!}
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <a href="{{ url()->previous() }}" class="btn btn-danger">Geri</a>
                    <div class="btn-group pull-right">
                        <button type="submit" class="btn btn-primary" name="approval" value="0">Kaydet</button>
                        <button type="submit" class="btn btn-success" name="approval" value="1">Kaydet & Onayla</button>
                    </div>
                </div>
                <!-- /.box-footer -->
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('admin.partials.modal.cropper', ['postId' => $post->id])

    <script>
        deleteItem('media', 'isimli çocuğun fotoğrafını silmek istediğine emin misin?', 'delete-btn', '/admin/post/{{ $post->id }}/media/[ID]');
        featureItem('media', '', 'feature-btn', '/admin/post/{{ $post->id }}/media/[ID]/feature');
    </script>
    <script>
        @if($post->child->featured_media_id)
            setFeaturedMedia({{ $post->child->featured_media_id }});
        @endif
    </script>
@endsection
