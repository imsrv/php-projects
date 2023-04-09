# phpMyAdmin MySQL-Dump
# version 2.3.2
# http://www.phpmyadmin.net/ (download page)
#
# Host: localhost
# Generation Time: Jan 26, 2003 at 10:58 PM
# Server version: 3.23.52
# PHP Version: 4.2.3
# Database : `gallery`
# --------------------------------------------------------

#
# Table structure for table `access`
#
DROP TABLE IF EXISTS imagecomments;
DROP TABLE IF EXISTS imagetrack;
DROP TABLE IF EXISTS photovote;
DROP TABLE IF EXISTS authorization;
DROP TABLE IF EXISTS fileinfo_a;
DROP TABLE IF EXISTS fileinfo_q;
DROP TABLE IF EXISTS profile_a;
DROP TABLE IF EXISTS profile_q;
DROP TABLE IF EXISTS session_track;
DROP TABLE IF EXISTS access;
DROP TABLE IF EXISTS prefs;
DROP TABLE IF EXISTS photofile;
DROP TABLE IF EXISTS photodir;
DROP TABLE IF EXISTS photovote;
DROP TABLE IF EXISTS photodir;

CREATE TABLE access (
  user_id int(11) NOT NULL default '0',
  dir_id int(11) NOT NULL default '0',
  r tinyint(4) NOT NULL default '0',
  u tinyint(4) NOT NULL default '0',
  d tinyint(4) NOT NULL default '0',
  e tinyint(4) NOT NULL default '0'
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `authorization`
#

CREATE TABLE authorization (
  id int(11) NOT NULL auto_increment,
  name varchar(20) NOT NULL default '',
  email varchar(100) NOT NULL default '',
  password varchar(20) NOT NULL default '',
  access_level int(4) NOT NULL default '10',
  mug varchar(50) NOT NULL default '',
  active tinyint(4) NOT NULL default '1',
  expires bigint(20) NOT NULL default '0',
  last_login bigint(20) NOT NULL default '0',
  PRIMARY KEY  (id),
  KEY id (id)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `fileinfo_a`
#

CREATE TABLE fileinfo_a (
  id int(11) NOT NULL auto_increment,
  q_id int(11) NOT NULL default '0',
  image_name varchar(60) NOT NULL default '',
  imagedir text NOT NULL,
  answer text NOT NULL,
  photo_id int(11) NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `fileinfo_q`
#

CREATE TABLE fileinfo_q (
  id int(11) NOT NULL auto_increment,
  question text NOT NULL,
  required tinyint(4) NOT NULL default '0',
  type tinyint(4) NOT NULL default '1',
  cols tinyint(4) NOT NULL default '75',
  rows tinyint(4) NOT NULL default '5',
  PRIMARY KEY  (id)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `imagecomments`
#

CREATE TABLE imagecomments (
  id int(11) NOT NULL auto_increment,
  filename text NOT NULL,
  comments text,
  name text,
  email text,
  date text NOT NULL,
  ip text NOT NULL,
  imagedir text NOT NULL,
  photo_id int(11) NOT NULL default '0',
  PRIMARY KEY  (id),
  KEY id (id)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `imagetrack`
#

CREATE TABLE imagetrack (
  id int(11) NOT NULL auto_increment,
  views int(11) NOT NULL default '1',
  photo_id int(11) NOT NULL default '0',
  PRIMARY KEY  (id),
  KEY id (id)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `photodir`
#

CREATE TABLE photodir (
  id int(11) NOT NULL auto_increment,
  name text NOT NULL,
  parentid int(11) NOT NULL default '0',
  parentdir text NOT NULL,
  datetaken date NOT NULL default '0000-00-00',
  description text NOT NULL,
  icon varchar(200) NOT NULL default 'dir.gif',
  anonymous_uploads tinyint(4) NOT NULL default '0',
  upload_access text NOT NULL,
  inlist tinyint(4) NOT NULL default '0',
  icon_id int(11) NOT NULL default '0',
  time_created bigint(20) NOT NULL default '0',
  private tinyint(4) NOT NULL default '0',
  owner int(11) NOT NULL default '1',
  PRIMARY KEY  (id),
  KEY id (id)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `photofile`
#

CREATE TABLE photofile (
  id int(11) NOT NULL auto_increment,
  filename char(100) NOT NULL default '',
  dir_id int(11) NOT NULL default '0',
  anonymous tinyint(4) NOT NULL default '1',
  orderid int(11) NOT NULL default '0',
  time_uploaded bigint(20) NOT NULL default '0',
  PRIMARY KEY  (id),
  KEY id (id)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `photovote`
#

CREATE TABLE photovote (
  id int(11) NOT NULL auto_increment,
  vote int(11) NOT NULL default '0',
  photo_id tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `prefs`
#

CREATE TABLE prefs (
  id int(11) NOT NULL auto_increment,
  allow_user_uploads tinyint(4) NOT NULL default '0',
  per_col tinyint(4) NOT NULL default '3',
  per_row tinyint(4) NOT NULL default '3',
  photo_per_col tinyint(4) NOT NULL default '3',
  photo_per_row tinyint(4) NOT NULL default '3',
  anonymous_comments tinyint(4) NOT NULL default '1',
  voting tinyint(4) NOT NULL default '1',
  default_uploads tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (id)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `profile_a`
#

CREATE TABLE profile_a (
  id int(11) NOT NULL auto_increment,
  u_id int(11) NOT NULL default '0',
  q_id int(11) NOT NULL default '0',
  answer text NOT NULL,
  PRIMARY KEY  (id),
  KEY id (id)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `profile_q`
#

CREATE TABLE profile_q (
  id int(11) NOT NULL auto_increment,
  question text NOT NULL,
  type tinyint(4) NOT NULL default '1',
  cols tinyint(4) NOT NULL default '25',
  rows tinyint(4) NOT NULL default '1',
  options text NOT NULL,
  PRIMARY KEY  (id),
  KEY id (id)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `session_track`
#

CREATE TABLE session_track (
  id int(11) NOT NULL auto_increment,
  session_id varchar(100) NOT NULL default '',
  time bigint(20) NOT NULL default '0',
  user_id int(11) NOT NULL default '0',
  ip varchar(20) NOT NULL default '',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

CREATE TABLE message (
  message_id int(11) NOT NULL auto_increment,
  to_id int(11) NOT NULL default '0',
  from_id int(11) NOT NULL default '0',
  subject varchar(200) NOT NULL default '',
  body text NOT NULL,
  date bigint(20) NOT NULL default '0',
  status tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (message_id)
) TYPE=MyISAM;


insert into fileinfo_q (question) values ("Name");
insert into fileinfo_q (question) values ("Email");
insert into fileinfo_q (question) values ("Description");
insert into fileinfo_q (question) values ("Keywords");
INSERT INTO prefs (default_uploads) VALUES (1);

