@extends('admin.parent')

@section('title', 'Fakülte Yazılar')

@section('header')
<section class="content-header">
  <h1>
    {{ $faculty->full_name }}
    <small>
      {{ request()->approval != null ? (request()->approval ? 'Onaylanmışlar' : 'Onaylanmamışlar') : "Tüm"}}
      {{ request()->type != null ? $post_types[request()->type] : "Çocuk"}} Yazıları
    </small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
    <li class="active">Yazılar</li>
  </ol>
</section>
@endsection

@section('content')
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">{{ $posts->total() }} Yazı</h3>
        <div class="box-tools">
          <form action="{{ url()->current() }}" method="GET">
            @foreach (request()->all() as $key => $val)
              @if ($key != "search")
                <input type="hidden" name="{{ $key }}" value="{{ $val }}">
              @endif
            @endforeach
            <div class="input-group input-group-sm">
              <input type="text" class="form-control table-search-bar pull-right" name="search" placeholder="Arama" value="{{ request()->search }}">
              <div class="input-group-btn">
                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                {{-- POST TYPE SELECTOR --}}
                <div class="btn-group btn-group-sm">
                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ request()->type != null ? $post_types[request()->type] : "Yazı Türü"}} <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu">
                    @foreach ($post_types as $key => $value)
                      <li><a href="{{ request()->fullUrlWithQuery(array_merge(request()->all(), ['type' => $key])) }}">{{ $value }}</a></li>
                    @endforeach
                  </ul>
                </div>
                {{-- APPROVAL SELECTOR --}}
                <div class="btn-group btn-group-sm">
                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ request()->approval != null ? (request()->approval ? 'Onaylanmışlar' : 'Onaylanmamışlar') : "Onay Durumu"}} <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu">
                    <li><a href="{{ request()->fullUrlWithQuery(array_merge(request()->all(), ['approval' => ''])) }}">Hepsi</a></li>
                    <li><a href="{{ request()->fullUrlWithQuery(array_merge(request()->all(), ['approval' => '1'])) }}">Onaylanmışlar</a></li>
                    <li><a href="{{ request()->fullUrlWithQuery(array_merge(request()->all(), ['approval' => '0'])) }}">Onaylanmamışlar</a></li>
                  </ul>
                </div>
                {{-- ROW PER PAGE --}}
                <div class="btn-group btn-group-sm">
                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ request()->per_page ?: "25"}}
                  </button>
                  <ul class="dropdown-menu">
                    @foreach([10, 25, 50, 100, 500] as $per)
                      <li><a href="{{ request()->fullUrlWithQuery(array_merge(request()->all(), ['per_page' => $per])) }}">{{ $per }}</a></li>
                    @endforeach
                  </ul>
                </div>
                <a href="{{ request()->fullUrlWithQuery(array_merge(request()->all(), ['download' => 'true'])) }}" class="btn btn-primary" target="_blank">
                  <i class="fa fa-download"></i>
                </a>
              </div>
            </div>
          </form>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body table-responsive no-padding">
        <table class="table table-striped table-hover table-bordered table-condensed">
          <thead>
            <tr>
              <th>ID</th>
              <th>Çocuğun Adı</th>
              <th>Tür</th>
              <th>Fotoğraf</th>
              <th>Yazı</th>
              <th>Durumu</th>
              <th class="three-button">İşlem</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($posts as $post)
            <tr id="post-{{ $post->id }}">
              <td>{{ $post->id }}</td>
              <td>{{ $post->child->full_name }} <strong>({{ $post->child->id }})</strong></td>
              <td>{{ $post->type }}</td>
              <td>
                @foreach($post->images as $image)
                <img class="table-img-lg" src="{{ $image->path }}" alt="{{ $post->child->full_name }}">
                @endforeach
              </td>
              <td>{!! $post->text !!}</td>
              <td id="post-{{ $post->id }}-status">{!! $post->approval_label !!}</td>
              <td>
                <div class="btn-group">
                  <button id="approve-post-{{ $post->id }}"
                    class="approve btn btn-default btn-xs @if($post->isApproved()) hidden @endif"
                    approve-id="{{ $post->id }}" approve-name="{{ $post->child->full_name }}-{{ $post->type }}" is-approve="1"
                    title="Yayınla">
                    <i class="fa fa-square-o"></i>
                  </button>
                  <button id="unapprove-post-{{ $post->id }}"
                    class="approve btn btn-success btn-xs @unless($post->isApproved()) hidden @endunless"
                    approve-id="{{ $post->id }}" approve-name="{{ $post->child->full_name }}-{{ $post->type }}" is-approve="0"
                    title="Yayından Çıkar">
                    <i class="fa fa-check-square-o"></i>
                  </button>
                  <a class="edit btn btn-warning btn-xs" href="{{ route("admin.post.edit", $post->id) }}">
                    <i class="fa fa-pencil"></i>
                  </a>
                  <a class="delete btn btn-danger btn-xs"
                  delete-id="{{ $post->id }}"
                  delete-name="{{ $post->child->full_name }}-{{ $post->type }}"
                  href="javascript:;">
                  <i class="fa fa-trash"></i>
                </a>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="8">Çocuk yazısı bulunmamaktadır.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
      {{ $posts->appends([
        'search' => request()->search,
        'approval' => request()->approval,
        'type' => request()->type,
        'per_page' => request()->per_page,
        ])->links() }}
      </div>
      <!-- /.box-footer -->
    </div>
    <!-- /.box -->
  </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
  deleteItem("post", "yazısını silmek istediğinize emin misiniz?");
  approveItem("post",
    "yazısını onaylamak istediğinize emin misiniz?",
    "yazısının onayını kaldırmak istediğinize emin misiniz?",
    function (approval, id) {
      if (approval) {
        $("#post-" + id + "-status").html('<span class="label label-success"> Onaylandı </span>')
      } else {
        $("#post-" + id + "-status").html('<span class="label label-danger"> Onaylanmadı </span>')
      }
    }
  );
</script>
@endsection
