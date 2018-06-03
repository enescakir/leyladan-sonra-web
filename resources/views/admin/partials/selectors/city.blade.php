@include('admin.partials.selectors.default', [
    'selector' => [
        'id'        => 'city-selector',
        'class'     => 'btn-default',
        'icon'      => 'fa fa-map-marker',
        'current'   => request()->city,
        'values'    => citiesToSelect(false, 'Hepsi'),
        'default'   => 'Şehir',
        'parameter' => 'city',
        'menu_class' => 'scrollable-menu',
    ]
])