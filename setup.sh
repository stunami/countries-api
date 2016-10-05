#!/bin/bash

sudo apt-get update

sudo apt install -y \
            php5-cli \
            php5-mysql \
            php5-curl \

sudo apt-get install -y mysql-server

php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('SHA384', 'composer-setup.php') === 'e115a8dc7871f15d853148a7fbac7da27d6c0030b848d9b3dc09e2a0388afed865e6a3d6b3c0fad45c48e2b5fc1196ae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"

sudo cp composer.phar /usr/local/bin/composer

cd /vagrant

sudo -u vagrant composer install

sudo -u vagrant php app/console doctrine:database:create
sudo -u vagrant php app/console doctrine:schema:create

sudo -u vagrant php app/console countries:import

sudo -u vagrant php app/console server:run 0.0.0.0:8000 -v
