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
                  <td itemprop="id">{{ $user->id }}</td>
                  <td itemprop="name">{{ $user->full_name }}</td>
                  <td itemprop="faculty">{{ $user->faculty->name }}</td>
                  <td itemprop="role">{{ $user->role_display }}</td>
                  <td itemprop="email">{{ $user->email }}</td>
                  <td itemprop="mobile">{{ $user->mobile }}</td>
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
                      <button 
                          class="role btn btn-primary btn-xs"
                          item-id="{{ $user->id }}" title="Görev Seç">
                          <i class="fa fa-briefcase"></i>
                      </button>  
                      <a class="delete btn btn-danger btn-xs" delete-id="{{ $user->id }}" delete-name="{{ $user->mobile }}" href="javascript:;" title="Sil">
                        <i class="fa fa-trash"></i>
                      </a>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="9">Üye bulunmamaktadır.</td>
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
  var roles = {!! json_encode(App\Models\Role::toSelect('Yeni Görev', null)) !!}

  function selectRole(slug, roles, buttonClass = "role") {
    $('.' + buttonClass).on('click', function (e) {
      var id = $(this).attr('item-id');
      var row = "#" + slug + "-" + id;
      var name = $(row).children('[itemprop=name]').html();
      var role = $(row).children('[itemprop=role]').html();
      swal({
        title: "Üye Yetkilendirme",
        html: "<h3><strong>Ad:</strong> " + name + "</h3>" +
              "<h3><strong>Aktif Görev:</strong> " + role + "</h3>",
        input: 'select',
        inputOptions: roles,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Değiştir!",
        showCancelButton: true,
        cancelButtonText: "İptal",
        showLoaderOnConfirm: true,
        onOpen: function() {
          $('.swal2-select').select2({
            minimumResultsForSearch: Infinity,
            dropdownCss: { 'z-index':9999999 }
          });
        },
        preConfirm: function (role) {
          return new Promise(function (resolve, reject) {
            if (role) {
              $.ajax({
                url: "/admin/" + slug + "/" + id,
                method: "PUT",
                data: { role: role}
              })
              .done(function(response){
                  resolve(response)
              })
              .fail(function (xhr, ajaxOptions, thrownError) {
                  ajaxError(xhr, ajaxOptions, thrownError);
              });
            } else {
                reject('Yeni görev seçmeniz gerekiyor')
            }
          });
        },
        allowOutsideClick: false,
      }).then(function (response) {
        $(row).children('[itemprop=role]').text(response.data.role)
      })
    });
  }
    selectRole('user', roles)
    approveItem('user',
      'isimli üyeyinin hesabını onaylamak istediğinize emin misiniz?',
      'isimli üyeyinin hesabının onayını kaldırmak istediğinize emin misiniz'
    );
    deleteItem("user", "numaralı bağışçıyı silmek istediğinize emin misiniz?");
  </script>
@endsection
