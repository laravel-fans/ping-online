FROM laravelfans/laravel:8

COPY . /var/www/laravel
RUN composer install --no-dev
