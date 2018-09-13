@extends('admin.parent')

@section('title', 'SMS Gönder')
  
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
      <div class="box box-primary">
        <!-- form start -->
        {!!	Form::open(['route' => ['admin.blood.sms.preview'], 'class' => 'form-horizontal', 'method' => 'POST']) !!}
        <div class="box-body">
          <div class="form-group{{ $errors->has('blood_types') ? ' has-error' : '' }}">
              {!! Form::label('blood_types', 'Kan Grubu *', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                <div class="btn-group" data-toggle="buttons">
                  <label class="btn btn-ls @if(in_array('A', old('blood_types') ?? [] )) active @endif">
                    {!! Form::checkbox('blood_types[]', 'A',  null) !!} A
                  </label>
                  <label class="btn btn-ls @if(in_array('B', old('blood_types') ?? [] )) active @endif">
                    {!! Form::checkbox('blood_types[]', 'B',  null) !!} B
                  </label>
                  <label class="btn btn-ls @if(in_array('AB', old('blood_types') ?? [] )) active @endif">
                    {!! Form::checkbox('blood_types[]', 'AB',  null) !!} AB
                  </label>
                  <label class="btn btn-ls @if(in_array('0', old('blood_types') ?? [] )) active @endif">
                    {!! Form::checkbox('blood_types[]', '0',  null) !!} 0
                  </label>
                </div>
                <small class="text-danger">{{ $errors->first('blood_types') }}</small>
              </div>
          </div>
          <div class="form-group{{ $errors->has('rhs') ? ' has-error' : '' }}">
              {!! Form::label('rhs', 'RH *', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                <div class="btn-group" data-toggle="buttons">
                  <label class="btn btn-ls @if(in_array('1', old('rhs') ?? [] )) active @endif">
                    {!! Form::checkbox('rhs[]', '1',  null) !!} Pozitif
                  </label>
                  <label class="btn btn-ls @if(in_array('0', old('rhs') ?? [] )) active @endif">
                    {!! Form::checkbox('rhs[]', '0',  null) !!} Negatif
                  </label>
                </div>
                <small class="text-danger">{{ $errors->first('rhs') }}</small>
              </div>
          </div>
          <div class="form-group{{ $errors->has('cities') ? ' has-error' : '' }}">
              {!! Form::label('cities', 'Şehir *', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                  {!! Form::select('cities[]', citiesToSelect(), null, ['class' => 'form-control select2', 'required' => 'required',  'multiple']) !!}
                  <small class="text-danger">{{ $errors->first('cities') }}</small>
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
                  <span class="help-block">Bu SMS'in gönüllülerimize gideceğini unutmayınız. <br> Lütfen imla kurallarına ve Türkçe karakterlere dikkat ediniz.</span>
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
              $('#sms_balance').html(result.data.balance + " adet SMS hakkınız kalmıştır.")
          },
          error: function (xhr, ajaxOptions, thrownError) {
            ajaxError(xhr, ajaxOptions, thrownError);
          }
      });
    });
  </script>
@endsection
