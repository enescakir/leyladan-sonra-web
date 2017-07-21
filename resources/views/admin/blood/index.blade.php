@extends('admin.parent')

@section('title')
  Tüm Bağışçıları
@endsection

@section('styles')
@endsection

@section('header')
  <section class="content-header">
    <h1>
      Tüm Bağışçıları
      <small>Sistemimize kayıtlı tüm kan bağışçılarına buradan ulaşabilirsiniz</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
      <li class="active">Bağışçılar</li>
    </ol>
  </section>
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Ayrıntılı Tablo</h3>

          <div class="box-tools">
            <div class="input-group input-group-sm" style="width: 200px;">
              <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">
              <div class="input-group-btn">
                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                <div class="btn-group btn-group-sm">
                  <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ request()->renew_rate ? request()->renew_rate . " aylık" : 'Paket'}} <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu">
                    <li><a href="{{ route('admin.blood.index') }}">Hepsi</a></li>
                    <li><a href="{{ route('admin.blood.index', ['renew_rate' => 1]) }}">Aylık</a></li>
                    <li><a href="{{ route('admin.blood.index', ['renew_rate' => 3]) }}">3 Aylık</a></li>
                    <li><a href="{{ route('admin.blood.index', ['renew_rate' => 6]) }}">6 Aylık</a></li>
                    <li><a href="{{ route('admin.blood.index', ['renew_rate' => 12]) }}">12 Aylık</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
          <table class="table table-striped table-hover table-bordered table-condensed">
            <thead>
              <tr>
                <th>ID</th>
                <th>Grup</th>
                <th>Rh</th>
                <th>Telefon</th>
                <th>Şehir</th>
                <th style="width:120px;">İşlem</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($bloods as $blood)
                <tr>
                  <td>{{ $blood->id }}</td>
                  <td>{{ $blood->blood_type }}</td>
                  <td>{{ $blood->rh }}</td>
                  <td>{{ $blood->mobile }}</td>
                  <td>{{ $blood->city }}</td>
                  <td>
                    <div class="btn-group">
                      <a class="edit btn btn-flat btn-warning btn-xs" href="{{ route("admin.blood.edit", $blood->id) }}">
                        <i class="fa fa-pencil"></i>
                      </a>
                      <a class="delete btn btn-flat btn-danger btn-xs" href="javascript:;"><i class="fa fa-trash"></i></a>
                    </div>

                </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6">Kan bağışçısı bulunmamaktadır.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
          {{ $bloods->links() }}
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
  </div>
@endsection

@section('scripts')
@endsection
