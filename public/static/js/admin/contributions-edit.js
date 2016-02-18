$(function() {
    // 自动选择回复的话
    $('input[name="state"]').click(function() {
        const messages = {'1' : '谢谢你~', '-1' : '抱歉呐，没有通过审核。'};
        $('input[name="reply_message"]').val(messages[this.value]);
    });
    $('input[name="state"]').each(function() {
        1 == this.value && this.click();
    });

    // 提示工具
    $('[data-toggle="tooltip"]').tooltip();
});
