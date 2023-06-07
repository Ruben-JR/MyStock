FROM php

RUN docker-php-install pdo pdo_mysql
#----------------------COMPOSER----------------------
#allow super user - set this if you use composer as a 
#super user at all times like in docker containers
ENV COMPOSER_ALLOW_SUPERUSER=1

#obtain composer using multi-stage build
COPY --from=composer /usr/bin/composer /usr/bin/composer

#Here we are copying only composer.json and composer.lock(instead of copying the entire source)
#right before doing composer install.
#this is enough to take advantage of docker cache and composer install will be executed only 
#when composer.json or composer.lock have indeed changed
COPY ./app/composer.* ./Documents/MyLab/MyStock/backend

#install composer
RUN composer install --prefer-dist --no-dev --no-scripts --no-postgress --no-interaction

#copy aplplication file to the working directory
COPY ./app .

#run composer dump-autoload --optimize

#----------------------PHP APPLICATION----------------------
