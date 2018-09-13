<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">
            @isset($title)
                {{ $title }}
            @endisset
        </h3>
        <div class="box-tools">
            <div class="input-group input-group-sm">
                @if(isset($search) && $search)
                    <input id="search-input" type="text" class="form-control table-search-bar pull-right search-input" name="search" placeholder="Arama"
                        value="{{ request()->search }}">
                @endif
                <div class="input-group-btn">
                    @if(isset($search) && $search)
                        <button id="search-btn" class="btn btn-default" type="submit">
                            <i class="fa fa-search"></i> Ara
                        </button>
                    @endif

                    {{--BULK ACTIONS --}}
                    @isset($actions)
                        <div class="btn-group btn-group-sm hidden-sm">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-wrench"></i>
                                İşlem
                            </button>
                            <ul class="dropdown-menu">
                                {{ $actions }}
                            </ul>
                        </div>
                    @endisset

                    @isset($filters)
                        {{ $filters }}
                    @endisset

                </div>
            </div>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body @isset($body_class) {{ $body_class }} @else no-padding @endisset">
        @isset($body)
            {{ $body }}
        @endisset
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        @isset($footer)
            {{ $footer }}
        @endisset
    </div>
    <!-- /.box-footer -->
</div>
<!-- /.box -->