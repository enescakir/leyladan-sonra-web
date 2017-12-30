@extends('admin.parent')

@section('title')
  Tüm Destekçiler
@endsection

@section('styles')
@endsection

@section('header')
  <section class="content-header">
    <h1>
      Tüm Destekçiler
      <small>Sistemimize kayıtlı tüm destekçilere buradan ulaşabilirsiniz</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
      <li class="active">Destekçiler</li>
    </ol>
  </section>
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">{{ $sponsors->total() }} Destekçi</h3>
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
                  <a href="{{ route('admin.sponsor.index', array_merge(request()->all(), ['csv' => 'true'])) }}" class="btn btn-primary" target="_blank">
                    <i class="fa fa-download"></i>
                  </a>
                  <a href="{{ route('admin.sponsor.create') }}" class="btn btn-success">
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
                <th>Öncelik</th>
                <th>Link</th>
                <th>Logo</th>
                <th class="three-button">İşlem</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($sponsors as $sponsor)
                <tr id="sponsor-{{ $sponsor->id }}">
                  <td>{{ $sponsor->id }}</td>
                  <td>{{ $sponsor->name }}</td>
                  <td>{{ $sponsor->order }}</td>
                  <td>{{ $sponsor->link }}</td>
                  <td>
                    <img class="table-img-sm" src="/{{ upload_path( "sponsor", $sponsor->logo ) }}" alt="{{ $sponsor->name }}">
                  </td>
                  <td>
                    <div class="btn-group">
                      <a class="btn btn-primary btn-xs" target="_blank" href="{{ $sponsor->link }}">
                        <i class="fa fa-globe"></i>
                      </a>
                      <a class="edit btn btn-warning btn-xs" href="{{ route("admin.sponsor.edit", $sponsor->id) }}">
                        <i class="fa fa-pencil"></i>
                      </a>
                      <a class="delete btn btn-danger btn-xs" sponsor-id="{{ $sponsor->id }}" sponsor-name="{{ $sponsor->name }}"  href="javascript:;"><i class="fa fa-trash"></i></a>
                    </div>

                </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6">Destekçi bulunmamaktadır.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          {{ $sponsors->appends([
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
    deleteItem("sponsor", "sponsor-id", "sponsor-name", "isimli destekçiyi silmek istediğinize emin misiniz?");
  </script>
@endsection
