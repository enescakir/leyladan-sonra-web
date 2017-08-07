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
                    <td id="diagnosis-{{ $diagnosis->id }}" class="diagnosis" diagnosis-id="{{ $diagnosis->id }}" diagnosis-name="{{ $diagnosis->name }}" diagnosis-desc="{{ $diagnosis->desc }}">
                        {{ $diagnosis->name }}
                      @if ($diagnosis->desc)
                        <span
                          data-toggle    = "popover"
                          data-trigger   = "hover"
                          data-placement = "top"
                          title          = "{{ $diagnosis->name }}"
                          data-content   = "{{ $diagnosis->desc }}">
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
    $( ".diagnosis" ).hover(
      function() {
        var id = $( this ).attr('diagnosis-id');
        var name = $( this ).attr('diagnosis-name');
        var desc = $( this ).attr('diagnosis-desc');
        $( this ).append(
          '<div class="btn-group" role="group">' +
            '<button type="button" diagnosis-id="' + id + '" diagnosis-name="' + name + '" diagnosis-desc="' + desc + '" class="edit btn btn-xs btn-warning"><i class="fa fa-pencil"></i></button>' +
            '<button type="button" diagnosis-id="' + id + '" diagnosis-name="' + name + '" diagnosis-desc="' + desc + '" class="delete btn btn-xs btn-danger"><i class="fa fa-trash-o"></i></button>' +
          '</div>'
        );
        deleteItem("diagnosis", "diagnosis-id", "diagnosis-name", "isimli tanıyı silmek istediğinize emin misiniz?");
        editDiagnosis(id, name, desc);
      },
      function() {
        $( this ).find( ".btn-group" ).remove();
      }
    );
    $("#create-diagnosis").click( function() {
      swal({
        title            : 'Tanı Ekle',
        html             :
          '<input id="name" class="swal2-input" placeholder="Tanının Adı">' +
          '<textarea id="desc" class="swal2-textarea" placeholder="Tanının Açıklaması"></textarea>',
        showCancelButton : true,
        confirmButtonText: 'Ekle',
        cancelButtonText : 'İptal',
        showLoaderOnConfirm: true,
        preConfirm: function (name) {
          return new Promise(function (resolve, reject) {
            var name = $('#name').val()
            var desc = $('#desc').val()
            if (!name) {
              reject('Tanının adını yazmanız gerekiyor');
            } else {
              $.ajax({
                url     : "/admin/diagnosis",
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
          title            : 'Tanı başarıyla eklendi',
          confirmButtonText: 'Tamam'
        }).then( function() { location.reload() });
      })
    })

    function editDiagnosis(id, name, desc) {
      $(".edit").click( function() {
        swal({
          title            : 'Tanı Düzenle',
          html             :
            '<input id="name" class="swal2-input" value="' + name + '" placeholder="Tanının Adı">' +
            '<textarea id="desc" class="swal2-textarea" placeholder="Tanının Açıklaması">' + desc + '</textarea>',
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
              }

              $.ajax({
                url     : "/admin/diagnosis/" + id,
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
