@extends('admin.profile.profile')

@section('title', 'Çocuklarım')

@section('styles')
@endsection

@section('header')
    <section class="content-header">
        <h1>
            Profilim
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
            <li><a href="{{ route('admin.profile.show') }}"> Profilim</a></li>
            <li class="active">Çocuklarım</li>
        </ol>
    </section>
@endsection

@section('profileContent')
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
                    <th class="two-button">İşlem</th>
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

@endsection
