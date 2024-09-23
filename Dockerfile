# Utiliser l'image officielle PHP avec Apache
FROM php:8.1-apache

# Installer les extensions PHP nécessaires
RUN docker-php-ext-install pdo pdo_mysql

# Copier tout le contenu de ton application dans le dossier de l'image Docker
COPY . /var/www/html/

# Assurer que le dossier a les bons droits pour Apache
RUN chown -R www-data:www-data /var/www/html

# Exposer le port 80
EXPOSE 80