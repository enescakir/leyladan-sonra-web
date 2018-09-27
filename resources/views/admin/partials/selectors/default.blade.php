<div id="{{ $selector['id'] ?? '' }}" class="btn-group btn-group-sm">
    <button id="{{ $selector['id'] ?? '' }}-button" type="button"
            class="btn {{ $selector['class'] ?? 'btn-default' }} dropdown-toggle"
            data-toggle="dropdown">
        <i class="{{ $selector['icon'] ?? '' }}"></i>
        {{ !is_null($selector['current'])
            ? (($selector['is_basic'] ?? false)
                ? $selector['current']
                : $selector['values'][$selector['current']])
            : $selector['default']
        }}
    </button>
    <ul id="{{ $selector['id'] ?? '' }}-menu" class="dropdown-menu {{ $selector['menu_class'] ?? '' }}">
        @foreach( $selector['values'] as $key => $value)
            <li>
                <a class="btn-filter" href="javascript:;"
                   filter-param="{{ $selector['parameter'] }}"
                   filter-value="{{ ($selector['is_basic'] ?? false) ? $value : $key }}"
                   filter-reload="{{ $selector['reload'] ?? '1' }}"
                >
                    {{ $value }}
                </a>
            </li>
        @endforeach
    </ul>
</div>