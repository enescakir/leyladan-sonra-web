@include('admin.partials.selectors.default', [
    'selector' => [
        'id'        => 'faculty-selector',
        'class'     => 'btn-default',
        'icon'      => 'fa fa-building',
        'current'   => request()->faculty_id,
        'values'    => App\Models\Faculty::toSelect('Hepsi'),
        'default'   => 'Fakülte',
        'parameter' => 'faculty_id',
        'menu_class' => 'scrollable-menu',
    ]
])