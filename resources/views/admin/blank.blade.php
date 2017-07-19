@extends('admin.parent')

@section('title')
  Boş Sayfa
@endsection

@section('styles')
@endsection

@section('header')
  <section class="content-header">
    <h1>
      Page Header
      <small>Optional description</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
      <li class="active">Boş Sayfa</li>
    </ol>
  </section>
@endsection

@section('content')
  <h3>Sayfa İçeriği</h3>
@endsection

@section('scripts')
@endsection
