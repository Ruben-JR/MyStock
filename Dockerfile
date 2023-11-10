FROM php:7.4-cli
COPY . /var/www/php
WORKDIR /var/www/php
CMD [ "php", "./connect.php" ]
