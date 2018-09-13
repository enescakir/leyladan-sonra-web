@include('admin.partials.selectors.default', [
    'selector' => [
        'id'        => 'diagnosis-selector',
        'class'     => 'btn-default',
        'icon'      => 'fa fa-stethoscope',
        'current'   => request()->diagnosis,
        'values'    => App\Models\Diagnosis::toSelect('Hepsi'),
        'default'   => 'Tanı',
        'parameter' => 'diagnosis',
        'menu_class' => 'scrollable-menu',
    ]
])