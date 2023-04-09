# phpMyAdmin MySQL-Dump
# version 2.3.3-rc1
# http://www.phpmyadmin.net/ (download page)
#
# Host: localhost
# Generation Time: Mar 19, 2003 at 09:40 AM
# Server version: 3.23.52
# PHP Version: 4.2.2
# Database : `comp3_jokesite_install_multi`
# --------------------------------------------------------

#
# Table structure for table `jokesite_category`
#

CREATE TABLE jokesite_category (
  category_id int(5) NOT NULL auto_increment,
  category_name_eng varchar(50) default NULL,
  PRIMARY KEY  (category_id),
  UNIQUE KEY category_name (category_name_eng)
) TYPE=MyISAM;

#
# Dumping data for table `jokesite_category`
#

INSERT INTO jokesite_category VALUES (1, 'Personality');
INSERT INTO jokesite_category VALUES (2, 'Men');
INSERT INTO jokesite_category VALUES (3, 'Blonde Jokes');
INSERT INTO jokesite_category VALUES (5, 'Animal Jokes');
INSERT INTO jokesite_category VALUES (7, 'Clinton Jokes');
INSERT INTO jokesite_category VALUES (8, 'College Jokes');
INSERT INTO jokesite_category VALUES (10, 'Farms Jokes');
INSERT INTO jokesite_category VALUES (11, 'Foreign Jokes');
INSERT INTO jokesite_category VALUES (12, 'Genie jokes');
INSERT INTO jokesite_category VALUES (18, 'Office Jokes');
INSERT INTO jokesite_category VALUES (20, 'Medical Jokes');
INSERT INTO jokesite_category VALUES (22, 'Misc Jokes');
INSERT INTO jokesite_category VALUES (23, 'Political Jokes');
INSERT INTO jokesite_category VALUES (27, 'Friendship Jokes');
INSERT INTO jokesite_category VALUES (28, 'Sports Jokes');
INSERT INTO jokesite_category VALUES (29, 'Woman Jokes');
INSERT INTO jokesite_category VALUES (30, 'At Work Jokes');
INSERT INTO jokesite_category VALUES (31, 'Dirty Jokes');
# --------------------------------------------------------

#
# Table structure for table `jokesite_censor_category`
#

CREATE TABLE jokesite_censor_category (
  censor_category_id int(10) NOT NULL auto_increment,
  censor_category_name_eng varchar(50) NOT NULL default '',
  PRIMARY KEY  (censor_category_id)
) TYPE=MyISAM;

#
# Dumping data for table `jokesite_censor_category`
#

INSERT INTO jokesite_censor_category VALUES (1, 'Adult');
INSERT INTO jokesite_censor_category VALUES (2, 'Clean');
INSERT INTO jokesite_censor_category VALUES (3, 'Gross');
INSERT INTO jokesite_censor_category VALUES (4, 'Dirty');
# --------------------------------------------------------

#
# Table structure for table `jokesite_daily_newsletters`
#

CREATE TABLE jokesite_daily_newsletters (
  joke_id int(5) NOT NULL default '0',
  joke_text_eng text NOT NULL,
  joke_title_eng varchar(250) NOT NULL default '',
  date varchar(10) default NULL
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `jokesite_fun_category`
#

CREATE TABLE jokesite_fun_category (
  category_id tinyint(1) NOT NULL auto_increment,
  category_name_eng varchar(50) NOT NULL default '',
  PRIMARY KEY  (category_id),
  UNIQUE KEY category_name (category_name_eng)
) TYPE=MyISAM;

#
# Dumping data for table `jokesite_fun_category`
#

INSERT INTO jokesite_fun_category VALUES (1, 'funnypeople');
INSERT INTO jokesite_fun_category VALUES (2, 'hotgirls');
INSERT INTO jokesite_fun_category VALUES (3, 'hotguys');
INSERT INTO jokesite_fun_category VALUES (4, 'funnyplaces');
INSERT INTO jokesite_fun_category VALUES (5, 'funnyanimals');
INSERT INTO jokesite_fun_category VALUES (6, 'hot shots');
# --------------------------------------------------------

#
# Table structure for table `jokesite_jokes`
#

CREATE TABLE jokesite_jokes (
  joke_id int(5) NOT NULL auto_increment,
  category_id int(5) NOT NULL default '0',
  name varchar(100) default NULL,
  email varchar(100) default NULL,
  joke_text text,
  joke_type varchar(10) default NULL,
  censor_type int(10) NOT NULL default '0',
  rating_value float default NULL,
  emailed_value int(10) NOT NULL default '0',
  date_add varchar(10) NOT NULL default '',
  validate tinyint(1) default NULL,
  joke_title varchar(70) NOT NULL default '',
  slng varchar(4) NOT NULL default '',
  PRIMARY KEY  (joke_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `jokesite_newsletter_category`
#

CREATE TABLE jokesite_newsletter_category (
  newsletter_category_id int(5) NOT NULL auto_increment,
  newsletter_category_name_eng varchar(70) NOT NULL default '',
  active enum('','on') NOT NULL default '',
  PRIMARY KEY  (newsletter_category_id)
) TYPE=MyISAM;

#
# Dumping data for table `jokesite_newsletter_category`
#

INSERT INTO jokesite_newsletter_category VALUES (1, 'daily', 'on');
INSERT INTO jokesite_newsletter_category VALUES (2, 'weekly', 'on');
INSERT INTO jokesite_newsletter_category VALUES (3, 'monthly', '');
# --------------------------------------------------------

#
# Table structure for table `jokesite_newsletter_subscribers`
#

CREATE TABLE jokesite_newsletter_subscribers (
  id int(5) NOT NULL auto_increment,
  type int(3) NOT NULL default '0',
  email varchar(50) NOT NULL default '',
  lastdate date NOT NULL default '0000-00-00',
  slng varchar(4) NOT NULL default '',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `jokesite_postcard_images`
#

CREATE TABLE jokesite_postcard_images (
  img_id int(5) NOT NULL auto_increment,
  category_id tinyint(1) default '0',
  little_img_name varchar(50) default NULL,
  big_img_name varchar(50) default NULL,
  name varchar(100) default NULL,
  email varchar(100) default NULL,
  comment text,
  validate tinyint(1) default NULL,
  slng varchar(4) NOT NULL default '',
  added date NOT NULL default '0000-00-00',
  show_images_at_home smallint(6) NOT NULL default '0',
  PRIMARY KEY  (img_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `jokesite_postcard_messages`
#

CREATE TABLE jokesite_postcard_messages (
  pm_id int(5) NOT NULL auto_increment,
  image_id int(5) NOT NULL default '0',
  title varchar(255) NOT NULL default '',
  your_name varchar(50) NOT NULL default '',
  your_email varchar(50) NOT NULL default '',
  to_name varchar(50) NOT NULL default '',
  to_email varchar(50) NOT NULL default '',
  message varchar(255) NOT NULL default '',
  PRIMARY KEY  (pm_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `jokesite_rating`
#

CREATE TABLE jokesite_rating (
  id int(5) NOT NULL auto_increment,
  joke_id int(5) NOT NULL default '0',
  rate_nr int(5) default NULL,
  total_value int(8) default NULL,
  rating_value float(3,1) NOT NULL default '0.0',
  emailed_nr int(5) NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;


# --------------------------------------------------------

#
# Table structure for table `jokesite_votes`
#

CREATE TABLE jokesite_votes (
  joke_id int(5) NOT NULL default '0',
  ip varchar(15) NOT NULL default ''
) TYPE=MyISAM;

#
# Dumping data for table `jokesite_votes`
#
