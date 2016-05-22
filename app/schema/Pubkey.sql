DROP   TABLE IF     EXISTS models_pubkey;
CREATE TABLE IF NOT EXISTS models_pubkey (
  pubkey_id    INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  uri          TEXT    NOT NULL UNIQUE,
  user_id      INTEGER NOT NULL,
  title        TEXT    NOT NULL,
  type         TEXT    NOT NULL,
  finger_print TEXT,
  data         BLOB,

  FOREIGN KEY(user_id) REFERENCES models_user(user_id)
);
