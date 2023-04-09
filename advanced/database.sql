
-- --------------------------------------------------------

-- 
-- Table structure for table `banners`
-- 

DROP TABLE IF EXISTS `banners`;
CREATE TABLE `banners` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `mouseover` varchar(255) NOT NULL default '',
  `location` varchar(255) NOT NULL default '',
  `urlto` varchar(255) NOT NULL default '',
  `stopit` varchar(255) NOT NULL default '',
  `java_status` varchar(255) NOT NULL default '',
  `openin` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  ;

-- 
-- Dumping data for table `banners`
-- 

INSERT INTO `banners` VALUES (4, 'Free PHP Scripts', 'Free Hit Counter, Password Protectors, Tell A Friend and more..', 'http://www.free-php-scripts.net/images/free_php_scripts.gif', 'http://www.free-php-scripts.net', 'OFF', 'ON', '_blank');

-- --------------------------------------------------------

-- 
-- Table structure for table `ips`
-- 

DROP TABLE IF EXISTS `ips`;
CREATE TABLE `ips` (
  `viewip` varchar(255) NOT NULL default '',
  `visitip` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`viewip`),
  UNIQUE KEY `visitip` (`visitip`)
) ENGINE=MyISAM ;

-- 
-- Dumping data for table `ips`
-- 

INSERT INTO `ips` VALUES ('127.0.0.1', '');
INSERT INTO `ips` VALUES ('', '127.0.0.1');

-- --------------------------------------------------------

-- 
-- Table structure for table `stats`
-- 

DROP TABLE IF EXISTS `stats`;
CREATE TABLE `stats` (
  `id` varchar(255) NOT NULL default '',
  `made` varchar(255) NOT NULL default '',
  `file_location` varchar(255) NOT NULL default '',
  `width` varchar(255) NOT NULL default '',
  `length` varchar(255) NOT NULL default '',
  `hits` varchar(255) NOT NULL default '',
  `uni_hits` varchar(255) NOT NULL default '',
  `views` varchar(255) NOT NULL default '',
  `uni_views` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM ;

-- 
-- Dumping data for table `stats`
-- 

INSERT INTO `stats` VALUES ('4', '05/25/2005', 'http://www.free-php-scripts.net/images/free_php_scripts.gif', 'NA', 'NA', '3', '1', '10', '1');
        