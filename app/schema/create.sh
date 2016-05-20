#!/bin/bash

echo "VACUUM;" | cat /app/schema/*.sql - | sqlite3 /data/pubkey.db
chmod 660 /data/pubkey.db
