FROM php:8.0-fpm

RUN apt-get update && apt-get install -y git

RUN docker-php-ext-install pdo pdo_mysql

RUN pecl install phalcon && \
    docker-php-ext-enable phalcon

COPY . /var/www/html

WORKDIR /var/www/html

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install --no-dev --optimize-autoloader

RUN git clone https://github.com/lmfmaier/phalcon-5-devtools.git /opt/phalcon-devtools && \
    ln -s /opt/phalcon-devtools/phalcon.php /usr/local/bin/phalcon

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]