FROM php:8.3-fpm

# Installation des dépendances système
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libicu-dev \
    && docker-php-ext-install pdo pdo_mysql zip intl

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www/frontend

# Copier les fichiers du projet
COPY . .

# Installation des dépendances PHP
RUN composer install --no-interaction --optimize-autoloader

# Permissions
RUN chown -R www-data:www-data /var/www/frontend

# Exposer le port
EXPOSE 8080

# Commande de démarrage
CMD php -S 0.0.0.0:8080 -t public