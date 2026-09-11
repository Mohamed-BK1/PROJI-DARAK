FROM php:8.2-apache
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN echo "DirectoryIndex login.php index.php index.html" > /var/www/html/.htaccess
COPY . /var/www/html/
EXPOSE 80
