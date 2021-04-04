FROM php:7.4-fpm

# Set working directory
ENV LARAVEL_PATH=/srv/app
WORKDIR $LARAVEL_PATH

# Install system dependencies
RUN apt-get update && apt-get install -y build-essential cron curl locales zip unzip git

RUN apt-get update && \
    apt-get install -y \
    zlib1g \
    fontconfig \
    libfreetype6 \
    libx11-dev \
    libxext-dev \
    wget \
    libjpeg62-turbo \
    #libssl1.0-dev \
    libxrender-dev \
    xvfb \
    xfonts-75dpi \
    cpulimit && \
    apt-get clean
# RUN wget https://downloads.wkhtmltopdf.org/0.12/0.12.5/wkhtmltox_0.12.5-1.stretch_amd64.deb
RUN ls
COPY ./deploy/wkhtmltox_0.12.5-1.stretch_amd64.deb /
RUN dpkg -i /wkhtmltox_0.12.5-1.stretch_amd64.deb

# Install PHP extensions
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/
RUN install-php-extensions intl bcmath gd pdo_mysql opcache uuid exif pcntl zip
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install composer & app dependencies
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer
COPY composer.json composer.json
COPY composer.lock composer.lock
# TODO remove prestissimo when composer hits v2
# RUN composer global require hirak/prestissimo --no-plugins --no-scripts
RUN composer install --prefer-dist --no-scripts --no-dev --no-autoloader && rm -rf /root/.composer
# Copy app
COPY . $LARAVEL_PATH/
COPY ./deploy/config/php/local.ini /usr/local/etc/php/conf.d/local.ini
RUN chmod -R 775 $LARAVEL_PATH/storage

RUN composer dump-autoload --no-interaction --no-dev --optimize
# Start app
EXPOSE 80
CMD php -S 0.0.0.0:80 -t public
