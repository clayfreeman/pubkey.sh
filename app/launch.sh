#!/bin/bash
set -e

# Generate self-signed TLS certificate (if necessary)
if [ ! -f "/data/server.key" ] || [ ! -f "/data/server.pem" ]; then
  openssl req -new -newkey rsa:4096 -days 16 -nodes -x509 -subj \
    "/C=NA/ST=NA/L=NA/O=NA/CN=${SERVER_NAME}" \
    -keyout /data/server.key -out /data/server.pem
fi

# Set the appropriate permissions on the SSL key
chown root:www-data /data/server.key
chown root:www-data /data/server.pem
chmod 640           /data/server.key
chmod 640           /data/server.pem

# Create the database from its schema (if necessary)
if [ ! -f "/data/pubkey.db" ]; then
  bash /app/schema/create.sh
fi

# Set the permissions on the app and data directories
mkdir -p /app
mkdir -p /data
chown -R root:www-data /app
find /app  -type d -exec chmod 550 "{}" \;
find /app  -type f -exec chmod 440 "{}" \;
chown -R root:www-data /data
find /data -type d -exec chmod 770 "{}" \;
find /data -type f -exec chmod 640 "{}" \;
if [ -f "${DATASOURCE_PATH#sqlite:}" ]; then
  chmod 660 "${DATASOURCE_PATH#sqlite:}"
fi
if [ -f "${HALITE_KEYFILE}" ]; then
  chmod 660 "${HALITE_KEYFILE}"
fi
