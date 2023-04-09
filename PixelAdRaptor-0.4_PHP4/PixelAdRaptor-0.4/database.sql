-- phpMyAdmin SQL Dump
-- version 2.6.3-pl1
-- http://www.phpmyadmin.net
-- 
-- Darbinė stotis: localhost
-- Atlikimo laikas:  2005 m. Lapkričio 02 d.  00:23
-- Serverio versija: 4.1.13
-- PHP versija: 5.0.5
-- 
-- Duombazė: `pxr`
-- 

-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `ads`
-- 

CREATE TABLE `ads` (
  `id` int(11) NOT NULL auto_increment,
  `x` int(11) NOT NULL default '0',
  `y` int(11) NOT NULL default '0',
  `width` int(11) NOT NULL default '0',
  `height` int(11) NOT NULL default '0',
  `name` varchar(250) NOT NULL default '',
  `email` varchar(250) NOT NULL default '',
  `title` varchar(200) NOT NULL default '',
  `link` varchar(200) NOT NULL default '',
  `size` int(20) NOT NULL default '0',
  `file` varchar(50) NOT NULL default '',
  `date` varchar(20) NOT NULL default '',
  `price` int(11) NOT NULL default '0',
  `hits` int(11) NOT NULL default '0',
  `active` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 ;

-- 
-- Sukurta duomenų kopija lentelei `ads`
-- 


-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `blog`
-- 

CREATE TABLE `blog` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(250) NOT NULL default '',
  `text` text NOT NULL,
  `date` varchar(40) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 ;

-- 
-- Sukurta duomenų kopija lentelei `blog`
-- 

INSERT INTO `blog` VALUES (10, 'Hello World!', 'Hello World! This is a test post.', 'November 1, 2005, 10:20 pm');

-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `config`
-- 

CREATE TABLE `config` (
  `id` tinyint(2) NOT NULL auto_increment,
  `variable` varchar(20) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 ;

-- 
-- Sukurta duomenų kopija lentelei `config`
-- 

INSERT INTO `config` VALUES (1, 'adsense', 'Disabled. This will be fixed to allow to leave the field blank. ');
INSERT INTO `config` VALUES (2, 'adsense_enabled', '0');
INSERT INTO `config` VALUES (3, 'title', 'PixelAdRaptor');
INSERT INTO `config` VALUES (4, 'description', '');
INSERT INTO `config` VALUES (5, 'slogan', 'PixelAdRaptor - your million dollar homepage engine');
INSERT INTO `config` VALUES (6, 'price', '1');
INSERT INTO `config` VALUES (7, 'business_email', 'test@test.com');
INSERT INTO `config` VALUES (8, 'site_url', '');

-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `contacts`
-- 

CREATE TABLE `contacts` (
  `id` int(5) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `email` varchar(250) NOT NULL default '',
  `subject` varchar(250) NOT NULL default '',
  `message` text NOT NULL,
  `wasread` tinyint(1) NOT NULL default '0',
  `wasreplied` tinyint(1) NOT NULL default '0',
  `date` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Sukurta duomenų kopija lentelei `contacts`
-- 


-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `faq`
-- 

CREATE TABLE `faq` (
  `id` int(11) NOT NULL auto_increment,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `weight` tinyint(2) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 ;

-- 
-- Sukurta duomenų kopija lentelei `faq`
-- 

INSERT INTO `faq` VALUES (9, 'What is 2 + 2?', 'It''s 4.', 0);

-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `navigation`
-- 

CREATE TABLE `navigation` (
  `id` int(11) NOT NULL auto_increment,
  `url` varchar(250) NOT NULL default '',
  `title` varchar(250) NOT NULL default '',
  `weight` tinyint(2) NOT NULL default '0',
  `active` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 ;

-- 
-- Sukurta duomenų kopija lentelei `navigation`
-- 

INSERT INTO `navigation` VALUES (2, 'Grid', 'Pixel grid', 4, 1);
INSERT INTO `navigation` VALUES (5, 'FAQ', 'FAQ', 2, 1);
INSERT INTO `navigation` VALUES (6, 'Contact', 'Contact us', 1, 1);
INSERT INTO `navigation` VALUES (7, 'Blog', 'Blog', 3, 1);

-- --------------------------------------------------------

-- 
-- Sukurta duomenų struktūra lentelei `static`
-- 

CREATE TABLE `static` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(250) NOT NULL default '',
  `url` varchar(250) NOT NULL default '',
  `content` longtext NOT NULL,
  `date` varchar(20) NOT NULL default '',
  `active` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 ;

-- 
-- Sukurta duomenų kopija lentelei `static`
-- 

