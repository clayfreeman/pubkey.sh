#!/bin/bash

# Exit on failure
set -e && cd /vagrant

echo "Installing required Composer packages..."
rm -rf composer.lock vendor
composer install > /dev/null

echo "Patching required Composer packages..."
patch vendor/composer/installed.json < password_lock.patch
composer dump-autoload

echo "Rebuilding database..."
mkdir -p data
echo "VACUUM;" | cat schema/*.sql - | sqlite3 data/pubkey.sh.db
sudo chgrp www-data data
sudo chgrp www-data data/pubkey.sh.db
sudo chmod g+rwx    data
sudo chmod g+rw     data/pubkey.sh.db
