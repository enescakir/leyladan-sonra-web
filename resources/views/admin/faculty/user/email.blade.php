@extends('admin.parent')

@section('title', 'E-posta Gönder')

@section('header')
    <section class="content-header">
        <h1>
            E-posta Gönder
            <small>Bu sayfadan fakültenizdeki üyelere toplu e-posta gönderin</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
            <li class="active">E-posta Gönder</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <!-- /.box-header -->
                <!-- form start -->
                {!! Form::open(['method' => 'POST', 'route' => ['admin.faculty.email.store', $faculty->id], 'class' => 'form-horizontal']) !!}
                <div class="box-body">
                    <div class="form-group{{ $errors->has('roles') ? ' has-error' : '' }}">
                        {!! Form::label('roles', 'Kişiler *', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                            @foreach($roles as $key => $name)
                                <div class="checkbox icheck">
                                    <label>
                                        <input type="checkbox" name="roles[]" value="{{ $key }}"> {{ $name }}
                                    </label>
                                </div>
                            @endforeach
                            <small class="text-danger">{{ $errors->first('roles') }}</small>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
                        {!! Form::label('subject', 'Başlık *', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                            {!! Form::text('subject', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('subject') }}</small>
                            <small class="help-block">E-posta başlığının çok uzun olmamasına özen gösterin</small>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                        {!! Form::label('body', 'Metin *', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                            {!! Form::textarea('body', null, ['class' => 'form-control summernote', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('body') }}</small>
                            <small class="help-block">E-posta metninde imla kurallarına özen gösterin</small>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    {!! Form::submit("Gönder", ['class' => 'btn btn-success pull-right']) !!}
                </div>
                <!-- /.box-footer -->
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection