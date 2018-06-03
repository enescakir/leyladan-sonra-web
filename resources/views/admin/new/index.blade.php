@extends('admin.parent')

@section('title', 'Tüm Haberler')

@section('header')
  <section class="content-header">
    <h1>
      Tüm Haberler
      <small>Sayfa {{ $news->currentPage() . "/" . $news->lastPage() }}</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
      <li class="active">Haberler</li>
    </ol>
  </section>
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12">
      @component('admin.partials.box.default')
        @slot('title', "{$news->total()} Haber")
  
        @slot('search', true)
    
        @slot('filters')

          {{-- ROW PER PAGE --}}
          @include('admin.partials.selectors.page')

          {{-- OTHER BUTTONS --}}
          <a class="btn btn-filter btn-primary" target="_blank"  href="javascript:;" filter-param="download" filter-value="true"><i class="fa fa-download"></i></a>
          <a href="{{ route('admin.new.create') }}" class="btn btn-success"><i class="fa fa-plus"></i></a>
        @endslot
  
        @slot('body')
          @component('admin.partials.box.table')
            @slot('head')
              <th>ID</th>
              <th>Ad</th>
              <th>Açıklama</th>
              <th>Kanal</th>
              <th class="three-button">İşlem</th>
            @endslot

            @slot('body')
            @forelse ($news as $new)
              <tr id="new-{{ $new->id }}">
                <td>{{ $new->id }}</td>
                <td>{{ $new->title }}</td>
                <td>{{ $new->desc }}</td>
                <td>{{ $new->channel->name }}</td>
                <td>
                  <div class="btn-group">
                    <a class="edit btn btn-primary btn-xs" target="_blank" href="{{ $new->link }}">
                      <i class="fa fa-globe"></i>
                    </a>
                    <a class="edit btn btn-warning btn-xs" href="{{ route("admin.new.edit", $new->id) }}">
                      <i class="fa fa-pencil"></i>
                    </a>
                    <a class="delete btn btn-danger btn-xs" delete-id="{{ $new->id }}" delete-name="{{ $new->title }}"  href="javascript:;">
                      <i class="fa fa-trash"></i>
                    </a>
                  </div>
              </td>
              </tr>
            @empty
              <tr>
                <td colspan="5">Haber bulunmamaktadır.</td>
              </tr>
            @endforelse

            @endslot
          @endcomponent
        @endslot

        @slot('footer')
          {{ $news->appends([
              'search'     => request()->search,
              'per_page'   => request()->per_page
          ])->links() }}
        @endslot
      @endcomponent
    </div>
  </div>
@endsection


@section('scripts')
  <script type="text/javascript">
    deleteItem("new", "isimli haberi silmek istediğinize emin misiniz?");
  </script>
@endsection
