#!/usr/bin/env bash
CLEANINSTALL=false;
if [ -f "/var/build" ]; then
    echo "⭐️ Build is running, therefore a clean install";
    CLEANINSTALL=true
    rm /var/build
fi

echo "⭐️ Install n and set the correct node version:";
node --version
npm install -g n
n 18.17.1
hash -r
node --version

echo "⭐️ Clean install ${CLEANINSTALL}";
if [ "$CLEANINSTALL" = true ]; then
    cd /var/www

    # copy .env file
    echo "⭐️ Copy .env file";
    cp /var/www/docker/docker.env /var/www/.env
    chmod 775 /var/www/.env
    chown www-data:www-data  /var/www/.env


    # move to webroot directory
    cd /var/www
    # run composer
    echo "⭐️ Run composer install";
    composer install

    echo "⭐️ Run NPM install";
#    npm install --userconfig="storage/framework/cache/.npmrc"

    echo "⭐️ Reset Database";
    php artisan db:wipe

    # Initialize database tables'
    php artisan migrate

    # Run database seeders
    php artisan db:seed --class=DatabaseSeeder
fi

# make sure folder permissions are set
echo "⭐️ Set folder access";
chmod a+w -R /var/www/bootstrap/cache
chmod a+w -R /var/www/storage/framework/sessions
chmod a+w -R /var/www/storage
chmod a+w -R /var/www/vendor
#chmod a+w -R /var/www/node_modules

# enable port-forwarding for port 7040, to allow Dusk Test /w Selenium to work
socat TCP-LISTEN:7038,fork TCP:frontend:7038 &

chmod -R 0755 vendor/laravel/dusk/bin/.

# run apache in foreground
apache2-foreground
