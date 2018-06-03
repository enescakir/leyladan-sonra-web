<div class="btn-group btn-group-sm">
    <button type="button" id="{{ $selector['id'] ?? '' }}" class="btn {{ $selector['class'] ?? 'btn-default' }} dropdown-toggle"
        data-toggle="dropdown">
        <i class="{{ $selector['icon'] ?? '' }}"></i>
        {{ $selector['current'] ? (($selector['is_basic'] ?? false) ? $selector['current'] : $selector['values'][$selector['current']]) : $selector['default'] }}
    </button>
    <ul class="dropdown-menu {{ $selector['menu_class'] ?? '' }}">
        @foreach( $selector['values'] as $key => $value)
            <li>
                <a class="btn-filter" href="javascript:;"
                    filter-param="{{ $selector['parameter'] }}"
                    filter-value="{{ ($selector['is_basic'] ?? false) ? $value : $key }}">
                    {{ $value }}
                </a>
            </li>
        @endforeach
    </ul>
</div>