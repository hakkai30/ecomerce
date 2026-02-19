FROM php:8.2-apache

# Instal·lar extensions necessàries per PDO i mysqli
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Habilitar mod_rewrite (opcional)
RUN a2enmod rewrite

# Assignar permisos
RUN chown -R www-data:www-data /var/www/html
