DROP TABLE IF EXISTS framy_Blowfish;
DROP TABLE IF EXISTS framy_Personal;

CREATE TABLE framy_Personal
(
  PersonalId SERIAL PRIMARY KEY,
  NameFirst TEXT NOT NULL,
  NameLast TEXT NOT NULL,
  Email TEXT UNIQUE NOT NULL
);

CREATE TABLE framy_Blowfish
(
  PersonalId INT NOT NULL PRIMARY KEY,
  Blowfish TEXT NOT NULL,
  TempBlowfish TEXT,
  Expiry TIMESTAMP WITH TIME ZONE,
  FOREIGN KEY (PersonalId) REFERENCES framy_Personal(PersonalId)
);
