FROM php:8.2-apache

# 1. ติดตั้ง System Dependencies (เพิ่ม ca-certificates สำหรับเชื่อมต่อ TiDB SSL)
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev zip unzip git curl ca-certificates \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 2. ติดตั้ง Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 3. ชี้ Apache DocumentRoot ไปที่โฟลเดอร์ public และเปิดใช้ mod_rewrite
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN a2enmod rewrite

WORKDIR /var/www/html
COPY . .

# 4. ติดตั้ง Composer packages
RUN composer install --no-dev --optimize-autoloader

# 5. สร้าง Storage Symlink ตั้งแต่ตอน Build (รันด้วยสิทธิ์ root จึงไม่ติด Permission denied)
RUN php artisan storage:link || true

# 6. กำหนดสิทธิ์ให้ Apache (www-data) ใช้งานโฟลเดอร์และแคชได้อย่างสมบูรณ์
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80
CMD ["apache2-foreground"]