@extends('admin.parent')

@section('title', $log->date . ' Girdileri')

@section('styles')
    @include('log-viewer::_template.style')
@endsection

@section('content')
<h1 class="page-header">Günlük Hata Girdileri [{{ $log->date }}]</h1>

<div class="row">
    <div class="col-md-2">
        @include('log-viewer::_partials.menu')
    </div>
    <div class="col-md-10">
        {{-- Log Details --}}
        <div class="panel panel-default">
            <div class="panel-heading">
                Dosya Ayrıntıları:
                <div class="group-btns pull-right">
                    <a href="{{ route('log-viewer::logs.download', [$log->date]) }}" class="btn btn-xs btn-success">
                        <i class="fa fa-download"></i> İNDİR
                    </a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-condensed">
                    <thead>
                        <tr>
                            <td>Dosya Konumu:</td>
                            <td colspan="5">{{ $log->getPath() }}</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Girdi Sayısı: </td>
                            <td>
                                <span class="label label-primary">{{ $entries->total() }}</span>
                            </td>
                            <td>Dosya Boyutu:</td>
                            <td>
                                <span class="label label-primary">{{ $log->size() }}</span>
                            </td>
                            <td>Oluşturulma:</td>
                            <td>
                                <span class="label label-primary">{{ $log->createdAt() }}</span>
                            </td>
                            <td>Güncelleme:</td>
                            <td>
                                <span class="label label-primary">{{ $log->updatedAt() }}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                {{-- Search --}}
                <form action="{{ route('log-viewer::logs.search', [$log->date, $level]) }}" method="GET">
                    <div class=form-group">
                        <div class="input-group">
                            <input id="query" name="query" class="form-control"  value="{!! request('query') !!}" placeholder="aradığınız kelimeyi yazın">
                            <span class="input-group-btn">
                                @if (request()->has('query'))
                                <a href="{{ route('log-viewer::logs.show', [$log->date]) }}" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span></a>
                                @endif
                                <button id="search-btn" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Log Entries --}}
        <div class="panel panel-default">
            <div class="table-responsive">
                <table id="entries" class="table table-condensed">
                    <thead>
                        <tr>
                            <th>Ortam</th>
                            <th style="width: 120px;">Seviye</th>
                            <th style="width: 65px;">Tarih</th>
                            <th>Başlık</th>
                            <th class="text-right">İşlem</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($entries as $key => $entry)
                        <tr>
                            <td>
                                <span class="label label-env">{{ $entry->env }}</span>
                            </td>
                            <td>
                                <span class="level level-{{ $entry->level }}">
                                    {!! $entry->level() !!}
                                </span>
                            </td>
                            <td>
                                <span class="label label-default">
                                    {{ $entry->datetime->format('H:i:s') }}
                                </span>
                            </td>
                            <td>
                                <p>{{ $entry->header }}</p>
                            </td>
                            <td class="text-right">
                                @if ($entry->hasStack())
                                <a class="btn btn-xs btn-default" role="button" data-toggle="collapse" href="#log-stack-{{ $key }}" aria-expanded="false" aria-controls="log-stack-{{ $key }}">
                                    <i class="fa fa-toggle-on"></i> Ayrıntı
                                </a>
                                @endif
                            </td>
                        </tr>
                        @if ($entry->hasStack())
                        <tr>
                            <td colspan="5" class="stack">
                                <div class="stack-content collapse" id="log-stack-{{ $key }}">
                                    {!! $entry->stack() !!}
                                </div>
                            </td>
                        </tr>
                        @endif
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                <span class="label label-default">{{ trans('log-viewer::general.empty-logs') }}</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($entries->hasPages())
            <div class="panel-footer">
                {!! $entries->appends(compact('query'))->links() !!}
                <span class="label label-info pull-right">
                    Sayfa {!! $entries->currentPage() !!} / {!! $entries->lastPage() !!}
                </span>
            </div>
            @endif
        </div>
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
        @unless (empty(log_styler()->toHighlight()))
        $('.stack-content').each(function() {
            var $this = $(this);
            var html = $this.html().trim()
            .replace(/({!! join(log_styler()->toHighlight(), '|') !!})/gm, '<strong>$1</strong>');

            $this.html(html);
        });
        @endunless
    });
</script>
@endsection
