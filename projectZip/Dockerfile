# Use official PHP image with Apache
FROM php:8.1-apache

# Install necessary PHP extensions (if needed)
RUN docker-php-ext-install pdo pdo_mysql

# Enable Apache mod_rewrite (if needed)
RUN a2enmod rewrite

# Copy project files to Apache root
COPY . /var/www/html/

# Set proper file permissions (if required)
RUN chown -R www-data:www-data /var/www/html

# Set working directory
WORKDIR /var/www/html

# Expose port 80
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]
