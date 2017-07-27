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
                <i class="fa fa-plus"> Ekle</i>
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
                            <td>{{$diagnosis->name}}</td>
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
    deleteItem("blood", "blood-id", "blood-mobile", "numaralı bağışçıyı silmek istediğinize emin misiniz?");
  </script>
@endsection
