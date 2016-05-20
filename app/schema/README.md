# README

To (re)build the database schema, run the following commands:

```sh
mkdir -p data
echo "VACUUM;" | cat schema/*.sql - | sqlite3 data/site.db
chgrp www-data data
chgrp www-data data/site.db
chmod 770      data
chmod 660      data/site.db
```
