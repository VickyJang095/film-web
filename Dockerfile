# Sử dụng PHP 8.2 kèm Apache
FROM php:8.2-apache

# Cài các tiện ích mở rộng Laravel cần
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libzip-dev \
    unzip \
    git \
    curl \
    zip \
    && docker-php-ext-install pdo_mysql mbstring zip

# Cài Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy toàn bộ mã nguồn Laravel vào container
COPY . /var/www/html

# Thiết lập thư mục làm việc
WORKDIR /var/www/html

# Thiết lập quyền
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

# Cài đặt Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Cấu hình Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN a2enmod rewrite

# Copy file cấu hình Apache
COPY ./000-default.conf /etc/apache2/sites-available/000-default.conf

# Cổng mặc định Apache (Render yêu cầu chạy trên 0.0.0.0:10000)
EXPOSE 80
