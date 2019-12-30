@extends('admin.parent')

@section('title', 'Tüm Kan Bağışçıları')

@section('header')
    <section class="content-header">
        <h1>
            Tüm Kan Bağışçıları
            <small>Sayfa {{ $bloods->currentPage() . "/" . $bloods->lastPage() }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
            <li class="active">Kan Bağışçıları</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            @component('admin.partials.box.default')
                @slot('title', "{$bloods->total()} Kan Bağışçısı")

                @slot('search', true)

                @slot('filters')
                    {{-- TYPE SELECTOR --}}
                    @include('admin.partials.selectors.default', [
                      'selector' => [
                        'id'        => 'blood-type-selector',
                        'class'     => 'btn-default',
                        'icon'      => 'fa fa-tint',
                        'current'   => request()->blood_type,
                        'values'    => [
                          ""   => "Hepsi",
                          "A"  => "A",
                          "B"  => "B",
                          "AB" => "AB",
                          "0"  => "0"
                        ],
                        'default'   => 'Kan Grubu',
                        'parameter' => 'blood_type'
                      ]
                    ])

                    {{-- RH SELECTOR --}}
                    @include('admin.partials.selectors.default', [
                        'selector' => [
                            'id'        => 'rh-selector',
                            'class'     => 'btn-default',
                            'icon'      => 'fa fa-check-circle-o',
                            'current'   => request()->rh,
                            'values'    => [
                                ""  => "Hepsi",
                                "1" => "Pozitif",
                                "0" => "Negatif",
                            ],
                            'default'   => 'RH',
                            'parameter' => 'rh'
                        ]
                    ])

                    {{-- CITY SELECTOR --}}
                    @include('admin.partials.selectors.city')

                    {{-- ROW PER PAGE --}}
                    @include('admin.partials.selectors.page')

                    {{-- OTHER BUTTONS --}}
                    <a class="btn btn-filter btn-primary" target="_blank" href="javascript:;" filter-param="download"
                       filter-value="true">
                        <i class="fa fa-download"></i>
                    </a>
                    @can('create', App\Models\Blood::class)
                        <a href="{{ route('admin.blood.create') }}" class="btn btn-success">
                            <i class="fa fa-plus"></i>
                        </a>
                    @endcan
                @endslot

                @slot('body')
                    @component('admin.partials.box.table')
                        @slot('head')
                            <th>ID</th>
                            <th>Grup</th>
                            <th>Rh</th>
                            <th>Telefon</th>
                            <th>Şehir</th>
                            <th class="two-button">İşlem</th>
                        @endslot

                        @slot('body')
                            @forelse($bloods as $blood)
                                <tr id="blood-{{ $blood->id }}">
                                    <td>{{ $blood->id }}</td>
                                    <td>{{ $blood->blood_type }}</td>
                                    <td>{{ $blood->rh }}</td>
                                    <td>{{ $blood->mobile_formatted }}</td>
                                    <td>{{ $blood->city }}</td>
                                    <td>
                                        <div class="btn-group">
                                            @can('update', $blood)
                                                <a class="edit btn btn-warning btn-xs"
                                                   href="{{ route("admin.blood.edit", $blood->id) }}">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                            @endcan
                                            @can('delete', $blood)
                                                <a class="delete btn btn-danger btn-xs" delete-id="{{ $blood->id }}"
                                                   delete-name="{{ $blood->mobile }}" href="javascript:;">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">Kan bağışçısı bulunmamaktadır.</td>
                                </tr>
                            @endforelse
                        @endslot
                    @endcomponent
                @endslot

                @slot('footer')
                    {{ $bloods->appends(App\Filters\BloodFilter::getAppends())->links() }}
                @endslot
            @endcomponent
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        deleteItem("blood", "numaralı bağışçıyı silmek istediğinize emin misiniz?");
    </script>
@endsection
