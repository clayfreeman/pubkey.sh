#!/bin/bash

# Generate self-signed TLS certificate (if necessary)
if [ ! -f "/data/server.key" ] || [ ! -f "/data/server.pem" ]; then
  openssl req -new -newkey rsa:4096 -days 16 -nodes -x509 -subj \
    "/C=NA/ST=NA/L=NA/O=NA/CN=${SERVER_NAME}" \
    -keyout /data/server.key -out /data/server.pem
fi

# Set the appropriate permissions on the SSL key
chown root:root /data/server.{key,pem}
chmod 640       /data/server.{key,pem}

# Create the database from its schema (if necessary)
if [ ! -f "/data/pubkey.db" ]; then
  bash /app/schema/create.sh
fi
