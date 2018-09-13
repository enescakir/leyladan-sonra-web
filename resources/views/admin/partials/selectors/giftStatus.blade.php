@include('admin.partials.selectors.default', [
    'selector' => [
        'id'        => 'gift-state-selector',
        'class'     => 'btn-default',
        'icon'      => 'fa fa-gift',
        'current'   => request()->gift_state,
        'values'    => \App\Enums\GiftStatus::toSelect('Hepsi'),
        'default'   => 'Hediye',
        'parameter' => 'gift_state'
    ]
])