@include('admin.partials.selectors.default', [
    'selector' => [
        'id'        => 'chat-state-selector',
        'class'     => 'btn-default',
        'icon'      => 'fa fa-comment',
        'current'   => request()->status,
        'values'    => \App\Enums\ChatStatus::toSelect('Hepsi'),
        'default'   => 'Durum',
        'parameter' => 'status'
    ]
])