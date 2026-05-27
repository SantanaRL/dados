FROM php:8.4-apache

WORKDIR /var/www/html

RUN sed -i 's|main|main non-free|' /etc/apt/sources.list.d/debian.sources && apt-get update && apt-get install -y \
    unixodbc \
    unixodbc-dev \
    freetds-bin \
    freetds-dev \
    libicu-dev \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libssl-dev \
    curl \
    libmemcached-dev

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# php libs (Core)
RUN docker-php-ext-install \
    intl \
    pdo_mysql \
    soap \
    zip \
    mbstring \
    bcmath \
    pdo_dblib
RUN pecl install memcached && docker-php-ext-enable memcached

# gd
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd

# php memory
ENV PHP_MEMORY_LIMIT=4096M
RUN echo "memory_limit=${PHP_MEMORY_LIMIT}" > "${PHP_INI_DIR}/conf.d/memory.ini"


# apache
RUN a2enmod rewrite
RUN sed -i 's|/var/www/html|/var/www/html/public|' /etc/apache2/sites-available/000-default.conf
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction

RUN chown -R www-data:www-data /var/www/html

USER www-data

CMD ["apache2-foreground"]