FROM php:8.2-apache

# Cài các tiện ích cần thiết
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl libpng-dev libonig-dev \
    && docker-php-ext-install pdo pdo_mysql zip gd

# Cài Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy Laravel code
COPY . /var/www/html

# Chỉ định thư mục làm việc
WORKDIR /var/www/html

# Cấp quyền
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache \
    && a2enmod rewrite

# Sửa cấu hình Apache để lắng nghe đúng cổng Render cung cấp
RUN sed -i 's/80/${PORT}/g' /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

# Copy lại cấu hình Apache nếu bạn có file custom
COPY ./000-default.conf /etc/apache2/sites-available/000-default.conf

# Tạo thư mục secrets (tuỳ ứng dụng bạn cần)
RUN mkdir -p /etc/secrets

# Cài Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Tạo key và cache config
RUN php artisan key:generate \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# EXPOSE mặc định, Render sẽ dùng biến PORT
EXPOSE 8080

# Start Apache foreground
CMD apache2-foreground
