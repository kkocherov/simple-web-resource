FROM ubuntu:18.04

ADD . /app

WORKDIR /app

ENV DEBIAN_FRONTEND=noninteractive
RUN  apt-get update && \
    apt-get install -y php php-fpm php-mbstring \
    php-pdo php-pgsql php-json ca-certificates

RUN mkdir /run/php/

RUN echo "listen = 0.0.0.0:9000" >> /etc/php/7.2/fpm/pool.d/www.conf;

RUN php composer.phar install

EXPOSE 9000

ENTRYPOINT php-fpm7.2 -F -R