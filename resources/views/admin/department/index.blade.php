@extends('admin.parent')

@section('title')
  Departmanlar
@endsection

@section('styles')
@endsection

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
                    <td id="department-{{ $department->id }}" class="department" department-id="{{ $department->id }}" department-name="{{ $department->name }}">
                      {{$department->name}}
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
        $( this ).append(
          '<div class="btn-group" role="group">' +
            '<button type="button" department-id="' + id + '" department-name="' + name + '" class="edit btn btn-xs btn-warning"><i class="fa fa-pencil"></i></button>' +
            '<button type="button" department-id="' + id + '" department-name="' + name + '" class="delete btn btn-xs btn-danger"><i class="fa fa-trash-o"></i></button>' +
          '</div>'
        );
        deleteItem("department", "department-id", "department-name", "isimli departmanı silmek istediğinize emin misiniz?");
        editDiagnosis(id, name);
      },
      function() {
        $( this ).find( ".btn-group" ).remove();
      }
    );
    $("#create-department").click( function() {
      swal({
        title            : 'Departman Ekle',
        input            : 'text',
        showCancelButton : true,
        confirmButtonText: 'Ekle',
        cancelButtonText : 'İptal',
        inputValidator   : function (value) {
          return new Promise(function (resolve, reject) {
            if (value) {
              resolve()
            } else {
              reject('Departmanın adını yazmanız gerekiyor')
            }
          })
        },
        showLoaderOnConfirm: true,
        preConfirm: function (name) {
          return new Promise(function (resolve, reject) {
            $.ajax({
              url     : "/admin/department",
              method  : "POST",
              dataType: "json",
              data    : { 'name' : name },
              success: function(result){
                resolve(result)
              },
              error: function (xhr, ajaxOptions, thrownError) {
                reject('Bir hata ile karşılaşıldı.')
                ajaxError(xhr, ajaxOptions, thrownError);
              }
            });
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

    function editDiagnosis(id, name) {
      $(".edit").click( function() {
        swal({
          title            : 'Departmanı Düzenle',
          input            : 'text',
          inputValue       : name,
          showCancelButton : true,
          confirmButtonText: 'Güncelle',
          cancelButtonText : 'İptal',
          inputValidator   : function (value) {
            return new Promise(function (resolve, reject) {
              if (value) {
                resolve()
              } else {
                reject('Departmanın adını boş bırakamazsınız')
              }
            })
          },
          showLoaderOnConfirm: true,
          preConfirm: function (input) {
            return new Promise(function (resolve, reject) {
              $.ajax({
                url     : "/admin/department/" + id,
                method  : "PUT",
                dataType: "json",
                data    : { 'name' : input },
                success: function(result){
                  resolve(result)
                },
                error: function (xhr, ajaxOptions, thrownError) {
                  reject('Bir hata ile karşılaşıldı.')
                  ajaxError(xhr, ajaxOptions, thrownError);
                }
              });
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
