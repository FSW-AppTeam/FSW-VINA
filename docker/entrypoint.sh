#!/usr/bin/env bash
CLEANINSTALL=false;
if [ -f "/var/build" ]; then
    echo "⭐️ Build is running, therefore a clean install";
    CLEANINSTALL=true
    rm /var/build
fi

npm config set cache=/var/www/storage/framework/cache/

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
    npm install --userconfig="storage/framework/cache/.npmrc"
    npm run dev
    npm run build

    echo "⭐️ Reset Database";
    php artisan db:wipe

    # Initialize database tables'
    php artisan migrate

    # Run database seeders
    php artisan db:seed --class=DatabaseSeeder
else
    # run composer
    echo "⭐️ Run composer update";
    composer update

    # run laraval's Mix
    echo "⭐️ Run NPM install";
    npm install --userconfig="storage/framework/cache/.npmrc"
    npx mix
fi

# make sure folder permissions are set
echo "⭐️ Set folder access";
chmod a+w -R /var/www/bootstrap/cache
chmod a+w -R /var/www/storage
chmod a+w -R /var/www/vendor
chmod a+w -R /var/www/node_modules

# run apache in foreground
apache2-foreground
