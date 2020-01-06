@extends('admin.parent')

@section('title', 'Tüm Gönüllüler')

@section('header')
    <section class="content-header">
        <h1>
            Tüm Gönüllüler
            <small>Sayfa {{ $volunteers->currentPage() . "/" . $volunteers->lastPage() }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
            <li class="active">Gönüllüler</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            @component('admin.partials.box.default')
                @slot('title', "{$volunteers->total()} Gönüllü")

                @slot('search', true)

                @slot('filters')
                    {{-- CITY SELECTOR --}}
                    @include('admin.partials.selectors.city')

                    {{-- ROW PER PAGE --}}
                    @include('admin.partials.selectors.page')

                    {{-- OTHER BUTTONS --}}
                    <a class="btn btn-filter btn-primary" target="_blank" href="javascript:" filter-param="download"
                       filter-value="true"><i class="fa fa-download"></i></a>
                    <a href="{{ route('admin.volunteer.create') }}" class="btn btn-success"><i
                                class="fa fa-plus"></i></a>
                @endslot

                @slot('body')
                    @component('admin.partials.box.table')
                        @slot('head')
                            <th>ID</th>
                            <th>Ad Soyad</th>
                            <th>E-posta</th>
                            <th>Telefon</th>
                            <th>Şehir</th>
                            <th>Hediye Sayısı</th>
                            <th>Sohbet Sayısı</th>
                            <th class="three-button">İşlem</th>
                        @endslot

                        @slot('body')
                            @forelse($volunteers as $volunteer)
                                <tr id="volunteer-{{ $volunteer->id }}">
                                    <td itemprop="id">{{ $volunteer->id }}</td>
                                    <td itemprop="name">{{ $volunteer->full_name }}</td>
                                    <td itemprop="email">{{ $volunteer->email }}</td>
                                    <td itemprop="mobile">{{ $volunteer->mobile }}</td>
                                    <td>{{ $volunteer->city }}</td>
                                    <td>{{ $volunteer->children_count }}</td>
                                    <td>{{ $volunteer->chats_count }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a class="show btn btn-primary btn-xs"
                                               href="{{ route("admin.volunteer.show", $volunteer->id) }}"
                                               title="Görüntüle">
                                                <i class="fa fa-search"></i>
                                            </a>
                                            <a class="edit btn btn-warning btn-xs"
                                               href="{{ route("admin.volunteer.edit", $volunteer->id) }}"
                                               title="Düzenle">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a class="delete btn btn-danger btn-xs" delete-id="{{ $volunteer->id }}"
                                               delete-name="{{ $volunteer->full_name }}" href="javascript:" title="Sil">
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
                    {{ $volunteers->appends(App\Filters\VolunteerFilter::getAppends())->links() }}
                @endslot
            @endcomponent
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        deleteItem("volunteer", "isimli gönüllüyü silmek istediğinize emin misiniz?");
    </script>
@endsection