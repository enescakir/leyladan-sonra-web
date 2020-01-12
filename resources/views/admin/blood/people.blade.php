@extends('admin.layouts.app')

@section('title', 'Kan Bağışı Görevlileri')

@section('header')
    <section class="content-header">
        <h1>
            Kan Bağışı Görevlileri
            <small>Bu sayfadan sistemdeki kan bağışı görevlilerini belirleyebilirsiniz</small>
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fa fa-home"></i> Anasayfa</a>
            </li>
            <li>
                <a href="{{ route('admin.blood.index') }}">Kan Bağışçıları</a>
            </li>
            <li class="active">Görevliler</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <!-- form start -->
                {!! Form::open(['route' => 'admin.blood.people.update', 'method' => 'POST' ]) !!}
                <div class="box-body">
                    <div class="form-group{{ $errors->has('users[]') ? ' has-error' : '' }}">
                        {!! Form::select('users[]', $users, $responsibles, ['class' => 'multi-select form-control', 'multiple' => 'multiple' ]) !!}
                    </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <a href="{{ route('admin.blood.index') }}" class="btn btn-danger">Geri</a>
                    {!! Form::submit("Güncelle", ['class' => 'btn btn-success pull-right']) !!}
                </div>
                <!-- /.box-footer -->
                {!! Form::close() !!}
                <div id="multiselect-loading" class="overlay">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>

            </div>
        </div>
    </div>
@endsection