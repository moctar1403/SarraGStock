FROM richarvey/nginx-php-fpm:latest

# Copier le code
COPY . /var/www/html/

WORKDIR /var/www/html

# Ne pas sauter Composer
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1
ENV APP_ENV production
ENV APP_DEBUG true
ENV LOG_CHANNEL stderr
ENV COMPOSER_ALLOW_SUPERUSER 1

# Installer les extensions nécessaires
RUN apk update && \
    apk add --no-cache curl && \
    docker-php-ext-install pdo_mysql

# Créer le fichier .env à partir de .env.example
RUN if [ ! -f .env ]; then cp .env.example .env; fi

# Installer les dépendances PHP avec Composer
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Générer la clé Laravel
RUN php artisan key:generate

# Permissions pour storage et cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache