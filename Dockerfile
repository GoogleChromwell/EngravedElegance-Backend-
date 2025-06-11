# Use official PHP image with Apache
FROM php:8.2-apache

# Enable mod_rewrite (optional)
RUN a2enmod rewrite

# Copy all project files into the container's web root
COPY . /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html
