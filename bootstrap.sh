#!/bin/bash

# Copyright 2016 Clay Freeman. All rights reserved
# This project is released under the GNU General Public License v3 (GPL-3.0)

# Exit on failure
set -e && cd

# Grab the repository from /vagrant
git clone /vagrant
cd vagrant

echo "Copy 'includes/settings.example.php' to 'includes/settings.php'..."
cp includes/settings.example.php includes/settings.php

echo "Installing required Composer packages..."
rm -rf composer.lock vendor
composer install --quiet

echo "Patching required Composer packages..."
patch vendor/composer/installed.json < password_lock.patch
composer dump-autoload

echo "Building database..."
mkdir -p data
echo "VACUUM;" | cat schema/*.sql - | sqlite3 data/site.db
# Set the appropriate permissions for the database/data folder
chgrp www-data data
chgrp www-data data/site.db
chmod 770      data
chmod 660      data/site.db

echo "Generating SSL certificate..."
openssl req -new -newkey rsa:4096 -days 16 -nodes -x509 -subj \
  "/C=NA/ST=Not Applicable/L=Not Applicable/O=Not Applicable/CN=localhost" \
  -keyout data/server.key -out data/server.pem &> /dev/null
# Set the appropriate permissions for the certificate/key
chgrp www-data data/server.key
chmod 640 data/server.key
chmod 644 data/server.pem
