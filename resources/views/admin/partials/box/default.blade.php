<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">
            @isset($title)
                {{ $title }}
            @endisset
        </h3>
        <div class="box-tools">
            @if(isset($search) && $search)
                <div class="input-group input-group-sm search-group">
                    <input id="search-input" type="text" class="form-control table-search-bar pull-right search-input"
                           name="search" placeholder="Arama"
                           value="{{ request()->search }}">
                    <div class="input-group-btn">
                        <button id="search-btn" class="btn btn-default" type="submit">
                            <i class="fa fa-search"></i> Ara
                        </button>
                    </div>
                </div>
            @endif

            @isset($filters)
                <div class="btn-group btn-group-sm filter-group">
                    {{ $filters }}
                </div>
            @endisset
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