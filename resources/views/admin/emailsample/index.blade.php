@extends('admin.parent')

@section('title', 'Tüm E-posta Örnekleri')

@section('header')
    <section class="content-header">
        <h1>
            Tüm E-posta Örnekleri
            <small>Sayfa {{ $samples->currentPage() . "/" . $samples->lastPage() }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
            <li class="active">E-posta Örnekleri</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            @component('admin.partials.box.default')
                @slot('title', "{$samples->total()} E-posta Örneği")

                @slot('search', true)

                @slot('filters')
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

                    {{-- ROW PER PAGE --}}
                    @include('admin.partials.selectors.page')

                    {{-- OTHER BUTTONS --}}
                    <a class="btn btn-filter btn-primary" target="_blank" href="javascript:;" filter-param="download"
                       filter-value="true"><i class="fa fa-download"></i></a>
                    <a href="{{ route('admin.emailsample.create') }}" class="btn btn-success"><i class="fa fa-plus"></i></a>
                @endslot

                @slot('body')
                    @component('admin.partials.box.table')
                        @slot('head')
                            <th>ID</th>
                            <th>Ad</th>
                            <th>Kategori</th>
                            <th>Metin</th>
                            <th>Oluşturan</th>
                            <th class="three-button">İşlem</th>
                        @endslot

                        @slot('body')
                            @forelse ($samples as $sample)
                                <tr id="emailsample-{{ $sample->id }}">
                                    <td>{{ $sample->id }}</td>
                                    <td>{{ $sample->name }}</td>
                                    <td>{{ $sample->category }}</td>
                                    <td class="clipboard-text"
                                        data-clipboard-text="{{ $sample->text }}">{!!  $sample->formatted_text !!}</td>
                                    <td>{{ $sample->creator->full_name ?? "-" }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="clipboard-text btn btn-primary btn-xs"
                                                    data-clipboard-text="{{ $sample->text }}"><i class="fa fa-copy"></i>
                                            </button>
                                            <a class="edit btn btn-warning btn-xs"
                                               href="{{ route("admin.emailsample.edit", $sample->id) }}">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a class="delete btn btn-danger btn-xs"
                                               delete-id="{{ $sample->id }}" delete-name="{{ $sample->name }}"
                                               href="javascript:">
                                                <i class="fa fa-trash"></i>
                                            </a>
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
                    {{ $samples->appends([
                        'search'   => request()->search,
                        'category' => request()->category,
                        'per_page' => request()->per_page,
                    ])->links() }}
                @endslot
            @endcomponent
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        deleteItem("emailsample", "isimli e-posta örneğini silmek istediğinize emin misiniz?");
    </script>
@endsection