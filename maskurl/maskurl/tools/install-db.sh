#!/bin/sh

## EDIT THESE VARIABLES
ADMINUSER=root
ADMINPASS=adminpass
DBSERVER=localhost

MASKURLUSER=maskurluser
MASKURLPASS=maskurlpass
MASKURLDOMAIN=localhost
MASKURLDBNAME=maskurl


mysql -u $ADMINUSER -p $ADMINPASS -h $DBSERVER << EOF

CREATE DATABASE $MASKURLDBNAME;
USE $MASKURLDBNAME;

CREATE TABLE users (
  id INT NOT NULL,
  username VARCHAR(20),
  password VARCHAR(20),
  sitetitle VARCHAR(255),
  sitedescription VARCHAR(255),
  sitekeywords VARCHAR(255),
  siteurl VARCHAR(255),
  email VARCHAR(255)
  PRIMARY KEY (id)
);

GRANT SELECT, INSERT, UPDATE, DELETE ON users TO $MASKURLUSER@$MASKURLDOMAIN IDENTIFIED BY "$MASKURLPASS";
EOF