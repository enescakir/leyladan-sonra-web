@include('admin.partials.selectors.default', [
    'selector' => [
        'id'        => 'page-selector',
        'class'     => 'btn-default hidden-xs',
        'icon'      => 'fa fa-list',
        'current'   => request()->per_page,
        'values'    => $values ?? [10, 25, 50, 100, 500],
        'default'   => '25',
        'parameter' => 'per_page',
        'is_basic'  => true,
    ]
])