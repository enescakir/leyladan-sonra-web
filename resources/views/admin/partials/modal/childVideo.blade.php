<style>
    .video-container {
        position: relative;
        padding-bottom: 56.25%;
        padding-top: 30px;
        height: 0;
        overflow: hidden;
    }

    .video-container iframe,
    .video-container object,
    .video-container embed {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
</style>
<div class="modal fade in" role="dialog" id="child-video-modal" tabindex="-1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                <h4 class="modal-title">Sisteme Yeni Çocuk Nasıl Eklenir?</h4>
            </div>
            <div class="modal-body">
                <div class="video-container">
                    <iframe width="383" height="241" src="https://www.youtube.com/embed/Xf0GK4otJQo" frameborder="0" allowfullscreen></iframe>
                </div>

            </div>
            <div class="modal-footer">
                <div class="btn-group">
                    <button type="button" class="btn btn-success" data-dismiss="modal">İzledim</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#child-video-modal').modal('show');
</script>