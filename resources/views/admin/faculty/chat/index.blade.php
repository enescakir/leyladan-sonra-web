@extends('admin.layouts.app')

@section('title', (request()->status == 'active' ? 'Aktif ' : '') . "Fakülte Sohbetleri")

@section('styles')
    <style>
        .selected {
            background-color: rgba(250, 222, 104, 0.6) !important;
        }

        .dropdown-menu {
            left: auto;
            right: 0;
        }

        .child-row {
            cursor: pointer;
        }

        .child-row .name {
            padding-left: 10px !important;
        }

        .child-row .counts {
            text-align: center;
            width: 25px;
            padding-right: 1px !important;
            padding-left: 1px !important;
        }

        .info-labels {
            font-size: 120%;
            margin: 5px;
            text-align: center;
        }

        .message-status {
            margin-left: 50px;
            float: left;
        }

        #children-box .table-responsive {
            max-height: 400px;
            min-height: 300px;
            overflow-y: scroll;
            overflow-x: hidden;
        }

        #child-box th {
            white-space: nowrap;
        }

        .overlay h3 {
            position: absolute;
            top: 50%;
            width: 100%;
            text-align: center;
        }

        #chats-box .table-responsive {
            min-height: 300px;
            max-height: 400px;
        }

        .chat-row {
            cursor: pointer;
        }

        .chat-row .label {
            margin: 0px 2px;
        }

        .chat-row .date {
            margin-top: 5px;
        }

        .chat-row td {
            vertical-align: middle !important;
        }

        #chats-container h4 {
            margin: 0px !important;
        }

        .direct-chat-contacts {
            height: 100%;
            padding: 5px 0px;
            z-index: 100;
            background: #fff;
            color: #000;
        }

        .direct-chat-contacts th {
            white-space: nowrap;
            text-align: right;
        }

        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #888;
            height: 20px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

    </style>
@endsection

@section('header')
    <section class="content-header">
        <h1>
            {{ request()->status == 'active' ? 'Aktif ' : '' }}Fakülte Sohbetleri
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
            <li class="active">Fakülte Sohbetleri</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div id="children-box" class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Çocuklar</h3>
                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <div class="input-group input-group-sm">
                        <input id="child-search-input" type="text"
                               class="form-control" name="search"
                               placeholder="Arama" value="{{ request('child_search') }}">
                        <div class="input-group-btn">
                            <button id="child-search-btn" class="btn btn-default" type="button">
                                <i class="fa fa-search"></i> Ara
                            </button>
                            @include('admin.partials.selectors.default', [
                                'selector' => [
                                    'id'        => 'gift-state-selector',
                                    'class'     => 'btn-default',
                                    'icon'      => 'fa fa-gift',
                                    'current'   => request()->gift_state,
                                    'values'    => \App\Enums\GiftStatus::toSelect('Hepsi'),
                                    'default'   => 'Hediye',
                                    'parameter' => 'gift_state',
                                    'reload'    => '0',
                                ]
                            ])
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-condensed">
                            <tbody id="children-container">
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="overlay">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
            </div>
            <!-- /. box -->
        </div>
        <!-- /.col -->
        <div class="col-md-5">
            <div id="chats-box" class="box box-primary direct-chat">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Çocuk <span class="label label-ls" data-widget="chat-pane-toggle"><i
                                    class="fa fa-child"></i> <span
                                    itemprop="child-name"></span></span>
                    </h3>

                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-toggle="tooltip" title="Çocuk Ayrıntıları"
                                data-widget="chat-pane-toggle"><i class="fa fa-child"></i></button>
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                    <div class="info-labels">
                        <span itemprop="child-status-label"></span>
                        <span class="label label-default"><i class="fa fa-gift"></i> <span itemprop="child-wish"></span></span>
                    </div>
                    <div class="input-group input-group-sm">
                        <input id="chat-search-input" type="text"
                               class="form-control" name="search"
                               placeholder="Arama" value="{{ request('chat_search') }}">
                        <div class="input-group-btn">
                            <button id="chat-search-btn" class="btn btn-default" type="button">
                                <i class="fa fa-search"></i> Ara
                            </button>
                            @include('admin.partials.selectors.default', [
                                'selector' => [
                                    'id'        => 'chat-status-selector',
                                    'class'     => 'btn-default',
                                    'icon'      => 'fa fa-comment',
                                    'current'   => request()->chat_status,
                                    'values'    => \App\Enums\ChatStatus::toSelect('Hepsi'),
                                    'default'   => 'Durum',
                                    'parameter' => 'chat_status',
                                    'reload'    => '0',
                                ]
                            ])

                        </div>
                    </div>
                    <div class="table-responsive mailbox-messages">
                        <table class="table table-hover table-striped">
                            <tbody id="chats-container">
                            </tbody>
                        </table>
                        <!-- /.table -->
                    </div>
                    <!-- /.mail-box-messages -->
                    <button id="close-all-button" class="btn btn-danger btn-block">
                        <i class="fa fa-archive"></i> Tüm sohbetleri kapat
                    </button>
                    <div class="direct-chat-contacts">
                        <h3 class="text-center"> Çocuk Ayrıntıları</h3>
                        <table class="table table-condensed table-bordered table-striped">
                            <tbody>
                            <tr>
                                <th>Ad</th>
                                <td itemprop="child-name"></td>
                            </tr>
                            <tr>
                                <th>Durumu</th>
                                <td itemprop="child-status-label"></td>
                            </tr>
                            <tr>
                                <th>Bizden İsteği</th>
                                <td itemprop="child-wish"></td>
                            </tr>
                            <tr>
                                <th>Gönüllü</th>
                                <td itemprop="child-volunteer"></td>
                            </tr>
                            <tr>
                                <th>Fakülte</th>
                                <td itemprop="child-faculty"></td>
                            </tr>
                            <tr>
                                <th>Departman</th>
                                <td itemprop="child-department"></td>
                            </tr>
                            <tr>
                                <th>Tanı</th>
                                <td itemprop="child-diagnosis"></td>
                            </tr>
                            <tr>
                                <th>Doğum Günü</th>
                                <td itemprop="child-birthday"></td>
                            </tr>
                            <tr>
                                <th>Sorumlular</th>
                                <td itemprop="child-users"></td>
                            </tr>
                            <tr>
                                <th>Ekstra Bilgi</th>
                                <td itemprop="child-extra"></td>
                            </tr>
                            </tbody>
                        </table>
                    </div><!-- /.direct-chat-pane -->
                </div>
                <!-- /.box-body -->
                <div class="overlay">
                    <i class="fa fa-refresh fa-spin"></i>
                    <h3>
                        Sohbetleri görüntülemek için çocuk seçiniz
                    </h3>
                </div>
            </div>
            <!-- /. box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4">
            <div id="messages-box" class="box box-primary direct-chat direct-chat-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Gönüllü
                        <span class="label label-ls" data-widget="chat-pane-toggle"><i class="fa fa-user"></i> <span
                                    itemprop="volunteer-name"></span></span>
                    </h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-toggle="tooltip" title="Gönüllü Ayrıntıları"
                                data-widget="chat-pane-toggle"><i class="fa fa-user"></i></button>
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="mailbox-controls">
                        <!-- Check all button -->
                        <button id="volunteered-button" type="button" class="btn btn-default btn-sm">
                            <i class="fa fa-gift"></i> Hediyeyi Aldı
                        </button>
                        <button id="close-button" type="button" class="btn btn-default btn-sm">
                            <i class="fa fa-archive"></i> Sohbeti Kapat
                        </button>
                        <button id="answer-button" type="button" class="btn btn-default btn-sm">
                            <i class="fa fa-thumbs-up"></i> Cevapladım
                        </button>

                    </div>
                    <!-- Conversations are loaded here -->
                    <div id="messages-container" class="direct-chat-messages">

                    </div><!--/.direct-chat-messages-->

                    <!-- Contacts are loaded here -->
                    <div class="direct-chat-contacts">
                        <h3 class="text-center"> Gönüllü Ayrıntıları</h3>
                        <table class="table table-condensed table-bordered table-striped">
                            <tbody>
                            <tr>
                                <th>Ad</th>
                                <td itemprop="volunteer-name"></td>
                            </tr>
                            <tr>
                                <th>E-posta</th>
                                <td itemprop="volunteer-email"></td>
                            </tr>
                            <tr>
                                <th>Telefon</th>
                                <td itemprop="volunteer-mobile"></td>
                            </tr>
                            <tr>
                                <th>Şehir</th>
                                <td itemprop="volunteer-city"></td>
                            </tr>
                            </tbody>
                        </table>
                    </div><!-- /.direct-chat-pane -->
                </div><!-- /.box-body -->
                <div class="overlay">
                    <i class="fa fa-refresh fa-spin"></i>
                    <h3>
                        Mesajları görüntülemek için sohbet seçiniz
                    </h3>
                </div>
                <div class="box-footer">

                    <div class="input-group">
                        <input type="text" name="message" placeholder="Mesajınızı yazın ..." class="form-control" disabled>
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-danger btn-flat" disabled>Gönder</button>
                        </span>
                    </div>
                </div><!-- /.box-footer-->
            </div><!--/.direct-chat -->
        </div>
        <!-- /.col -->
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        var child = {!! request()->filled('child_id') ? "{ id:" . request()->child_id . "}" : '{}' !!};
        var chat = {!! request()->filled('chat_id') ? "{ id:" . request()->chat_id . "}" : '{}' !!};
        var volunteer = {};
        var childSearch = {!! request()->filled('child_search') ? "'" . request()->child_search . "'" : 'null' !!};
        var chatSearch = {!! request()->filled('chat_search') ? "'" . request()->chat_search . "'" : 'null' !!};
        var giftStatus = {!! request()->filled('gift_state') ? "'" . request()->gift_state . "'" : 'null' !!};
        var chatStatus = {!! request()->filled('chat_status') ? "'" . request()->chat_status . "'" : 'null' !!};
        var childStatus = {!! "'" . request()->status . "'" !!};

        fetchChildren();
        if (child.id) {
            fetchChats();
            if (chat.id) {
                fetchMessages();
            }
        }

        function fetchChildren() {
            $('#children-box .overlay').show();

            $.ajax({
                url: '/admin/faculty/' + AuthUser.faculty_id + '/chat',
                method: 'GET',
                data: {search: childSearch, gift_state: giftStatus, status: childStatus}
            }).done(function (response) {
                var rows = "";
                response.data.children.forEach(function (element) {
                    var row = '' +
                        '<tr class="child-row ' + (child ? (child.id == element.id ? 'selected' : '') : '') + '" child-id="' + element.id + '">' +
                        '<th class="name">' + element.full_name + '</th>' +
                        '<td class="counts">' +
                        '<span class="label label-sm label-danger" data-toggle="tooltip" title="Açık">' + element.open_count + '</span>' +
                        '</td>' +
                        '<td class="counts">' +
                        '<span class="label label-sm label-primary" data-toggle="tooltip" title="Cevaplanmış">' + element.answered_count + '</span>' +
                        '</td>' +
                        '<td class="counts">' +
                        '<span class="label label-sm label-success" data-toggle="tooltip" title="Kapalı">' + element.closed_count + '</span>' +
                        '</td>' +
                        '</tr>';
                    rows += row;
                })
                if (response.data.children.length == 0) {
                    rows = '<tr><td colspan="4" class="text-center"><h3>Aradınığız kriterlerde çocuk bulunamadı</h3></td></tr>'
                }
                $('#children-container').html(rows);

                initChatButtons();
            }).fail(function (xhr, ajaxOptions, thrownError) {
                ajaxError(xhr, ajaxOptions, thrownError);
            }).always(function () {
                $('#children-box .overlay').hide();
            });
        }

        function initChatButtons() {
            $('.child-row').on('click', function () {
                removeChat();

                $('.child-row.selected').removeClass('selected');
                $(this).addClass('selected');

                child.id = $(this).attr('child-id');
                insertParam('child_id', child.id, 0);

                fetchChats();
            });
        }

        function fetchChats() {
            $('#chats-box .overlay').show();

            $.ajax({
                url: '/admin/child/' + child.id + '/chat',
                method: 'GET',
                data: {search: chatSearch, status: chatStatus}
            }).done(function (response) {
                child = response.data.child;

                $('[itemprop="child-name"]').html(child.full_name);
                $('[itemprop="child-status"]').html(child.gift_state);
                $('[itemprop="child-status-label"]').html(child.gift_state_label);
                $('[itemprop="child-wish"]').html(child.wish);
                $('[itemprop="child-faculty"]').html(child.faculty.name);
                $('[itemprop="child-department"]').html(child.department);
                $('[itemprop="child-diagnosis"]').html(child.diagnosis);
                if (child.volunteer) {
                    $('[itemprop="child-volunteer"]').html(child.volunteer.full_name);
                }
                $('[itemprop="child-birthday"]').html(moment(child.birthday).format('DD.MM.Y'));
                $('[itemprop="child-users"]').html(child.users.map(function (elem) {
                    return elem.full_name;
                }).join(", "));
                $('[itemprop="child-extra"]').html(child.extra_info);

                var rows = "";
                response.data.chats.forEach(function (element) {
                    var labelClass = "";
                    if (element.status === "Açık") {
                        labelClass = "label-danger"
                    } else if (element.status === "Cevaplandı") {
                        labelClass = "label-primary"
                    } else if (element.status === "Kapalı") {
                        labelClass = "label-success"
                    }
                    var row = '' +
                        '<tr class="chat-row ' + (chat ? (chat.id == element.id ? 'selected' : '') : '') + '" chat-id="' + element.id + '">' +
                        '<td class="text-center"><h4><span class="label ' + labelClass + '">' + element.status + '</span></h4></td>' +
                        '<td><b>' + element.volunteer.full_name + '</b>' + (element.volunteer_id == child.volunteer_id ? '<span class="label label-danger" data-toggle="tooltip" title="Hediyeyi Aldı"><i class="fa fa-trophy"></i></span>' : '') + '<br>' + element.volunteer.email + '</td>' +
                        '<td class="text-center"><h4>' +
                        '<span class="label label-warning" data-toggle="tooltip" title="Aldığı Hediye Sayısı"><i class="fa fa-gift"></i> ' + element.volunteer.children_count + '</span>' +
                        '<span class="label label-success" data-toggle="tooltip" title="Sohbet Sayısı"><i class="fa fa-comments"></i> ' + element.volunteer.chats_count + '</span>' +
                        '</h4><div class="date">' + moment(element.created_at).format('DD.MM.Y') + '</div></td>' +
                        '</tr>';
                    rows += row;
                });
                $('#chats-container').html(rows);
                initMessages();
                $('[data-toggle="tooltip"]').tooltip();
            }).fail(function (xhr, ajaxOptions, thrownError) {
                ajaxError(xhr, ajaxOptions, thrownError);
            }).always(function () {
                $('#chats-box .overlay').hide();
            });
        }

        function initMessages() {
            $('.chat-row').on('click', function () {
                $('.chat-row.selected').removeClass('selected');
                $(this).addClass('selected');
                chat.id = $(this).attr('chat-id');
                insertParam('chat_id', chat.id, 0);
                fetchMessages();
            });
        }

        function fetchMessages() {
            $('#messages-box .overlay').show();
            $.ajax({
                url: '/admin/chat/' + chat.id + '/message',
                method: 'GET',
            }).done(function (response) {

                chat = response.data.chat;
                volunteer = chat.volunteer;

                $('[itemprop="volunteer-name"]').html(volunteer.full_name);
                $('[itemprop="volunteer-email"]').html(volunteer.email);
                $('[itemprop="volunteer-mobile"]').html(volunteer.mobile);
                $('[itemprop="volunteer-city"]').html(volunteer.city);

                var rows = "";
                response.data.messages.forEach(function (element) {
                    var answerLabel = '<span class="label label-danger"><i class="fa fa-times"></i> Cevaplanmadı</span>';
                    if (element.answered_at && element.answerer) {
                        answerLabel = '<span class="label label-success"><i class="fa fa-check"></i> ' + element.answerer.full_name + ' tarafından cevaplandı</span>';
                    }

                    var row = '<div class="direct-chat-msg ' + (element.is_sent ? 'right' : 'left') + '">' +
                        '<div class="direct-chat-info clearfix">' +
                        '<span class="direct-chat-name ' + (element.is_sent ? 'pull-right' : 'pull-left') + '">' + (element.is_sent ? element.sender.full_name : chat.volunteer.full_name) + '</span>' +
                        '<span class="direct-chat-timestamp ' + (element.is_sent ? 'pull-left' : 'pull-right') + '">' + moment(element.created_at).format('DD.MM.Y') + '</span>' +
                        '</div>' +
                        '<img class="direct-chat-img" src="' + (element.is_sent ? element.sender.photo_small_url : '/admin/img/user-default-small.png') + '" alt="' + (element.is_sent ? element.sender.full_name : chat.volunteer.full_name) + '">' +
                        '<div class="direct-chat-text">' + element.text + '</div>' +
                        (element.is_sent ? '' : '<div class="clearfix"></div><div class="message-status">' + answerLabel + '</div>') +
                        '</div>';
                    rows += row;
                });
                $('#messages-container').html(rows);

            }).fail(function (xhr, ajaxOptions, thrownError) {
                ajaxError(xhr, ajaxOptions, thrownError);
            }).always(function () {
                $('#messages-box .overlay').hide();
            });
        }

    </script>
    <script>
        function removeParam(param) {
            insertParam(param, '', 0);
        }

        function removeChild() {
            child = {};
            removeParam('child_id');
            $('#chats-box .overlay').show();
            $('#messages-box .overlay').show();
            $('#chats-container').html('');
            $('#messages-container').html('');
        }

        function removeChat() {
            chat = {};
            removeParam('chat_id');
            $('#messages-box .overlay').show();
            $('#messages-container').html('');
        }

        function searchChildren(search) {
            removeChild();
            removeChat();

            childSearch = search;
            insertParam('child_search', search, 0);
            fetchChildren();
        }

        function searchChats(search) {
            removeChat();

            chatSearch = search;
            insertParam('chat_search', search, 0);
            fetchChats();
        }

        function applyAction(message, url, data, callback) {
            swal({
                title: "Emin misin?",
                html: message,
                type: "warning",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Evet!",
                showCancelButton: true,
                cancelButtonText: "Hayır",
                showLoaderOnConfirm: true,
                preConfirm: function () {
                    return new Promise(function (resolve, reject) {
                        $.ajax({
                            url: url,
                            method: "PUT",
                            data: data,
                            dataType: "json",
                            success: function (response) {
                                resolve(response.data);
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                ajaxError(xhr, ajaxOptions, thrownError);
                            }
                        });
                    })
                },
                allowOutsideClick: false,
            }).then(function (data) {
                callback(data);
            })
        }

        $('#child-search-btn').on('click', function () {
            searchChildren($('#child-search-input').val())
        });

        $('#child-search-input').on("keydown", function (e) {
            if (e.keyCode === 13) {
                searchChildren($(this).val())
            }
        });

        $('#chat-search-btn').on('click', function () {
            searchChats($('#chat-search-input').val())
        });

        $('#chat-search-input').on("keydown", function (e) {
            if (e.keyCode === 13) {
                searchChats($(this).val())
            }
        });

        $('#close-all-button').on('click', function () {
            var message = "'<strong>" + child.full_name + "</strong>' isimli çocuğun tüm sohbetlerini kapatmak istediğine emin misin? " +
                "<br> Cevaplanmamış tüm mesajlar şu an senin tarafından cevaplandı olarak işaretlenecekler.";
            var url = "/admin/child/" + child.id + "/chat";

            applyAction(
                message,
                url,
                {action: "close-all"},
                function (data) {
                    removeChat();
                    fetchChats();
                });
        });

        $('#close-button').on('click', function () {
            var message = "'<strong>" + volunteer.full_name + "</strong>' isimli gönüllünün sohbetini kapatmak istediğine emin misin? " +
                "<br> Cevaplanmamış tüm mesajlar şu an senin tarafından cevaplandı olarak işaretlenecekler.";
            var url = "/admin/chat/" + chat.id + "/message";

            applyAction(
                message,
                url,
                {action: "close"},
                function (data) {
                    fetchChats();
                    fetchMessages();
                });
        });

        $('#answer-button').on('click', function () {
            var message = "'<strong>" + volunteer.full_name + "</strong>' isimli gönüllünün mesajını cevaplandığına emin misin?";
            var url = "/admin/chat/" + chat.id + "/message";

            applyAction(
                message,
                url,
                {action: "answer"},
                function (data) {
                    fetchChats();
                    fetchMessages();
                });
        });

        $('#volunteered-button').on('click', function () {
            var message = "'<strong>" + volunteer.full_name + "</strong>' isimli gönüllünün '<strong>" + child.full_name + "</strong>' isimli miniğimizin hediyesini aldığına emin misin?";
            var url = "/admin/chat/" + chat.id + "/message";

            applyAction(
                message,
                url,
                {action: "volunteer", volunteer_id: volunteer.id},
                function (data) {
                    fetchChats();
                    fetchMessages();
                });
        });

        $('#gift-state-selector .btn-filter').on('click', function () {
            removeChild();
            removeChat();

            $('#gift-state-selector-button').html('<i class="fa fa-gift"></i> ' + $(this).text());
            giftStatus = $(this).attr('filter-value');
            fetchChildren();
        });

        $('#chat-status-selector .btn-filter').on('click', function () {
            removeChat();

            $('#chat-status-selector-button').html('<i class="fa fa-comment"></i> ' + $(this).text());
            chatStatus = $(this).attr('filter-value');
            fetchChats();
        });

    </script>
@endsection
