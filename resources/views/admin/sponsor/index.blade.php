@extends('admin.parent')

@section('title', 'Tüm Destekçiler')

@section('header')
    <section class="content-header">
        <h1>
            Tüm Destekçiler
            <small>Sayfa {{ $sponsors->currentPage() . "/" . $sponsors->lastPage() }}</small>
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
            @component('admin.partials.box.default')
                @slot('title', "{$sponsors->total()} Destekçi")

                @slot('search', true)

                @slot('filters')
                    {{-- ORDER SELECTOR --}}
                    @include('admin.partials.selectors.default', [
                      'selector' => [
                        'id'        => 'order-selector',
                        'class'     => 'btn-default',
                        'icon'      => 'fa fa-sort-amount-asc',
                        'current'   => request()->order,
                        'values'    => [
                          "" => "Hepsi",
                          1  => "Öncelik 1",
                          2  => "Öncelik 2",
                          3  => "Öncelik 3",
                          4  => "Öncelik 4",
                          5  => "Öncelik 5",
                          6  => "Öncelik 6",
                          7  => "Öncelik 7",
                          8  => "Öncelik 8",
                          9  => "Öncelik 9",
                          10 => "Öncelik 10"
                        ],
                        'default'   => 'Öncelik',
                        'parameter' => 'order'
                      ]
                    ])

                    {{-- ROW PER PAGE --}}
                    @include('admin.partials.selectors.page')

                    {{-- OTHER BUTTONS --}}
                    <a class="btn btn-filter btn-primary" target="_blank" href="javascript:;" filter-param="download"
                       filter-value="true"><i class="fa fa-download"></i></a>
                    <a href="{{ route('admin.sponsor.create') }}" class="btn btn-success"><i class="fa fa-plus"></i></a>
                @endslot

                @slot('body')
                    @component('admin.partials.box.table')
                        @slot('head')
                            <th>ID</th>
                            <th>Ad</th>
                            <th>Öncelik</th>
                            <th>Link</th>
                            <th>Logo</th>
                            <th class="three-button">İşlem</th>
                        @endslot

                        @slot('body')
                            @forelse ($sponsors as $sponsor)
                                <tr id="sponsor-{{ $sponsor->id }}">
                                    <td>{{ $sponsor->id }}</td>
                                    <td>{{ $sponsor->name }}</td>
                                    <td>{{ $sponsor->order }}</td>
                                    <td><a href="{{ $sponsor->link }}" target="_blank">{{ $sponsor->link }}</a></td>
                                    <td>
                                        <a href="{{ $sponsor->logo_url }}" target="_blank">
                                            <img class="table-img-sm" src="{{ $sponsor->thumb_url }}"
                                                 alt="{{ $sponsor->name }}">
                                        </a>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a class="edit btn btn-warning btn-xs"
                                               href="{{ route("admin.sponsor.edit", $sponsor->id) }}">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a class="delete btn btn-danger btn-xs" delete-id="{{ $sponsor->id }}"
                                               delete-name="{{ $sponsor->name }}" href="javascript:;"><i
                                                        class="fa fa-trash"></i></a>
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
                    {{ $sponsors->appends([
                        'search'   => request()->search,
                        'order'    => request()->order,
                        'per_page' => request()->per_page,
                    ])->links() }}
                @endslot
            @endcomponent
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        deleteItem("sponsor", "isimli destekçiyi silmek istediğinize emin misiniz?");
    </script>
@endsection