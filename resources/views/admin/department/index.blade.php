@extends('admin.parent')

@section('title', 'Departmanlar')
  
@section('header')
  <section class="content-header">
    <h1>
      Departmanlar
      <small>Sistemimize bulunan tüm departmanlara buradan ulaşabilirsiniz</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
      <li class="active">Departmanlar</li>
    </ol>
  </section>
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">{{ count($departments) }} departman</h3>
          <div class="box-tools">
            <div class="btn-group btn-group-sm">
              <button id="create-department" class="btn btn-success">
                <i class="fa fa-plus"></i> Ekle
              </button>
            </div>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
          <table class="table table-striped table-condensed table-bordered">
            <tbody>
              @foreach ($departments as $row)
                <tr>
                  @foreach($row as $department)
                    <td id="department-{{ $department->id }}" class="department" department-id="{{ $department->id }}" department-name="{{ $department->name }}" department-desc="{{ $department->desc }}">
                        {{ $department->name }}
                      @if ($department->desc)
                        <span
                          data-toggle    = "popover"
                          data-trigger   = "hover"
                          data-placement = "top"
                          title          = "{{ $department->name }}"
                          data-content   = "{{ $department->desc }}">
                          <i class="fa fa-question-circle" aria-hidden="true"></i>
                        </span>
                      @endif
                    </td>
                  @endforeach
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
  </div>
@endsection

@section('scripts')
  <script type="text/javascript">
    $( ".department" ).hover(
      function() {
        var id = $( this ).attr('department-id');
        var name = $( this ).attr('department-name');
        var desc = $( this ).attr('department-desc');
        $( this ).append(
          '<div class="btn-group" role="group">' +
            '<button type="button" department-id="' + id + '" department-name="' + name + '" department-desc="' + desc + '" class="edit btn btn-xs btn-warning"><i class="fa fa-pencil"></i></button>' +
            '<button type="button" delete-id="' + id + '" delete-name="' + name + '" department-desc="' + desc + '" class="delete btn btn-xs btn-danger"><i class="fa fa-trash-o"></i></button>' +
          '</div>'
        );
        deleteItem("department", "isimli departmanı silmek istediğinize emin misiniz?");
        editDepartment(id, name, desc);
      },
      function() {
        $( this ).find( ".btn-group" ).remove();
      }
    );
    $("#create-department").click( function() {
      swal({
        title            : 'Departman Ekle',
        html             :
          '<input id="name" class="swal2-input" placeholder="Departmanın Adı">' +
          '<textarea id="desc" class="swal2-textarea" placeholder="Departmanın Açıklaması"></textarea>',
        showCancelButton : true,
        confirmButtonText: 'Ekle',
        cancelButtonText : 'İptal',
        showLoaderOnConfirm: true,
        preConfirm: function (name) {
          return new Promise(function (resolve, reject) {
            var name = $('#name').val()
            var desc = $('#desc').val()
            if (!name) {
              reject('Departmanın adını yazmanız gerekiyor');
            } else {
              $.ajax({
                url     : "/admin/department",
                method  : "POST",
                dataType: "json",
                data    : { 'name' : name, 'desc' : desc },
                success: function(result){
                  resolve(result)
                },
                error: function (xhr, ajaxOptions, thrownError) {
                  reject('Bir hata ile karşılaşıldı.')
                  ajaxError(xhr, ajaxOptions, thrownError);
                }
              });
            }
          })
        },
        allowOutsideClick: false
      }).then(function () {
        swal({
          type             : 'success',
          title            : 'Departman başarıyla eklendi',
          confirmButtonText: 'Tamam'
        }).then( function() { location.reload() });
      })
    })

    function editDepartment(id, name, desc) {
      $(".edit").click( function() {
        swal({
          title            : 'Departmanı Düzenle',
          html             :
            '<input id="name" class="swal2-input" value="' + name + '" placeholder="Departmanın Adı">' +
            '<textarea id="desc" class="swal2-textarea" placeholder="Departmanın Açıklaması">' + desc + '</textarea>',
          showCancelButton : true,
          confirmButtonText: 'Güncelle',
          cancelButtonText : 'İptal',
          showLoaderOnConfirm: true,
          preConfirm: function (input) {
            return new Promise(function (resolve, reject) {
              var name = $('#name').val()
              var desc = $('#desc').val()
              if (!name) {
                reject('Tanının adını yazmanız gerekiyor');
              } else {
                $.ajax({
                  url     : "/admin/department/" + id,
                  method  : "PUT",
                  dataType: "json",
                  data    : { 'name' : name, 'desc' : desc },
                  success: function(result){
                    resolve(result)
                  },
                  error: function (xhr, ajaxOptions, thrownError) {
                    reject('Bir hata ile karşılaşıldı.')
                    ajaxError(xhr, ajaxOptions, thrownError);
                  }
                });
              }
            })
          },
          allowOutsideClick: false
        }).then(function () {
          swal({
            type             : 'success',
            title            : 'Departman başarıyla güncellendi',
            confirmButtonText: 'Tamam'
          }).then( function() { location.reload() });
        })
      })
    }
  </script>
@endsection
