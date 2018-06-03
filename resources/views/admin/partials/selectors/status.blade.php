@include('admin.partials.selectors.default', [
    'selector' => [
        'id'        => 'status-selector',
        'class'     => 'btn-default',
        'icon'      => 'fa fa-question-circle',
        'current'   => request()->status,
        'values'    => $values,
        'default'   => 'Durum',
        'parameter' => 'status'
    ]
])