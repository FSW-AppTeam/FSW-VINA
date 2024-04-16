FROM php:8.2-apache AS apache
# set workdir
RUN mkdir -p /var/www/
WORKDIR /var/www

# upgrades!
RUN apt-get update
RUN apt-get -y dist-upgrade
RUN apt-get install -y dos2unix

RUN apt-get install -y nano
RUN apt-get install -y git
RUN apt-get install -y zip unzip libzip-dev
RUN apt-get install -y libxml2-dev
RUN apt-get install -y libssh2-1
RUN apt-get install -y libssh2-1-dev
RUN apt-get install -y wget
RUN apt-get install -y sudo
RUN apt-get install -y iputils-ping
RUN apt-get install -y sendmail

RUN apt-get install -y libpng-dev
RUN apt-get install -y zlib1g-dev

RUN apt-get install -y ca-certificates curl gnupg

RUN docker-php-ext-install gd
RUN docker-php-ext-install zip

RUN apt-get clean -y

RUN echo "sendmail_path='/usr/sbin/sendmail -t -i --smtp-addr=\"mail.docker:1025\"'" >> /usr/local/etc/php/conf.d/sendmail.ini
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install zip
RUN sed -i '/#!\/bin\/sh/aservice sendmail restart' /usr/local/bin/docker-php-entrypoint
RUN sed -i '/#!\/bin\/sh/aecho "$(hostname -i)\t$(hostname) $(hostname).localhost" >> /etc/hosts' /usr/local/bin/docker-php-entrypoint

# And clean up the image
RUN rm -rf /var/lib/apt/lists/*

# set corrent TimeZone
ENV TZ=Europe/Amsterdam
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# install additional webserver packages
RUN a2enmod ssl
RUN a2enmod rewrite
RUN a2enmod headers

# install NodeJS
RUN mkdir -p /etc/apt/keyrings
RUN curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg
RUN echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_18.x nodistro main" | sudo tee /etc/apt/sources.list.d/nodesource.list

RUN sudo apt-get update
RUN apt-get install -y nodejs

# install additional PHP extensions
RUN docker-php-ext-install pdo_mysql mysqli soap

# copy httpd files
COPY ./docker/httpd.conf /etc/apache2/sites-enabled/000-default.conf

# copy webapp files
COPY ./ /var/www

# copy github token
COPY ./docker/auth.json /root/.composer/auth.json

# install composer
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

# install self signed certifcates to thrust other local dev environments
COPY ./docker/certificates/apache/docker.dev.crt /usr/local/share/ca-certificates
RUN cd /usr/local/share/ca-certificates && update-ca-certificates

# entrypoint
COPY ./docker/entrypoint.sh /entrypoint.sh
RUN chmod ugo+x /entrypoint.sh
RUN dos2unix /entrypoint.sh

RUN touch /var/build

ENTRYPOINT /entrypoint.sh
