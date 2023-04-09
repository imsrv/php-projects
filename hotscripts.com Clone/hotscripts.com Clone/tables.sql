# phpMyAdmin SQL Dump
# version 2.5.6-rc1
# http://www.needit.ru/
#
# Host: localhost
# Generation Time: Mar 26, 2004 at 12:12 AM
# Server version: 4.0.18
# PHP Version: 4.2.3

# --------------------------------------------------------

#
# Table structure for table `sbwmd_admin`
#

CREATE TABLE `sbwmd_admin` (
  `id` bigint(20) NOT NULL auto_increment,
  `admin_name` varchar(255) default NULL,
  `pwd` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;

#
# Dumping data for table `sbwmd_admin`
#

INSERT INTO `sbwmd_admin` VALUES (1, 'mafiascripts', 'mafiascripts');

# --------------------------------------------------------

#
# Table structure for table `sbwmd_ads`
#

CREATE TABLE `sbwmd_ads` (
  `id` bigint(20) NOT NULL auto_increment,
  `url` varchar(255) NOT NULL default '',
  `bannerurl` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `credits` bigint(20) NOT NULL default '0',
  `displays` bigint(20) NOT NULL default '0',
  `paid` varchar(255) NOT NULL default '',
  `approved` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=19 ;

#
# Dumping data for table `sbwmd_ads`
#


# --------------------------------------------------------

#
# Table structure for table `sbwmd_banners`
#

CREATE TABLE `sbwmd_banners` (
  `id` bigint(20) NOT NULL auto_increment,
  `img_url` varchar(255) default NULL,
  `banner_link` varchar(255) default NULL,
  `width` int(11) default NULL,
  `height` int(11) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=15 ;

#
# Dumping data for table `sbwmd_banners`
#

INSERT INTO `sbwmd_banners` VALUES (13, 'banners/linktous2.gif', NULL, NULL, NULL);
INSERT INTO `sbwmd_banners` VALUES (14, 'banners/linktous3.gif', NULL, NULL, NULL);
INSERT INTO `sbwmd_banners` VALUES (11, 'banners/linktous1.gif', NULL, NULL, NULL);

# --------------------------------------------------------

#
# Table structure for table `sbwmd_categories`
#

CREATE TABLE `sbwmd_categories` (
  `id` bigint(20) NOT NULL auto_increment,
  `cat_name` varchar(255) default NULL,
  `pid` bigint(20) default NULL,
  `clicks` bigint(20) default NULL,
  `cat_img` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=100 ;

#
# Dumping data for table `sbwmd_categories`
#

INSERT INTO `sbwmd_categories` VALUES (21, 'Flash', 0, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (20, 'CGI and Perl', 0, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (72, 'Software', 23, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (67, 'Communities', 23, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (17, 'ASP', 0, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (58, 'Hosting', 0, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (73, 'Communities', 24, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (23, 'JavaScript', 0, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (24, 'PHP', 0, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (45, 'Linux', 0, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (44, 'Mac', 0, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (27, 'XML', 0, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (28, 'Books', 21, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (29, 'Fla Archives', 21, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (30, 'Movies', 21, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (31, 'Communities', 21, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (32, 'Software', 21, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (33, 'Tutorials', 21, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (34, 'Web Sites', 21, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (35, 'Windows', 0, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (39, 'Communities', 20, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (38, 'Books', 20, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (40, 'Scripts', 20, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (41, 'Software', 20, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (42, 'Tutorials', 20, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (43, 'Web Sites', 20, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (71, 'Websites', 23, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (70, 'Tutorials', 23, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (69, 'Scripts', 23, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (68, 'Books', 23, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (52, 'Communities', 17, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (53, 'Books', 17, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (54, 'Scripts', 17, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (55, 'Software', 17, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (56, 'Tutorials', 17, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (57, 'Websites', 17, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (59, 'Budget', 58, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (60, 'Windows', 58, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (61, 'E-Commerce', 58, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (62, 'VP Servers', 58, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (63, 'Unix/Linux', 58, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (64, 'Reseller', 58, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (65, 'Dedicated', 58, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (66, 'Domain Registration', 58, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (74, 'Books', 24, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (75, 'Scripts', 24, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (76, 'Software', 24, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (77, 'Tutorials', 24, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (78, 'Websites', 24, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (79, 'Books', 45, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (80, 'Communities', 45, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (81, 'Software', 45, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (82, 'Tutorials', 45, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (83, 'OS 9', 44, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (84, 'OS X', 44, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (90, 'Software', 27, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (89, 'Communities', 27, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (88, 'Books', 27, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (91, 'Scripts', 27, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (92, 'Tutorials', 27, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (93, 'Books', 35, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (94, 'Windows NT', 35, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (95, 'Windows 2000', 35, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (96, 'Windows XP', 35, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (97, 'Windows 98', 35, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (98, 'Tutorials', 35, NULL, '');
INSERT INTO `sbwmd_categories` VALUES (99, 'Communities', 35, NULL, '');

# --------------------------------------------------------

#
# Table structure for table `sbwmd_config`
#

CREATE TABLE `sbwmd_config` (
  `id` bigint(20) NOT NULL auto_increment,
  `admin_email` varchar(255) default NULL,
  `site_name` varchar(255) default NULL,
  `site_addrs` varchar(255) default NULL,
  `recperpage` int(11) default NULL,
  `image_after_pages` int(11) default NULL,
  `no_of_images` int(11) default NULL,
  `agreement` longtext,
  `recinpanel` int(11) default NULL,
  `null_char` varchar(255) default NULL,
  `no_of_friends` int(11) default NULL,
  `privacy` longtext,
  `legal` longtext,
  `terms` longtext,
  `username_len` int(11) default NULL,
  `pwd_len` int(11) default NULL,
  `pay_pal` varchar(255) NOT NULL default '',
  `site_root` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;

#
# Dumping data for table `sbwmd_config`
#

INSERT INTO `sbwmd_config` VALUES (1, 'info@mafiascripts.com', 'Scripts Download', 'http://www.mafiascripts.com', 29, 1, 1, 'By using our website you agree to all terms set forth by the moderator of this site. We make claims of association or endorse any materials devilvered through this site. We have the right to remove, edit and post products at our discretion. ', 5, '- -', 5, '', '', '', 5, 5, 'info@mafiascripts.com', 'http://www.mafiascript.com');

# --------------------------------------------------------

#
# Table structure for table `sbwmd_currency`
#

CREATE TABLE `sbwmd_currency` (
  `id` bigint(20) NOT NULL auto_increment,
  `cur_name` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=5 ;

#
# Dumping data for table `sbwmd_currency`
#

INSERT INTO `sbwmd_currency` VALUES (1, 'US$');
INSERT INTO `sbwmd_currency` VALUES (2, '€');
INSERT INTO `sbwmd_currency` VALUES (3, '£');
INSERT INTO `sbwmd_currency` VALUES (4, 'CAN$');

# --------------------------------------------------------

#
# Table structure for table `sbwmd_email_id`
#

CREATE TABLE `sbwmd_email_id` (
  `id` bigint(20) NOT NULL auto_increment,
  `fname` varchar(255) default NULL,
  `lname` varchar(255) default NULL,
  `useremail` varchar(255) default NULL,
  `friend_email` longtext,
  `no_of_friends` int(11) default NULL,
  `sid` bigint(20) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=10 ;

#
# Dumping data for table `sbwmd_email_id`
#


# --------------------------------------------------------

#
# Table structure for table `sbwmd_featuredads`
#

CREATE TABLE `sbwmd_featuredads` (
  `id` bigint(20) NOT NULL auto_increment,
  `name_url` varchar(255) default NULL,
  `url` varchar(255) default NULL,
  `fd_desc` longtext,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=8 ;

#
# Dumping data for table `sbwmd_featuredads`
#


# --------------------------------------------------------

#
# Table structure for table `sbwmd_feedback`
#

CREATE TABLE `sbwmd_feedback` (
  `id` bigint(20) NOT NULL auto_increment,
  `fname` varchar(255) default NULL,
  `lname` varchar(255) default NULL,
  `email` varchar(255) default NULL,
  `url` varchar(255) default NULL,
  `title` varchar(255) default NULL,
  `comment` longtext,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=10 ;

#
# Dumping data for table `sbwmd_feedback`
#


# --------------------------------------------------------

#
# Table structure for table `sbwmd_licence_types`
#

CREATE TABLE `sbwmd_licence_types` (
  `id` bigint(20) NOT NULL auto_increment,
  `licence_name` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=6 ;

#
# Dumping data for table `sbwmd_licence_types`
#

INSERT INTO `sbwmd_licence_types` VALUES (1, 'shareware');
INSERT INTO `sbwmd_licence_types` VALUES (2, 'freeware');
INSERT INTO `sbwmd_licence_types` VALUES (3, 'GPL');
INSERT INTO `sbwmd_licence_types` VALUES (4, 'commercial');
INSERT INTO `sbwmd_licence_types` VALUES (5, 'membership');

# --------------------------------------------------------

#
# Table structure for table `sbwmd_mailing_list`
#

CREATE TABLE `sbwmd_mailing_list` (
  `id` bigint(20) NOT NULL auto_increment,
  `username` varchar(255) NOT NULL default '',
  `useremail` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=6 ;

#
# Dumping data for table `sbwmd_mailing_list`
#


# --------------------------------------------------------

#
# Table structure for table `sbwmd_mails`
#

CREATE TABLE `sbwmd_mails` (
  `id` bigint(20) NOT NULL auto_increment,
  `mailid` bigint(20) NOT NULL default '0',
  `fromid` varchar(255) NOT NULL default '',
  `subject` varchar(255) NOT NULL default '',
  `mail` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=7 ;

#
# Dumping data for table `sbwmd_mails`
#

INSERT INTO `sbwmd_mails` VALUES (2, 2, 'you@yourdomain.com', 'Your software has been Approved', 'Hi <name>,\r\n\r\nYour software <softwarename> has been Approved for inclusion on the site.\r\n\r\n\r\nRegards,\r\nAdmin\r\n');
INSERT INTO `sbwmd_mails` VALUES (3, 3, 'you@yourdomain.com', 'Your software has not been approved', 'Hi <name>,\r\n\r\nYour software <softwarename> has been disapproved from inclusion on the site.\r\n\r\n\r\nRegards,\r\nAdmin\r\n');
INSERT INTO `sbwmd_mails` VALUES (5, 5, 'you@yourdomain.com', 'Your banner Stats', 'Hi <name>,\r\n\r\nStats for your banner on <date> are:\r\n\r\nTotal Credits:    <credits>\r\nBanner Displays:  <displays>\r\nCredits Left:     <balance>\r\n\r\nRegards,\r\nAdmin');
INSERT INTO `sbwmd_mails` VALUES (6, 6, 'you@yourdomain.com', 'Please Confirm signup', 'Hi,\r\n\r\nYour have initiated the reqistration process at our website by providing this email id.\r\n\r\nTo continue registration please click on the link <link>\r\n\r\nIf you did not request for membership or you donot want this continue then just ignore this email.\r\n\r\nThanks for being part of our website.\r\n\r\nRegards,\r\nAdmin.');
INSERT INTO `sbwmd_mails` VALUES (4, 4, 'you@yourdomain.com', 'Your password', 'Hi <name>,\r\n\r\nHere is your login information:\r\n\r\nUsername:        <username>\r\nPassword:        <password>\r\nEmail:           <email>\r\n\r\n\r\nThanks for being part of our website.\r\n\r\nRegards,\r\nAdmin');
INSERT INTO `sbwmd_mails` VALUES (1, 1, 'you@yourdomain.com', 'Welcome', 'Hi <name>,\r\n\r\n\r\nYour registration information is as follows:\r\n\r\nUsername:        <username>\r\nPassword:        <password>\r\nEmail:           <email>\r\n\r\n\r\nThanks for being part of our website.\r\n\r\nRegards,\r\nAdmin');

# --------------------------------------------------------

#
# Table structure for table `sbwmd_member_feedback`
#

CREATE TABLE `sbwmd_member_feedback` (
  `id` bigint(20) NOT NULL auto_increment,
  `fname` varchar(255) default NULL,
  `lname` varchar(255) default NULL,
  `email` varchar(255) default NULL,
  `url` varchar(255) default NULL,
  `title` varchar(255) default NULL,
  `comment` longtext,
  `uid` bigint(20) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=8 ;

#
# Dumping data for table `sbwmd_member_feedback`
#


# --------------------------------------------------------

#
# Table structure for table `sbwmd_members`
#

CREATE TABLE `sbwmd_members` (
  `id` bigint(20) NOT NULL auto_increment,
  `c_name` varchar(255) default NULL,
  `c_contact` varchar(255) default NULL,
  `stadd1` varchar(255) default NULL,
  `stadd2` varchar(255) default NULL,
  `city` varchar(255) default NULL,
  `state_us` bigint(20) default NULL,
  `state_non_us` varchar(255) default NULL,
  `zip` varchar(50) default NULL,
  `country` varchar(255) default NULL,
  `phone` varchar(50) default NULL,
  `fax` varchar(50) default NULL,
  `email` varchar(255) default NULL,
  `homepage` varchar(255) default NULL,
  `username` varchar(255) default NULL,
  `recieve_offer` varchar(10) default NULL,
  `pwd` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=18 ;

#
# Dumping data for table `sbwmd_members`
#

# --------------------------------------------------------

#
# Table structure for table `sbwmd_plans`
#

CREATE TABLE `sbwmd_plans` (
  `id` bigint(20) NOT NULL auto_increment,
  `credits` bigint(20) NOT NULL default '0',
  `price` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=8 ;

#
# Dumping data for table `sbwmd_plans`
#

INSERT INTO `sbwmd_plans` VALUES (3, 1000, 50);
INSERT INTO `sbwmd_plans` VALUES (7, 10000, 35);
INSERT INTO `sbwmd_plans` VALUES (6, 5000, 20);

# --------------------------------------------------------

#
# Table structure for table `sbwmd_platforms`
#

CREATE TABLE `sbwmd_platforms` (
  `id` bigint(20) NOT NULL auto_increment,
  `cid` bigint(20) default NULL,
  `plat_name` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=26 ;

#
# Dumping data for table `sbwmd_platforms`
#

INSERT INTO `sbwmd_platforms` VALUES (22, 35, 'NT');
INSERT INTO `sbwmd_platforms` VALUES (21, 35, '2000');
INSERT INTO `sbwmd_platforms` VALUES (20, 35, 'XP');
INSERT INTO `sbwmd_platforms` VALUES (19, 35, 'ME');
INSERT INTO `sbwmd_platforms` VALUES (18, 35, '98');
INSERT INTO `sbwmd_platforms` VALUES (17, 35, '95');
INSERT INTO `sbwmd_platforms` VALUES (25, 44, 'OS X');
INSERT INTO `sbwmd_platforms` VALUES (24, 44, 'OS 9');
INSERT INTO `sbwmd_platforms` VALUES (23, 35, '98, ME, XP');
INSERT INTO `sbwmd_platforms` VALUES (16, 35, 'All Windows');

# --------------------------------------------------------

#
# Table structure for table `sbwmd_ratings`
#

CREATE TABLE `sbwmd_ratings` (
  `id` bigint(20) NOT NULL auto_increment,
  `sid` bigint(20) default NULL,
  `rating` int(11) default NULL,
  `ip` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=23 ;

#
# Dumping data for table `sbwmd_ratings`
#


# --------------------------------------------------------

#
# Table structure for table `sbwmd_sideads`
#

CREATE TABLE `sbwmd_sideads` (
  `id` bigint(20) NOT NULL auto_increment,
  `url` varchar(255) default NULL,
  `linktext` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=8 ;

#
# Dumping data for table `sbwmd_sideads`
#


# --------------------------------------------------------

#
# Table structure for table `sbwmd_signups`
#

CREATE TABLE `sbwmd_signups` (
  `id` bigint(20) NOT NULL auto_increment,
  `rnum` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `onstamp` timestamp(14) NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=20 ;

#
# Dumping data for table `sbwmd_signups`
#


# --------------------------------------------------------

#
# Table structure for table `sbwmd_soft_desc`
#

CREATE TABLE `sbwmd_soft_desc` (
  `id` bigint(20) NOT NULL auto_increment,
  `sid` bigint(20) default NULL,
  `major_features` longtext,
  `prog_desc` longtext,
  `author_notes` longtext,
  `addnl_soft` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=25 ;

#
# Dumping data for table `sbwmd_soft_desc`
#


# --------------------------------------------------------

#
# Table structure for table `sbwmd_softwares`
#

CREATE TABLE `sbwmd_softwares` (
  `id` bigint(20) NOT NULL auto_increment,
  `uid` bigint(20) NOT NULL default '0',
  `s_name` varchar(255) default NULL,
  `cid` bigint(20) default NULL,
  `lid` bigint(20) default NULL,
  `platforms` varchar(255) default NULL,
  `cur_id` bigint(20) default NULL,
  `price` decimal(10,2) default NULL,
  `ss_url` varchar(255) default NULL,
  `home_url` varchar(255) default NULL,
  `soft_url` varchar(255) default NULL,
  `eval_period` varchar(255) default NULL,
  `version` varchar(255) default NULL,
  `digital_riverid` varchar(255) default NULL,
  `featured` varchar(10) default NULL,
  `page_views` bigint(20) default NULL,
  `hits_dev_site` bigint(20) default NULL,
  `downloads` bigint(20) default NULL,
  `featured_display` bigint(20) default NULL,
  `approved` varchar(10) default NULL,
  `tmpdate` timestamp(14) NOT NULL,
  `rel_date` timestamp(14) NOT NULL default '00000000000000',
  `date_approved` timestamp(14) NOT NULL default '00000000000000',
  `date_submitted` timestamp(14) NOT NULL default '00000000000000',
  `popularity` int(11) default NULL,
  `admin_desc` longtext,
  `size` bigint(20) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=37 ;

#
# Dumping data for table `sbwmd_softwares`
#

