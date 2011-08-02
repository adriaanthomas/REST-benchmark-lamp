drop database if exists rest;
create database rest;

use rest;

create user 'rest'@'localhost' identified by 'rest';
grant select,insert,update,delete on rest.* to 'rest'@'localhost';

CREATE TABLE rest_data2 (
  id INT UNSIGNED NOT NULL,
  short_string VARCHAR(200) NOT NULL,
  long_string VARCHAR(3000) NOT NULL,
  int_number INT NOT NULL,
  true_or_false BIT NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB;
