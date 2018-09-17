<?php
$suffix = isset($suffix)
    ? $suffix
    : '';
$suffixArray = isset($suffix)
    ? '.' . $suffix
    : '';
?>
@foreach($tempMedias as $index => $id)
    <div class="post-image-container" id="media-{{ $id }}">
        <input type="hidden" name="mediaId[{{ $suffix }}][]" value="{{ $id }}">
        <input type="hidden" name="mediaName[{{ $suffix }}][]" value="{{ old('mediaName' . $suffixArray)[$index] }}">
        <input type="hidden" name="mediaFeature[{{ $suffix }}][]"
               value="{{ old('mediaFeature' . $suffixArray)[$index] }}">
        <input type="hidden" name="mediaRatio[{{ $suffix }}][]" value="{{ old('mediaRatio' . $suffixArray)[$index] }}">
        <a href="{{ asset('storage/tmp/' . old('mediaName' . $suffixArray)[$index]) }}" target="_blank">
            <img class="post-image img-responsive"
                 src="{{ asset('storage/tmp/' . old('mediaName' . $suffixArray)[$index]) }}">
        </a>
        <button type="button" class="delete-tmp-btn delete-btn img-btn btn btn-sm btn-danger"
                title="Fotoğrafı Sil" delete-id="{{ $id }}">
            <i class="fa fa-trash"></i>
        </button>
        @if(old('mediaFeature' . $suffixArray)[$index] == '1')
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
