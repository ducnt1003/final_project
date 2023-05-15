FROM php:8.0-alpine  


RUN docker-php-ext-install pdo pdo_mysql

RUN apk update && apk add --no-cache supervisor

CMD ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisord.conf"]
