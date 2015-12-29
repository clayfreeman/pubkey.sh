DROP   TABLE IF     EXISTS models_token;
CREATE TABLE IF NOT EXISTS models_token (
  id       INTEGER  NOT NULL PRIMARY KEY AUTOINCREMENT,
  uid      INTEGER  NOT NULL,
  expires  DATETIME NOT NULL,
  selector TEXT     NOT NULL UNIQUE,
  token    TEXT     NOT NULL UNIQUE,

  FOREIGN KEY(uid) REFERENCES models_user(id)
);
