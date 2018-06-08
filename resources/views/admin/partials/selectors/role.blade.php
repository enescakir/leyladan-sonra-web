@include('admin.partials.selectors.default', [
    'selector' => [
      'id'        => 'role-type-selector',
      'class'     => 'btn-default',
      'icon'      => 'fa fa-tint',
      'current'   => request()->role_name,
      'values'    => App\Models\Role::toSelect('Hepsi', null),
      'default'   => 'Görev',
      'parameter' => 'role_name'
    ]
  ])
