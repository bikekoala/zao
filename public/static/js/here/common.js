// 绑定加载远程 Modal 框
var bindRemoteModal = function($ele) {
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
        $modal.find('.modal-content').load(url, null, bindRemoteModal);
        $modal.modal({backdrop: false, show: true});
    };

    if ($ele instanceof jQuery) {
        load($ele);
    } else {
        $('.load-remote-modal').off().on('click', function() {
            load($(this));
        });
    }
}
