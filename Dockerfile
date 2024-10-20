FROM php:8.0-apache

RUN docker-php-ext-install pdo pdo_mysql

COPY ./src /var/www/html/

RUN chown -R www-data:www-data /var/www/html/
RUN chmod -R 755 /var/www/html/

COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 80
