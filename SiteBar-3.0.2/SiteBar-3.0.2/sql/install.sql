
/* CREATE TABLES */

CREATE TABLE `sitebar_acl` (
  `gid` int(10) unsigned NOT NULL default '0',
  `nid` int(10) unsigned NOT NULL default '0',
  `allow_select` tinyint(1) NOT NULL default '1',
  `allow_update` tinyint(1) NOT NULL default '0',
  `allow_delete` tinyint(1) NOT NULL default '0',
  `allow_purge` tinyint(1) NOT NULL default '0',
  `allow_insert` tinyint(1) NOT NULL default '0',
  `allow_grant` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`gid`,`nid`),
  KEY `IGID` (`gid`)
) TYPE=MyISAM COMMENT='Access control list. Defines rights of groups to root nodes.';

CREATE TABLE `sitebar_config` (
  `gid_admins` int(10) unsigned NOT NULL default '1',
  `gid_everyone` int(10) unsigned NOT NULL default '2',
  `release` varchar(10) NOT NULL default '3.0.2',
  `params` text
) TYPE=MyISAM COMMENT='Basic Sitebar parameters';

CREATE TABLE `sitebar_group` (
  `gid` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(50) default NULL,
  `allow_addself` tinyint(1) NOT NULL default '0',
  `allow_contact` tinyint(1) NOT NULL default '0',
  `auto_join` text,
  `comment` text,
  PRIMARY KEY  (`gid`)
) TYPE=MyISAM PACK_KEYS=0 COMMENT='Groups of users with auto join feature.';

CREATE TABLE `sitebar_link` (
  `lid` int(10) unsigned NOT NULL auto_increment,
  `nid` int(10) unsigned NOT NULL default '0',
  `url` varchar(255) NOT NULL default '',
  `name` varchar(50) default NULL,
  `private` tinyint(1) default '0',
  `comment` text,
  `favicon` varchar(255) default NULL,
  `t_changed` timestamp(14) NOT NULL,
  `t_tested` timestamp(14) NOT NULL,
  `deleted_by` int(10) unsigned default NULL,
  `is_dead` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`lid`),
  UNIQUE KEY `name` (`nid`,`name`),
  UNIQUE KEY `url` (`nid`,`url`)
) TYPE=MyISAM PACK_KEYS=0 COMMENT='Each link must belong to a node.';

CREATE TABLE `sitebar_member` (
  `gid` int(10) unsigned NOT NULL default '0',
  `uid` int(10) unsigned NOT NULL default '0',
  `moderator` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`gid`,`uid`)
) TYPE=MyISAM COMMENT='Membership';

CREATE TABLE `sitebar_node` (
  `nid` int(10) unsigned NOT NULL auto_increment,
  `nid_parent` int(10) unsigned NOT NULL default '0',
  `name` varchar(50) default NULL,
  `deleted_by` int(10) unsigned default NULL,
  `comment` text,
  PRIMARY KEY  (`nid`),
  UNIQUE KEY `name` (`nid_parent`,`name`),
  KEY `pnid` (`nid_parent`)
) TYPE=MyISAM PACK_KEYS=0 COMMENT='Node contains other nodes and links.';

CREATE TABLE `sitebar_root` (
  `nid` int(10) unsigned NOT NULL default '0',
  `uid` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`nid`),
  UNIQUE KEY `nid` (`nid`,`uid`)
) TYPE=MyISAM COMMENT='Contains list of trees and their respective owners.';

CREATE TABLE `sitebar_user` (
  `uid` int(10) unsigned NOT NULL auto_increment,
  `email` varchar(50) NOT NULL default '',
  `pass` varchar(32) default NULL,
  `name` varchar(50) default NULL,
  `verified` tinyint(1) NOT NULL default '0',
  `demo` tinyint(1) NOT NULL default '0',
  `code` int(6) default NULL,
  `comment` text,
  `params` text,
  PRIMARY KEY  (`uid`),
  UNIQUE KEY `email` (`email`)
) TYPE=MyISAM PACK_KEYS=0 COMMENT='Users of the application.';

CREATE TABLE `sitebar_session` (
  `uid` tinyint(10) unsigned NOT NULL default '0',
  `code` varchar(32) NOT NULL default '',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `expires` int(11) NOT NULL default '0',
  `ip` varchar(15) NOT NULL default '',
  PRIMARY KEY  (`code`)
) TYPE=MyISAM COMMENT='Session management';

/* INSERT DEFAULT DATA
   - this data can be modified, however this is standard setup and
     any change here might lead to malfunction of SiteBar 3.
*/

INSERT INTO `sitebar_config` VALUES();

INSERT INTO `sitebar_user` (`uid`, `email`, `comment`)
VALUES (1, 'Admin', 'Administrator of the system');

INSERT INTO `sitebar_user` (`uid`, `email`, `name`)
VALUES (2, 'Anonymous', 'Anonymous user');

INSERT INTO `sitebar_root` VALUES (1, 1);
INSERT INTO `sitebar_root` VALUES (5, 1);

INSERT INTO `sitebar_group` VALUES (1, 'Admins', 0, 0, NULL, 'Default group for administrators');
INSERT INTO `sitebar_group` VALUES (2, 'Everyone', 1, 1, '.*', 'Default public group');

INSERT INTO `sitebar_member` VALUES (1, 1, 1);
INSERT INTO `sitebar_member` VALUES (2, 1, 1);
INSERT INTO `sitebar_member` VALUES (2, 2, 0);

INSERT INTO `sitebar_acl` VALUES (1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `sitebar_acl` VALUES (2, 1, 1, 0, 0, 0, 0, 0);
INSERT INTO `sitebar_acl` VALUES (1, 4, 1, 1, 1, 1, 1, 1);

INSERT INTO `sitebar_node` VALUES (1, 0, 'Public Bookmarks', NULL, NULL);
INSERT INTO `sitebar_node` VALUES (2, 1, 'SiteBar Project', NULL, 'Links related to the SiteBar project');
INSERT INTO `sitebar_node` VALUES (3, 2, 'Development Team', NULL, 'Members and their roles');
INSERT INTO `sitebar_node` VALUES (4, 2, 'Promotion & Reviews', NULL, 'Various statistics and ratings. Please rate SiteBar if you like it.');
INSERT INTO `sitebar_node` VALUES (5, 0, 'Admins\' Bookmarks', NULL, 'Bookmarks of SiteBar Administrators');

INSERT INTO `sitebar_link` (`nid`, `url`, `name`, `comment`)
VALUES (2, 'http://sourceforge.net/projects/sitebar', 'Project Page', 'Open Source Project Hosting Site');

INSERT INTO `sitebar_link` (`nid`, `url`, `name`, `comment`)
VALUES (2, 'http://www.sitebar.org', 'Homepage', 'Official Homepage');

INSERT INTO `sitebar_link` (`nid`, `url`, `name`, `comment`)
VALUES (3, 'http://www.mindslip.com/', 'David Szego', 'Author of SiteBar');

INSERT INTO `sitebar_link` (`nid`, `url`, `name`, `comment`, `favicon`)
VALUES (3, 'http://brablc.com/', 'Ondrej Brablc', 'Author of SiteBar Release 3', 'http://brablc.com/favicon.ico');

INSERT INTO `sitebar_link` (`nid`, `url`, `name`)
VALUES (2, 'http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/sitebar/sitebar3/#dirlist', 'Browse CVS');

INSERT INTO `sitebar_link` (`nid`, `url`, `name`, `comment`)
VALUES (2, 'http://brablc.com/sitebar', 'Development Demo', 'The most up-to-date version of SiteBar (CVS or pre CVS).');

INSERT INTO `sitebar_link` (`nid`, `url`, `name`)
VALUES (4, 'http://freshmeat.net/projects/sitebar/', 'freshmeat.net');

INSERT INTO `sitebar_link` (`nid`, `url`, `name`)
VALUES (4, 'http://www.hotscripts.com/Detailed/26925.html', 'HotScripts.com');

INSERT INTO `sitebar_link` (`nid`, `url`, `name`)
VALUES (4, 'http://www.yhbt.com/article.php?story=20030928163414229', 'Philip Lowman\'s Blog');

INSERT INTO `sitebar_link` (`nid`, `url`, `name`)
VALUES (4, 'http://sourceforge.net/project/stats/?group_id=76467', 'SourceForge.net: Project statistics');

INSERT INTO `sitebar_link` (`nid`, `url`, `name`)
VALUES (4, 'http://lbstone.com/apb/stats/', 'Stats for Bookmark Programs');
