FROM php:8.3

# Install system dependencies
RUN apt-get update -y && apt-get install -y \
    openssl \
    zip \
    unzip \
    git \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP extensions
RUN docker-php-ext-install pdo mbstring pdo_mysql

WORKDIR /app
COPY . .
RUN composer install

CMD php artisan serve --host=0.0.0.0
EXPOSE 8000
