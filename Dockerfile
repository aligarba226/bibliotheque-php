FROM php:8.3-apache

# Installer l'extension PDO MySQL requise pour se connecter à Aiven
RUN docker-php-ext-install pdo pdo_mysql

# Copier tous les fichiers du projet dans le serveur web
COPY . /var/www/html/

# Donner les bonnes permissions
RUN chown -R www-data:www-data /var/www/html

# Exposer le port 80 pour le web
EXPOSE 80