DROP   TABLE IF     EXISTS models_token;
CREATE TABLE IF NOT EXISTS models_token (
  id       INTEGER  NOT NULL PRIMARY KEY AUTOINCREMENT,
  uid      INTEGER  NOT NULL,
  expires  DATETIME NOT NULL,
  selector TEXT     NOT NULL,
  token    TEXT     NOT NULL,

  FOREIGN KEY(uid) REFERENCES models_user(id)
);
