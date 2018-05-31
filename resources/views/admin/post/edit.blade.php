@extends('admin.parent')

@section('title', $post->child->full_name)

@section('styles')
<style type="text/css">
  .post-image {
    max-height: 300px;
    float: left;
    margin-right: 10px;
  }
  .img-add-container {
    float: left;
    width: 150px;
    height: 300px;
    text-align: center;
    vertical-align: middle;
  }
</style>
@endsection

@section('header')
<section class="content-header">
  <h1>
    {{ $post->child->full_name }}
    <small><strong>{{ $post->type}}</strong> yazısını düzenliyorsunuz</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
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
            <tr><th>Ad</th><td>{{ $post->child->first_name }}</td></tr>
            <tr><th>Soyad</th><td>{{ $post->child->last_name }}</td></tr>
            <tr><th>Tanı</th><td>{{ $post->child->diagnosis }}</td></tr>
            <tr><th>Tanı Açıklama</th><td>{{ $post->child->diagnosis_desc }}</td></tr>
            <tr><th>Alınan Tedaviler</th><td>{{ $post->child->taken_treatment }}</td></tr>
            <tr><th>Doğum Günü</th><td>{{ $post->child->birthday_label }}</td></tr>
            <tr><th>Bizden İsteği</th><td>{{ $post->child->wish }}</td></tr>
            <tr><th>Departman</th><td>{{ $post->child->department }}</td></tr>
            <tr><th>Sorumlular</th><td>{{ $post->child->users->implode('full_name', ', ') }}</td></tr>
            <tr><th>Ekstra Bilgi</th><td>{{ $post->child->extra_info }}</td></tr>
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
          @forelse($post->images as $image)
            <img class="post-image img-responsive" src="{{ $image->path }}" alt="{{ $post->child->full_name }}">
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
      {!! Form::open(['method' => 'PUT', 'route' => ['admin.post.update', $post->id], 'class' => 'form-horizontal', 'files' => true]) !!}
      <div class="box-body">
        {!! Form::textarea('text', null, ['class' => 'form-control', 'required' => 'required']) !!}
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <a href="{{ url()->previous() }}" class="btn btn-danger">Geri</a>
        <div class="btn-group pull-right">
          {!! Form::submit("Kaydet", ['class' => 'btn btn-primary', 'value' => '0']) !!}
          {!! Form::submit("Kaydet & Onayla", ['class' => 'btn btn-success', 'value' => '1']) !!}
        </div>
      </div>
      <!-- /.box-footer -->
      {!! Form::close() !!}
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="img-modal" role="dialog" aria-labelledby="modalLabel" tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Yeni Fotoğraf Ekle</h4>
      </div>
      <div class="modal-body">
        <div class="img-container">
          <img id="image" class="img-responsive" src="{{ asset('resources/admin/media/child_no_image.jpg') }}">
        </div>
      </div>
      <div class="modal-footer">
        <div class="btn-group">
          <button type="button" class="btn btn-primary" data-method="rotate" data-option="-45" title="Rotate Left">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.rotate(-45)">
              <span class="fa fa-rotate-left"></span>
            </span>
          </button>
          <button type="button" class="btn btn-primary" data-method="rotate" data-option="45" title="Rotate Right">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.rotate(45)">
              <span class="fa fa-rotate-right"></span>
            </span>
          </button>
        </div>
        <div class="btn-group">
          <button type="button" class="btn btn-primary" data-method="scaleX" data-option="-1" title="Flip Horizontal">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.scaleX(-1)">
              <span class="fa fa-arrows-h"></span>
            </span>
          </button>
          <button type="button" class="btn btn-primary" data-method="scaleY" data-option="-1" title="Flip Vertical">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.scaleY(-1)">
              <span class="fa fa-arrows-v"></span>
            </span>
          </button>
        </div>
        <div class="btn-group d-flex flex-nowrap" data-toggle="buttons">
          <label class="btn btn-primary active">
            <input type="radio" class="sr-only" id="aspectRatio1" name="aspectRatio" value="1.7777777777777777">
              Yatay
          </label>
          <label class="btn btn-primary">
            <input type="radio" class="sr-only" id="aspectRatio2" name="aspectRatio" value="1.3333333333333333">
            Dikey
          </label>
        </div>
        <div class="btn-group">
          <label class="btn btn-primary btn-upload" for="inputImage" title="Upload image file">
            <input type="file" class="sr-only" id="inputImage" name="file" accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff">
            <span class="fa fa-upload"></span>
          </label>
        </div>
        <button type="button" class="btn btn-default" data-dismiss="modal">Kaydet</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">
  $("#add-img-btn").click(function (event) {
    $("#img-modal").modal("show")
  })

  window.addEventListener('DOMContentLoaded', function () {
    var image = document.getElementById('image');
    var cropBoxData;
    var canvasData;
    var cropper;
    $('#img-modal').on('shown.bs.modal', function () {
      cropper = new Cropper(image, {
        autoCropArea: 0.5,
        ready: function () {
            // Strict mode: set crop box data first
            cropper.setCropBoxData(cropBoxData).setCanvasData(canvasData);
          }
        });
    }).on('hidden.bs.modal', function () {
      cropBoxData = cropper.getCropBoxData();
      canvasData = cropper.getCanvasData();
      cropper.destroy();
    });
  });
</script>
@endsection
