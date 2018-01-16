@extends('admin.parent')

@section('title')
  Tüm Haberler
@endsection

@section('styles')
@endsection

@section('header')
  <section class="content-header">
    <h1>
      Tüm Haberler
      <small>Sistemimize kayıtlı tüm haberlere buradan ulaşabilirsiniz</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
      <li class="active">Haberler</li>
    </ol>
  </section>
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">{{ $news->total() }} Haber</h3>
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
                  <a href="{{ route('admin.new.index', array_merge(request()->all(), ['download' => 'true'])) }}" class="btn btn-primary" target="_blank">
                    <i class="fa fa-download"></i>
                  </a>
                  <a href="{{ route('admin.new.create') }}" class="btn btn-success">
                    <i class="fa fa-plus"></i>
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
                <th>Ad</th>
                <th>Açıklama</th>
                <th>Kanal</th>
                <th class="three-button">İşlem</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($news as $new)
                <tr id="new-{{ $new->id }}">
                  <td>{{ $new->id }}</td>
                  <td>{{ $new->title }}</td>
                  <td>{{ $new->desc }}</td>
                  <td>{{ $new->channel->name }}</td>
                  <td>
                    <div class="btn-group">
                      <a class="edit btn btn-primary btn-xs" target="_blank" href="{{ $new->link }}">
                        <i class="fa fa-globe"></i>
                      </a>
                      <a class="edit btn btn-warning btn-xs" href="{{ route("admin.new.edit", $new->id) }}">
                        <i class="fa fa-pencil"></i>
                      </a>
                      <a class="delete btn btn-danger btn-xs" delete-id="{{ $new->id }}" delete-name="{{ $new->title }}"  href="javascript:;">
                        <i class="fa fa-trash"></i>
                      </a>
                    </div>
                </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5">Haber bulunmamaktadır.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          {{ $news->appends([
                  'search' => request()->search,
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
    deleteItem("new", "isimli haberi silmek istediğinize emin misiniz?");
  </script>
@endsection
