@extends('admin.parent')

@section('title', 'Hata Girdileri')

@section('styles')
    @include('log-viewer::_template.style')
@endsection

@section('header')
  <section class="content-header">
    <h1>
      Hata Girdileri
      <small>Son 5 günde oluşturulan girdilere buradan ulaşabilirsiniz</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
      <li class="active">Hata Girdileri</li>
    </ol>
  </section>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"> 5 Günlük Hata Girdisi</h3>
                <div class="box-tools">
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive ">
                <table class="table table-condensed table-hover table-bordered table-stats">
                    <thead>
                        <tr>
                            @foreach($headers as $key => $header)
                            <th class="{{ $key == 'date' ? 'text-left' : 'text-center' }}">
                                @if ($key == 'date')
                                <span class="label label-info">{{ $header }}</span>
                                @else
                                <span class="level level-{{ $key }}">
                                    {!! log_styler()->icon($key) . ' ' . $header !!}
                                </span>
                                @endif
                            </th>
                            @endforeach
                            <th class="text-center">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($rows->count() > 0)
                        @foreach($rows as $date => $row)
                        <tr>
                            @foreach($row as $key => $value)
                            <td class="{{ $key == 'date' ? 'text-left' : 'text-center' }}">
                                @if ($key == 'date')
                                <span class="label label-primary">{{ $value }}</span>
                                @elseif ($value == 0)
                                <span class="level level-empty">{{ $value }}</span>
                                @else
                                <a href="{{ route('log-viewer::logs.filter', [$date, $key]) }}">
                                    <span class="level level-{{ $key }}">{{ $value }}</span>
                                </a>
                                @endif
                            </td>
                            @endforeach
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="{{ route('log-viewer::logs.show', [$date]) }}" class="btn btn-xs btn-info">
                                        <i class="fa fa-search"></i>
                                    </a>
                                    <a href="{{ route('log-viewer::logs.download', [$date]) }}" class="btn btn-xs btn-success">
                                        <i class="fa fa-download"></i>
                                    </a>
                                    <a href="#delete-log-modal" class="btn btn-xs btn-danger delete-modal" data-log-date="{{ $date }}">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="11" class="text-center">
                                <span class="label label-default">{{ trans('log-viewer::general.empty-logs') }}</span>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                {{ $rows->links() }}
            </div>
            <!-- /.box-footer -->
        </div>
        <!-- /.box -->
    </div>
</div>
{{-- DELETE MODAL --}}
<div id="delete-log-modal" class="modal fade">
    <div class="modal-dialog">
        <form id="delete-log-form" action="{{ route('log-viewer::logs.delete') }}" method="POST">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="date" value="">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">HATA GİRDİ DOSYASINI SİL</h4>
                </div>
                <div class="modal-body">
                    <p></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-default pull-left" data-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-sm btn-danger" data-loading-text="Loading&hellip;">DOSYAYI SİL</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    Chart.defaults.global.responsive      = true;
    Chart.defaults.global.scaleFontFamily = "'Source Sans Pro'";
    Chart.defaults.global.animationEasing = "easeOutQuart";
</script>
<script>
    $(function () {
        var deleteLogModal = $('div#delete-log-modal'),
        deleteLogForm  = $('form#delete-log-form'),
        submitBtn      = deleteLogForm.find('button[type=submit]');
        $("a.delete-modal").on('click', function(event) {
            event.preventDefault();
            var date = $(this).data('log-date');
            deleteLogForm.find('input[name=date]').val(date);
            deleteLogModal.find('.modal-body p').html(
                '<span class="label label-primary">' + date + '</span> tarihli hata girdisi dosyasını <span class="label label-danger">SİLMEK</span> istediğinize emin misiniz?'
                );
            deleteLogModal.modal('show');
        });
        deleteLogForm.on('submit', function(event) {
            event.preventDefault();
            submitBtn.button('loading');
            $.ajax({
                url:      $(this).attr('action'),
                type:     $(this).attr('method'),
                dataType: 'json',
                data:     $(this).serialize(),
                success: function(data) {
                    submitBtn.button('reset');
                    if (data.result === 'success') {
                        deleteLogModal.modal('hide');
                        location.reload();
                    }
                    else {
                        alert('AJAX ERROR ! Check the console !');
                        console.error(data);
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    alert('AJAX ERROR ! Check the console !');
                    console.error(errorThrown);
                    submitBtn.button('reset');
                }
            });
            return false;
        });
        deleteLogModal.on('hidden.bs.modal', function() {
            deleteLogForm.find('input[name=date]').val('');
            deleteLogModal.find('.modal-body p').html('');
        });
    });
</script>
@endsection
