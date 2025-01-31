FROM php:8.1-apache
WORKDIR /var/www/html

RUN apt update
RUN apt-get install -y build-essential re2c libaio1 unzip wget
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN php -r "unlink('composer-setup.php');"
RUN echo 'memory_limit = 1024M' >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini
RUN a2enmod rewrite
EXPOSE 80