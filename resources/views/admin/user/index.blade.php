@extends('admin.parent')

@section('title', 'Tüm Üyeler')

@section('header')
  <section class="content-header">
    <h1>
      Tüm Üyeler
      <small>Sayfa {{ $users->currentPage() . "/" . $users->lastPage() }}</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
      <li class="active">Üyeler</li>
    </ol>
  </section>
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12">
      @component('admin.partials.box.default')
        @slot('title', "{$users->total()} Üye")
  
        @slot('search', true)
    
        @slot('filters')
          {{-- ROLE SELECTOR --}}
          @include('admin.partials.selectors.role')

          {{-- FACULTY SELECTOR --}}
          @include('admin.partials.selectors.faculty')

          {{-- APPROVAL SELECTOR --}}
          @include('admin.partials.selectors.approval')

          {{-- ROW PER PAGE --}}
          @include('admin.partials.selectors.page')

          {{-- OTHER BUTTONS --}}
          <a class="btn btn-filter btn-primary" target="_blank"  href="javascript:;" filter-param="download" filter-value="true"><i class="fa fa-download"></i></a>
          <a href="{{ route('admin.user.create') }}" class="btn btn-success"><i class="fa fa-plus"></i></a>
        @endslot
  
        @slot('body')
          @component('admin.partials.box.table')
            @slot('head')
              <th>ID</th>
              <th>Ad Soyad</th>
              <th>Fakülte</th>
              <th>Görev</th>
              <th>E-posta</th>
              <th>Telefon</th>
              <th>Doğumgünü</th>
              <th>Yıl</th>
              <th class="seven-button">İşlem</th>
            @endslot

            @slot('body')
              @forelse($users as $user)
                <tr id="user-{{ $user->id }}"
                  class="{{ $user->isApproved() ? 'success' : 'warning' }}">
                  <td>{{ $user->id }}</td>
                  <td>{{ $user->full_name }}</td>
                  <td>{{ $user->faculty->name }}</td>
                  <td>{{ $user->role_display }}</td>
                  <td>{{ $user->email }}</td>
                  <td>{{ $user->mobile }}</td>
                  <td>{{ $user->birthday_label }}</td>
                  <td>{{ $user->year }}</td>
                  <td>
                    <div class="btn-group">
                      <button id="approval-user-{{ $user->id }}" 
                        class="approval btn btn-default btn-xs"
                        approval-id="{{ $user->id }}" approval-name="{{ $user->full_name }}" approved="{{ (int) $user->isApproved() }}">
                        <i class="fa fa-square-o"></i>
                      </button>
                      <a class="edit btn btn-warning btn-xs" href="{{ route("admin.user.edit", $user->id) }}"  title="Düzenle">
                        <i class="fa fa-pencil"></i>
                      </a>
                      <a class="delete btn btn-danger btn-xs" delete-id="{{ $user->id }}" delete-name="{{ $user->mobile }}" href="javascript:;" title="Sil">
                        <i class="fa fa-trash"></i>
                      </a>
                    </div>                      
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6">Üye bulunmamaktadır.</td>
                </tr>
              @endforelse
            @endslot
          @endcomponent
        @endslot

        @slot('footer')
          {{ $users->appends([
              'search'     => request()->search,
              'per_page'   => request()->per_page,
              'user_type' => request()->user_type,
              'rh'         => request()->rh,
              'city'       => request()->city,
          ])->links() }}
        @endslot
      @endcomponent
    </div>
  </div>
@endsection

@section('scripts')
  <script type="text/javascript">
    approveItem('user',
      'isimli üyeyinin hesabını onaylamak istediğinize emin misiniz?',
      'isimli üyeyinin hesabının onayını kaldırmak istediğinize emin misiniz'
    );
    deleteItem("user", "numaralı bağışçıyı silmek istediğinize emin misiniz?");
  </script>
@endsection
