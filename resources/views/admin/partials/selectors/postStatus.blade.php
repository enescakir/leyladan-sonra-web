@include('admin.partials.selectors.default', [
    'selector' => [
        'id'        => 'until-selector',
        'class'     => 'btn-default',
        'icon'      => 'fa fa-pencil-square-o',
        'current'   => request()->until,
        'values'    => [
            ""  => "Hepsi",
            true => "Yayında",
            false => "Yayında Değil",
        ],
        'default'   => 'Yayın Durumu',
        'parameter' => 'until'
    ]
])
