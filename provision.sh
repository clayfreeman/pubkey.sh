#!/bin/bash

# Copyright 2016 Clay Freeman. All rights reserved
# This project is released under the GNU General Public License v3 (GPL-3.0)

# Exit on failure
set -e

# List of packages required for operation
PACKAGES="git nginx nodejs-legacy npm php7.0-dev php7.0-fpm php7.0-mcrypt
  php7.0-sqlite sqlite3"

echo "Ensuring that /vagrant is read-only..."
MOUNT_TEST=$(mount | awk '$3 == "/vagrant" { print $3, $6 }' | grep "\bro\b")

if [ -z "${MOUNT_TEST}" ]; then
  echo "/vagrant is not read-only."
  exit 1
fi

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
phpenmod mcrypt > /dev/null
service php7.0-fpm restart

echo "Installing Bower..."
npm install -g bower

echo "Installing Composer..."
curl -sS https://getcomposer.org/installer | \
  php -- --install-dir=/usr/local/bin --filename=composer > /dev/null

echo "Configuring nginx..."
# Disable the default site
rm -f /etc/nginx/sites-enabled/*
# Copy the custom configuration files to the nginx directory
cp -r /vagrant/configs/nginx/. /etc/nginx
# Enable the pubkey.sh site
ln -s /etc/nginx/sites-available/pubkey.sh /etc/nginx/sites-enabled

# Ensure the ubuntu user is part of the www-data group
gpasswd -a ubuntu www-data

echo "Bootstrapping project..."
su - ubuntu -c "bash /vagrant/bootstrap.sh"

echo "Restarting nginx..."
service nginx restart
