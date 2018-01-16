@extends('admin.parent')

@section('title', 'Tüm Çocuklar')

@section('header')
<section class="content-header">
  <h1>
  Tüm Çocuklar
  <small>Sistemimize kayıtlı tüm çocuklara buradan ulaşabilirsiniz</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
    <li class="active">Çocuklar</li>
  </ol>
</section>
@endsection

@section('content')
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">{{ $children->total() }} Çocuk</h3>
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
                {{-- FACULTY SELECTOR --}}
                <div class="btn-group btn-group-sm">
                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  {{ request()->faculty_id != null ? $faculties[request()->faculty_id] : "Fakülte"}} <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu scrollable-menu">
                    @foreach ($faculties as $key => $value)
                    <li><a href="{{ route('admin.child.index', array_merge(request()->all(), ['faculty_id' => $key])) }}">{{ $value }}</a></li>
                    @endforeach
                  </ul>
                </div>
                {{-- DEPARTMENT SELECTOR --}}
                <div class="btn-group btn-group-sm">
                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  {{ request()->department != null ? $departments[request()->department] : "Departman"}} <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu scrollable-menu">
                    @foreach ($departments as $key => $value)
                    <li><a href="{{ route('admin.child.index', array_merge(request()->all(), ['department' => $key])) }}">{{ $value }}</a></li>
                    @endforeach
                  </ul>
                </div>
                {{-- DIAGNOSIS SELECTOR --}}
                <div class="btn-group btn-group-sm">
                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  {{ request()->diagnosis != null ? $diagnoses[request()->diagnosis] : "Tanı"}} <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu scrollable-menu">
                    @foreach ($diagnoses as $key => $value)
                    <li><a href="{{ route('admin.child.index', array_merge(request()->all(), ['diagnosis' => $key])) }}">{{ $value }}</a></li>
                    @endforeach
                  </ul>
                </div>
                {{-- ROW PER PAGE --}}
                <div class="btn-group btn-group-sm">
                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  {{ request()->per_page ?: "25"}}
                  </button>
                  <ul class="dropdown-menu">
                    <li><a href="{{ route('admin.child.index', array_merge(request()->all(), ['per_page' => 10])) }}">10</a></li>
                    <li><a href="{{ route('admin.child.index', array_merge(request()->all(), ['per_page' => 25])) }}">25</a></li>
                    <li><a href="{{ route('admin.child.index', array_merge(request()->all(), ['per_page' => 50])) }}">50</a></li>
                    <li><a href="{{ route('admin.child.index', array_merge(request()->all(), ['per_page' => 100])) }}">100</a></li>
                    <li><a href="{{ route('admin.child.index', array_merge(request()->all(), ['per_page' => 500])) }}">500</a></li>
                  </ul>
                </div>
                <a href="{{ route('admin.child.index', array_merge(request()->all(), ['download' => 'true'])) }}" class="btn btn-primary" target="_blank">
                  <i class="fa fa-download"></i>
                </a>
                <a href="{{ route('admin.child.create') }}" class="btn btn-success"><i class="fa fa-plus"></i></a>
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
              <th>İsim</th>
              <th>Fakülte</th>
              <th>Departman</th>
              <th>Tanı</th>
              <th>Dilek</th>
              <th>Doğumgünü</th>
              <th>Tanışma</th>
              <th>Hediye</th>
              <th class="three-button">İşlem</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($children as $child)
            <tr id="child-{{ $child->id }}">
              <td>{{ $child->id }}</td>
              <td>{{ $child->full_name }}</td>
              <td>{{ $child->faculty->name }}</td>
              <td>{{ $child->department }}</td>
              <td>{{ $child->diagnosis }}</td>
              <td>{{ $child->wish }}</td>
              <td>{{ $child->birthday_human }}</td>
              <td>{{ $child->meeting_day_human }}</td>
              <td>{!! $child->gift_state_label !!}</td>
              <td>
                <div class="btn-group">
                  <a class="show btn btn-primary btn-xs" href="{{ route("admin.child.show", $child->id) }}">
                    <i class="fa fa-search"></i>
                  </a>
                  <a class="edit btn btn-warning btn-xs" href="{{ route("admin.child.edit", $child->id) }}">
                    <i class="fa fa-pencil"></i>
                  </a>
                  <a class="delete btn btn-danger btn-xs" delete-id="{{ $child->id }}" delete-name="{{ $child->full_name }}" href="javascript:;"><i class="fa fa-trash"></i></a>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="10">Çocuk bulunmamaktadır.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        {{ $children->appends([
          'search' => request()->search,
          'faculty_id' => request()->faculty_id,
          'department' => request()->department,
          'diagnosis' => request()->diagnosis,
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
  deleteItem("child", "isimli çocuğu silmek istediğinize emin misiniz?");
</script>
@endsection
