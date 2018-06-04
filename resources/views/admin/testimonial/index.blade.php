@extends('admin.parent')

@section('title', 'Tüm Referanslar')

@section('header')
  <section class="content-header">
    <h1>
      Tüm Referanslar
      <small>Sayfa {{ $testimonials->currentPage() . "/" . $testimonials->lastPage() }}</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
      <li class="active">Referanslar</li>
    </ol>
  </section>
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12">
      @component('admin.partials.box.default')
        @slot('title', "{$testimonials->total()} Referans")
  
        @slot('search', true)
    
        @slot('filters')
          {{-- PRIORITY SELECTOR --}}
          @include('admin.partials.selectors.default', [
            'selector' => [
              'id'        => 'priority-selector',
              'class'     => 'btn-default',
              'icon'      => 'fa fa-sort-amount-asc',
              'current'   => request()->priority,
              'values'    => [
                "" => "Hepsi",
                1  => "Öncelik 1",
                2  => "Öncelik 2",
                3  => "Öncelik 3",
                4  => "Öncelik 4",
                5  => "Öncelik 5",
                6  => "Öncelik 6",
                7  => "Öncelik 7",
                8  => "Öncelik 8",
                9  => "Öncelik 9",
                10 => "Öncelik 10"
              ],
              'default'   => 'Öncelik',
              'parameter' => 'priority'
            ]
          ])
          @include('admin.partials.selectors.default', [
            'selector' => [
              'id'        => 'via-selector',
              'class'     => 'btn-default',
              'icon'      => 'fa fa-cloud',
              'current'   => request()->via,
              'values'    => $sources,
              'default'   => 'Kaynak',
              'parameter' => 'via'
            ]
          ])

          {{-- ROW PER PAGE --}}
          @include('admin.partials.selectors.page')

          {{-- OTHER BUTTONS --}}
          <a class="btn btn-filter btn-primary" target="_blank"  href="javascript:;" filter-param="download" filter-value="true"><i class="fa fa-download"></i></a>
          <a href="{{ route('admin.testimonial.create') }}" class="btn btn-success"><i class="fa fa-plus"></i></a>
        @endslot
  
        @slot('body')
          @component('admin.partials.box.table')
            @slot('head')
              <th>ID</th>
              <th>Ad</th>
              <th>E-posta</th>
              <th>Öncelik</th>
              <th>Kaynak</th>
              <th>Yazı</th>
              <th class="three-button">İşlem</th>
            @endslot

            @slot('body')
              @forelse ($testimonials as $testimonial)
                <tr id="testimonial-{{ $testimonial->id }}">
                  <td>{{ $testimonial->id }}</td>
                  <td>{{ $testimonial->name }}</td>
                  <td>{{ $testimonial->email }}</td>
                  <td>{{ $testimonial->priority }}</td>
                  <td>{{ $testimonial->via }}</td>
                  <td>{{ $testimonial->text }}</td>
                  <td>
                    <div class="btn-group">
                      <button id="approve-testimonial-{{ $testimonial->id }}"
                        class="approve btn btn-default btn-xs @if($testimonial->isApproved()) hidden @endif"
                        approve-id="{{ $testimonial->id }}" approve-name="{{ $testimonial->name }}" is-approve="1"
                        title="Yayınla">
                        <i class="fa fa-square-o"></i>
                      </button>
                      <button id="unapprove-testimonial-{{ $testimonial->id }}"
                        class="approve btn btn-success btn-xs @unless($testimonial->isApproved()) hidden @endunless"
                        approve-id="{{ $testimonial->id }}" approve-name="{{ $testimonial->name }}" is-approve="0"
                        title="Yayından Çıkar">
                        <i class="fa fa-check-square-o"></i>
                      </button>
                      <a class="edit btn btn-warning btn-xs" href="{{ route("admin.testimonial.edit", $testimonial->id) }}">
                        <i class="fa fa-pencil"></i>
                      </a>
                      <a class="delete btn btn-danger btn-xs"
                        delete-id="{{ $testimonial->id }}" delete-name="{{ $testimonial->name }}" href="javascript:;">
                        <i class="fa fa-trash"></i>
                      </a>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="7">Referans bulunmamaktadır.</td>
                </tr>
              @endforelse
            @endslot
          @endcomponent
        @endslot

        @slot('footer')
          {{ $testimonials->appends([
              'search'   => request()->search,
              'per_page' => request()->per_page,
              'priority' => request()->priority,
              'via'      => request()->via,
          ])->links() }}
        @endslot
      @endcomponent
    </div>
  </div>
@endsection

@section('scripts')
  <script type="text/javascript">
    deleteItem("testimonial", "referansını silmek istediğinize emin misiniz?");
    approveItem("testimonial",
      "isimli referansı onaylamak istediğinize emin misiniz?",
      "isimli referansın onayını kaldırmak istediğinize emin misiniz?"
    );
  </script>
@endsection
