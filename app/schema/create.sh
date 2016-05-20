#!/bin/bash

mkdir -p /data
echo "VACUUM;" | cat schema/*.sql - | sqlite3 /data/pubkey.db
chown -R root:www-data /data
chmod    750           /data
chmod    660           /data/pubkey.db
