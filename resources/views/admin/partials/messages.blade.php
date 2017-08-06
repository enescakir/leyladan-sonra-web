@if (session()->has('success_message'))
  <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {!! session()->get('success_message') !!}
  </div>
@endif

@if (session()->has('error_message'))
  <div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {!! session()->get('error_message') !!}
  </div>
@endif

@if (session()->has('info_message'))
  <div class="alert alert-info alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {!! session()->get('info_message') !!}
  </div>
@endif
