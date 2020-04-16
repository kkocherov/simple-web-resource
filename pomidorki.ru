server {
        listen 80;
        server_name pomidorki.ru;

        access_log /var/log/access.log;
        error_log /var/log/error.log;

        root /home/kirill/workspace/auth-example;

        location ~ \.php$ {
               include snippets/fastcgi-php.conf;

               fastcgi_pass unix:/run/php/php7.2-fpm.sock;
#               fastcgi_pass 127.0.0.1:9000;
        }


}
