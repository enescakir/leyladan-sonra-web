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
          <h3 class="box-title">{{ $bloods->total() }} Bağışçı</h3>
          <div class="box-tools">
            <form action="{{ url()->current() }}" method="GET">
              @foreach (request()->all() as $key => $val)
                @if ($key != "search")
                  <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                @endif
              @endforeach
              <div class="input-group input-group-sm" style="width: 280px;">
                <input type="text" class="form-control pull-right" name="search" placeholder="Arama" value="{{ request()->search }}">
                <div class="input-group-btn">
                  <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  {{-- TYPE SELECTOR --}}
                  <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      {{ request()->blood_type != null ? request()->blood_type : "Kan Grubu"}} <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                      <li><a href="{{ route('admin.blood.index', array_merge(request()->all(), ['blood_type' => ''])) }}">Hepsi</a></li>
                      <li><a href="{{ route('admin.blood.index', array_merge(request()->all(), ['blood_type' => 'A'])) }}">A</a></li>
                      <li><a href="{{ route('admin.blood.index', array_merge(request()->all(), ['blood_type' => 'B'])) }}">B</a></li>
                      <li><a href="{{ route('admin.blood.index', array_merge(request()->all(), ['blood_type' => 'AB'])) }}">AB</a></li>
                      <li><a href="{{ route('admin.blood.index', array_merge(request()->all(), ['blood_type' => '0'])) }}">0</a></li>
                    </ul>
                  </div>
                  {{-- RH SELECTOR --}}
                  <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      {{ request()->rh != null ? "RH " . request()->rh : "RH"}} <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                      <li><a href="{{ route('admin.blood.index', array_merge(request()->all(), ['rh' => ''])) }}">Hepsi</a></li>
                      <li><a href="{{ route('admin.blood.index', array_merge(request()->all(), ['rh' => '1'])) }}">Pozitif</a></li>
                      <li><a href="{{ route('admin.blood.index', array_merge(request()->all(), ['rh' => '0'])) }}">Negatif</a></li>
                    </ul>
                  </div>
                  {{-- ROW PER PAGE --}}
                  <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      {{ request()->per_page ?: "25"}}
                    </button>
                    <ul class="dropdown-menu">
                      <li><a href="{{ route('admin.blood.index', array_merge(request()->all(), ['per_page' => 10])) }}">10</a></li>
                      <li><a href="{{ route('admin.blood.index', array_merge(request()->all(), ['per_page' => 25])) }}">25</a></li>
                      <li><a href="{{ route('admin.blood.index', array_merge(request()->all(), ['per_page' => 50])) }}">50</a></li>
                      <li><a href="{{ route('admin.blood.index', array_merge(request()->all(), ['per_page' => 100])) }}">100</a></li>
                      <li><a href="{{ route('admin.blood.index', array_merge(request()->all(), ['per_page' => 500])) }}">500</a></li>
                    </ul>
                  </div>
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
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          {{ $bloods->appends([
                  'search' => request()->search,
                  'per_page' => request()->per_page,
                  'blood_type' => request()->blood_type,
                  'rh' => request()->rh,
             ])->links() }}
        </div>
        <!-- /.box-footer -->
      </div>
      <!-- /.box -->
    </div>
  </div>
@endsection

@section('scripts')
@endsection
