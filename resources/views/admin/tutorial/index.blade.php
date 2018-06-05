@extends('admin.parent')

@section('title', 'Eğitimler')

@section('styles')
<style>
    .videoWrapper {
        position: relative;
        padding-bottom: 56.25%; /* 16:9 */
        padding-top: 25px;
        height: 0;
    }
    .videoWrapper iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
</style>
@endsection

@section('header')
  <section class="content-header">
    <h1>
      Eğitimler
      <small>{{ $tutorials->total() }} Video</small>
    </h1>
    <ol class="breadcrumb">
      <li>
        <a href="{{ route('admin.dashboard') }}">
          <i class="fa fa-home"></i> Anasayfa</a>
      </li>
      <li class="active">Eğitimler</li>
    </ol>
  </section>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
        <div class="input-group input-group-sm">
            <input id="search-input" type="text" class="form-control table-search-bar pull-right search-input" name="search" placeholder="Arama"
              value="{{ request()->search }}">
            <div class="input-group-btn">
              <button id="search-btn" class="btn btn-default" type="submit">
                <i class="fa fa-search"></i> Ara
              </button>
              {{-- TYPE SELECTOR --}}
              @include('admin.partials.selectors.default', [
                'selector' => [
                  'id'        => 'category-selector',
                  'class'     => 'btn-default',
                  'icon'      => 'fa fa-files-o',
                  'current'   => request()->category,
                  'values'    => $categories,
                  'default'   => 'Kategori',
                  'parameter' => 'category'
                ]
              ])
              <a href="{{ route('admin.tutorial.create') }}" class="btn btn-success"><i class="fa fa-plus"></i></a>
            </div>
          </div>        
    </div>
  </div>
  <br>
  @forelse($tutorials->chunk(4) as $chunk)
    <div class="row">
      @foreach($chunk as $tutorial)
        <div id="tutorial-{{ $tutorial->id }}" class="col-sm-6 col-md-4">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"> {{ $tutorial->name }}</h3> <span class="label label-danger label-sm">{{ $tutorial->category }}</span>
              <div class="box-tools">
                <div class="btn-group btn-group-xs">
                  <a class="edit btn btn-warning btn-xs" href="{{ route("admin.tutorial.edit", $tutorial->id) }}">
                    <i class="fa fa-pencil"></i>
                  </a>
                  <a class="delete btn btn-danger btn-xs" delete-id="{{ $tutorial->id }}" delete-name="{{ $tutorial->name }}" href="javascript:;">
                    <i class="fa fa-trash"></i>
                  </a>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding text-center">
                <div class="videoWrapper">
                  <iframe width="560" height="315" src="{{ $tutorial->link }}" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
    @empty
    <h2>Bu kriterlere uygun eğitim videosu bulunamadı</h2>
  @endforelse

  {{ $tutorials->appends([
    'search'   => request()->search,
    'category' => request()->category,
    'per_page' => request()->per_page,
  ])->links() }}
  
@endsection

@section('scripts')
  <script type="text/javascript">
    deleteItem("tutorial", "isimli eğitim videosunu silmek istediğinize emin misiniz?");
  </script>
@endsection