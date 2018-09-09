@include('admin.partials.selectors.default', [
    'selector' => [
        'id'        => 'approval-selector',
        'class'     => 'btn-default',
        'icon'      => 'fa fa-check-circle-o',
        'current'   => request()->approval,
        'values'    => [
            ""  => "Hepsi",
            true => "Onaylanmış",
            false => "Onaylanmamış",
        ],
        'default'   => 'Onay Durumu',
        'parameter' => 'approval'
    ]
])
