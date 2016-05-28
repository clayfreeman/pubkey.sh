FROM       clayfreeman/web
MAINTAINER Clay Freeman <docker-hub@clayfreeman.com>

# Copy the nginx configuration file to the image
COPY docker-site.tpl /etc/nginx/conf.d/

# Install the required Debian packages
RUN  apt-get install -y composer git nodejs-legacy npm php7.0-dev \
                        php7.0-sqlite sqlite3 unzip

# Download, compile, and install libsodium from source
RUN  git clone https://github.com/jedisct1/libsodium.git && cd libsodium && \
     git checkout "$(git for-each-ref --sort=taggerdate --format \
     'tags/%(tag)' | tail -1)" && ./autogen.sh && ./configure && make && \
     make check && make install

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
RUN  rm -rf public/resources && bower install --allow-root && \
     find public/resources -type f -not \( \
       -name \*\.js   -o -name \*\.css   -o -name \*\.otf -o -name \*\.ttf -o \
       -name \*\.woff -o -name \*\.woff2 \
     \) -delete
RUN  rm -rf composer.lock vendor && composer install

# Run the custom launch script CMD
CMD  ["bash", "/app/launch.sh"]
