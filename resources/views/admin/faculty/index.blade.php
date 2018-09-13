@extends('admin.parent')

@section('title', "Fakülteler")

@section('header')
    <section class="content-header">
        <h1>
            Fakülteler
            <small>Sayfa {{ $faculties->currentPage() . "/" . $faculties->lastPage() }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
            <li class="active">Fakülteler</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            @component('admin.partials.box.default')
                @slot('title', "{$faculties->total()} Fakülte")

                @slot('search', true)

                @slot('filters')
                    {{-- STATUS SELECTOR --}}
                    @include('admin.partials.selectors.default', [
                        'selector' => [
                            'id'        => 'started-selector',
                            'class'     => 'btn-default',
                            'icon'      => 'fa fa-check-circle-o',
                            'current'   => request()->started,
                            'values'    => [
                                ""  => "Hepsi",
                                true => "Başlayanlar",
                                false => "Görüşülenler",
                            ],
                            'default'   => 'Durum',
                            'parameter' => 'started'
                        ]
                    ])

                    {{-- CITY SELECTOR --}}
                    @include('admin.partials.selectors.city')

                    {{-- ROW PER PAGE --}}
                    @include('admin.partials.selectors.page')

                    {{-- OTHER BUTTONS --}}
                    <a class="btn btn-filter btn-primary" target="_blank" href="javascript:" filter-param="download"
                       filter-value="true"><i class="fa fa-download"></i></a>
                @endslot

                @slot('body')
                    @component('admin.partials.box.table')
                        @slot('head')
                            <th>ID</th>
                            <th>Logo</th>
                            <th>Ad</th>
                            <th>Şehir</th>
                            <th>Çocuk Sayısı</th>
                            <th>Üye Sayısı</th>
                            <th>Durum</th>
                            <th>Yöneticiler</th>
                            <th class="two-button">İşlem</th>
                        @endslot

                        @slot('body')
                            @forelse($faculties as $faculty)
                                <tr id="faculty-{{ $faculty->id }}"
                                    class="{{ $faculty->isStarted() ? 'success' : 'warning' }}">
                                    <td itemprop="id">{{ $faculty->id }}</td>
                                    <td>
                                        <a href="{{ $faculty->logo_url }}" target="_blank">
                                            <img class="table-img-sm" src="{{ $faculty->thumb_url }}"
                                                 alt="{{ $faculty->full_name }}">
                                        </a>
                                    </td>
                                    <td itemprop="name">{{ $faculty->full_name }}</td>
                                    <td itemprop="city">{{ $faculty->city }}</td>
                                    <td>{{ $faculty->children_count }}</td>
                                    <td>{{ $faculty->users_count }}</td>
                                    <td itemprop="started_at">
                                        @if($faculty->isStarted())
                                            <span class="label bg-green">{{ $faculty->started_at_label }}</span>
                                        @else
                                            <span class="label bg-yellow">Görülüşüyor</span>
                                        @endif
                                    </td>
                                    <td>{{ $faculty->managers->implode('full_name', ', ') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a class="show btn btn-primary btn-xs"
                                               href="{{ route("admin.faculty.show", [$faculty->id]) }}" title="Göster">
                                                <i class="fa fa-search"></i>
                                            </a>
                                            <a class="edit btn btn-warning btn-xs"
                                               href="{{ route("admin.faculty.edit", [$faculty->id]) }}" title="Düzenle">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">Fakülte bulunmamaktadır.</td>
                                </tr>
                            @endforelse
                        @endslot
                    @endcomponent
                @endslot

                @slot('footer')
                    {{ $faculties->appends(App\Filters\FacultyFilter::getAppends())->links() }}
                @endslot
            @endcomponent
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
    </script>
@endsection
