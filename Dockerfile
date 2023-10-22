FROM php:8.1-apache
# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    locales \
    libzip-dev \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd
RUN docker-php-ext-install gd

COPY . .
RUN curl -sS https://getcomposer.org/installer | php -- --version=2.6.5 --install-dir=/usr/local/bin --filename=composer
RUN composer install

CMD ["php","artisan","serve","--host=0.0.0.0","--port=8000"]
EXPOSE 8000

LABEL authors="jwhangbo"

#ENTRYPOINT ["top", "-b"]
