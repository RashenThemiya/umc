# Use the official PHP image with Apache pre-installed
FROM php:8.1-apache

# Install additional PHP extensions if needed
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable Apache mod_rewrite (useful for many PHP frameworks)
RUN a2enmod rewrite

# Copy application code into the /var/www/html directory in the container
COPY . /var/www/html

# Set permissions to make sure Apache can access the files
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose port 80 to access the application
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]
