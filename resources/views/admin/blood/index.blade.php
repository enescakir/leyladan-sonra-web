@extends('admin.parent')

@section('title')
Tüm Bağışçılar
@endsection

@section('styles')
@endsection

@section('header')
  <section class="content-header">
    <h1>
      Tüm Bağışçılar
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
              <div class="input-group input-group-sm">
                <input type="text" class="form-control table-search-bar pull-right" name="search" placeholder="Arama" value="{{ request()->search }}">
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
                  {{-- CITY SELECTOR --}}
                  <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      {{ request()->city ? request()->city : "Şehir"}} <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu scrollable-menu">
                      <li><a href="{{ route('admin.blood.index', array_merge(request()->all(), ['city' => ''])) }}">Hepsi</a></li>
                      @foreach (citiesToSelect() as $city)
                        <li><a href="{{ route('admin.blood.index', array_merge(request()->all(), ['city' => $city])) }}">{{ $city }}</a></li>
                      @endforeach
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
                  <a href="{{ route('admin.blood.index', array_merge(request()->all(), ['download' => 'true'])) }}" class="btn btn-primary" target="_blank">
                    <i class="fa fa-download"></i>
                  </a>
                  <a href="{{ route('admin.blood.create') }}" class="btn btn-success"><i class="fa fa-plus"></i></a>
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
                <th class="two-button">İşlem</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($bloods as $blood)
                <tr id="blood-{{ $blood->id }}">
                  <td>{{ $blood->id }}</td>
                  <td>{{ $blood->blood_type }}</td>
                  <td>{{ $blood->rh }}</td>
                  <td>{{ $blood->mobile_formatted }}</td>
                  <td>{{ $blood->city }}</td>
                  <td>
                    <div class="btn-group">
                      <a class="edit btn btn-warning btn-xs" href="{{ route("admin.blood.edit", $blood->id) }}">
                        <i class="fa fa-pencil"></i>
                      </a>
                      <a class="delete btn btn-danger btn-xs" delete-id="{{ $blood->id }}" delete-name="{{ $blood->mobile }}" href="javascript:;"><i class="fa fa-trash"></i></a>
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
                  'city' => request()->city,
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
    deleteItem("blood", "numaralı bağışçıyı silmek istediğinize emin misiniz?");
  </script>
@endsection
