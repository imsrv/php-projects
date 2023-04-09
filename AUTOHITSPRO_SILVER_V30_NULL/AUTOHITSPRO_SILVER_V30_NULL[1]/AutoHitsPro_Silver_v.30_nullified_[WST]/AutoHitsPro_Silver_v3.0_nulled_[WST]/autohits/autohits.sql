DROP TABLE IF EXISTS cat;
CREATE TABLE cat (
   id int(11) NOT NULL AUTO_INCREMENT,
   title varchar(255) NOT NULL,
   ps varchar(255) NOT NULL,
   PRIMARY KEY (id))
   TYPE=MyISAM;


INSERT  INTO cat VALUES (1, 'Arts &amp; Humanities', 'Literature, Performing Arts, Visual Arts &amp; Design...') ;
INSERT  INTO cat VALUES (2, 'Auto, Boating &amp; Aviation', 'Cars, Motorcycles, SUVs, Racing...') ;
INSERT  INTO cat VALUES (3, 'Computing &amp; Technology', 'Networks, Hardware, Programming...') ;
INSERT  INTO cat VALUES (4, 'Health &amp; Fitness', 'Comics, Fun Cool Stuff, Humor &amp; Jokes, Cartoons...') ;
INSERT  INTO cat VALUES (5, 'Internet &amp; Online', 'Freebies, Games, Chats, Mp3\'s, Web Cams...') ;
INSERT  INTO cat VALUES (6, 'Leisure &amp; Entertainment', 'Movies, Music, Online, TV, Radio...') ;
INSERT  INTO cat VALUES (7, 'Lifestyle', 'Books, Fashion, Hobbies, Sports...') ;
INSERT  INTO cat VALUES (8, 'Reference, Media &amp; News', 'Education, Broadcast, Publishing, Magazines...') ;
INSERT  INTO cat VALUES (9, 'Personal', 'Family, Home, Kids, Relationships...') ;
INSERT  INTO cat VALUES (10, 'Services', 'Greeting Cards, Dating, Fund Raising...') ;
INSERT  INTO cat VALUES (11, 'Shopping', 'Auctions, Buying Guides, Cards/Gifts, Classifieds, Online Stores, Product Search...') ;
INSERT  INTO cat VALUES (12, 'Society &amp; Culture', 'Politics, Religion, Folklore...') ;
INSERT  INTO cat VALUES (13, 'Travel', 'Activities, Destinations, Lodging, Reservations, Transportation, Trip Planning...') ;
INSERT  INTO cat VALUES (14, 'Work &amp; Money', 'Banking, Planning, Retirement, Stocks, Jobs...') ;
INSERT  INTO cat VALUES (15, 'Adult', 'Crude Language, Nudity...') ;

DROP TABLE IF EXISTS clear;
CREATE TABLE clear (
   id int(11) NOT NULL AUTO_INCREMENT,
   date int(11) NOT NULL DEFAULT '0',
   PRIMARY KEY (id))
   TYPE=MyISAM;

INSERT INTO clear VALUES (1, '0') ;


DROP TABLE IF EXISTS idm_idc;
CREATE TABLE idm_idc (
   idm int(11) NOT NULL DEFAULT '0',
   idc int(11) NOT NULL DEFAULT '0')
   TYPE=MyISAM;


DROP TABLE IF EXISTS idu_idc;
CREATE TABLE idu_idc (
   idu int(11) NOT NULL DEFAULT '0',
   idc int(11) NOT NULL DEFAULT '0')
   TYPE=MyISAM;


DROP TABLE IF EXISTS language;
CREATE TABLE language (
   id int(11) NOT NULL AUTO_INCREMENT,
   language varchar(255) NOT NULL,
   PRIMARY KEY (id))
   TYPE=MyISAM;


INSERT  INTO language VALUES (1, 'Arabic') ;
INSERT  INTO language VALUES (2, 'Chinese') ;
INSERT  INTO language VALUES (3, 'Czech') ;
INSERT  INTO language VALUES (4, 'Danish') ;
INSERT  INTO language VALUES (5, 'Dutch') ;
INSERT  INTO language VALUES (6, 'English') ;
INSERT  INTO language VALUES (7, 'Esperanto') ;
INSERT  INTO language VALUES (8, 'Estonian') ;
INSERT  INTO language VALUES (9, 'Finnish') ;
INSERT  INTO language VALUES (10, 'French') ;
INSERT  INTO language VALUES (11, 'German') ;
INSERT  INTO language VALUES (12, 'Greek') ;
INSERT  INTO language VALUES (13, 'Hebrew') ;
INSERT  INTO language VALUES (14, 'Hungarian') ;
INSERT  INTO language VALUES (15, 'Icelandic') ;
INSERT  INTO language VALUES (16, 'Italian') ;
INSERT  INTO language VALUES (17, 'Japanese') ;
INSERT  INTO language VALUES (18, 'Korean') ;
INSERT  INTO language VALUES (19, 'Latvian') ;
INSERT  INTO language VALUES (20, 'Lithuanian') ;
INSERT  INTO language VALUES (21, 'Norwegian') ;
INSERT  INTO language VALUES (22, 'Polish') ;
INSERT  INTO language VALUES (23, 'Portuguese') ;
INSERT  INTO language VALUES (24, 'Romanian') ;
INSERT  INTO language VALUES (25, 'Russian') ;
INSERT  INTO language VALUES (26, 'Slovak') ;
INSERT  INTO language VALUES (27, 'Spanish') ;
INSERT  INTO language VALUES (28, 'Swedish') ;
INSERT  INTO language VALUES (29, 'Turkish') ;

DROP TABLE IF EXISTS pass;
CREATE TABLE pass (
   id int(11) NOT NULL AUTO_INCREMENT,
   login varchar(255) NOT NULL,
   pass varchar(255) NOT NULL,
   PRIMARY KEY (id))
   TYPE=MyISAM;


INSERT  INTO pass VALUES (1, 'admin', '2$WIW9NMSB2fc') ;

DROP TABLE IF EXISTS site;
CREATE TABLE site (
   id int(11) NOT NULL AUTO_INCREMENT,
   idu int(11) NOT NULL DEFAULT '0',
   site varchar(255) NOT NULL,
   language int(11) NOT NULL DEFAULT '0',
   url varchar(255) NOT NULL,
   b tinyint(4) NOT NULL DEFAULT '0',
   credits float NOT NULL DEFAULT '0',
   pokaz int(11) NOT NULL DEFAULT '0',
   p1 int(11) NOT NULL DEFAULT '0',
   p2 int(11) NOT NULL DEFAULT '0',
   p3 int(11) NOT NULL DEFAULT '0',
   p4 int(11) NOT NULL DEFAULT '0',
   p5 int(11) NOT NULL DEFAULT '0',
   p6 int(11) NOT NULL DEFAULT '0',
   p0 int(11) NOT NULL DEFAULT '0',
   cat int(11) NOT NULL DEFAULT '0',
   PRIMARY KEY (id))
   TYPE=MyISAM;


DROP TABLE IF EXISTS tmp_mail;
CREATE TABLE tmp_mail (
   id int(11) NOT NULL AUTO_INCREMENT,
   idu int(11) NOT NULL DEFAULT '0',
   email varchar(255) NOT NULL,
   cod int(11) NOT NULL DEFAULT '0',
   PRIMARY KEY (id))
   TYPE=MyISAM;

DROP TABLE IF EXISTS user;
CREATE TABLE user (
   id int(11) NOT NULL AUTO_INCREMENT,
   name varchar(255) NOT NULL,
   email varchar(255) NOT NULL,
   pass varchar(255) NOT NULL,
   share tinyint(2) NOT NULL DEFAULT '0',
   own int(11) NOT NULL DEFAULT '0',
   credits float NOT NULL DEFAULT '0',
   c1 float NOT NULL DEFAULT '0',
   c2 float NOT NULL DEFAULT '0',
   c3 float NOT NULL DEFAULT '0',
   c4 float NOT NULL DEFAULT '0',
   c5 float NOT NULL DEFAULT '0',
   c6 float NOT NULL DEFAULT '0',
   c0 float NOT NULL DEFAULT '0',
   type tinyint(3) NOT NULL DEFAULT '0',
   br tinyint(4) NOT NULL DEFAULT '0',
   date date NOT NULL DEFAULT '0000-00-00',
   cr_earn float NOT NULL DEFAULT '0',
   tmp_mail int(11) NOT NULL DEFAULT '0',
   last_page_time datetime NOT NULL default '0000-00-00 00:00:00',
   PRIMARY KEY (id))
   TYPE=MyISAM;

