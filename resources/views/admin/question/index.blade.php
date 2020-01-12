@extends('admin.layouts.app')

@section('title', 'Sıkça Sorulan Sorulan')

@section('header')
    <section class="content-header">
        <h1>
            Sıkça Sorulan Sorulan
            <small>Sayfa {{ $questions->currentPage() . "/" . $questions->lastPage() }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
            <li class="active">Sıkça Sorulan Sorulan</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            @component('admin.partials.box.default')
                @slot('title', "{$questions->total()} Soru")

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
                          1  => "Sıralama 1",
                          2  => "Sıralama 2",
                          3  => "Sıralama 3",
                          4  => "Sıralama 4",
                          5  => "Sıralama 5",
                          6  => "Sıralama 6",
                          7  => "Sıralama 7",
                          8  => "Sıralama 8",
                          9  => "Sıralama 9",
                          10 => "Sıralama 10"
                        ],
                        'default'   => 'Sırlama',
                        'parameter' => 'order'
                      ]
                    ])

                    {{-- ROW PER PAGE --}}
                    @include('admin.partials.selectors.page')

                    {{-- OTHER BUTTONS --}}
                    <a class="btn btn-filter btn-primary" target="_blank" href="javascript:;" filter-param="download"
                       filter-value="true"><i class="fa fa-download"></i></a>
                    <a href="{{ route('admin.question.create') }}" class="btn btn-success"><i
                                class="fa fa-plus"></i></a>
                @endslot

                @slot('body')
                    @component('admin.partials.box.table')
                        @slot('head')
                            <th>ID</th>
                            <th>Soru</th>
                            <th>Cevap</th>
                            <th>Sıralama</th>
                            <th class="two-button">İşlem</th>
                        @endslot

                        @slot('body')
                            @forelse ($questions as $question)
                                <tr id="question-{{ $question->id }}">
                                    <td>{{ $question->id }}</td>
                                    <td>{{ $question->text }}</td>
                                    <td>{!! $question->answer !!}</td>
                                    <td>{{ $question->order }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a class="edit btn btn-warning btn-xs"
                                               href="{{ route("admin.question.edit", $question->id) }}">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a class="delete btn btn-danger btn-xs"
                                               delete-id="{{ $question->id }}" delete-name="{{ $question->name }}"
                                               href="javascript:;">
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
                    {{ $questions->appends([
                        'search'   => request()->search,
                        'order'    => request()->order,
                        'per_page' => request()->per_page
                    ])->links() }}
                @endslot
            @endcomponent
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        deleteItem("question", "sorusunu silmek istediğinize emin misiniz?");
    </script>
@endsection

