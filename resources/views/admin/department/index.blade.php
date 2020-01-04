@extends('admin.parent')

@section('title', 'Departmanlar')

@section('header')
    <section class="content-header">
        <h1>
            Departmanlar
            <small>Sayfa {{ $departments->currentPage() . "/" . $departments->lastPage() }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
            <li class="active">Departmanlar</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            @component('admin.partials.box.default')
                @slot('title', "{$departments->total()} Departman")

                @slot('search', true)

                @slot('filters')

                    {{-- ROW PER PAGE --}}
                    @include('admin.partials.selectors.page')

                    {{-- OTHER BUTTONS --}}
                    <a class="btn btn-filter btn-primary" target="_blank" href="javascript:;" filter-param="download"
                       filter-value="true"><i class="fa fa-download"></i></a>
                    <a href="{{ route('admin.department.create') }}" class="btn btn-success"><i class="fa fa-plus"></i></a>
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
                            @forelse ($departments as $department)
                                <tr id="department-{{ $department->id }}">
                                    <td>{{ $department->id }}</td>
                                    <td>{{ $department->name }}</td>
                                    <td>{{ $department->desc }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a class="edit btn btn-warning btn-xs"
                                               href="{{ route("admin.department.edit", $department->id) }}">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a class="delete btn btn-danger btn-xs"
                                               delete-id="{{ $department->id }}" delete-name="{{ $department->name }}"
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
                    {{ $departments->appends([
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
        deleteItem("department", "isimli departmanı silmek istediğinize emin misiniz?");
    </script>
@endsection
