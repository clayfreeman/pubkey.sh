DROP   TABLE IF     EXISTS models_user;
CREATE TABLE IF NOT EXISTS models_user (
  id       INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  email    TEXT    NOT NULL UNIQUE,
  username TEXT    NOT NULL UNIQUE,
  password TEXT    NOT NULL,
  pid      INTEGER,

  FOREIGN KEY(pid) REFERENCES models_pubkey(id)
);
