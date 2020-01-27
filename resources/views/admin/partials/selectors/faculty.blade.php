@include('admin.partials.selectors.default', [
    'selector' => [
        'id'        => 'faculty-selector',
        'class'     => 'btn-default',
        'icon'      => 'fa fa-hospital-o',
        'current'   => request()->faculty_id,
        'values'    => App\Models\Faculty::toSelect('Hepsi', 'full_name', 'id', 'name'),
        'default'   => 'Fakülte',
        'parameter' => 'faculty_id',
        'menu_class' => 'scrollable-menu',
    ]
])