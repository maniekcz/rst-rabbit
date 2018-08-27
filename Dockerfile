FROM php:7.2-apache

RUN a2enmod rewrite

RUN apt-get update && apt-get install -y libicu-dev git libz-dev wget nano libpng-dev libcurl4-openssl-dev vim netcat  \
    && rm -rf /var/lib/apt/lists/*r

RUN docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd && docker-php-ext-install pdo_mysql
RUN docker-php-ext-install intl opcache zip mbstring gd sockets bcmath

RUN wget https://getcomposer.org/composer.phar && mv composer.phar /usr/bin/composer && chmod +x /usr/bin/composer
RUN pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini

ADD ./docker/web/apache.conf /etc/apache2/sites-enabled/000-default.conf
ADD ./docker/web/php.ini /usr/local/etc/php/php.ini
ADD ./backend /var/www/symfony

COPY ./docker/web/apache2-foreground /usr/bin/apache2-foreground
COPY ./docker/web/entrypoint.sh /usr/bin/entrypoint.sh
RUN chmod +x /usr/bin/entrypoint.sh

WORKDIR /var/www/symfony
RUN mkdir -p var/log

RUN chmod -R 777 ./var/
RUN chown -R www-data:www-data /var/www/symfony

ENTRYPOINT ["/usr/bin/entrypoint.sh"]
CMD ["apache2-foreground"]

