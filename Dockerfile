FROM richarvey/nginx-php-fpm:latest

# Copier le code
COPY . /var/www/html/

WORKDIR /var/www/html

ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1
ENV APP_ENV production
ENV APP_DEBUG true   # <-- Temporairement true pour voir l'erreur exacte
ENV LOG_CHANNEL stderr
ENV COMPOSER_ALLOW_SUPERUSER 1

# Installer les extensions nécessaires
RUN apk update && \
    apk add --no-cache curl \
    && docker-php-ext-install pdo_mysql

# Générer la clé Laravel supprime l'erreur 500
RUN php artisan key:generate

# Permissions pour storage et cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache