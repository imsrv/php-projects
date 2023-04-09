# phpMyAdmin SQL Dump
# version 2.5.6
# http://www.phpmyadmin.net
#
# Host: localhost
# Generation Time: Apr 22, 2004 at 04:56 PM
# Server version: 4.0.13
# PHP Version: 4.2.2
# 
# Database : `lore`
# 

# --------------------------------------------------------

#
# Table structure for table `lore_articles`
#

DROP TABLE IF EXISTS lore_articles;
CREATE TABLE lore_articles (id int(3) unsigned zerofill NOT NULL auto_increment,category_id int(10) unsigned NOT NULL default '0',user_id int(10) unsigned NOT NULL default '0',title text NOT NULL,content text NOT NULL,keywords varchar(255) default NULL,created_time int(10) unsigned default NULL,modified_time int(10) unsigned default NULL,num_views int(10) unsigned NOT NULL default '0',num_prints int(10) unsigned NOT NULL default '0',num_emails int(10) unsigned NOT NULL default '0',total_rating int(10) unsigned NOT NULL default '0',num_ratings int(10) unsigned NOT NULL default '0',allow_comments tinyint(1) unsigned NOT NULL default '1',published tinyint(1) unsigned NOT NULL default '0',featured tinyint(1) unsigned NOT NULL default '0',alias varchar(255) default NULL,header_id int(10) unsigned NOT NULL default '0',footer_id int(10) unsigned NOT NULL default '0',PRIMARY KEY  (id),KEY user_id (user_id),KEY num_ratings (num_ratings),KEY category_id (category_id),KEY created_time (created_time),KEY total_rating (total_rating),KEY num_views (num_views),KEY published (published),KEY alias (alias),FULLTEXT KEY title_content_keywords (title,content,keywords),FULLTEXT KEY title_keywords (title,keywords)) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `lore_attachments`
#

DROP TABLE IF EXISTS lore_attachments;
CREATE TABLE lore_attachments (id int(10) unsigned NOT NULL auto_increment,article_id int(10) unsigned NOT NULL default '0',filename varchar(100) NOT NULL default '',filetype varchar(255) default NULL,filesize int(10) unsigned NOT NULL default '0',file mediumblob NOT NULL,num_downloads int(10) unsigned NOT NULL default '0',PRIMARY KEY  (id),KEY article_id (article_id)) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `lore_blackboard`
#

DROP TABLE IF EXISTS lore_blackboard;
CREATE TABLE lore_blackboard (name varchar(20) NOT NULL default '',content mediumtext NOT NULL,PRIMARY KEY  (name)) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `lore_categories`
#

DROP TABLE IF EXISTS lore_categories;
CREATE TABLE lore_categories (id int(10) NOT NULL auto_increment,parent_category_id int(10) NOT NULL default '0',name varchar(50) NOT NULL default '',description varchar(255) default NULL,total_articles int(10) unsigned NOT NULL default '0',published tinyint(1) unsigned NOT NULL default '0',PRIMARY KEY  (id),KEY parent_category_id (parent_category_id),FULLTEXT KEY name_description (name,description)) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `lore_comments`
#

DROP TABLE IF EXISTS lore_comments;
CREATE TABLE lore_comments (id int(10) unsigned NOT NULL auto_increment,article_id int(10) unsigned NOT NULL default '0',name varchar(100) default NULL,email varchar(100) default NULL,title varchar(255) default NULL,comment mediumtext NOT NULL,approved tinyint(1) unsigned NOT NULL default '0',created_time int(10) unsigned NOT NULL default '0',PRIMARY KEY  (id),KEY article_id (article_id),KEY created_time (created_time),KEY approved (approved),KEY name (name),KEY email (email),KEY title (title)) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `lore_glossary`
#

DROP TABLE IF EXISTS lore_glossary;
CREATE TABLE lore_glossary (id int(10) unsigned NOT NULL auto_increment,term varchar(100) NOT NULL default '',alt_term_1 varchar(100) default NULL,alt_term_2 varchar(100) default NULL,alt_term_3 varchar(100) default NULL,definition text NOT NULL,PRIMARY KEY  (id),KEY term (term)) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `lore_search_log`
#

DROP TABLE IF EXISTS lore_search_log;
CREATE TABLE lore_search_log (id int(10) unsigned NOT NULL auto_increment,search varchar(255) NOT NULL default '',the_time int(10) unsigned NOT NULL default '0',PRIMARY KEY  (id),KEY search (search,the_time)) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `lore_users`
#

DROP TABLE IF EXISTS lore_users;
CREATE TABLE lore_users (id int(10) unsigned NOT NULL auto_increment,level set('Administrator','Writer','Moderator') NOT NULL default '',username varchar(30) NOT NULL default '',password varchar(32) NOT NULL default '',email varchar(100) NOT NULL default '',PRIMARY KEY  (id),KEY username (username),KEY password (password),KEY email (email),KEY level (level)) TYPE=MyISAM;

