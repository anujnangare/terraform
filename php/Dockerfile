FROM php:8.2-fpm

# Install mysqli and pdo_mysql extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Set working directory
WORKDIR /var/www/html

# Copy application files are mounted by docker-compose; optional: copy default files
# COPY . /var/www/html

# Set permissions (optional)
RUN chown -R www-data:www-data /var/www/html
