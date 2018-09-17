<style>
    .img-container {
        height: 60vh;
    }

    .actions .btn-group {
        margin-bottom: 5px;
    }
    @media (max-width: 550px) {
        .btn-group-sm-block {
            width: 100%;
        }
        .btn-group-sm-block .btn {
            width: 100%;
        }
    }

</style>
<div class="modal fade" id="img-modal" role="dialog" aria-labelledby="modalLabel" tabindex="-1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                <h4 class="modal-title">Yeni Fotoğraf Ekle</h4>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <img id="cropper-img" class="img-responsive"
                         src="{{ asset('resources/admin/media/child_no_image.jpg') }}">
                </div>
            </div>
            <div class="modal-footer">
                <div class="actions pull-left">
                    <div class="btn-group btn-group-sm-block">
                        <label class="btn btn-primary btn-upload" for="inputImage" title="Fotoğraf Seç">
                            <input type="file" class="sr-only no-filestyle" id="inputImage" name="file"
                                   accept=".jpg,.jpeg,.png">
                            <i class="fa fa-upload"></i>
                            Fotoğraf Seç
                        </label>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary transform-btn" data-method="rotate"
                                data-option="-90"
                                data-toggle="tooltip"
                                title="Sola Döndür">
                            <i class="fa fa-rotate-left"></i>
                        </button>
                        <button type="button" class="btn btn-primary transform-btn" data-method="rotate"
                                data-option="90"
                                data-toggle="tooltip" title="Sağa Döndür">
                            <i class="fa fa-rotate-right"></i>
                        </button>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary transform-btn" data-method="zoom"
                                data-option="0.1"
                                data-toggle="tooltip"
                                title="Yakınlaş">
                            <i class="fa fa-search-plus"></i>
                        </button>
                        <button type="button" class="btn btn-primary transform-btn" data-method="zoom"
                                data-option="-0.1"
                                data-toggle="tooltip" title="Uzaklaş">
                            <i class="fa fa-search-minus"></i>
                        </button>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary transform-btn" data-method="scaleX"
                                data-option="-1"
                                data-toggle="tooltip" title="Yatay Yansıt">
                            <i class="fa fa-arrows-h"></i>
                        </button>
                        <button type="button" class="btn btn-primary transform-btn" data-method="scaleY"
                                data-option="-1"
                                data-toggle="tooltip" title="Dikey Yansıt">
                            <i class="fa fa-arrows-v"></i>
                        </button>
                    </div>
                    <div class="btn-group d-flex flex-nowrap" data-toggle="buttons">
                        <label class="btn btn-primary active">
                            <input type="radio" class="sr-only ratio-btn" name="aspectRatio" value="1.333333">
                            Yatay
                        </label>
                        <label class="btn btn-primary">
                            <input type="radio" class="sr-only ratio-btn" name="aspectRatio" value="0.666667">
                            Dikey
                        </label>
                    </div>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">İptal</button>
                    <button type="button" class="btn btn-success" id="crop-btn">Kaydet</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    var postID = false;
    var imageContainer  = ".img-add-container";
    var suffix = '';
    var url = '/admin/tmp-media';

    $(function () {
        $(".add-img-btn").on('click', function (event) {
            suffix = $(this).attr('suffix');
            postID = $(this).attr('post-id');
            if (postID){
                url = '/admin/post/' + postID + '/media';
            }
            if (suffix){
                imageContainer = '.img-add-container-' + suffix;
            }
            $('#img-modal').modal("show")
        });

        var URL = window.URL || window.webkitURL;
        var image = $('#cropper-img').get(0);
        var cropBoxData;
        var canvasData;
        var cropper;
        var options = {
            viewMode: 2,
            aspectRatio: 4 / 3,
            dragMode: 'move',
            ready: function () {
                cropper.setCropBoxData(cropBoxData).setCanvasData(canvasData);
            }
        };
        var aspectRatio = '4/3';
        var originalImageURL = image.src;
        var uploadedImageType = 'image/jpeg';
        var uploadedImageName = 'cropped.jpg';
        var uploadedImageURL;

        $('#img-modal').on('shown.bs.modal', function () {
            cropper = new Cropper(image, options);
        }).on('hidden.bs.modal', function () {
            cropBoxData = cropper.getCropBoxData();
            canvasData = cropper.getCanvasData();
            cropper.destroy();
        });

        $('.ratio-btn').on('change', function () {
            var value = parseFloat($(this).attr('value'));
            aspectRatio = value > 1 ? '4/3' : '2/3';
            cropper.setAspectRatio(value);
        });

        $('.transform-btn').on('click', function () {
            var method = $(this).data('method');
            var option = $(this).data('option');
            cropper[method](option);

            switch (method) {
                case 'rotate':
                    cropper.clear();
                    cropper.crop();
                    break;
                case 'scaleX':
                case 'scaleY':
                    $(this).data('option', -option);
                    cropper.clear();
                    cropper.crop();
                    break;
            }
            cropBoxData = cropper.getCropBoxData();
            canvasData = cropper.getCanvasData();
        });

        // Import image
        var inputImage = $('#inputImage').get(0);

        if (URL) {
            inputImage.onchange = function () {
                var files = this.files;
                var file;

                if (cropper && files && files.length) {
                    file = files[0];

                    if (/^image\/\w+/.test(file.type)) {
                        uploadedImageType = file.type;
                        uploadedImageName = file.name;

                        if (uploadedImageURL) {
                            URL.revokeObjectURL(uploadedImageURL);
                        }

                        image.src = uploadedImageURL = URL.createObjectURL(file);
                        cropper.destroy();
                        cropper = new Cropper(image, options);
                        inputImage.value = null;
                    } else {
                        window.alert('Please choose an image file.');
                    }
                }
            };
        } else {
            inputImage.disabled = true;
            inputImage.parentNode.className += ' disabled';
        }

        $('#crop-btn').on('click', function () {
            var button = $(this);
            button.html('<i class="fa fa-refresh fa-spin"></i>' + button.html());
            button.attr('disabled', 'true');

            canvas = cropper.getCroppedCanvas({maxWidth: 3200, maxHeight: 3200});

            canvas.toBlob(function (blob) {
                var formData = new FormData();
                formData.append('image', blob, 'child.jpg');
                formData.append('ratio', aspectRatio);

                $.ajax(url, {
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                }).done(function (response) {
                    $("#img-modal").modal("hide");
                    if (postID) {
                        var cell = getNewMediaCell(response.data.media.id, response.data.child.full_name, cropper.getCroppedCanvas({maxHeight: 300}).toDataURL());
                        $(imageContainer).before(cell);
                        deleteItem('media', 'isimli çocuğun fotoğrafını silmek istediğine emin misin?', 'delete-btn-new', '/admin/post/' + postID + '/media/[ID]');
                        featureItem('media', '', 'feature-btn-new', '/admin/post/' + postID + '/media/[ID]/feature');
                    } else {
                        var cell = getTemporaryMediaCell(response.data.id, response.data.name, response.data.path, response.data.ratio);
                        $(imageContainer).before(cell);
                        $('.delete-tmp-btn').on('click', function () {
                            var id = $(this).attr('delete-id');
                            $('#media-' + id).remove();
                        });
                        $('.feature-tmp-btn').on('click', function () {
                            var id = $(this).attr('feature-id');
                            $('input[name="mediaFeature' + (suffix ? '[' + suffix + ']' : '') + '[]"]').val('0');
                            $('#media-' + id + ' input[name="mediaFeature' + (suffix ? '[' + suffix + ']' : '') + '[]"]').val('1');
                            setFeaturedMedia(id, 'feature-tmp-btn');
                        });
                    }
                }).fail(function (xhr, ajaxOptions, thrownError) {
                    ajaxError(xhr, ajaxOptions, thrownError);
                }).always(function () {
                    button.removeAttr('disabled');
                    button.html('Kaydet');
                });
            }, 'image/jpeg');
        });
    });

    function getNewMediaCell(mediaId, childName, mediaUrl) {
        return '<div class="post-image-container" id="media-' + mediaId + '">' +
            '<a href="' + mediaUrl + '" target="_blank">' +
            '<img class="post-image img-responsive" src="' + mediaUrl + '">' +
            '</a>' +
            '<button type="button" class="delete-btn delete-btn-new img-btn btn btn-sm btn-danger" title="Fotoğrafı Sil"' +
            'delete-name="' + childName + '" delete-id="' + mediaId + '">' +
            '<i class="fa fa-trash"></i>' +
            '</button>' +
            '<button type="button" class="feature-btn feature-btn-new img-btn btn btn-sm btn-default" title="Fotoğrafı Öne Çıkar"' +
            'feature-id="' + mediaId + '">' +
            '<i class="fa fa-star-o"></i></button>' +
            '</div>';
    }

    function getTemporaryMediaCell(id, name, path, ratio) {
        return '<div class="post-image-container" id="media-' + id + '">' +
            '<input type="hidden" name="mediaId' + (suffix ? '[' + suffix + ']' : '') + '[]" value="' + id + '">'+
            '<input type="hidden" name="mediaName' + (suffix ? '[' + suffix + ']' : '') + '[]" value="' + name + '">'+
            '<input type="hidden" name="mediaFeature' + (suffix ? '[' + suffix + ']' : '') + '[]" value="0">'+
            '<input type="hidden" name="mediaRatio' + (suffix ? '[' + suffix + ']' : '') + '[]" value="' + ratio + '">'+
            '<a href="' + path + '" target="_blank">' +
            '<img class="post-image img-responsive" src="' + path + '">' +
            '</a>' +
            '<button type="button" class="delete-tmp-btn delete-btn img-btn btn btn-sm btn-danger" title="Fotoğrafı Sil"' + ' delete-id="' + id + '">' +
            '<i class="fa fa-trash"></i>' +
            '</button>' +
            '<button type="button" class="feature-tmp-btn feature-btn img-btn btn btn-sm btn-default" title="Fotoğrafı Öne Çıkar"' +
            'feature-id="' + id + '">' +
            '<i class="fa fa-star-o"></i></button>' +
            '</div>';
    }
</script>
