// 初始化地图
$.maps.draw();

// 重载地图
$('#switch-map').click(function() {
    //this.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';

    $('#user-tips').addClass('hide');

    if ('自己' === this.innerHTML) {
        $.maps.draw('personal');
        this.innerHTML = '世界';
    } else {
        $.maps.draw('world');
        this.innerHTML = '自己';
    }
});

// 用户下拉菜单
$('#user').on('mouseenter', function() {
    $('#user-tips').removeClass('hide');
}).on('mouseleave', function() {
    setTimeout(function() {
        $('#user-tips').addClass('hide');
    }, 100);
});

// 加载远程 Modal 框
var loadRemoteModal = function($ele) {
    var load = function($ele) {
        var url = $ele.attr('data-url');
        var $modal = $('#basic-modal');

        // 移除数据
        $modal.removeData('bs.modal');

        // 提示缓冲
        loadingHtml = '<div class="modal-body">' +
                      '    <h2 class="text-center">' +
                      '        <i class="fa fa-spinner fa-spin"></i>' +
                      '    </h2>' +
                      '</div>';
        $modal.find('.modal-content').html(loadingHtml);

        // 异步加载数据，并显示
        $modal.find('.modal-content').load(url, null, loadRemoteModal);
        $modal.modal({backdrop: false, show: true});
    };

    if ($ele instanceof jQuery) {
        load($ele);
    } else {
        $('.load-remote-modal').on('click', function() {
            load($(this));
        });
    }
}
loadRemoteModal();
