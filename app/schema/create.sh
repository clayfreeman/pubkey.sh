#!/bin/bash

mkdir -p /data
echo "VACUUM;" | cat schema/*.sql - | sqlite3 /data/pubkey.db
chgrp www-data /data
chgrp www-data /data/pubkey.db
chmod 770      /data
chmod 660      /data/pubkey.db
