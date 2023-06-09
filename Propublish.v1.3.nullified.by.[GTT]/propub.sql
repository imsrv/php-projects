CREATE TABLE `article_news` (
  `id` int(11) NOT NULL auto_increment,
  `catid` int(11) default NULL,
  `authorid` int(11) default NULL,
  `date` varchar(8) default NULL,
  `date_changed` varchar(8) default NULL,
  `title` varchar(150) default NULL,
  `intro` text,
  `body` text,
  `count` int(11) default '1',
  `validated` int(4) default NULL,
  `status` tinyint(4) default NULL,
  `frontpage` int(11) default NULL,
  `grade` int(11) default NULL,
  `votes` int(11) default NULL,
  `topnews` tinyint(4) default NULL,
  `show_html` int(11) default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;


CREATE TABLE `author_news` (
  `userid` int(11) NOT NULL auto_increment,
  `fname` varchar(50) NOT NULL default '',
  `lname` varchar(50) NOT NULL default '',
  `email` varchar(50) NOT NULL default '',
  `registrered` timestamp(8) NOT NULL,
  `picture` varchar(40) NOT NULL default '',
  `password` varchar(40) NOT NULL default '',
  `about` text,
  `level` tinyint(4) default '2',
  PRIMARY KEY  (`userid`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;

INSERT INTO author_news VALUES (1, '', 'ChangemE', 'admin@gtt.com', 20020619, '', 'GTT', '', 1);

CREATE TABLE `cat_news` (
  `id` int(11) NOT NULL auto_increment,
  `catname` varchar(50) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=3 ;


INSERT INTO `cat_news` VALUES (1, 'Democat 1');
INSERT INTO `cat_news` VALUES (2, 'Democat 2');

CREATE TABLE `level_news` (
  `levelid` int(11) NOT NULL auto_increment,
  `levelname` varchar(60) default NULL,
  `level` int(11) default NULL,
  PRIMARY KEY  (`levelid`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;


INSERT INTO `level_news` VALUES (1, 'Admin', 1);

CREATE TABLE `newspicture_news` (
  `id` int(4) NOT NULL auto_increment,
  `artikkelid` int(11) default NULL,
  `bin_data` longblob,
  `filename` varchar(50) default NULL,
  `filesize` varchar(50) default NULL,
  `filetype` varchar(50) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1;



    