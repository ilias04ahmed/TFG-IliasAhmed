FROM php:8.2-apache

RUN apt-get update && apt-get install -y --no-install-recommends \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite

# 1. Nos situamos en el directorio de trabajo
WORKDIR /var/www/html

# 2. COPIAMOS LOS ARCHIVOS PRIMERO (para que la carpeta /src/public ya exista)
COPY . .

# 3. Definimos la ruta y configuramos Apache
ENV APACHE_DOCUMENT_ROOT=/var/www/html/src/public

RUN sed -ri -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/*.conf \
    && sed -ri -e "s!/var/www/!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/apache2.conf

RUN echo "<Directory ${APACHE_DOCUMENT_ROOT}>" >> /etc/apache2/apache2.conf && \
    echo '    Options FollowSymLinks' >> /etc/apache2/apache2.conf && \
    echo '    AllowOverride All' >> /etc/apache2/apache2.conf && \
    echo '    Require all granted' >> /etc/apache2/apache2.conf && \
    echo '</Directory>' >> /etc/apache2/apache2.conf