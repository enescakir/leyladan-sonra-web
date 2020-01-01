@extends('admin.parent')

@section('title', "{$faculty->full_name} Yazıları")

@section('header')
    <section class="content-header">
        <h1>
            {{ $faculty->full_name }}
            {{ request()->approval != null ? (request()->approval ? 'Onaylanmışlar' : 'Onaylanmamışlar') : ""}}
            {{ request()->type != null ? $postTypes[request()->type] : ""}} Yazıları
            <small>Sayfa {{ $posts->currentPage() . "/" . $posts->lastPage() }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
            <li class="active">{{ $faculty->full_name }} Yazıları</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            @component('admin.partials.box.default')
                @slot('title', "{$posts->total()} Yazı")

                @slot('search', true)

                @slot('filters')
                    {{-- APPROVAL SELECTOR --}}
                    @include('admin.partials.selectors.approval')

                    {{-- POST TYPE SELECTOR --}}
                    @include('admin.partials.selectors.default', [
                      'selector' => [
                        'id'        => 'type-selector',
                        'class'     => 'btn-default',
                        'icon'      => 'fa fa-question-circle',
                        'current'   => request()->type,
                        'values'    => $postTypes,
                        'default'   => 'Yazı Türü',
                        'parameter' => 'type',
                      ]
                    ])

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
                            <th>Çocuğun Adı</th>
                            <th>Tür</th>
                            <th>Fotoğraf</th>
                            <th>Yazı</th>
                            <th>Durumu</th>
                            <th class="three-button">İşlem</th>
                        @endslot

                        @slot('body')
                            @forelse ($posts as $post)
                                <tr id="post-{{ $post->id }}">
                                    <td>{{ $post->id }}</td>
                                    <td>{{ $post->child->full_name ?? "-" }} <strong>({{ $post->child->id ?? "-" }}
                                            )</strong></td>
                                    <td>{{ $post->type }}</td>
                                    <td>
                                        @foreach($post->media->chunk(3) as $chunk)
                                            <div style="display: flex;">
                                                @foreach($chunk as $media)
                                                    <img class="table-img-md" style="margin:2px;"
                                                         src="{{ $media->getUrl('thumb') }}"
                                                         alt="{{ $post->child->full_name ?? "-" }}">
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </td>
                                    <td>{!! $post->text !!}</td>
                                    <td id="post-{{ $post->id }}-status">{!! $post->approval_label !!}</td>
                                    <td>
                                        <div class="btn-group">
                                            @can('approve', $post)
                                                <button id="approval-post-{{ $post->id }}"
                                                        class="approval btn btn-default btn-xs"
                                                        approval-id="{{ $post->id }}"
                                                        approval-name="{{ $post->child->full_name ?? "-" }}-{{ $post->type }}"
                                                        approved="{{ (int) $post->isApproved() }}">
                                                    <i class="fa fa-square-o"></i>
                                                </button>
                                            @endcan
                                            @can('update', $post)
                                                <a class="edit btn btn-warning btn-xs"
                                                   href="{{ route("admin.faculty.post.edit", [$faculty->id, $post->id]) }}">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                            @endcan
                                            @can('delete', $post)
                                                <a class="delete btn btn-danger btn-xs"
                                                   delete-id="{{ $post->id }}"
                                                   delete-name="{{ $post->child->full_name ?? "-" }}-{{ $post->type }}"
                                                   href="javascript:;">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">Çocuk yazısı bulunmamaktadır.</td>
                                </tr>
                            @endforelse

                        @endslot
                    @endcomponent
                @endslot

                @slot('footer')
                    {{ $posts->appends(App\Filters\PostFilter::getAppends())->links() }}
                @endslot
            @endcomponent
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        deleteItem("post", "yazısını silmek istediğinize emin misiniz?");
        approveItem("post",
            "yazısını onaylamak istediğinize emin misiniz? <br> <strong>Onam formunu</strong> kontrol ettiniz mi? <br>Onam formunun hatasız ve eksiksiz olduğunu onaylıyor musunuz?",
            "yazısının onayını kaldırmak istediğinize emin misiniz?",
            function (approval, id) {
                if (approval) {
                    $("#post-" + id + "-status").html('<span class="label label-success"> Onaylandı </span>')
                } else {
                    $("#post-" + id + "-status").html('<span class="label label-danger"> Onaylanmadı </span>')
                }
            }
        );
    </script>
@endsection
