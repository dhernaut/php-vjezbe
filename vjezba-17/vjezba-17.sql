-- vjezba-17.sql
CREATE DATABASE IF NOT EXISTS vjezba_17 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE vjezba_17;

DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS countries;

CREATE TABLE countries (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(80) NOT NULL,
  code CHAR(2) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_country_name (name),
  UNIQUE KEY uq_country_code (code)
);

CREATE TABLE users (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  first_name VARCHAR(50) NOT NULL,
  last_name  VARCHAR(50) NOT NULL,
  email      VARCHAR(120) NOT NULL,
  username   VARCHAR(20) NOT NULL,
  password   VARCHAR(255) NOT NULL,
  country_id INT UNSIGNED NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_email (email),
  UNIQUE KEY uq_username (username),
  KEY idx_country (country_id),
  CONSTRAINT fk_users_country
    FOREIGN KEY (country_id)
    REFERENCES countries (id)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
);

INSERT INTO countries (id, name, code) VALUES
  (1, "Argentina", "AR"),
  (2, "Australia", "AU"),
  (3, "Croatia", "HR"),
  (4, "Germany", "DE"),
  (5, "USA", "US");

INSERT INTO users (first_name, last_name, email, username, password, country_id) VALUES
  ("Bob", "Johnson", "bob.johnson@example.com", "bobj", "demo", 1),
  ("Charlie", "Brown", "charlie.brown@example.com", "charlieb", "demo", 1),
  ("Frank", "Miller", "frank.miller@example.com", "frankm", "demo", 1),
  ("Grace", "Moore", "grace.moore@example.com", "gracem", "demo", 1),
  ("Winnie", "Young", "winn.y@example.com", "winniey", "demo", 2);
