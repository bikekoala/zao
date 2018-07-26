<style type="text/css">
    #donate-module {
        margin-top: 30px;
        text-align: center;
    }
    #donate-module a.btn-donate {
        display: inline-block;
        width: 82px;
        height: 82px;
        zoom: 90%;
        background: url("/static/img/btn_donate.gif") no-repeat;
    }
    #donate-module a.btn-donate:hover {
        background-position: 0px -82px;
    }
    #donate-module .donate-guide {
        display: none;
        margin-top: 20px;
    }
    #donate-module .donate-guide span {
        display: block;
        margin-top: 5px;
        font-size: 12px;
        color: #9d9d9d;
    }
    #donate-module .donate-qrcode {
        height: 8em;
    }
    #donate-module .donate-qrcode img {
        height: 100%;
    }
</style>

<div id="donate-module">
    <a class="btn-donate" id="btn-donate" href="javascript:;"></a>
    <div class="donate-guide">
        <div class="donate-qrcode">
            <a href="https://paypal.me/sunxuewu" target="_blank"><img src="/static/img/donate_paypal.jpg" alt="PayPal" title="PayPal.Me/sunxuewu"></a>
            <img src="/static/img/feiyushow.jpg" alt="飞鱼全家福">
            <a href="javascript:;"><img src="/static/img/donate_alipay_new.jpg" alt="Alipay" title="Alipay"></a>
            <!--img src="/static/img/donate_wechat.jpg" alt="微信" title="微信"-->
        </div>
        <span>这将用于支付AWS服务器和七牛云存储、带宽的账单，谢谢你</span>
    </div>
</div>

<script type="text/javascript">
    $(function() {
        $('#btn-donate').on('click', function() {
            $('#donate-module .donate-guide').toggle();
            $('html, body').animate({scrollTop: $(document).height()}, 300);
        });
        $('#donate-module .donate-qrcode').css('height', $('#donate-module').width() / 3.7)
    })
</script>
