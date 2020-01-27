@extends('admin.layouts.app')

@section('title', 'Tüm Kan Bağışı Mesajları')

@section('header')
    <section class="content-header">
        <h1>
            Tüm Kan Bağışı Mesajları
            <small>Sayfa {{ $messages->currentPage() . "/" . $messages->lastPage() }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
            <li class="active">Kan Bağışı Mesajları</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            @component('admin.partials.box.default')
                @slot('title', "{$messages->total()} Kan Bağışı Mesajı")

                @slot('search', true)

                @slot('filters')
                    {{-- TYPE SELECTOR --}}
                    @include('admin.partials.selectors.default', [
                      'selector' => [
                        'id'        => 'sender-selector',
                        'class'     => 'btn-default',
                        'icon'      => 'fa fa-user',
                        'current'   => request()->sent_by,
                        'values'    => $senders,
                        'default'   => 'Gönderen',
                        'parameter' => 'sent_by',
                        'menu_class' => 'scrollable-menu'
                      ]
                    ])

                    {{-- ROW PER PAGE --}}
                    @include('admin.partials.selectors.page')

                    {{-- OTHER BUTTONS --}}
                    <a class="btn btn-filter btn-primary" target="_blank" href="javascript:;" filter-param="download"
                       filter-value="true"><i class="fa fa-download"></i></a>
                    <a href="{{ route('admin.blood.sms.show') }}" class="btn btn-success"><i
                                class="fa fa-paper-plane"></i></a>
                @endslot

                @slot('body')
                    @component('admin.partials.box.table')
                        @slot('head')
                            <th>ID</th>
                            <th>Gönderen</th>
                            <th>Kişi Sayısı</th>
                            <th>Mesaj</th>
                        @endslot

                        @slot('body')
                            @forelse($messages as $message)
                                <tr id="message-{{ $message->id }}">
                                    <td>{{ $message->id }}</td>
                                    <td>{{ $message->sender->full_name ?? '-' }}</td>
                                    <td>{{ $message->receiver_count }}</td>
                                    <td class="post-column">{{ $message->message }}</td>
                                </tr>
                            @empty
                                    @include('admin.partials.noDataRow')
                            @endforelse
                        @endslot
                    @endcomponent
                @endslot

                @slot('footer')
                    {{ $messages->appends([
                        'search'     => request()->search,
                        'per_page'   => request()->per_page,
                        'sent_by' => request()->sent_by
                    ])->links() }}
                @endslot
            @endcomponent
        </div>
    </div>
@endsection