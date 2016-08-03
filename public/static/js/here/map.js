// 初始化地图
$.maps.draw();

// 绑定切换地图
$('#switch-map').click(function() {
    var mode = this.innerHTML;
    var that = this;

    this.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';

    setTimeout(function() {
        document.getElementById('user-tips').className += ' hide';
        that.innerHTML = {'自己': '世界', '世界': '自己'}[mode];
    }, 1000);

    setTimeout(function() {
        $.maps.draw({'自己': 'personal', '世界': 'world'}[mode]);
    }, 0);
});

// 绑定下拉菜单
$('#user').on('mouseenter', function() {
    $('#user-tips').removeClass('hide');
}).on('mouseleave', function() {
    setTimeout(function() {
        $('#user-tips').addClass('hide');
    }, 100);
});

// 绑定加载远程 Modal 框
bindRemoteModal();

// 关闭 Modal 框时刷新地图
$('#basic-modal').on('hide.bs.modal', function(e) {
    var mode = document.getElementById('switch-map').innerHTML;
    $.maps.draw({'自己': 'world', '世界': 'personal'}[mode]);
})
