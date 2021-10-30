FROM laravelfans/laravel:8

RUN apt-get update \
    && apt-get install -y iputils-ping \
    && apt-get clean \
    && apt-get autoclean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
COPY . /var/www/laravel
RUN composer install --no-dev
