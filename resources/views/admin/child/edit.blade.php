@extends('admin.parent')

@section('title', 'Çocuk Ekle')

@section('styles')
@endsection

@section('header')
    <section class="content-header">
        <h1>
            Çocuk Ekle
            <small>Bu sayfadan sisteme yeni çocuk ekleyebilirsiniz</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
            <li><a href="{{ route('admin.child.index') }}">Çocuklarım</a></li>
            <li class="active">Çocuk Ekle</li>
        </ol>
    </section>
@endsection

@section('content')
    {!! Form::model($child, ['method' => 'PUT', 'route' => ['admin.child.update', $child->id], 'class' => '', 'files' => true]) !!}
    <div class="row">
        <div class="col-md-5">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">Genel Bilgiler</h4>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6 form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            {!! Form::label('first_name', 'Ad *', ['class' => 'control-label']) !!}
                            {!! Form::text('first_name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('first_name') }}</small>
                        </div>
                        <div class="col-md-6 form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            {!! Form::label('last_name', 'Soyad *', ['class' => 'control-label']) !!}
                            {!! Form::text('last_name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('last_name') }}</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group{{ $errors->has('diagnosis') ? ' has-error' : '' }}">
                            {!! Form::label('diagnosis', 'Tanı *', ['class' => 'control-label']) !!}
                            {!! Form::select('diagnosis', $diagnosises, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('diagnosis') }}</small>
                        </div>
                        <div class="col-md-6 form-group{{ $errors->has('diagnosis_desc') ? ' has-error' : '' }}">
                            {!! Form::label('diagnosis_desc', 'Tanı Açıklama', ['class' => 'control-label']) !!}
                            {!! Form::text('diagnosis_desc', null, ['class' => 'form-control', 'placeholder' => 'Halkın anlayabileceği bir şekilde']) !!}
                            <small class="text-danger">{{ $errors->first('diagnosis_desc') }}</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group{{ $errors->has('child_state') ? ' has-error' : '' }}">
                            {!! Form::label('child_state', 'Durumu *', ['class' => 'control-label']) !!}
                            <div class="input-group">
                                <div class="input-group-btn">
                                    <button type="button" id="child-state-btn" class="btn btn-default dropdown-toggle"
                                            data-toggle="dropdown">{{ $child->child_state ? : old('child_state', 'Durum seçiniz') }}
                                        <span
                                                class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a class="state-btn" href="javascript:" help-text="Nerede? Nasıl?">Devam
                                                Ediyor</a></li>
                                        <li><a class="state-btn" href="javascript:"
                                               help-text="İyileşme tarihi">İyileşti</a></li>
                                        <li><a class="state-btn" href="javascript:" help-text="Vefat tarihi">Vefat
                                                Etti</a></li>
                                        <li role="separator" class="divider"></li>
                                        <li><a class="state-btn" href="javascript:" help-text="Açıklama">Diğer</a></li>
                                    </ul>
                                </div><!-- /btn-group -->
                                {!! Form::hidden('child_state', null, ['required' => 'required']) !!}
                                {!! Form::text('child_state_desc', null, ['class' => 'form-control', 'placeholder' => '', 'required' => 'required']) !!}
                            </div>
                            <small class="text-danger">{{ $errors->first('child_state') }}</small>
                            <small class="text-danger">{{ $errors->first('child_state_desc') }}</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group{{ $errors->has('birthday') ? ' has-error' : '' }}">
                            {!! Form::label('birthday', 'Doğum Günü *', ['class' => 'control-label']) !!}
                            {!! Form::text('birthday', $child->birthday_label, ['class' => 'form-control date-mask birthday-picker', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('birthday') }}</small>
                        </div>
                        <div class="col-md-6 form-group{{ $errors->has('meeting_day') ? ' has-error' : '' }}">
                            {!! Form::label('meeting_day', 'Tanışma Günü *', ['class' => 'control-label']) !!}
                            {!! Form::text('meeting_day', $child->meeting_day_label, ['class' => 'form-control date-mask date-picker', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('meeting_day') }}</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group{{ $errors->has('until') ? ' has-error' : '' }}">
                            {!! Form::label('until', 'Son Yayın Tarihi *', ['class' => 'control-label']) !!}
                            {!! Form::text('until', $child->until_label, ['class' => 'form-control date-mask date-picker', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('until') }}</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group{{ $errors->has('taken_treatment') ? ' has-error' : '' }}">
                            {!! Form::label('taken_treatment', 'Alınan Tedaviler', ['class' => 'control-label']) !!}
                            {!! Form::text('taken_treatment', null, ['class' => 'form-control']) !!}
                            <small class="text-danger">{{ $errors->first('taken_treatment') }}</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group{{ $errors->has('wish') ? ' has-error' : '' }}">
                            {!! Form::label('wish', 'Dilek *', ['class' => 'control-label']) !!}
                            {!! Form::text('wish', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => '"Bir Çocuk Bir Dilek" mottomuzu unutmayın']) !!}
                            <small class="text-danger">{{ $errors->first('wish') }}</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group{{ $errors->has('faculty_id') ? ' has-error' : '' }}">
                            {!! Form::label('faculty_id', 'Fakülte', ['class' => 'control-label']) !!}
                            {!! Form::select('faculty_id', $faculties, auth()->user()->faculty_id, ['class' => 'form-control select2', 'required' => 'required', 'disabled' => 'disabled']) !!}
                            {!! Form::hidden('faculty_id', auth()->user()->faculty_id) !!}
                            <small class="text-danger">{{ $errors->first('faculty_id') }}</small>
                        </div>
                        <div class="col-md-6 form-group{{ $errors->has('department') ? ' has-error' : '' }}">
                            {!! Form::label('department', 'Departman', ['class' => 'control-label']) !!}
                            {!! Form::select('department', $departments, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('department') }}</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group{{ $errors->has('users') ? ' has-error' : '' }}">
                            {!! Form::label('users', 'Sorumlular *', ['class' => 'control-label']) !!}
                            {!! Form::select('users[]', $users, null, ['class' => 'form-control select2', 'multiple' => 'multiple', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('users') }}</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group{{ $errors->has('extra_info') ? ' has-error' : '' }}">
                            {!! Form::label('extra_info', 'Ektra Bilgi', ['class' => 'control-label']) !!}
                            {!! Form::textarea('extra_info', null, ['class' => 'form-control', 'rows' => '4']) !!}
                            <small class="text-danger">{{ $errors->first('extra_info') }}</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group{{ $errors->has('verification_doc') ? ' has-error' : '' }}">
                            <a href="{{ route('admin.child.verification.show', $child->id) }}" target="_blank">
                                <img class="img-responsive"
                                     src="{{ route('admin.child.verification.show', $child->id) }}"
                                     alt="{{ "{$child->full_name} Onam Formu" }}">
                            </a>
                            {!! Form::label('verification_doc', 'Onam Formu', ['class' => 'control-label']) !!}
                            {!! Form::file('verification_doc', ['class' => 'form-control']) !!}
                            <small class="text-danger">{{ $errors->first('verification_doc') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <!-- GUARDIAN BOX -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">Veli Bilgileri</h4>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6 form-group{{ $errors->has('g_first_name') ? ' has-error' : '' }}">
                            {!! Form::label('g_first_name', 'Ad *', ['class' => 'control-label']) !!}
                            {!! Form::text('g_first_name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('g_first_name') }}</small>
                        </div>
                        <div class="col-md-6 form-group{{ $errors->has('g_last_name') ? ' has-error' : '' }}">
                            {!! Form::label('g_last_name', 'Soyad *', ['class' => 'control-label']) !!}
                            {!! Form::text('g_last_name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('g_last_name') }}</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group{{ $errors->has('g_mobile') ? ' has-error' : '' }}">
                            {!! Form::label('g_mobile', 'Telefon *', ['class' => 'control-label']) !!}
                            {!! Form::text('g_mobile', null, ['class' => 'form-control mobile', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('g_mobile') }}</small>
                        </div>
                        <div class="col-md-6 form-group{{ $errors->has('g_email') ? ' has-error' : '' }}">
                            {!! Form::label('g_email', 'E-posta', ['class' => 'control-label']) !!}
                            {!! Form::email('g_email', null, ['class' => 'form-control']) !!}
                            <small class="text-danger">{{ $errors->first('g_email') }}</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group{{ $errors->has('province') ? ' has-error' : '' }}">
                            {!! Form::label('province', 'İlçe *', ['class' => 'control-label']) !!}
                            {!! Form::text('province', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('province') }}</small>
                        </div>
                        <div class="col-md-6 form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                            {!! Form::label('city', 'İl *', ['class' => 'control-label']) !!}
                            {!! Form::text('city', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('city') }}</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                            {!! Form::label('address', 'Adres *', ['class' => 'control-label']) !!}
                            {!! Form::textarea('address', null, ['class' => 'form-control', 'rows' => '2', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('address') }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- POST BOX -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">Tanışma Yazısı</h4>
                </div>
                <div class="box-body">
                    <div class="post-images">
                        @foreach(old('mediaId', []) as $index => $id)
                            <div class="post-image-container" id="media-{{ $id }}">
                                <input type="hidden" name="mediaId[]" value="{{ $id }}">
                                <input type="hidden" name="mediaName[]" value="{{ old('mediaName')[$index] }}">
                                <input type="hidden" name="mediaFeature[]" value="{{ old('mediaFeature')[$index] }}">
                                <input type="hidden" name="mediaRatio[]" value="{{ old('mediaRatio')[$index] }}">
                                <a href="{{ asset('storage/tmp/' . old('mediaName')[$index]) }}" target="_blank">
                                    <img class="post-image img-responsive"
                                         src="{{ asset('storage/tmp/' . old('mediaName')[$index]) }}">
                                </a>
                                <button type="button" class="delete-tmp-btn delete-btn img-btn btn btn-sm btn-danger"
                                        title="Fotoğrafı Sil" delete-id="{{ $id }}">
                                    <i class="fa fa-trash"></i>
                                </button>
                                @if(old('mediaFeature')[$index] == '1')
                                    <button type="button"
                                            class="feature-tmp-btn feature-btn img-btn btn btn-sm btn-warning"
                                            title="Fotoğrafı Öne Çıkar"
                                            feature-id="{{ $id }}">
                                        <i class="fa fa-star"></i></button>
                                @else
                                    <button type="button"
                                            class="feature-tmp-btn feature-btn img-btn btn btn-sm btn-default"
                                            title="Fotoğrafı Öne Çıkar"
                                            feature-id="{{ $id }}">
                                        <i class="fa fa-star-o"></i></button>
                                @endif
                            </div>
                        @endforeach
                        <div class="img-add-container">
                            <a class="btn btn-app" id="add-img-btn">
                                <i class="fa fa-plus"></i> Fotoğraf Eke
                            </a>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('meeting_text') ? ' has-error' : '' }}">
                        {!! Form::label('meeting_text', 'Metin *', ['class' => 'control-label']) !!}
                        {!! Form::textarea('meeting_text', null, ['class' => 'form-control summernote', 'rows' => '3', 'required' => 'required']) !!}
                        <small class="text-danger">{{ $errors->first('meeting_text') }}</small>
                    </div>

                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">Hediye Teslim Yazısı</h4>
                </div>
                <div class="box-body">
                    <div class="post-images">
                        @foreach(old('mediaId', []) as $index => $id)
                            <div class="post-image-container" id="media-{{ $id }}">
                                <input type="hidden" name="mediaId[]" value="{{ $id }}">
                                <input type="hidden" name="mediaName[]" value="{{ old('mediaName')[$index] }}">
                                <input type="hidden" name="mediaFeature[]" value="{{ old('mediaFeature')[$index] }}">
                                <input type="hidden" name="mediaRatio[]" value="{{ old('mediaRatio')[$index] }}">
                                <a href="{{ asset('storage/tmp/' . old('mediaName')[$index]) }}" target="_blank">
                                    <img class="post-image img-responsive"
                                         src="{{ asset('storage/tmp/' . old('mediaName')[$index]) }}">
                                </a>
                                <button type="button" class="delete-tmp-btn delete-btn img-btn btn btn-sm btn-danger"
                                        title="Fotoğrafı Sil" delete-id="{{ $id }}">
                                    <i class="fa fa-trash"></i>
                                </button>
                                @if(old('mediaFeature')[$index] == '1')
                                    <button type="button"
                                            class="feature-tmp-btn feature-btn img-btn btn btn-sm btn-warning"
                                            title="Fotoğrafı Öne Çıkar"
                                            feature-id="{{ $id }}">
                                        <i class="fa fa-star"></i></button>
                                @else
                                    <button type="button"
                                            class="feature-tmp-btn feature-btn img-btn btn btn-sm btn-default"
                                            title="Fotoğrafı Öne Çıkar"
                                            feature-id="{{ $id }}">
                                        <i class="fa fa-star-o"></i></button>
                                @endif
                            </div>
                        @endforeach
                        <div class="img-add-container">
                            <a class="btn btn-app" id="add-img-btn">
                                <i class="fa fa-plus"></i> Fotoğraf Eke
                            </a>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('meeting_text') ? ' has-error' : '' }}">
                        {!! Form::label('meeting_text', 'Metin *', ['class' => 'control-label']) !!}
                        {!! Form::textarea('meeting_text', null, ['class' => 'form-control summernote', 'rows' => '3', 'required' => 'required']) !!}
                        <small class="text-danger">{{ $errors->first('meeting_text') }}</small>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            {!! Form::submit("Güncelle", ['class' => 'btn btn-success btn-lg btn-block']) !!}
        </div>
    </div>
    {!! Form::close() !!}

@endsection

@section('scripts')
    @include('admin.partials.modal.cropper')

    <script>
        $('.state-btn').on('click', function () {
            var value = $(this).text();
            var help = $(this).attr('help-text');
            $('#child-state-btn').html(value + ' <span class="caret"></span>');
            $('input[name=child_state]').val(value);
            $('input[name=child_state_desc]').attr('placeholder', help);
        });

        $("#similarity-accept-btn").on('click', function () {
            $('#similarity-accept-input').val("1");
            $('#similarity-modal').modal('hide');
        });

        $('.delete-tmp-btn').on('click', function () {
            var id = $(this).attr('delete-id');
            $('#media-' + id).remove();
        });
        $('.feature-tmp-btn').on('click', function () {
            var id = $(this).attr('feature-id');
            $('input[name="mediaFeature[]"]').val('0');
            $('#media-' + id + ' input[name="mediaFeature[]"]').val('1');
            setFeaturedMedia(id, 'feature-tmp-btn');
        });
    </script>
@endsection
