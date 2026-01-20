FROM php:8.4-fpm

# সিস্টেম ডিপেন্ডেন্সি ইন্সটল
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip libzip-dev

# পিএইচপি এক্সটেনশন (অ্যাসাইনমেন্টের জন্য প্রয়োজনীয়)
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# কম্পোজার কপি করা
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# পারমিশন ফিক্স: ডকার ইউজারকে আপনার পিসির ইউজারের সাথে সিঙ্ক করা
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

WORKDIR /var/www/html

# ওনারশিপ সেট করা
RUN chown -R www-data:www-data /var/www/html

USER www-data