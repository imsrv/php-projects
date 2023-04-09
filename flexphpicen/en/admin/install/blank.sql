CREATE TABLE catalog (
   catalogid bigint(32) NOT NULL auto_increment,
   catalogname varchar(255) NOT NULL,
   description text,
   parentid bigint(32) DEFAULT '0' NOT NULL,
   PRIMARY KEY (catalogid)
);

CREATE TABLE picture (
   picid bigint(32) NOT NULL auto_increment,
   catalogid bigint(32),
   title varchar(255),
   adddate varchar(50),
   picture varchar(255),
   isdisplay tinyint(4) DEFAULT '0' NOT NULL,
   PRIMARY KEY (picid),
   KEY catalogid (catalogid)
);

CREATE TABLE picadmin (
   adminid int(10) NOT NULL auto_increment,
   username varchar(50) NOT NULL,
   password varchar(50) NOT NULL,
   PRIMARY KEY (adminid)
);