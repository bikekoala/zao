###
# 早~ 嗷嗷嗷嗷～
##
server {
    listen      80;
    server_name zaoaoaoaoao.com www.zaoaoaoaoao.com;
    root        /var/www/zao/public;
    index       index.php;

    # www域名跳转 
    if ($host = 'www.zaoaoaoaoao.com' ) {
        rewrite ^/(.*)$ http://zaoaoaoaoao.com/$1 permanent;
    }

    # 主站入口
    location / {
        try_files $uri $uri/ /index.php$is_args$args;
    }

    location ~ \.php$ {
        fastcgi_pass    127.0.0.1:9000;
        fastcgi_param   SCRIPT_FILENAME  $document_root$fastcgi_script_name;
        include         fastcgi_params;
    }

    access_log  /var/log/nginx/access.zaoaoaoaoao.com.log;
    error_log   /var/log/nginx/error.zaoaoaoaoao.com.log error;
}
