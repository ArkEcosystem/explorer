#!/usr/bin/env bash

sudo chown -R explorer:www-data /var/www/explorer
touch database/database.sqlite
#--- run installs 
composer install
yarn install
#--- fire up services
sudo supervisord & 
sudo chmod -R 775 /var/www/explorer/database
sudo chmod -R 775 /var/www/explorer/storage
sudo chmod -R 775 /var/www/explorer/bootstrap/cache 
yarn cache clean
rm -rf ~/.composer/
#--- laravel and cache setup
php artisan key:generate --force
php artisan migrate:fresh --force
php artisan storage:link
php artisan cache:real-time-statistics
php artisan cache:statistics
php artisan cache:last-blocks
php artisan cache:usernames
php artisan cache:musig
php artisan cache:delegate-aggregates
php artisan cache:delegates
php artisan cache:exchange-rates
php artisan cache:chart-fee
php artisan cache:past-round-performance
php artisan cache:productivity
php artisan cache:votes
php artisan cache:resignation-ids
#--- run system scheduler
sudo crond
bash
