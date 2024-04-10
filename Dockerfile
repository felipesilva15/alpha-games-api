FROM php:8.1-fpm-alpine

# Instala o composer
RUN docker-php-ext-install pdo pdo_mysql sockets
RUN curl -sS https://getcomposer.org/installer | php -- \
     --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

# Copia os arquivos do projeto
COPY . .
COPY .env.example .env

# Define as variáveis de ambiente no Dockerfile
ARG DB_CONNECTION=mysql
ARG DB_HOST=144.22.157.228
ARG DB_PORT=3306
ARG DB_DATABASE=Alpha
ARG DB_USERNAME=Alpha
ARG DB_PASSWORD=Alpha
ARG APP_ENV=production

# Substitui as variáveis no arquivo .env pelas variáveis de ambiente
RUN sed -i "s#DB_HOST=.*#DB_HOST=${DB_HOST}#" .env \
    && sed -i "s#DB_PORT=.*#DB_PORT=${DB_PORT}#" .env \
    && sed -i "s#DB_DATABASE=.*#DB_DATABASE=${DB_DATABASE}#" .env \
    && sed -i "s#DB_USERNAME=.*#DB_USERNAME=${DB_USERNAME}#" .env \
    && sed -i "s#DB_PASSWORD=.*#DB_PASSWORD=${DB_PASSWORD}#" .env \
    && sed -i "s#APP_ENV=.*#APP_ENV=${APP_ENV}#" .env

RUN composer install
RUN php artisan route:cache && php artisan view:cache
RUN php artisan key:generate

EXPOSE 80

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]