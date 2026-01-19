FROM php:8.2-apache

# Instalar extensiones necesarias
RUN apt-get update && apt-get install -y \
    libpq-dev \
    cron \
    && docker-php-ext-install pdo pdo_pgsql \
    && apt-get clean

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Copiar archivos del proyecto
COPY . /var/www/html/

# Configurar permisos
RUN chown -R www-data:www-data /var/www/html

# Copiar y configurar crontab
COPY crontab /etc/cron.d/newsletter-cron
RUN chmod 0644 /etc/cron.d/newsletter-cron \
    && crontab /etc/cron.d/newsletter-cron \
    && touch /var/log/cron.log

# Configurar Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Exponer puerto
EXPOSE 80

# Iniciar Apache y Cron
CMD cron && apache2-foreground