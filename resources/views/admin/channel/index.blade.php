@extends('admin.parent')

@section('title')
  Tüm Haber Kanalları
@endsection

@section('styles')
@endsection

@section('header')
  <section class="content-header">
    <h1>
      Tüm Haber Kanalları
      <small>Sistemimize kayıtlı tüm haber kanallarına buradan ulaşabilirsiniz</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
      <li class="active">Haber Kanalları</li>
    </ol>
  </section>
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">{{ $channels->total() }} Haber Kanalı</h3>
          <div class="box-tools">
            <form action="{{ url()->current() }}" method="GET">
              @foreach (request()->all() as $key => $val)
                @if ($key != "search")
                  <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                @endif
              @endforeach
              <div class="input-group input-group-sm">
                <input type="text" class="form-control pull-right" style="max-width:100px;" name="search" placeholder="Arama" value="{{ request()->search }}">
                <div class="input-group-btn">
                  <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  <a href="{{ route('admin.channel.index', array_merge(request()->all(), ['csv' => 'true'])) }}" class="btn btn-default" target="_blank"><i class="fa fa-download"></i></a>
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
                <th>Kategori</th>
                <th>Logo</th>
                <th>Haber Sayısı</th>
                <th class="two-button">İşlem</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($channels as $channel)
                <tr id="channel-{{ $channel->id }}">
                  <td>{{ $channel->id }}</td>
                  <td>{{ $channel->name }}</td>
                  <td>{{ $channel->category }}</td>
                  <td>
                    <img class="table-img-sm" src="/{{ upload_path( "channel", $channel->logo ) }}" alt="{{ $channel->name }}">
                  </td>
                  <td>{{ $channel->news_count }}</td>
                  <td>
                    <div class="btn-group">
                      <a class="edit btn btn-flat btn-warning btn-xs" href="{{ route("admin.channel.edit", $channel->id) }}">
                        <i class="fa fa-pencil"></i>
                      </a>
                      <a class="delete btn btn-flat btn-danger btn-xs" channel-id="{{ $channel->id }}" channel-name="{{ $channel->name }}"  href="javascript:;"><i class="fa fa-trash"></i></a>
                    </div>

                </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6">Haber kanalı bulunmamaktadır.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          {{ $channels->appends([
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
    deleteItem("channel", "channel-id", "channel-name", "isimli haber kanalını silmek istediğinize emin misiniz?");
  </script>
@endsection
