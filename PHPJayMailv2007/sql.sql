CREATE TABLE `mailing_list` (
  `user_id` tinyint(5) NOT NULL auto_increment,
  `email` varchar(40) NOT NULL default '',
  `name` varchar(40) NOT NULL default '',
  `approved` char(1) NOT NULL default 'N',
  PRIMARY KEY  (`user_id`),
  UNIQUE KEY `email` (`email`)
) TYPE=MyISAM AUTO_INCREMENT=20 ;
