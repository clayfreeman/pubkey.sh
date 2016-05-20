FROM       clayfreeman/web
MAINTAINER Clay Freeman <docker-hub@clayfreeman.com>

# Copy the nginx configuration file to the image
COPY docker-site.tpl /etc/nginx/conf.d/

# Install the required Debian packages
RUN  apt-get install -y composer git libsodium-dev nodejs-legacy npm \
                        php7.0-dev php7.0-sqlite sqlite3 unzip

# Install (and enable) the PHP libsodium extension
RUN  pecl install libsodium && \
     echo "extension=libsodium.so" > \
       /etc/php/7.0/mods-available/libsodium.ini && \
     phpenmod libsodium

# Install the bower package globally
RUN  npm install -g bower

# Install the required bower/composer dependencies for the app
COPY app /app
WORKDIR  /app
RUN  rm -rf public/resources && bower install --allow-root
RUN  rm -rf composer.lock vendor && composer install

# Setup volumes for the data and letsencrypt directories
VOLUME /data
VOLUME /etc/letsencrypt

# Run the custom launch script CMD
CMD  ["bash", "/app/launch.sh"]
