#!/bin/bash

# Exit on failure
set -e

# List of packages required for operation
PACKAGES="nginx php5-dev php5-fpm php5-mcrypt"

echo "Fetching updated list of packages..."
apt-get update > /dev/null

echo "Upgrading the system..."
apt-get dist-upgrade --force-yes -y > /dev/null

echo "Cleaning old/cached packages..."
apt-get autoremove --force-yes -y > /dev/null
apt-get autoclean > /dev/null
apt-get clean > /dev/null

echo "Installing required packages..."; echo
apt-get install --force-yes -y ${PACKAGES} > /dev/null

echo "Enabling PHP modules..."
php5enmod mcrypt > /dev/null

echo "Installing Composer..."
curl -sS https://getcomposer.org/installer | \
  php -- --install-dir=/usr/local/bin --filename=composer > /dev/null

echo "Bootstrapping project..."
su - vagrant -c "bash /vagrant/bootstrap.sh"
