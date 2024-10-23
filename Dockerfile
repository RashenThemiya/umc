# Use the official PHP with Apache image
FROM php:8.1-apache

# Install necessary PHP extensions
RUN docker-php-ext-install mysqli

# Enable Apache mod_rewrite (useful for routing)
RUN a2enmod rewrite

# Set working directory to Apache's web root
WORKDIR /var/www/html

# Copy project files into the container
COPY . /var/www/html/

# Set permissions for Apache
RUN chown -R www-data:www-data /var/www/html

# Expose Apache on port 80
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]
