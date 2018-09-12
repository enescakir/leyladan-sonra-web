@include('admin.partials.selectors.default', [
    'selector' => [
        'id'        => 'department-selector',
        'class'     => 'btn-default',
        'icon'      => 'fa fa-building',
        'current'   => request()->department,
        'values'    => App\Models\Department::toSelect('Hepsi'),
        'default'   => 'Departman',
        'parameter' => 'department',
        'menu_class' => 'scrollable-menu',
    ]
])