# Ici on lui dit je veux utiliser une boîte toute prête qui contient PHP et Apache
FROM php:7.4-apache

# Installer les extensions PDO et PDO MySQL pour permettre l'utilisation de PDO avec MySQL
RUN docker-php-ext-install pdo pdo_mysql

RUN docker-php-ext-install mysqli

# Copier le contenu du répertoire (tes fichiers index.html, style.css ...) actuel dans le répertoire du serveur Apache
COPY ./ /var/www/html/

#On donne les clés à Apache pour qu'il puisse utiliser les fichiers qu'on a mis dans la boîte.
# www-data est un utilisateur créé par défaut pour Apache
# La commande chown permet de donner à Apache la permission de lire et utiliser les fichiers que tu mets dans ton site web.
RUN chown -R www-data:www-data /var/www/html 