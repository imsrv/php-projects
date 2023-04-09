
CREATE TABLE `e_post` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `groupname` varchar(50) NOT NULL default '',
  `username` varchar(20) NOT NULL default '',
  `whofrom` varchar(20) NOT NULL default '',
  `date` date NOT NULL default '0000-00-00',
  `time` time NOT NULL default '00:00:00',
  `readstate` smallint(1) unsigned NOT NULL default '0',
  `subject` varchar(20) NOT NULL default '',
  `message` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;


CREATE TABLE `e_users` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `username` varchar(20) NOT NULL default '',
  `passwd` varchar(16) NOT NULL default '',
  `email` varchar(50) NOT NULL default '',
  `groupname` varchar(50) NOT NULL default '',
  `notify` smallint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=3 ;


INSERT INTO `e_users` VALUES (1, 'test1', 'test1', 'test1@test.com', 'test', '');
INSERT INTO `e_users` VALUES (2, 'test2', 'test2', 'test2@test.com', 'test', '');

CREATE TABLE `e_friends` (
  `username` varchar(20) NOT NULL default '',
  `friend` varchar(20) NOT NULL default ''
) TYPE=MyISAM;


