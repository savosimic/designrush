# 1) Base PHP/Composer image
FROM php:8.2-cli

# 2) Install PHP extensions + system deps
RUN apt-get update \
  && apt-get install -y \
       git \
       unzip \
       libzip-dev \
       libpng-dev \
       libonig-dev \
       curl \
  && docker-php-ext-install \
       pdo_mysql mbstring zip exif pcntl bcmath gd

# 3) Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4) Install Node.js (LTS) for compiling assets
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
  && apt-get install -y nodejs \
  && npm install -g npm

# 5) Set working dir
WORKDIR /var/www/html

# 6) Copy project files
COPY . .
RUN if [ ! -f .env ]; then cp .env.example .env; fi

# 7) Install PHP deps, build assets & cache
RUN composer install --no-interaction --prefer-dist \
  && php artisan key:generate \
  && npm install \
  && npm run build \
  && php artisan config:cache \
  && php artisan route:cache \
  && php artisan view:cache

# 8) Expose Laravel’s built-in server port
EXPOSE 8000

# 9) Default command: run migrations, seed data, tests, then start
CMD php artisan migrate --seed --force \
#  && php artisan test \
  && php artisan serve --host=0.0.0.0 --port=8000
