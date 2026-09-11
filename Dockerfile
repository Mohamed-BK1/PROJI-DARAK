FROM php:8.2-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN a2enmod rewrite

# السماح لـ Apache بقراءة الملفات وتغيير DirectoryIndex
RUN echo "<Directory /var/www/html/>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
    DirectoryIndex index.php index.html login.php register.php\n\
</Directory>" > /etc/apache2/conf-available/override.conf \
    && a2enconf override

COPY PROJI-DARAK /var/www/html/
EXPOSE 80
