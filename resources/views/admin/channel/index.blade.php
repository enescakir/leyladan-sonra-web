@extends('admin.parent')

@section('title', 'Tüm Haber Kanalları')

@section('header')
    <section class="content-header">
        <h1>
            Tüm Haber Kanalları
            <small>Sayfa {{ $channels->currentPage() . "/" . $channels->lastPage() }}</small>
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fa fa-home"></i> Anasayfa</a>
            </li>
            <li class="active">Haber Kanalları</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            @component('admin.partials.box.default')
                @slot('title', "{$channels->total()} Haber Kanalı")

                @slot('search', true)

                @slot('filters')
                    {{-- TYPE SELECTOR --}}
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
                    <a class="btn btn-filter btn-primary" target="_blank" href="javascript:" filter-param="download"
                       filter-value="true"><i class="fa fa-download"></i></a>
                    <a href="{{ route('admin.channel.create') }}" class="btn btn-success"><i class="fa fa-plus"></i></a>
                @endslot

                @slot('body')
                    @component('admin.partials.box.table')
                        @slot('head')
                            <th>ID</th>
                            <th>Ad</th>
                            <th>Kategori</th>
                            <th>Logo</th>
                            <th>Haber Sayısı</th>
                            <th class="three-button">İşlem</th>
                        @endslot

                        @slot('body')
                            @forelse($channels as $channel)
                                <tr id="channel-{{ $channel->id }}">
                                    <td>{{ $channel->id }}</td>
                                    <td>{{ $channel->name }}</td>
                                    <td>{{ $channel->category }}</td>
                                    <td>
                                        <a href="{{ $channel->logo_url }}" target="_blank">
                                            <img class="table-img-sm" src="{{ $channel->thumb_url }}"
                                                 alt="{{ $channel->name }}">
                                        </a>
                                    </td>
                                    <td>{{ $channel->news_count }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a class="btn btn-primary btn-xs"
                                               href="{{ route("admin.new.index", ['channel_id' => $channel->id]) }}">
                                                <i class="fa fa-list"></i>
                                            </a>
                                            <a class="edit btn btn-warning btn-xs"
                                               href="{{ route("admin.channel.edit", $channel->id) }}">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a class="delete btn btn-danger btn-xs" delete-id="{{ $channel->id }}"
                                               delete-name="{{ $channel->name }}" href="javascript:">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">Haber kanalı bulunmamaktadır.</td>
                                </tr>
                            @endforelse
                        @endslot
                    @endcomponent
                @endslot

                @slot('footer')
                    {{ $channels->appends([
                        'search'   => request()->search,
                        'per_page' => request()->per_page,
                        'category' => request()->category,
                    ])->links() }}
                @endslot
            @endcomponent
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        deleteItem("channel", "isimli haber kanalını silmek istediğinize emin misiniz?");
    </script>
@endsection
