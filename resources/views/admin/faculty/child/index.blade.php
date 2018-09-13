@extends('admin.parent')

@section('title', 'Fakülte Çocukları')

@section('header')
    <section class="content-header">
        <h1>
            {{ $faculty->full_name }} Çocukları
            <small>Sayfa {{ $children->currentPage() . "/" . $children->lastPage() }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
            <li class="active">{{ $faculty->full_name }} Çocukları</li>
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
                    <a href="{{ route('admin.child.create') }}" class="btn btn-success"><i class="fa fa-plus"></i></a>
                @endslot

                @slot('body')
                    @component('admin.partials.box.table')
                        @slot('head')
                            <th>ID</th>
                            <th>İsim</th>
                            <th>Departman</th>
                            <th>Tanı</th>
                            <th>Dilek</th>
                            <th>Doğumgünü</th>
                            <th>Tanışma</th>
                            <th>Hediye</th>
                            <th>Sorumlular</th>
                            <th class="three-button">İşlem</th>
                        @endslot

                        @slot('body')
                            @forelse($children as $child)
                                <tr id="child-{{ $child->id }}">
                                    <td itemprop="id">{{ $child->id }}</td>
                                    <td itemprop="name">{{ $child->full_name }}</td>
                                    <td class="long-column">{{ $child->department }}</td>
                                    <td>{{ $child->diagnosis }}</td>
                                    <td class="long-column">{{ $child->wish }}</td>
                                    <td>{{ $child->birthday_human }}</td>
                                    <td>{{ $child->meeting_day_human }}</td>
                                    <td itemprop="gift_state">{!! $child->gift_state_label !!}</td>
                                    <td class="long-column">{!! $child->users->implode('full_name', ', ') !!}</td>
                                    <td>
                                        <div class="btn-group">
                                            @can('list faculty children detail')
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

                                            @elsecan('list faculty children basic')
                                                @role(App\Enums\UserRole::Relation)
                                                <button class="process-btn btn btn-default btn-sm"
                                                        process-type="{{ App\Enums\ProcessType::VolunteerFound }}">
                                                    Gönüllü bulundu
                                                </button>
                                                @endrole
                                                @role(App\Enums\UserRole::Website)
                                                <a class="post btn btn-default btn-sm"
                                                   href="{{ route("admin.child.post.index", $child->id) }}">
                                                    Yazılarını göster </a>
                                                @endrole
                                                @role(App\Enums\UserRole::Gift)
                                                <button class="process-btn btn btn-default btn-sm"
                                                        process-type="{{ App\Enums\ProcessType::GiftArrived }}">
                                                    Hediyesi geldi
                                                </button>
                                                @endrole
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10">Çocuk bulunmamaktadır.</td>
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
        var processMessages = {
            4: "isimli çocuğumuzun gönüllüsünün bulunduğuna emin misiniz?",
            6: "isimli çocuğumuzun hediyesinin geldiğinden emin misiniz?"
        };

        deleteItem("child", "isimli çocuğu silmek istediğinize emin misiniz?");
        $('.process-btn').on('click', function () {
            var row = $(this).closest('tr');
            var id = row.find('td[itemprop=id]').text();
            var name = row.find('td[itemprop=name]').text();
            var type = $(this).attr('process-type');
            swal({
                title: "Emin misin?",
                text: "'" + name + "' " + processMessages[type],
                type: "warning",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Evet, eminim!",
                showCancelButton: true,
                cancelButtonText: "Hayır",
                showLoaderOnConfirm: true,
                preConfirm: function () {
                    return new Promise(function (resolve, reject) {
                        $.ajax({
                            url: "/admin/child/" + id + "/process",
                            method: "POST",
                            data: {type: type},
                            success: function (response) {
                                resolve(response)
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                ajaxError(xhr, ajaxOptions, thrownError);
                            }
                        });
                    })
                },
                allowOutsideClick: false,
            }).then(function (response) {
                row.find('td[itemprop=gift_state]').html(response.label);
            })
        });
    </script>
@endsection
