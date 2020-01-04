@extends('admin.parent')

@section('title', 'Tanıtım Materyalleri')

@section('header')
    <section class="content-header">
        <h1>
            Tanıtım Materyalleri
            <small>İndir düğmelerine tıklayarak ilgili materyalin çalışma dosyasını indirebilirsiniz</small>
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fa fa-home"></i> Anasayfa</a>
            </li>
            <li class="active">Tanıtım Materyalleri</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="input-group input-group-sm">
                <input id="search-input" type="text" class="form-control table-search-bar pull-right search-input"
                       name="search" placeholder="Arama"
                       value="{{ request()->search }}">
                <div class="input-group-btn">
                    <button id="search-btn" class="btn btn-default" type="submit">
                        <i class="fa fa-search"></i> Ara
                    </button>
                    {{-- CATEGORY SELECTOR --}}
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
                    <a href="{{ route('admin.material.create') }}" class="btn btn-success"><i
                                class="fa fa-plus"></i></a>
                </div>
            </div>
        </div>
    </div>
    <br>
    @forelse($materials->chunk(4) as $chunk)
        <div class="row">
            @foreach($chunk as $material)
                <div id="material-{{ $material->id }}" class="col-xs-6 col-sm-3">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title"> {{ $material->name }} </h3>
                            <div class="box-tools">
                                <div class="btn-group btn-group-xs">
                                    <a class="edit btn btn-warning btn-xs"
                                       href="{{ route("admin.material.edit", $material->id) }}">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a class="delete btn btn-danger btn-xs" delete-id="{{ $material->id }}"
                                       delete-name="{{ $material->name }}" href="javascript:;">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                    <a class="btn btn-xs btn-success" target="_blank" href="{{ $material->link }}">
                                        <i class="fa fa-download"></i> İndir
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body no-padding text-center">
                            <img class="img-responsive" style="margin:auto" src="{{ $material->image_url }}"
                                 alt="{{ $material->name }}">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @empty
        <div class="text-center">
            <p style="font-size: 80px; line-height: 1; margin: 10px;"><i class="fa fa-exclamation-triangle"></i></p>
            <p style="font-size: 24px;">Aradığınız kriterlerde veri bulunamadı</p>
        </div>
    @endforelse

    {{ $materials->appends([
      'search'   => request()->search,
      'category' => request()->category,
      'per_page' => request()->per_page,
    ])->links() }}

@endsection

@section('scripts')
    <script type="text/javascript">
        deleteItem("material", "isimli tanıtım materyalini silmek istediğinize emin misiniz?");
    </script>
@endsection