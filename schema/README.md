# README

To (re)build the database schema, run the following commands:

```sh
cat schema/*.sql | sqlite3 data/pubkey.db
echo "VACUUM;"   | sqlite3 data/pubkey.db
sudo chgrp www-data data
sudo chgrp www-data data/pubkey.db
sudo chmod g+rwx    data
sudo chmod g+rw     data/pubkey.db
```
