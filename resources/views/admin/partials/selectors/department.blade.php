@include('admin.partials.selectors.default', [
    'selector' => [
        'id'        => 'department-selector',
        'class'     => 'btn-default',
        'icon'      => 'fa fa-bed',
        'current'   => request()->department,
        'values'    => App\Models\Department::toSelect('Hepsi', 'name', 'name'),
        'default'   => 'Departman',
        'parameter' => 'department',
        'menu_class' => 'scrollable-menu',
    ]
])