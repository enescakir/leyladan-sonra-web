@include('admin.partials.selectors.default', [
    'selector' => [
        'id'        => 'year-selector',
        'class'     => 'btn-default',
        'icon'      => 'fa fa-graduation-cap',
        'current'   => request()->year,
        'values'    => [
          "" => "Hepsi",
          0  => "Hazırlık",
          1  => "1.Yıl",
          2  => "2.Yıl",
          3  => "3.Yıl",
          4  => "4.Yıl",
          5  => "5.Yıl",
          6  => "6.Yıl"
        ],
        'default'   => 'Yıl',
        'parameter' => 'year'
    ]
])