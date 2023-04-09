CREATE TABLE descr (
   name varchar(255) NOT NULL,
   descr text NOT NULL,
   seclevel int(11) DEFAULT '0' NOT NULL,
   PRIMARY KEY (name)
);

CREATE TABLE comments (
   id int(11) NOT NULL auto_increment,
   pic_name varchar(251) NOT NULL,
   comment text NOT NULL,
   datetime datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
   user text NOT NULL,
   ip varchar(16) NOT NULL,
   PRIMARY KEY (id),
   KEY pic_name (pic_name)
);

CREATE TABLE users (
   login char(20) NOT NULL,
   pass char(32) NOT NULL,
   cookieval char(128) NOT NULL,
   seclevel int(11) DEFAULT '0' NOT NULL,
   PRIMARY KEY (login)
);

CREATE TABLE ratings (
  id int(11) NOT NULL auto_increment,
  datetime datetime NOT NULL default '0000-00-00 00:00:00',
  pic_name varchar(251) NOT NULL default '',
  ip varchar(16) NOT NULL default '',
  rating int(11) NOT NULL default '0',
  PRIMARY KEY  (id),
  KEY pic_name (pic_name)
); 
