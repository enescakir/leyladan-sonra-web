$.ajaxSetup({headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')}});

$(function () {
    initCheckbox();
    initSelect2();
    initDatePicker();
    initFileInput();
    initMaxLength();
    initFilterButton();
    initMask();
    initMultiSelect();
    initTabRemember();
    initClipboard();
    initNumberInput();
    initSummernote();
    initSidebar();
    initBrokenImage();
    $('[data-toggle="popover"]').popover();
    $('[data-toggle="tooltip"]').tooltip();
    searchItem("search-btn", "search-input", "search");
});

// INITS
function initCheckbox() {
    $('.icheck').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass: 'iradio_flat-green',
        increaseArea: '20%' // optional
    });
}

function initSelect2() {
    $('.select2').select2({
        width: '100%'
    });
    $('.select2-no-search').select2({
        minimumResultsForSearch: Infinity,
        width: '100%'
    });
}

function initDatePicker() {
    moment.locale('tr');

    $('.birthday-picker').datepicker({
        language: "tr",
        startView: 2,
        autoclose: true
    });

    $('.date-picker').datepicker({
        language: "tr",
        autoclose: true
    });
}

function initFileInput() {
    $(":file").not('.swal2-file').not('.no-filestyle').filestyle({
        buttonText: "Dosya seç",
        iconName: "fa fa-folder-open",
        placeholder: "Dosya seçilmedi",
        buttonBefore: true
    });
}

function initMaxLength() {
    $('.max-length').maxlength({
        alwaysShow: true
    });
}

function initFilterButton() {
    $(".btn-filter").click(function (e) {
        e.preventDefault();
        var reload = true;
        if ($(this).attr('filter-reload') == 0) {
            reload = false;
        }
        $(this).trigger("change");

        insertParam($(this).attr('filter-param'), $(this).attr('filter-value'), reload);
    });
}

function initMask() {
    $('.date-mask').inputmask('dd.mm.yyyy', {'placeholder': 'GG.AA.YYYY'});
    $('.mobile').inputmask('(999) 999 99 99', {'placeholder': '(___) ___ __ __'});
    $(".url-mask").inputmask({regex: "https?://.*"});
}

function initMultiSelect() {
    $('.multi-select').multiSelect({
        selectableHeader: "<input type='text' class='search-input' style='width: 100%; margin-bottom: 10px;' autocomplete='off' placeholder='Arama'>",
        selectionHeader: "<input type='text' class='search-input' style='width: 100%; margin-bottom: 10px;' autocomplete='off' placeholder='Arama'>",
        afterInit: function () {
            $('#multiselect-loading').remove();
            var that = this,
                $selectableSearch = that.$selectableUl.prev(),
                $selectionSearch = that.$selectionUl.prev(),
                selectableSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)',
                selectionSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selection.ms-selected';

            that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                .on('keydown', function (e) {
                    if (e.which === 40) {
                        that.$selectableUl.focus();
                        return false;
                    }
                });

            that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                .on('keydown', function (e) {
                    if (e.which == 40) {
                        that.$selectionUl.focus();
                        return false;
                    }
                });
        },
        afterSelect: function () {
            this.qs1.cache();
            this.qs2.cache();
        },
        afterDeselect: function () {
            this.qs1.cache();
            this.qs2.cache();
        }
    });
}

function initTabRemember() {
    // Tab remember
    var hash = document.location.hash;
    var prefix = "tab_";
    if (hash) {
        $('.nav-tabs a[href="' + hash.replace(prefix, "") + '"]').tab('show');
    }

// Change hash for page-reload
    $('.nav-tabs a').on('shown.bs.tab', function (e) {
        window.location.hash = e.target.hash.replace("#", "#" + prefix);
    });
}

function initClipboard() {
    var clipboard = new ClipboardJS('.clipboard-text');
    clipboard.on('success', function (e) {
        $(e.trigger).tooltip({
            placement: 'bottom',
            trigger: 'manual',
            title: 'Kopyalandı'
        });
        $(e.trigger).tooltip('show');
        setTimeout(function () {
            $(e.trigger).tooltip('destroy');
            e.clearSelection();
        }, 1000);
    });
}

function initNumberInput() {
    $(".number").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            // Allow: Ctrl/cmd+A
            (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
            // Allow: Ctrl/cmd+C
            (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
            // Allow: Ctrl/cmd+X
            (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
            // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
}

function initSummernote() {
    $('.summernote').summernote({
        height: 200,
        toolbar: [
            ['style', ['style', 'bold', 'italic', 'underline', 'clear']],
            ['fontsize', ['fontsize']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link']],
            ['misc', ['fullscreen', 'codeview']]
        ]

    });
}

function initBrokenImage() {
    $('img').on('error', function () {
        console.log($(this));
        $(this).attr('src', '/admin/img/child_no_image.jpg');
    });
}

function initSidebar() {
    $.ajax({
        url: "/admin/sidebar/data",
        method: "GET"
    }).done(function (response) {
        $('.unapproved-user-count').text(response.data['unapproved-user-count']);
        $('.unapproved-post-count').text(response.data['unapproved-post-count']);
        $('.open-chat-count').text(response.data['open-chat-count']);
    });
}

// HELPER FUNTIONS
function deleteItem(slug, message, deleteClass = "delete", url = null) {
    $('.' + deleteClass).on('click', function (e) {
        var id = $(this).attr('delete-id');
        var name = $(this).attr('delete-name');
        swal({
            title: "Emin misin?",
            text: "'" + name + "' " + message,
            type: "warning",
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Evet, sil!",
            showCancelButton: true,
            cancelButtonText: "Hayır",
            showLoaderOnConfirm: true,
            preConfirm: function (email) {
                return new Promise(function (resolve, reject) {
                    var path = url ? url.replace('[ID]', id) : ("/admin/" + slug + "/" + id);
                    $.ajax({
                        url: path,
                        method: "DELETE",
                        dataType: "json",
                        success: function (result) {
                            resolve()
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            ajaxError(xhr, ajaxOptions, thrownError);
                        }
                    });
                })
            },
            allowOutsideClick: false,
        }).then(function () {
            $("#" + slug + "-" + id).remove();
            swal({
                title: "Başarıyla Silindi!",
                type: "success",
                confirmButtonText: "Tamam",
            });
        })
    });
}

function setFeaturedMedia(mediaId, selectorClass = 'feature-btn') {
    $('.' + selectorClass).html('<i class="fa fa-star-o"></i></button>').addClass('btn-default').removeClass('btn-warning');
    $('.' + selectorClass + '[feature-id=' + mediaId + ']').html('<i class="fa fa-star"></i></button>').addClass('btn-warning').removeClass('btn-default');
}

function featureItem(slug, message, buttonClass = "feature-btn", url = null) {
    $('.' + buttonClass).on('click', function () {
        var id = $(this).attr('feature-id');
        var path = url ? url.replace('[ID]', id) : ("/admin/" + slug + "/" + id + "/feature");
        $.ajax({
            url: path,
            method: "PUT"
        }).done(function (response) {
            setFeaturedMedia(response.data.media.id);
        }).fail(function (xhr, ajaxOptions, thrownError) {
            ajaxError(xhr, ajaxOptions, thrownError);
        });
    });
}

function setApprovalButton(elem, approval) {
    if (approval) {
        $(elem)
            .html('<i class="fa fa-check-square-o"></i>')
            .addClass('btn-success')
            .attr('title', 'Onayı Kaldır')
            .removeClass('btn-default')
            .closest("tr")
            .addClass('success')
            .removeClass('warning')
    } else {
        $(elem)
            .html('<i class="fa fa-square-o"></i>')
            .addClass('btn-default')
            .attr('title', 'Onayla')
            .removeClass('btn-success')
            .closest("tr")
            .addClass('warning')
            .removeClass('success')

    }
}

function sendApproval(slug, id, name, approval, callback) {
    $.ajax({
        url: "/admin/" + slug + "/" + id + "/approve",
        method: "PUT",
        dataType: "json",
        data: {
            'approval': approval
        },
    }).done(function (response) {
        callback(response)
    }).fail(function (xhr, ajaxOptions, thrownError) {
        ajaxError(xhr, ajaxOptions, thrownError);
    });
}

function approveItem(slug, approveMessage, unapproveMessage, callback, popup = true, approveClass = "approval") {
    $(function () {
        $('.approval').each(function () {
            setApprovalButton(this, $(this).attr('approved') == 1)
        })
    });

    $('.' + approveClass).on('click', function (e) {
        var button = $(this)
        var id = button.attr('approval-id');
        var name = button.attr('approval-name');
        var approval = (button.attr('approved') == '1' ? 0 : 1);
        if (popup) {
            swal({
                title: "Emin misin?",
                html: "'" + name + "' " + (approval ? approveMessage : unapproveMessage),
                type: "warning",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Evet, " + (approval ? 'onayla!' : 'onayı kaldır!'),
                showCancelButton: true,
                cancelButtonText: "Hayır",
                showLoaderOnConfirm: true,
                preConfirm: function () {
                    return new Promise(function (resolve, reject) {
                        sendApproval(slug, id, name, approval, function (response) {
                            resolve(response)
                        });
                    })
                },
                allowOutsideClick: false,
            }).then(function (response) {
                button.attr('approved', approval);
                setApprovalButton(button, response.data.approval)
                if (typeof callback === "function") {
                    callback(approval, id, name)
                }
            });

        } else {
            sendApproval(slug, id, name, approval, function (response) {
                button.attr('approved', approval);
                setApprovalButton(button, response.data.approval)
                if (typeof callback === "function") {
                    callback(approval, id, name)
                }
            });
        }
    });
}

function selectRole(slug, roles, buttonClass = "role") {
    $('.' + buttonClass).on('click', function (e) {
        var id = $(this).attr('item-id');
        var row = "#" + slug + "-" + id;
        var name = $(row).children('[itemprop=name]').html();
        var role = $(row).children('[itemprop=role]').html();
        swal({
            title: "Üye Yetkilendirme",
            html: "<h3><strong>Ad:</strong> " + name + "</h3>" +
                "<h3><strong>Aktif Görev:</strong> " + role + "</h3>",
            input: 'select',
            inputOptions: roles,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Değiştir!",
            showCancelButton: true,
            cancelButtonText: "İptal",
            showLoaderOnConfirm: true,
            onOpen: function () {
                $('.swal2-select').select2({
                    minimumResultsForSearch: Infinity,
                    dropdownCss: {'z-index': 9999999}
                });
            },
            preConfirm: function (role) {
                return new Promise(function (resolve, reject) {
                    if (role) {
                        $.ajax({
                            url: "/admin/" + slug + "/" + id,
                            method: "PUT",
                            data: {role: role}
                        })
                            .done(function (response) {
                                resolve(response)
                            })
                            .fail(function (xhr, ajaxOptions, thrownError) {
                                ajaxError(xhr, ajaxOptions, thrownError);
                            });
                    } else {
                        reject('Yeni görev seçmeniz gerekiyor')
                    }
                });
            },
            allowOutsideClick: false,
        }).then(function (response) {
            $(row).children('[itemprop=role]').text(response.data.role)
        })
    });
}


function ajaxError(xhr, ajaxOptions, thrownError) {
    message = "Bir hata ile karşılaşıldı!";
    console.log("XHR:");
    console.log(xhr);
    // if (xhr.responseJSON.message) {
    //   message = xhr.responseJSON.message;
    //   if (xhr.responseJSON.errors) {
    //     message += "\n\n" + xhr.responseJSON.errors;
    //   }
    // }
    console.log("Ajax Options:");
    console.log(ajaxOptions);
    console.log("Thrown Error:");
    console.log(thrownError);
    swal({
        title: message,
        type: "error",
        confirmButtonText: "Tamam",
    });
}

function block(selector) {
    $(selector).block({
        message: null,
    });
}

function unblock(selector) {
    $(selector).unblock();
}

function getSelecteds(class_name) {
    var selected = [];
    if (class_name) {
        $('.' + class_name + ':checkbox:checked').each(function () {
            selected.push($(this).val());
        });
    } else {
        $('input:checked').each(function () {
            selected.push($(this).val());
        });
    }
    return selected;
}

function checkAll(check_id, check_class) {
    $('#' + check_id).change(function () {
        $('.' + check_class).prop("checked", this.checked);
    });
}

function insertParam(key, value, reload = true) {
    key = encodeURI(key);
    value = encodeURI(value);
    var kvp = document.location.search.substr(1).split('&');
    var i = kvp.length;
    var x;
    while (i--) {
        x = kvp[i].split('=');

        if (x[0] == key) {
            x[1] = value;
            kvp[i] = x.join('=');
            break;
        }
    }

    if (i < 0) {
        kvp[kvp.length] = [key, value].join('=');
    }

    //this will reload the page, it's likely better to store this until finished
    if (reload) {
        document.location.search = kvp.join('&');
    } else {
        var newUrl = document.location.origin + document.location.pathname + "?" + kvp.join('&');
        window.history.replaceState(null, null, newUrl);
    }
}

function searchItem(button, input, param) {
    $('#' + input).focus();
    $('#' + button).click(function () {
        insertParam(param, $('#' + input).val());
    })
    $('#' + input).on("keydown", function (e) {
        if (e.keyCode == 13) {
            insertParam(param, $('#' + input).val());
        }
    });
}

function getChartColors() {
    return ['rgba(255, 99, 132, 0.5)', 'rgba(54, 162, 235, 0.5)', 'rgba(255, 206, 86, 0.5)', 'rgba(75, 192, 192, 0.5)', 'rgba(153, 102, 255, 0.5)', 'rgba(255, 159, 64, 0.5)', 'rgba(220,20,60, 0.5)', 'rgba(173,255,47, 0.5)', 'rgba(0,250,154, 0.5)', 'rgba(0,206,209, 0.5)', 'rgba(0,191,255, 0.5)', 'rgba(225,200,220, 0.5)', 'rgba(244,164,96, 0.5)', 'rgba(50,205,50, 0.5)', 'rgba(255, 99, 132, 0.5)', 'rgba(54, 162, 235, 0.5)', 'rgba(255, 206, 86, 0.5)', 'rgba(75, 192, 192, 0.5)', 'rgba(153, 102, 255, 0.5)', 'rgba(255, 159, 64, 0.5)', 'rgba(220,20,60, 0.5)', 'rgba(173,255,47, 0.5)', 'rgba(0,250,154, 0.5)', 'rgba(0,206,209, 0.5)', 'rgba(0,191,255, 0.5)', 'rgba(225,200,220, 0.5)', 'rgba(244,164,96, 0.5)', 'rgba(50,205,50, 0.5)', 'rgba(255, 99, 132, 0.5)', 'rgba(54, 162, 235, 0.5)', 'rgba(255, 206, 86, 0.5)', 'rgba(75, 192, 192, 0.5)', 'rgba(153, 102, 255, 0.5)', 'rgba(255, 159, 64, 0.5)', 'rgba(220,20,60, 0.5)', 'rgba(173,255,47, 0.5)', 'rgba(0,250,154, 0.5)', 'rgba(0,206,209, 0.5)', 'rgba(0,191,255, 0.5)', 'rgba(225,200,220, 0.5)', 'rgba(244,164,96, 0.5)', 'rgba(50,205,50, 0.5)',
    ];
}

function initChart(id, type, labels, data, label) {
    var ctx = document.getElementById(id).getContext('2d');
    return new Chart(ctx, {
        type: type,
        data: {
            labels: labels,
            datasets: [{
                label: label,
                data: data,
                backgroundColor: getChartColors(),
            }]
        },
    });
}

function initPieChart(id, labels, data) {
    initChart(id, 'pie', labels, data);
}

