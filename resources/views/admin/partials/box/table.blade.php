<div class="table-responsive">
    <table class="table @isset($class) {{ $class }} @else table-striped table-hover table-bordered table-condensed @endisset">
        <thead>
            <tr>
                @isset($head)
                    {{ $head }}
                @endisset
            </tr>
        </thead>
        <tbody>
            @isset($body)
                {{ $body }}
            @endisset
        </tbody>
    </table>
</div>
