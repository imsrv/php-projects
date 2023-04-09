# MySQL-Front Dump 2.4
#
# Host: localhost   Database: vadim_lindapics
#--------------------------------------------------------
# Server version 4.0.12-nt-log


#
# Table structure for table 'tm_cj_banned'
#

DROP TABLE IF EXISTS tm_cj_banned;
CREATE TABLE `tm_cj_banned` (
  `domain` varchar(255) default NULL,
  UNIQUE KEY `domain` (`domain`)
) TYPE=MyISAM;



#
# Dumping data for table 'tm_cj_banned'
#


#
# Table structure for table 'tm_cj_cron'
#

DROP TABLE IF EXISTS tm_cj_cron;
CREATE TABLE `tm_cj_cron` (
  `_time` int(11) NOT NULL default '0'
) TYPE=MyISAM;



#
# Dumping data for table 'tm_cj_cron'
#
INSERT INTO tm_cj_cron (_time) VALUES("1048978803");


#
# Table structure for table 'tm_cj_dburl'
#

DROP TABLE IF EXISTS tm_cj_dburl;
CREATE TABLE `tm_cj_dburl` (
  `url` varchar(255) NOT NULL default '0'
) TYPE=MyISAM;



#
# Dumping data for table 'tm_cj_dburl'
#


#
# Table structure for table 'tm_cj_force'
#

DROP TABLE IF EXISTS tm_cj_force;
CREATE TABLE `tm_cj_force` (
  `tid` mediumint(8) unsigned NOT NULL default '0',
  `_hour` tinyint(3) unsigned NOT NULL default '0',
  `_force` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`tid`,`_hour`)
) TYPE=MyISAM;



#
# Dumping data for table 'tm_cj_force'
#
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("1", "0", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("1", "1", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("1", "2", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("1", "3", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("1", "4", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("1", "5", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("1", "6", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("1", "7", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("1", "8", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("1", "9", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("1", "10", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("1", "11", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("1", "12", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("1", "13", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("1", "14", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("1", "15", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("1", "16", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("1", "17", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("1", "18", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("1", "19", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("1", "20", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("1", "21", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("1", "22", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("1", "23", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("2", "0", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("2", "1", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("2", "2", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("2", "3", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("2", "4", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("2", "5", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("2", "6", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("2", "7", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("2", "8", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("2", "9", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("2", "10", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("2", "11", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("2", "12", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("2", "13", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("2", "14", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("2", "15", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("2", "16", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("2", "17", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("2", "18", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("2", "19", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("2", "20", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("2", "21", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("2", "22", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("2", "23", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("3", "0", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("3", "1", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("3", "2", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("3", "3", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("3", "4", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("3", "5", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("3", "6", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("3", "7", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("3", "8", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("3", "9", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("3", "10", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("3", "11", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("3", "12", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("3", "13", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("3", "14", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("3", "15", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("3", "16", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("3", "17", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("3", "18", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("3", "19", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("3", "20", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("3", "21", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("3", "22", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("3", "23", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("4", "0", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("4", "1", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("4", "2", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("4", "3", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("4", "4", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("4", "5", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("4", "6", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("4", "7", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("4", "8", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("4", "9", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("4", "10", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("4", "11", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("4", "12", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("4", "13", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("4", "14", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("4", "15", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("4", "16", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("4", "17", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("4", "18", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("4", "19", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("4", "20", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("4", "21", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("4", "22", "0");
INSERT INTO tm_cj_force (tid, _hour, _force) VALUES("4", "23", "0");


#
# Table structure for table 'tm_cj_group'
#

DROP TABLE IF EXISTS tm_cj_group;
CREATE TABLE `tm_cj_group` (
  `gid` tinyint(5) unsigned NOT NULL default '0',
  `_desc` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`gid`)
) TYPE=MyISAM;



#
# Dumping data for table 'tm_cj_group'
#
INSERT INTO tm_cj_group (gid, _desc) VALUES("1", "Anal");
INSERT INTO tm_cj_group (gid, _desc) VALUES("2", "Amateur");
INSERT INTO tm_cj_group (gid, _desc) VALUES("3", "Teens");
INSERT INTO tm_cj_group (gid, _desc) VALUES("4", "Blowjob");
INSERT INTO tm_cj_group (gid, _desc) VALUES("5", "Shemale");
INSERT INTO tm_cj_group (gid, _desc) VALUES("6", "Mature");
INSERT INTO tm_cj_group (gid, _desc) VALUES("7", "");
INSERT INTO tm_cj_group (gid, _desc) VALUES("8", "");
INSERT INTO tm_cj_group (gid, _desc) VALUES("9", "");
INSERT INTO tm_cj_group (gid, _desc) VALUES("10", "");
INSERT INTO tm_cj_group (gid, _desc) VALUES("11", "");
INSERT INTO tm_cj_group (gid, _desc) VALUES("12", "");
INSERT INTO tm_cj_group (gid, _desc) VALUES("13", "");
INSERT INTO tm_cj_group (gid, _desc) VALUES("14", "");
INSERT INTO tm_cj_group (gid, _desc) VALUES("15", "");
INSERT INTO tm_cj_group (gid, _desc) VALUES("16", "");


#
# Table structure for table 'tm_cj_hour'
#

DROP TABLE IF EXISTS tm_cj_hour;
CREATE TABLE `tm_cj_hour` (
  `tid` smallint(5) unsigned NOT NULL default '0',
  `_time` int(3) NOT NULL default '0',
  `_uin` smallint(5) unsigned NOT NULL default '0',
  `_rin` smallint(5) unsigned NOT NULL default '0',
  `_out` smallint(5) unsigned NOT NULL default '0',
  `_clk` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`tid`,`_time`)
) TYPE=MyISAM;



#
# Dumping data for table 'tm_cj_hour'
#


#
# Table structure for table 'tm_cj_iplog'
#

DROP TABLE IF EXISTS tm_cj_iplog;
CREATE TABLE `tm_cj_iplog` (
  `_ip` int(11) NOT NULL default '0',
  `tid` mediumint(8) unsigned NOT NULL default '1',
  `_time` int(11) NOT NULL default '0',
  `_act` tinyint(3) unsigned NOT NULL default '1',
  `_proxy` tinyint(1) unsigned NOT NULL default '0',
  KEY `NewIndex` (_ip,tid,_act)
) TYPE=MyISAM;




#
# Dumping data for table 'tm_cj_iplog'
#


#
# Table structure for table 'tm_cj_stats'
#

DROP TABLE IF EXISTS tm_cj_stats;
CREATE TABLE `tm_cj_stats` (
  `tid` mediumint(8) unsigned NOT NULL default '0',
  `_uin` int(10) unsigned NOT NULL default '0',
  `_rin` int(10) unsigned NOT NULL default '0',
  `_out` int(10) unsigned NOT NULL default '0',
  `_clk` int(10) unsigned NOT NULL default '0',
  `_huin` smallint(5) unsigned NOT NULL default '0',
  `_hrin` smallint(3) unsigned NOT NULL default '0',
  `_hout` smallint(5) unsigned NOT NULL default '0',
  `_hclk` smallint(5) unsigned NOT NULL default '0',
  `_back` smallint(5) unsigned NOT NULL default '130',
  PRIMARY KEY  (`tid`)
) TYPE=MyISAM;



#
# Dumping data for table 'tm_cj_stats'
#
INSERT INTO tm_cj_stats (tid, _uin, _rin, _out, _clk, _huin, _hrin, _hout, _hclk, _back) VALUES("4", "0", "0", "0", "0", "0", "0", "0", "0", "0");
INSERT INTO tm_cj_stats (tid, _uin, _rin, _out, _clk, _huin, _hrin, _hout, _hclk, _back) VALUES("1", "0", "0", "0", "0", "0", "0", "0", "0", "0");
INSERT INTO tm_cj_stats (tid, _uin, _rin, _out, _clk, _huin, _hrin, _hout, _hclk, _back) VALUES("2", "0", "0", "0", "0", "0", "0", "0", "0", "0");
INSERT INTO tm_cj_stats (tid, _uin, _rin, _out, _clk, _huin, _hrin, _hout, _hclk, _back) VALUES("3", "0", "0", "0", "0", "0", "0", "0", "0", "0");


#
# Table structure for table 'tm_cj_tmpst'
#

DROP TABLE IF EXISTS tm_cj_tmpst;
CREATE TABLE `tm_cj_tmpst` (
  `tid` smallint(5) unsigned NOT NULL default '0',
  `_uin` mediumint(8) unsigned NOT NULL default '0',
  `_rin` mediumint(8) unsigned NOT NULL default '0',
  `_out` mediumint(8) unsigned NOT NULL default '0',
  `_clk` mediumint(8) unsigned NOT NULL default '0',
  `_force` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`tid`)
) TYPE=MyISAM;



#
# Dumping data for table 'tm_cj_tmpst'
#
INSERT INTO tm_cj_tmpst (tid, _uin, _rin, _out, _clk, _force) VALUES("1", "0", "0", "0", "0", "0");
INSERT INTO tm_cj_tmpst (tid, _uin, _rin, _out, _clk, _force) VALUES("2", "0", "0", "0", "0", "0");
INSERT INTO tm_cj_tmpst (tid, _uin, _rin, _out, _clk, _force) VALUES("3", "0", "0", "0", "0", "0");
INSERT INTO tm_cj_tmpst (tid, _uin, _rin, _out, _clk, _force) VALUES("4", "0", "0", "0", "0", "0");


#
# Table structure for table 'tm_cj_traders'
#

DROP TABLE IF EXISTS tm_cj_traders;
CREATE TABLE `tm_cj_traders` (
  `tid` mediumint(8) unsigned NOT NULL auto_increment,
  `_egid` mediumint(8) unsigned NOT NULL default '0',
  `_status` enum('on','off') NOT NULL default 'on',
  `_domain` char(32) NOT NULL default '',
  `_face` char(12) NOT NULL default '',
  `_url` char(100) NOT NULL default '',
  `_mail` char(32) NOT NULL default '',
  `_icq` char(15) NOT NULL default '',
  `_pass` char(32) NOT NULL default '',
  `_back` smallint(5) unsigned NOT NULL default '130',
  PRIMARY KEY  (`tid`),
  KEY `NewIndex` (`_domain`),
  KEY `NewIndex2` (`_egid`,`_status`)
) TYPE=MyISAM;



#
# Dumping data for table 'tm_cj_traders'
#
INSERT INTO tm_cj_traders (tid, _egid, _status, _domain, _face, _url, _mail, _icq, _pass, _back) VALUES("2", "0", "on", "gallery", "", "", "", "", "", "130");
INSERT INTO tm_cj_traders (tid, _egid, _status, _domain, _face, _url, _mail, _icq, _pass, _back) VALUES("1", "2", "on", "bookmark", "", "", "", "", "21232f297a57a5a743894a0e4a801fc3", "130");
INSERT INTO tm_cj_traders (tid, _egid, _status, _domain, _face, _url, _mail, _icq, _pass, _back) VALUES("3", "0", "on", "exout", "", "http://www.link_to_exout.com/url.html", "", "", "", "130");
INSERT INTO tm_cj_traders (tid, _egid, _status, _domain, _face, _url, _mail, _icq, _pass, _back) VALUES("4", "0", "on", "nocookie", "", "http://www.link_to_nocookie.com/url.html", "", "", "", "130");

create table if not exists tm_cj_settings
(
   id                             varchar(32)                    not null,
   value                          varchar(255)                   not null,
   primary key (id)
);
INSERT INTO tm_cj_settings (id, value) VALUES ('last_trader', '4');
INSERT INTO tm_cj_settings (id, value) VALUES ('last_trader_view', '4');
