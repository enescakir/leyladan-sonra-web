@extends('admin.layouts.app')

@section('title', 'Dilek Kategorileri')

@section('header')
    <section class="content-header">
        <h1>
            Dilek Kategorileri
            <small>Sayfa {{ $categories->currentPage() . "/" . $categories->lastPage() }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
            <li class="active">Dilek Kategorileri</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            @component('admin.partials.box.default')
                @slot('title', "{$categories->total()} Kategori")

                @slot('search', true)

                @slot('filters')

                    {{-- ROW PER PAGE --}}
                    @include('admin.partials.selectors.page')

                    {{-- OTHER BUTTONS --}}
                    <a class="btn btn-filter btn-primary" target="_blank" href="javascript:;" filter-param="download"
                       filter-value="true"><i class="fa fa-download"></i></a>
                    @can('create', App\Models\WishCategory::class)
                        <a href="{{ route('admin.wish-category.create') }}" class="btn btn-success"><i
                                    class="fa fa-plus"></i></a>
                    @endcan
                @endslot

                @slot('body')
                    @component('admin.partials.box.table')
                        @slot('head')
                            <th>ID</th>
                            <th>Ad</th>
                            <th>Açıklama</th>
                            <th class="two-button">İşlem</th>
                        @endslot

                        @slot('body')
                            @forelse ($categories as $category)
                                <tr id="wish-category-{{ $category->id }}">
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->desc }}</td>
                                    <td>
                                        <div class="btn-group">
                                            @can('update', $category)
                                                <a class="edit btn btn-warning btn-xs"
                                                   href="{{ route("admin.wish-category.edit", $category->id) }}">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                            @endcan
                                            @can('delete', $category)
                                                <a class="delete btn btn-danger btn-xs"
                                                   delete-id="{{ $category->id }}" delete-name="{{ $category->name }}"
                                                   href="javascript:;">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                @include('admin.partials.noDataRow')
                            @endforelse
                        @endslot
                    @endcomponent
                @endslot

                @slot('footer')
                    {{ $categories->appends([
                        'search'   => request()->search,
                        'per_page' => request()->per_page
                    ])->links() }}
                @endslot
            @endcomponent
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        deleteItem("wish-category", "isimli kategoriyi silmek istediğinize emin misiniz?");
    </script>
@endsection

