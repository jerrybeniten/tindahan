FROM php:8.2-apache

# Enable SSL and necessary Apache modules
RUN a2enmod ssl
RUN a2enmod rewrite

ARG user
ARG uid

# Install Apache, PHP, and Composer
RUN apt-get update && apt-get install -y \ 
    apache2 \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    certbot \
    python3-certbot-apache \
    vim \
    npm 

# Enable Apache modules
RUN a2enmod rewrite

# Create directories for SSL certificates
RUN mkdir -p /etc/ssl/certs /etc/ssl/private

# Generate a self-signed SSL certificate for local development if the environment is local
ARG ENVIRONMENT=local

RUN if [ "$ENVIRONMENT" = "local" ]; then \
        openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
        -keyout /etc/ssl/private/selfsigned.key \
        -out /etc/ssl/certs/selfsigned.crt \
        -subj "/CN=localhost"; \
    else \
        openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
        -keyout /etc/ssl/private/selfsigned.key \
        -out /etc/ssl/certs/selfsigned.crt \
        -subj "/CN=jerrybeniten.com"; \
    fi

# Expose port 80
EXPOSE 80 443

ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apach2
ENV APACHE_LOCK_DIR /var/lock/apache2
ENV APACHE_PID_FILE /var/run/apach2.pid

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd intl

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN mkdir -p /home/root/.composer && \
    chown -R root:root /home/root

# Set file permissions
RUN htpasswd -cb /etc/apache2/.htpasswd test test

COPY ./vhost.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html/

USER root