$(function() {
    // Datatime Picker
    $('#date').datetimepicker({
        locale: 'zh-cn',
        format: 'YYYY-MM'
    });

    // Google Maps Autocomplete input
    $('#location').select2({
        ajax: {
            url: '/here/placeAutocomplete',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    input: params.term
                };
            },
            processResults: function(data) {
                if ('OK' === data.status) {
                    var list = [];
                    for (var i in data.predictions) {
                        list[i] = {
                            id: data.predictions[i].place_id,
                            text: data.predictions[i].description
                        };
                    }
                    return {
                        results: list,
                        more: false
                    };
                } else {
                    return {
                        results: [{
                            disabled: true,
                            loading: true,
                            text: data.status
                        }]
                    };
                }
            },
            cache: true
        },
        theme: 'bootstrap'
    });

    // Submit
    $('#submit').on('click', function() {
        // init
        var $that = $(this);
        var $form = $('#form');
        var $btns = $('.modal-footer>button');
        var $message = $('#message');

        // clean message
        $message.html('');

        // validation
        var pmessages = {
            'location': '请搜寻一个地点',
            'date'    : '请选择一个日期'
        };
        var params = $form.serializeArray();
        var pnames = {};
        for (var i in params) {
            if ('' !== params[i].value) {
                pnames[params[i].name] = 1;
            }
        }
        for (var pname in pmessages) {
            if (1 !== pnames[pname]) {
                $message.html(pmessages[pname]);
                return false;
            }
        }

        // send request
        $.ajax({
            type: 'POST',
            url: '/heres',
            data: params,
            beforeSend: function() {
                $message.html('<i class="fa fa-spinner fa-spin"></i> 正在保存 ...');
                $btns.attr('disabled', true);
            },
            success: function(data) {
                if ('OK' === data.status) {
                    loadRemoteModal($that);
                } else {
                    $message.html('保存失败，请刷新重试，或通知 <a href="http://weibo.com/doyoufly" target="_blank"><u>樹袋大熊</u></a>');
                    $btns.attr('disabled', false);
                }
            }
        });
        return false;
    });

    // Delete
    $('#delete').on('click', function() {
        // init
        var $that = $(this);
        var $form = $('#form');
        var $btns = $('.modal-footer>button');
        var $message = $('#message');
        var id = $form.children('input[name="id"]').val();

        // clean message
        $message.html('');

        // send request
        $.ajax({
            type: 'DELETE',
            url: '/heres/' + id,
            beforeSend: function() {
                $message.html('<i class="fa fa-spinner fa-spin"></i> 正在删除 ...');
                $btns.attr('disabled', true);
            },
            success: function(data) {
                if ('OK' === data.status) {
                    loadRemoteModal($that);
                } else {
                    $message.html('删除失败，请刷新重试，或通知 <a href="http://weibo.com/doyoufly" target="_blank"><u>樹袋大熊</u></a>');
                    $btns.attr('disabled', false);
                }
            }
        });
        return false;
    });
});
