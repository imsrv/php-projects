-- phpMyAdmin SQL Dump
-- version 2.6.1
-- http://www.phpmyadmin.net
-- 
-- Host: db22.perfora.net
-- Generation Time: Jul 16, 2005 at 01:33 PM
-- Server version: 4.0.24
-- PHP Version: 4.3.10-2
-- 
-- Database: `db88977318`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `admin25`
-- 

DROP TABLE IF EXISTS `admin25`;
CREATE TABLE IF NOT EXISTS `admin25` (
  `AdminID` int(10) NOT NULL auto_increment,
  `username` varchar(50) NOT NULL default '',
  `password` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`AdminID`)
) TYPE=MyISAM;

-- 
-- Dumping data for table `admin25`
-- 

INSERT INTO `admin25` VALUES (1, 'admin25', 'admin25');

-- --------------------------------------------------------

-- 
-- Table structure for table `images25`
-- 

DROP TABLE IF EXISTS `images25`;
CREATE TABLE IF NOT EXISTS `images25` (
  `id` int(11) NOT NULL auto_increment,
  `filename` text NOT NULL,
  `ipaddress` text NOT NULL,
  `date` int(11) NOT NULL default '0',
  `status` tinyint(4) NOT NULL default '1',
  `pkey` varchar(25) NOT NULL default '',
  `user` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

-- 
-- Dumping data for table `images25`
-- 

INSERT INTO `images25` VALUES (30, '09cfbf891e.zip', '67.185.226.140', 1121529575, 1, '09cfbf891e', 0);
INSERT INTO `images25` VALUES (31, 'c6ced50258.jpg', '69.88.8.191', 1121534457, 1, 'c6ced50258', 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `pending25`
-- 

DROP TABLE IF EXISTS `pending25`;
CREATE TABLE IF NOT EXISTS `pending25` (
  `id` int(255) unsigned NOT NULL auto_increment,
  `username` varchar(15) NOT NULL default '',
  `since` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

-- 
-- Dumping data for table `pending25`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `users25`
-- 

DROP TABLE IF EXISTS `users25`;
CREATE TABLE IF NOT EXISTS `users25` (
  `uid` int(11) NOT NULL auto_increment,
  `username` varchar(50) default NULL,
  `password` varchar(50) default NULL,
  `first_name` varchar(20) NOT NULL default '',
  `last_name` varchar(35) NOT NULL default '',
  `street` varchar(100) NOT NULL default '',
  `city` varchar(40) NOT NULL default '',
  `state` varchar(5) NOT NULL default '',
  `zip` varchar(10) NOT NULL default '',
  `country` varchar(40) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `telephone` varchar(12) NOT NULL default '',
  `last_paid` varchar(50) NOT NULL default '',
  `signup_date` varchar(50) NOT NULL default '',
  `status` int(11) NOT NULL default '1',
  PRIMARY KEY  (`uid`)
) TYPE=MyISAM;

-- 
-- Dumping data for table `users25`
-- 

INSERT INTO `users25` VALUES (1, 'netshark', '', 'netshark', 'server', '218 east buffalo', 'new buffalo', 'michi', '49117', 'usa', 'admin@scriptz.ws', '', 'free', 'Jul 16, 2005', 1);
INSERT INTO `users25` VALUES (2, 'demo', '', 'demo', 'demo', '2132', 'fdfafdf', 'dfads', '54878', 'usa', 'netshark_server@yahoo.com', '1-555-1212', 'free', 'Jul 16, 2005', 1);
