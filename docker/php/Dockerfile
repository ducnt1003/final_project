FROM php:8.0-fpm

ENV SOURCE_ROOT /var/www/html/my-app
RUN mkdir -p ${SOURCE_ROOT} && groupadd -g 1000 nginx && useradd -g 1000 -u 1000 -d ${SOURCE_ROOT} -s /bin/bash nginx

# Set working directory
WORKDIR /var/www/html/my-app/

# Install dependencies for the operating system software
RUN apt-get update && apt-get install -y \
    cron \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    libzip-dev \
    unzip \
    git \
    libonig-dev \
    curl \
    procps

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions for php
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd

# Install composer (php package manager)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# RUN curl -sL https://deb.nodesource.com/setup_16.x | bash -
# RUN apt-get install -y nodejs

#Config cron
RUN touch /var/log/cron.log
RUN crontab -l | { cat; echo "* * * * * cd /var/www/html/my-app && php artisan schedule:run >> /var/log/cron.log"; } | crontab -


# Copy existing application directory contents to the working directory
COPY ./my-app /var/www/html/my-app

# Assign permissions of the working directory to the www-data user
RUN chown -R nginx:nginx \
        /var/www/html/my-app/

# RUN chmod -R 777 \
#         /var/www/html/my-app/storage \
#         /var/www/html/my-app/bootstrap/cache

# Expose port 9000 and start php-fpm server (for FastCGI Process Manager)
EXPOSE 9000
CMD ["php-fpm"]