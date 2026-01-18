# Usamos PHP con Apache
FROM php:8.2-apache

# Instalamos las librerías necesarias para PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# CONFIGURACIÓN DE RUTA: 
# Raíz de la web: carpeta /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copiamos el contenido al contenedor
COPY . /var/www/html/

# Permisos para evitar errores de escritura
RUN chown -R www-data:www-data /var/www/html