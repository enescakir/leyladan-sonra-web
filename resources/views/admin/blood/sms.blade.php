@extends('admin.parent')

@section('title')
  SMS Gönder
@endsection

@section('styles')
@endsection

@section('header')
  <section class="content-header">
    <h1>
      Kan Bağışı SMS Gönder
      <small>Bu sayfadan sistemdeki kan bağışçılarına SMS gönderebilirsiniz</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
      <li><a href="{{ route('admin.blood.index') }}">Bağışçılar</a></li>
      <li class="active">SMS Gönder</li>
    </ol>
  </section>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-8">
      <!-- Horizontal Form -->
      <div class="box box-danger">
        <!-- form start -->
        {!!	Form::open(['route' => ['admin.blood.sms.preview'], 'class' => 'form-horizontal', 'method' => 'POST']) !!}
        <div class="box-body">
          <div class="form-group{{ $errors->has('blood_type') ? ' has-error' : '' }}">
              {!! Form::label('blood_type', 'Kan Grubu *', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                <div class="btn-group" data-toggle="buttons">
                  <label class="btn btn-ls @if(old('blood_type') == 'A') active @endif">
                    {!! Form::radio('blood_type', 'A',  null) !!} A
                  </label>
                  <label class="btn btn-ls @if(old('blood_type') == 'B') active @endif">
                    {!! Form::radio('blood_type', 'B',  null) !!} B
                  </label>
                  <label class="btn btn-ls @if(old('blood_type') == 'AB') active @endif">
                    {!! Form::radio('blood_type', 'AB',  null) !!} AB
                  </label>
                  <label class="btn btn-ls @if(old('blood_type') == '0') active @endif">
                    {!! Form::radio('blood_type', '0',  null) !!} 0
                  </label>
                </div>
                <small class="text-danger">{{ $errors->first('blood_type') }}</small>
              </div>
          </div>
          <div class="form-group{{ $errors->has('rh') ? ' has-error' : '' }}">
              {!! Form::label('rh', 'RH *', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                <div class="btn-group" data-toggle="buttons">
                  <label class="btn btn-ls @if(old('rh') == '1') active @endif">
                    {!! Form::radio('rh', '1',  null) !!} Pozitif
                  </label>
                  <label class="btn btn-ls @if(old('rh') == '0') active @endif">
                    {!! Form::radio('rh', '0',  null) !!} Negatif
                  </label>
                </div>
                <small class="text-danger">{{ $errors->first('rh') }}</small>
              </div>
          </div>
          <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
              {!! Form::label('city', 'Şehir *', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                  {!! Form::select('city', citiesToSelect(), null, ['class' => 'form-control select2', 'required' => 'required', 'placeholder' => 'Şehir seçiniz']) !!}
                  <small class="text-danger">{{ $errors->first('city') }}</small>
              </div>
          </div>
          <div class="form-group">
              <label class="col-md-3 control-label">
                  SMS Bakiye:
              </label>
              <div class="col-md-9">
                <p class="form-control-static" id="sms_balance"></p>
              </div>
          </div>
          <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
              {!! Form::label('message', 'Metin:', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                  {!! Form::textarea('message', null, ['class' => 'form-control max-length', 'maxlength' => 150, 'rows' => 3, 'required' => 'required']) !!}
                  <span class="help-block">Bu SMS'in gönüllülerimize gideceğini unutmayınız. <br> Lütfen imla kurallarına ve Türkçe karakterler dikkat ediniz.</span>
                  <small class="text-danger">{{ $errors->first('message') }}</small>
              </div>
          </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <a href="{{ url()->current() }}" class="btn btn-danger">Sıfırla</a>
          {!! Form::submit("İleri", ['class' => 'btn btn-success pull-right']) !!}
        </div>
        <!-- /.box-footer -->
        {!! Form::close() !!}
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script type="text/javascript">
    $(function () {
      block('#sms_balance');
      $.ajax({
          url: "/admin/blood/sms/balance",
          method: "GET",
          dataType: "json",
          success: function(result){
              $('#sms_balance').html(result.balance + " adet SMS hakkınız kalmıştır.")
          },
          error: function (xhr, ajaxOptions, thrownError) {
            ajaxError(xhr, ajaxOptions, thrownError);
          }
      });
    });
  </script>
@endsection
