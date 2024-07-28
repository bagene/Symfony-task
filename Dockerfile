FROM php:8.2-cli-bullseye AS base

RUN apt-get update \
    && apt-get upgrade -y \
    && apt-get install -y --no-install-recommends \
        curl \
        git \
        libzip-dev \
        unzip \
    && docker-php-ext-install  \
      mysqli \
      pdo_mysql \
      zip \
    && apt-get autoclean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

RUN groupadd -g 1000 customer \
    && useradd -d /home/customer -s /bin/bash -u 1000 -g 1000 customer \
    && mkdir -p /home/customer/app \
    && chown -R customer:customer /home/customer

USER customer

WORKDIR /home/customer/app


