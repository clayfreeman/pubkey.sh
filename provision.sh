#!/bin/bash

# Copyright 2016 Clay Freeman. All rights reserved
# This project is released under the GNU General Public License v3 (GPL-3.0)

# Exit on failure
set -e

# List of packages required for operation
PACKAGES="git nginx nodejs-legacy npm php5-dev php5-fpm php5-mcrypt
  php5-sqlite sqlite3"

echo "Remounting /vagrant as read-only..."
mount -r -o remount /vagrant

echo "Fetching updated list of packages..."
apt-get -qq update

echo "Upgrading the system..."
apt-get -qq dist-upgrade --force-yes -y

echo "Cleaning old/cached packages..."
apt-get -qq autoremove --force-yes -y
apt-get -qq autoclean
apt-get -qq clean

echo "Installing required packages..."; echo
apt-get install --force-yes -y ${PACKAGES}

echo "Enabling required PHP modules..."
php5enmod mcrypt > /dev/null
service php5-fpm restart

echo "Installing Bower..."
npm install -g bower

echo "Installing Composer..."
curl -sS https://getcomposer.org/installer | \
  php -- --install-dir=/usr/local/bin --filename=composer > /dev/null

echo "Configuring nginx..."
# Disable the default site
rm /etc/nginx/sites-enabled/default
# Copy the custom configuration files to the nginx directory
cp -r /vagrant/configs/nginx/. /etc/nginx
# Enable the pubkey.sh site
ln -s /etc/nginx/sites-available/pubkey.sh /etc/nginx/sites-enabled

# Ensure the vagrant user is part of the www-data group
gpasswd -a vagrant www-data

echo "Bootstrapping project..."
su - vagrant -c "bash /vagrant/bootstrap.sh"

echo "Restarting nginx..."
service nginx restart
