###
# 早~ 嗷嗷嗷嗷～
##
server {
    listen      80;
    server_name zaoaoaoaoao.com;
    return      301 https://$host$request_uri;
}

server {
    listen      443 ssl;
    server_name zaoaoaoaoao.com www.zaoaoaoaoao.com;
    root        /var/www/zao/public;
    index       index.php;

    # ssl 证书 
    # https://gist.github.com/konklone/6532544 
    ssl_certificate /var/www/zao/document/nginx/unified.crt;
    ssl_certificate_key /var/www/zao/document/nginx/ssl.key.unsecure;

    # www 域名跳转 
    if ($host = 'www.zaoaoaoaoao.com' ) {
        rewrite ^/(.*)$ https://zaoaoaoaoao.com/$1 permanent;
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
