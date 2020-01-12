@extends('admin.parent')

@section('title', 'Tanılar')

@section('header')
    <section class="content-header">
        <h1>
            Tanılar
            <small>Sayfa {{ $diagnosises->currentPage() . "/" . $diagnosises->lastPage() }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
            <li class="active">Tanılar</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            @component('admin.partials.box.default')
                @slot('title', "{$diagnosises->total()} Tanı")

                @slot('search', true)

                @slot('filters')

                    {{-- ROW PER PAGE --}}
                    @include('admin.partials.selectors.page')

                    {{-- OTHER BUTTONS --}}
                    <a class="btn btn-filter btn-primary" target="_blank" href="javascript:;" filter-param="download"
                       filter-value="true"><i class="fa fa-download"></i></a>
                    @can('create', App\Models\Diagnosis::class)
                        <a href="{{ route('admin.diagnosis.create') }}" class="btn btn-success"><i
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
                            @forelse ($diagnosises as $diagnosis)
                                <tr id="diagnosis-{{ $diagnosis->id }}">
                                    <td>{{ $diagnosis->id }}</td>
                                    <td>{{ $diagnosis->name }}</td>
                                    <td>{{ $diagnosis->desc }}</td>
                                    <td>
                                        <div class="btn-group">
                                            @can('update', $diagnosis)
                                                <a class="edit btn btn-warning btn-xs"
                                                   href="{{ route("admin.diagnosis.edit", $diagnosis->id) }}">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                            @endcan
                                            @can('delete', $diagnosis)
                                                <a class="delete btn btn-danger btn-xs"
                                                   delete-id="{{ $diagnosis->id }}" delete-name="{{ $diagnosis->name }}"
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
                    {{ $diagnosises->appends([
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
        deleteItem("diagnosis", "isimli tanıyı silmek istediğinize emin misiniz?");
    </script>
@endsection

