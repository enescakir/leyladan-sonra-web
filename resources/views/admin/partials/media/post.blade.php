@foreach($postMedias as $media)
    <div class="post-image-container" id="media-{{$media->id}}">
        <a href="{{ $media->getUrl('large') }}" target="_blank">
            <img class="post-image img-responsive" src="{{ $media->getUrl('thumb') }}"
                 alt="{{ $childName }}">
        </a>
        <button type="button" class="delete-btn {{ $deleteClass ?? '' }} img-btn btn btn-sm btn-danger" title="Fotoğrafı Sil"
                delete-name="{{ $childName }}"
                delete-id="{{ $media->id }}"><i
                    class="fa fa-trash"></i></button>
        <button type="button" class="feature-btn {{ $featureClass ?? '' }} img-btn btn btn-sm btn-default" title="Fotoğrafı Öne Çıkar"
                feature-id="{{ $media->id }}">
            <i class="fa fa-star-o"></i></button>
    </div>
@endforeach
