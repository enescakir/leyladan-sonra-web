@extends('admin.parent')

@section('title', 'Tüm Çocuklar')

@section('styles')
    <style>
    </style>
@endsection

@section('header')
    <section class="content-header">
        <h1>
            Tüm Çocuklar
            <small>Sayfa {{ $children->currentPage() . "/" . $children->lastPage() }}</small>
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
            @component('admin.partials.box.default')
                @slot('title', "{$children->total()} Çocuk")

                @slot('search', true)

                @slot('filters')
                    {{-- FACULTY SELECTOR --}}
                    @include('admin.partials.selectors.faculty')

                    {{-- DEPARTMENT SELECTOR --}}
                    @include('admin.partials.selectors.department')

                    {{-- DIAGNOSIS SELECTOR --}}
                    @include('admin.partials.selectors.diagnosis')

                    {{-- POST STATUS SELECTOR --}}
                    @include('admin.partials.selectors.postStatus')

                    {{-- GIFT STATUS SELECTOR --}}
                    @include('admin.partials.selectors.giftStatus')

                    {{-- ROW PER PAGE --}}
                    @include('admin.partials.selectors.page')

                    {{-- OTHER BUTTONS --}}
                    <a class="btn btn-filter btn-primary" target="_blank" href="javascript:;" filter-param="download"
                       filter-value="true"><i class="fa fa-download"></i></a>
                @endslot

                @slot('body')
                    @component('admin.partials.box.table')
                        @slot('head')
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
                        @endslot

                        @slot('body')
                            @forelse($children as $child)
                                <tr id="child-{{ $child->id }}">
                                    <td>{{ $child->id }}</td>
                                    <td>{{ $child->full_name }}</td>
                                    <td>{{ $child->faculty->name }}</td>
                                    <td>{{ $child->department }}</td>
                                    <td class="long-column">{{ $child->diagnosis }}</td>
                                    <td class="long-column">{{ $child->wish }}</td>
                                    <td>{{ $child->birthday_human }}</td>
                                    <td>{{ $child->meeting_day_human }}</td>
                                    <td>{!! $child->gift_state_label !!}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a class="show btn btn-primary btn-xs"
                                               href="{{ route("admin.child.show", $child->id) }}">
                                                <i class="fa fa-search"></i>
                                            </a>
                                            <a class="edit btn btn-warning btn-xs"
                                               href="{{ route("admin.child.edit", $child->id) }}">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a class="delete btn btn-danger btn-xs" delete-id="{{ $child->id }}"
                                               delete-name="{{ $child->full_name }}" href="javascript:"><i
                                                        class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9">Çocuk bulunmamaktadır.</td>
                                </tr>
                            @endforelse
                        @endslot
                    @endcomponent
                @endslot

                @slot('footer')
                    {{ $children->appends(App\Filters\ChildFilter::getAppends())->links() }}
                @endslot
            @endcomponent
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        deleteItem("child", "isimli çocuğu silmek istediğinize emin misiniz?");
    </script>
@endsection
