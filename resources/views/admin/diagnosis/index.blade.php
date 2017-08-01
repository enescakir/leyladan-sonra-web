@extends('admin.parent')

@section('title')
  Tanılar
@endsection

@section('styles')
@endsection

@section('header')
  <section class="content-header">
    <h1>
      Tanılar
      <small>Sistemimize bulunan tüm tanılara buradan ulaşabilirsiniz</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
      <li class="active">Tanılar</li>
    </ol>
  </section>
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">{{ count($diagnosises) }} Tanı</h3>
          <div class="box-tools">
            <div class="btn-group btn-group-sm">
              <button id="create-diagnosis" class="btn btn-success">
                <i class="fa fa-plus"></i> Ekle
              </button>
            </div>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
          <table class="table table-striped table-condensed table-bordered">
            <tbody>
              @foreach ($diagnosises as $row)
                <tr>
                  @foreach($row as $diagnosis)
                    <td id="diagnosis-{{ $diagnosis->id }}" class="diagnosis" diagnosis-id="{{ $diagnosis->id }}" diagnosis-name="{{ $diagnosis->name }}">
                      {{$diagnosis->name}}
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
    $( ".diagnosis" ).hover(
      function() {
        var id = $( this ).attr('diagnosis-id');
        var name = $( this ).attr('diagnosis-name');
        $( this ).append(
          '<div class="btn-group" role="group">' +
            '<button type="button" diagnosis-id="' + id + '" diagnosis-name="' + name + '" class="edit btn btn-xs btn-warning"><i class="fa fa-pencil"></i></button>' +
            '<button type="button" diagnosis-id="' + id + '" diagnosis-name="' + name + '" class="delete btn btn-xs btn-danger"><i class="fa fa-trash-o"></i></button>' +
          '</div>'
        );
        deleteItem("diagnosis", "diagnosis-id", "diagnosis-name", "isimli tanıyı silmek istediğinize emin misiniz?");
        editDiagnosis(id, name);
      },
      function() {
        $( this ).find( ".btn-group" ).remove();
      }
    );
    $("#create-diagnosis").click( function() {
      swal({
        title            : 'Tanı Ekle',
        input            : 'text',
        showCancelButton : true,
        confirmButtonText: 'Ekle',
        cancelButtonText : 'İptal',
        inputValidator   : function (value) {
          return new Promise(function (resolve, reject) {
            if (value) {
              resolve()
            } else {
              reject('Tanının adını yazmanız gerekiyor')
            }
          })
        },
        showLoaderOnConfirm: true,
        preConfirm: function (name) {
          return new Promise(function (resolve, reject) {
            $.ajax({
              url     : "/admin/diagnosis",
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
          title            : 'Tanı başarıyla eklendi',
          confirmButtonText: 'Tamam'
        }).then( function() { location.reload() });
      })
    })

    function editDiagnosis(id, name) {
      $(".edit").click( function() {
        swal({
          title            : 'Tanı Düzenle',
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
                reject('Tanının adını boş bırakamazsınız')
              }
            })
          },
          showLoaderOnConfirm: true,
          preConfirm: function (input) {
            return new Promise(function (resolve, reject) {
              $.ajax({
                url     : "/admin/diagnosis/" + id,
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
            title            : 'Tanı başarıyla güncellendi',
            confirmButtonText: 'Tamam'
          }).then( function() { location.reload() });
        })
      })
    }
  </script>
@endsection
