# phpMyAdmin SQL Dump
# version 2.5.6
# http://www.phpmyadmin.net
#
# Host: localhost
# Generation Time: Oct 01, 2004 at 03:22 AM
# Server version: 4.0.20
# PHP Version: 4.3.8
# 
# Database : mysql`
# 
# --------------------------------------------------------

#
# Table structure for table `admin`
#

CREATE TABLE `admin` (
  `sess_id` varchar(250) NOT NULL default '',
  `started` bigint(20) NOT NULL default '0',
  `paypal_mail` text NOT NULL
) TYPE=MyISAM;

#
# Dumping data for table `admin`
#

INSERT INTO `admin` VALUES ('2cbe2a81794e27f5115e496c389690f0', 1096531377, '');
INSERT INTO `admin` VALUES ('274de4c09549d83690b55089318805f6', 1096482788, '');
INSERT INTO `admin` VALUES ('46fcd93654f05c8eedcad6988f8ea1c4', 1096527769, '');
INSERT INTO `admin` VALUES ('9d54ade58a93d1db4795492196fed688', 1096542406, '');
INSERT INTO `admin` VALUES ('1a25b96e71d0233eb9b144076ca6d265', 1096508893, '');
INSERT INTO `admin` VALUES ('c11f4f5af02d56342713d4772e182d98', 1096563933, '');
INSERT INTO `admin` VALUES ('2a34f04526e3959f783ce63fae8631a1', 1096551157, '');

# --------------------------------------------------------

#
# Table structure for table `answers`
#

CREATE TABLE `answers` (
  `a_id` int(11) NOT NULL auto_increment,
  `a_qid` int(11) NOT NULL default '0',
  `a_ans` text NOT NULL,
  PRIMARY KEY  (`a_id`)
) TYPE=MyISAM COMMENT='Profile Question Answers' AUTO_INCREMENT=21 ;


#
# Table structure for table `banners`
#

CREATE TABLE `banners` (
  `b_id` int(11) NOT NULL auto_increment,
  `b_desc` longtext NOT NULL,
  `b_img` text NOT NULL,
  `b_url` text NOT NULL,
  `b_typ` char(1) NOT NULL default 'H',
  `b_blk` char(1) NOT NULL default 'N',
  `b_dur` char(1) NOT NULL default 'D',
  `b_f_day` bigint(20) default NULL,
  `b_t_day` bigint(20) default NULL,
  `b_noi` int(11) default NULL,
  `b_ncl` int(11) default NULL,
  `b_see` int(11) NOT NULL default '0',
  `b_clks` int(11) NOT NULL default '0',
  `b_clkips` longtext NOT NULL,
  `b_dt` datetime NOT NULL default '0000-00-00 00:00:00',
  `b_exp` char(1) NOT NULL default 'N',
  PRIMARY KEY  (`b_id`)
) TYPE=MyISAM COMMENT='Banner Details' AUTO_INCREMENT=3 ;


#
# Table structure for table `blogs`
#

CREATE TABLE `blogs` (
  `blog_id` int(11) NOT NULL auto_increment,
  `blog_own` int(11) NOT NULL default '0',
  `blog_memf` varchar(150) NOT NULL default '',
  `blog_meml` varchar(150) NOT NULL default '',
  `blog_matt` longtext NOT NULL,
  `blog_img` varchar(150) NOT NULL default '',
  `blog_dt` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`blog_id`)
) TYPE=MyISAM COMMENT='Blog Details' AUTO_INCREMENT=22 ;

#
# Table structure for table `bmarks`
#

CREATE TABLE `bmarks` (
  `bmr_id` bigint(20) NOT NULL auto_increment,
  `mem_id` bigint(20) NOT NULL default '0',
  `sec_id` bigint(20) NOT NULL default '0',
  `type` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`bmr_id`)
) TYPE=MyISAM AUTO_INCREMENT=3 ;

#
# Table structure for table `board`
#

CREATE TABLE `board` (
  `top_id` bigint(20) NOT NULL auto_increment,
  `trb_id` bigint(20) NOT NULL default '0',
  `topic` varchar(250) NOT NULL default '',
  `post` text NOT NULL,
  `mem_id` bigint(20) NOT NULL default '0',
  `added` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`top_id`)
) TYPE=MyISAM AUTO_INCREMENT=5 ;

#
# Table structure for table `bydate`
#

CREATE TABLE `bydate` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `eventdate` date NOT NULL default '0000-00-00',
  `eventtime` time NOT NULL default '25:00:00',
  `shortevent` varchar(50) NOT NULL default '',
  `longevent` varchar(255) NOT NULL default '',
  `userid` varchar(25) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `eventdate` (`eventdate`),
  KEY `eventtime` (`eventtime`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Dumping data for table `bydate`
#


# --------------------------------------------------------

#
# Table structure for table `calendar_events`
#

CREATE TABLE `calendar_events` (
  `event_id` int(10) unsigned NOT NULL auto_increment,
  `event_mem` int(11) NOT NULL default '0',
  `event_day` int(2) NOT NULL default '0',
  `event_month` int(2) NOT NULL default '0',
  `event_year` int(4) NOT NULL default '0',
  `event_time` varchar(5) NOT NULL default '',
  `event_dur` varchar(5) NOT NULL default '0',
  `event_part` text NOT NULL,
  `event_priority` varchar(150) NOT NULL default '',
  `event_access` varchar(150) NOT NULL default '',
  `event_title` varchar(200) NOT NULL default '',
  `event_desc` text NOT NULL,
  `event_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `event_update` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`event_id`)
) TYPE=MyISAM AUTO_INCREMENT=13 ;


#
# Table structure for table `calusers`
#

CREATE TABLE `calusers` (
  `userid` varchar(25) NOT NULL default '',
  `password` varchar(25) NOT NULL default '',
  `rights` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`userid`),
  UNIQUE KEY `userid` (`userid`),
  KEY `userid_2` (`userid`)
) TYPE=MyISAM;


# --------------------------------------------------------

#
# Table structure for table `categories`
#

CREATE TABLE `categories` (
  `cat_id` bigint(20) NOT NULL default '0',
  `name` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`cat_id`)
) TYPE=MyISAM;

INSERT INTO categories (cat_id, name) VALUES (1000, ' Announcements'),
(2000, ' Deals & Steals'),
(7000, ' For Sale'),
(6000, ' Housing'),
(9000, ' Jobs'),
(4000, ' Local'),
(5000, ' People/Personals'),
(8000, ' Services');

#
# Table structure for table `chat_banned`
#

CREATE TABLE `chat_banned` (
  `ip` varchar(255) NOT NULL default '',
  `datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  KEY `ip` (`ip`),
  KEY `datetime` (`datetime`)
) TYPE=MyISAM;

#
# Dumping data for table `chat_banned`
#


# --------------------------------------------------------

#
# Table structure for table `chat_ip`
#

CREATE TABLE `chat_ip` (
  `name` varchar(255) NOT NULL default '',
  `ip` varchar(60) NOT NULL default '',
  `datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  KEY `ip` (`ip`),
  KEY `datetime` (`datetime`),
  KEY `name` (`name`)
) TYPE=MyISAM;

#
# Table structure for table `chat_messages`
#

CREATE TABLE `chat_messages` (
  `ID` int(11) NOT NULL auto_increment,
  `room` varchar(255) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `message` text NOT NULL,
  `datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`ID`),
  KEY `room` (`room`),
  KEY `datetime` (`datetime`)
) TYPE=MyISAM AUTO_INCREMENT=148 ;

#
# Dumping data for table `chat_messages`
#


# --------------------------------------------------------

#
# Table structure for table `chat_users`
#

CREATE TABLE `chat_users` (
  `ID` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `room` varchar(255) NOT NULL default '',
  `datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `moderator` tinyint(1) NOT NULL default '0',
  `hide_profile` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`ID`),
  KEY `name` (`name`),
  KEY `room` (`room`)
) TYPE=MyISAM AUTO_INCREMENT=88 ;

#
# Dumping data for table `chat_users`
#


# --------------------------------------------------------

#
# Table structure for table `company`
#

CREATE TABLE `company` (
  `companyid` char(10) NOT NULL default '',
  `companyname` char(50) NOT NULL default '',
  PRIMARY KEY  (`companyid`)
) TYPE=MyISAM;


#
# Table structure for table `complete`
#

CREATE TABLE `complete` (
  `cmp_id` int(11) NOT NULL default '0',
  `complete` varchar(250) NOT NULL default '',
  `detailes` text NOT NULL
) TYPE=MyISAM;

#
# Dumping data for table `complete`
#

INSERT INTO `complete` VALUES (0, 'Registration Complete!', 'Congratulations! Follow the instructions in the registration email.');
INSERT INTO `complete` VALUES (1, 'Forgotten Password', 'Your temp password is sent.');
INSERT INTO `complete` VALUES (2, 'Complete', 'Validation Complete!');
INSERT INTO `complete` VALUES (3, 'Invitation', 'Invitation is sent.');
INSERT INTO `complete` VALUES (4, 'Join A Group', 'Your request is sent to moderator.');
INSERT INTO `complete` VALUES (5, 'Editing Profile', 'Profile updated.');
INSERT INTO `complete` VALUES (6, 'Deleting Group', 'Group completely deleted.');
INSERT INTO `complete` VALUES (7, 'Deleting Listing', 'Listing completely deleted.');
INSERT INTO `complete` VALUES (8, 'Sending Feedback', 'Your feedback has been sent. Thank you.');
INSERT INTO `complete` VALUES (9, 'Registration Failed!', 'Sorry! The registration process failed. Please try again. Thanks!');
INSERT INTO `complete` VALUES (10, 'Profile Updation Process', 'Thanks! Your profile has been updated and the payment received.');
INSERT INTO `complete` VALUES (11, 'Profile Updation Status', 'Sorry! Your profile has been updated and the payment process cause some problems.');

# --------------------------------------------------------

#
# Table structure for table `department`
#

CREATE TABLE `department` (
  `departmentid` char(10) NOT NULL default '',
  `departmentname` char(50) NOT NULL default '',
  PRIMARY KEY  (`departmentid`)
) TYPE=MyISAM;


#
# Table structure for table `errors`
#

CREATE TABLE `errors` (
  `err_id` int(11) NOT NULL default '0',
  `error` varchar(250) NOT NULL default '',
  `detailes` text NOT NULL
) TYPE=MyISAM;

#
# Dumping data for table `errors`
#

INSERT INTO `errors` VALUES (0, 'Login Error', 'Please <a href=index.php?mode=login&act=form>Login</a> or <a href=index.php?mode=join>Join</a>');
INSERT INTO `errors` VALUES (1, 'Sign-Up Error', 'Email and Confirm Email fields are not equal!');
INSERT INTO `errors` VALUES (2, 'Sign-Up Error', 'Password and Confirm Password fields are not equal!');
INSERT INTO `errors` VALUES (3, 'Error', 'Please, fill in required fields.');
INSERT INTO `errors` VALUES (4, 'Sign-Up Error', 'This contact information is already used.');
INSERT INTO `errors` VALUES (5, 'Forgotten Password', 'Email not found in our database.');
INSERT INTO `errors` VALUES (6, 'Email Validation', 'Wrong validate key!');
INSERT INTO `errors` VALUES (7, 'Sign-Up Error', 'Password must be between 4 and 12 characters.');
INSERT INTO `errors` VALUES (8, 'Banned User', 'You are banned!');
INSERT INTO `errors` VALUES (9, 'Upload Photo Error', 'The type of uploaded file is not supported.');
INSERT INTO `errors` VALUES (10, 'Upload Photo Error', 'Uploaded image file size is over 500K');
INSERT INTO `errors` VALUES (11, 'Group Access Error', 'You are not a member of this group.');
INSERT INTO `errors` VALUES (12, 'Banned User', 'You are banned!');
INSERT INTO `errors` VALUES (13, 'Group Access Error', 'This is private group.');
INSERT INTO `errors` VALUES (14, 'Group Access Error', 'You have no rights to edit this group.');
INSERT INTO `errors` VALUES (15, 'Admin Access Error', 'Login Error.');
INSERT INTO `errors` VALUES (16, 'Email Validation', 'You didn\'t verify your email.');
INSERT INTO `errors` VALUES (17, 'Search Error', 'You have attempted to perform a search without specifying sufficient search parameters. In order to complete your search, you will need to enter more information in one or more of the boxes to the right. Please note that many fields require at least 3 characters.');
INSERT INTO `errors` VALUES (18, 'Invitation Error', 'You already invited this user.');
INSERT INTO `errors` VALUES (19, 'Event Publishing Error', 'Choose AM or PM for event start time.');
INSERT INTO `errors` VALUES (20, 'Group Join Error', 'You are already a member of this group!.');
INSERT INTO `errors` VALUES (21, 'Group Create Error', 'Fill in all fields!');
INSERT INTO `errors` VALUES (22, 'Group Create Error', 'This URL is already used by another group.');
INSERT INTO `errors` VALUES (23, 'Bookmark Error', 'You already bookmarked this item.');
INSERT INTO `errors` VALUES (24, 'Admin Error', 'Not valid session key! <a href=\'admin.php\'>Relogin</a>, please');
INSERT INTO `errors` VALUES (25, 'Sign-Up', 'You are already a member! No need to register again.');
INSERT INTO `errors` VALUES (26, 'Invitation Error', 'You can\'t invite your self!');
INSERT INTO `errors` VALUES (27, 'Group Create Error', 'Group name is already used!');
INSERT INTO `errors` VALUES (28, 'Listing Manage Error', 'You are not lister of this listing!');
INSERT INTO `errors` VALUES (29, 'Group Access', 'Sorry. This group is suspended!');
INSERT INTO `errors` VALUES (30, 'Invitation Error', 'This user is already your friend.');
INSERT INTO `errors` VALUES (31, 'Form Error', 'Please fill the form properly!');
INSERT INTO `errors` VALUES (32, 'Event Setup', 'Please check your E-mail and publish your event!');
INSERT INTO `errors` VALUES (33, 'Event Publish', 'This event published successfully!');
INSERT INTO `errors` VALUES (34, 'Payment Error', 'Sorry! Your payment process is not yet completed. Please contact the administrator</a>.');
INSERT INTO `errors` VALUES (35, 'Access Error', 'You need to be logged in to access this section. Please <a href=index.php?mode=login&act=form>Login</a> or <a href=index.php?mode=join>Join</a>');
INSERT INTO `errors` VALUES (36, 'Membership Error', 'You have to upgrade your membership to access this area. Thank You!');

# --------------------------------------------------------

#
# Table structure for table `event_cat`
#

CREATE TABLE `event_cat` (
  `event_id` int(11) NOT NULL auto_increment,
  `event_nam` varchar(150) NOT NULL default '',
  PRIMARY KEY  (`event_id`)
) TYPE=MyISAM COMMENT='Event Categories Details' AUTO_INCREMENT=16 ;


#
# Table structure for table `event_list`
#

CREATE TABLE `event_list` (
  `even_id` int(11) NOT NULL auto_increment,
  `even_own` int(11) NOT NULL default '0',
  `even_cat` int(11) NOT NULL default '0',
  `even_title` text NOT NULL,
  `even_desc` longtext NOT NULL,
  `even_stat` varchar(25) NOT NULL default '',
  `even_end` varchar(25) NOT NULL default '',
  `even_loc` varchar(250) NOT NULL default '',
  `even_loc1` text NOT NULL,
  `even_zip` varchar(50) NOT NULL default '',
  `even_phon` varchar(15) NOT NULL default '',
  `even_url` longtext NOT NULL,
  `even_img` varchar(250) NOT NULL default '',
  `even_dt` datetime NOT NULL default '0000-00-00 00:00:00',
  `even_hits` bigint(20) NOT NULL default '0',
  `even_active` char(1) NOT NULL default 'N',
  PRIMARY KEY  (`even_id`)
) TYPE=MyISAM COMMENT='Event Details' AUTO_INCREMENT=20 ;

#
# Table structure for table `events`
#

CREATE TABLE `events` (
  `evn_id` bigint(20) NOT NULL auto_increment,
  `trb_id` bigint(20) NOT NULL default '0',
  `mem_id` bigint(20) NOT NULL default '0',
  `title` varchar(250) NOT NULL default '',
  `description` text NOT NULL,
  `start_date` bigint(20) NOT NULL default '0',
  `start_time` bigint(20) NOT NULL default '0',
  `end_date` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`evn_id`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;

# --------------------------------------------------------

#
# Table structure for table `f_categories`
#

CREATE TABLE `f_categories` (
  `f_cat_id` bigint(20) NOT NULL auto_increment,
  `name` varchar(250) NOT NULL default '',
  `descr` longtext NOT NULL,
  `lpost` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`f_cat_id`)
) TYPE=MyISAM COMMENT='Forum Categories' AUTO_INCREMENT=17 ;


#
# Table structure for table `forums`
#

CREATE TABLE `forums` (
  `f_id` bigint(20) NOT NULL auto_increment,
  `f_c_id` bigint(20) NOT NULL default '0',
  `f_own` bigint(20) NOT NULL default '0',
  `f_memf` varchar(150) NOT NULL default '',
  `f_meml` varchar(150) NOT NULL default '',
  `f_matt` longtext NOT NULL,
  `f_dt` datetime NOT NULL default '0000-00-00 00:00:00',
  `f_st` char(1) NOT NULL default 'P',
  `f_rid` int(11) NOT NULL default '0',
  `f_last` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`f_id`)
) TYPE=MyISAM COMMENT='Forum Details' AUTO_INCREMENT=26 ;


#
# Table structure for table `industries`
#

CREATE TABLE `industries` (
  `ind_id` varchar(5) NOT NULL default '',
  `name` varchar(250) NOT NULL default ''
) TYPE=MyISAM;

#
# Dumping data for table `industries`
#

INSERT INTO `industries` VALUES ('_C1', 'High Tech');
INSERT INTO `industries` VALUES ('1', 'Defense &amp; Space');
INSERT INTO `industries` VALUES ('3', 'Computer Hardware');
INSERT INTO `industries` VALUES ('4', 'Computer Software');
INSERT INTO `industries` VALUES ('5', 'Computer Networking');
INSERT INTO `industries` VALUES ('6', 'Internet');
INSERT INTO `industries` VALUES ('7', 'Semiconductors');
INSERT INTO `industries` VALUES ('8', 'Telecommunications');
INSERT INTO `industries` VALUES ('96', 'Information Technology and Services');
INSERT INTO `industries` VALUES ('_C2', 'Legal');
INSERT INTO `industries` VALUES ('9', 'Law Practice');
INSERT INTO `industries` VALUES ('10', 'Legal Services');
INSERT INTO `industries` VALUES ('_C3', 'Management');
INSERT INTO `industries` VALUES ('11', 'Management Consulting');
INSERT INTO `industries` VALUES ('_C4', 'Medical and Health Care');
INSERT INTO `industries` VALUES ('12', 'Biotechnology');
INSERT INTO `industries` VALUES ('13', 'Medical Practice');
INSERT INTO `industries` VALUES ('14', 'Hospital &amp; Health Care');
INSERT INTO `industries` VALUES ('15', 'Pharmaceuticals');
INSERT INTO `industries` VALUES ('16', 'Veterinary');
INSERT INTO `industries` VALUES ('17', 'Medical Equipment');
INSERT INTO `industries` VALUES ('_C16', 'Marketing');
INSERT INTO `industries` VALUES ('80', 'Marketing and Advertising');
INSERT INTO `industries` VALUES ('97', 'Market Research');
INSERT INTO `industries` VALUES ('98', 'Public Relations and Communications');
INSERT INTO `industries` VALUES ('_C5', 'Consumer Goods');
INSERT INTO `industries` VALUES ('18', 'Cosmetics');
INSERT INTO `industries` VALUES ('19', 'Apparel');
INSERT INTO `industries` VALUES ('20', 'Sporting Goods');
INSERT INTO `industries` VALUES ('21', 'Tobacco');
INSERT INTO `industries` VALUES ('22', 'Supermarkets');
INSERT INTO `industries` VALUES ('23', 'Food Production');
INSERT INTO `industries` VALUES ('24', 'Consumer Electronics');
INSERT INTO `industries` VALUES ('25', 'Consumer Goods');
INSERT INTO `industries` VALUES ('26', 'Furniture');
INSERT INTO `industries` VALUES ('27', 'Retail');
INSERT INTO `industries` VALUES ('_C6', 'Recreation, Travel, Entertainment and Arts');
INSERT INTO `industries` VALUES ('28', 'Entertainment');
INSERT INTO `industries` VALUES ('29', 'Gambling &amp; Casinos');
INSERT INTO `industries` VALUES ('30', 'Leisure &amp; Travel');
INSERT INTO `industries` VALUES ('31', 'Hospitality');
INSERT INTO `industries` VALUES ('32', 'Restaurants');
INSERT INTO `industries` VALUES ('33', 'Sports');
INSERT INTO `industries` VALUES ('34', 'Food &amp; Beverages');
INSERT INTO `industries` VALUES ('40', 'Recreational Facilities and Services');
INSERT INTO `industries` VALUES ('35', 'Motion Pictures');
INSERT INTO `industries` VALUES ('36', 'Broadcast Media');
INSERT INTO `industries` VALUES ('37', 'Museums and Institutions');
INSERT INTO `industries` VALUES ('38', 'Fine Art');
INSERT INTO `industries` VALUES ('39', 'Performing Arts');
INSERT INTO `industries` VALUES ('99', 'Design');
INSERT INTO `industries` VALUES ('_C7', 'Finance');
INSERT INTO `industries` VALUES ('41', 'Banking');
INSERT INTO `industries` VALUES ('42', 'Insurance');
INSERT INTO `industries` VALUES ('43', 'Financial Services');
INSERT INTO `industries` VALUES ('44', 'Real Estate');
INSERT INTO `industries` VALUES ('45', 'Investment Banking/Venture');
INSERT INTO `industries` VALUES ('46', 'Investment Management');
INSERT INTO `industries` VALUES ('47', 'Accounting');
INSERT INTO `industries` VALUES ('_C17', 'Non-Profit');
INSERT INTO `industries` VALUES ('100', 'Non-Profit Management');
INSERT INTO `industries` VALUES ('101', 'Fund-Raising');
INSERT INTO `industries` VALUES ('102', 'Program Development');
INSERT INTO `industries` VALUES ('_C8', 'Construction');
INSERT INTO `industries` VALUES ('48', 'Construction');
INSERT INTO `industries` VALUES ('49', 'Building Materials');
INSERT INTO `industries` VALUES ('50', 'Architecture &amp; Planning');
INSERT INTO `industries` VALUES ('51', 'Civil Engineering');
INSERT INTO `industries` VALUES ('_C9', 'Manufacturing');
INSERT INTO `industries` VALUES ('52', 'Aviation');
INSERT INTO `industries` VALUES ('53', 'Automotive');
INSERT INTO `industries` VALUES ('54', 'Chemicals');
INSERT INTO `industries` VALUES ('55', 'Machinery');
INSERT INTO `industries` VALUES ('56', 'Mining &amp; Metals');
INSERT INTO `industries` VALUES ('57', 'Oil &amp; Energy');
INSERT INTO `industries` VALUES ('58', 'Shipbuilding');
INSERT INTO `industries` VALUES ('59', 'Utilities');
INSERT INTO `industries` VALUES ('60', 'Textiles');
INSERT INTO `industries` VALUES ('61', 'Paper &amp; Forest Products');
INSERT INTO `industries` VALUES ('62', 'Railroad Manufacture');
INSERT INTO `industries` VALUES ('_C10', 'Agriculture');
INSERT INTO `industries` VALUES ('63', 'Farming');
INSERT INTO `industries` VALUES ('64', 'Ranching');
INSERT INTO `industries` VALUES ('65', 'Dairy');
INSERT INTO `industries` VALUES ('66', 'Fishery');
INSERT INTO `industries` VALUES ('_C11', 'Education');
INSERT INTO `industries` VALUES ('67', 'Primary/Secondary');
INSERT INTO `industries` VALUES ('68', 'Higher Education');
INSERT INTO `industries` VALUES ('69', 'Education Management');
INSERT INTO `industries` VALUES ('_C12', 'Scientific');
INSERT INTO `industries` VALUES ('70', 'Scientific Research');
INSERT INTO `industries` VALUES ('_C13', 'Government');
INSERT INTO `industries` VALUES ('71', 'Military');
INSERT INTO `industries` VALUES ('72', 'Legislative Office');
INSERT INTO `industries` VALUES ('73', 'Judiciary');
INSERT INTO `industries` VALUES ('74', 'International Affairs');
INSERT INTO `industries` VALUES ('75', 'Government Administration');
INSERT INTO `industries` VALUES ('76', 'Executive Office');
INSERT INTO `industries` VALUES ('77', 'Law Enforcement');
INSERT INTO `industries` VALUES ('78', 'Public Safety');
INSERT INTO `industries` VALUES ('79', 'Public Policy');
INSERT INTO `industries` VALUES ('_C14', 'Service Industry');
INSERT INTO `industries` VALUES ('81', 'Newspapers');
INSERT INTO `industries` VALUES ('82', 'Publishing');
INSERT INTO `industries` VALUES ('103', 'Writing and Editing');
INSERT INTO `industries` VALUES ('83', 'Printing');
INSERT INTO `industries` VALUES ('84', 'Information Services');
INSERT INTO `industries` VALUES ('85', 'Libraries');
INSERT INTO `industries` VALUES ('86', 'Environmental Services');
INSERT INTO `industries` VALUES ('87', 'Package/Freight Delivery');
INSERT INTO `industries` VALUES ('88', 'Individual &amp; Family Services');
INSERT INTO `industries` VALUES ('89', 'Religious Institutions');
INSERT INTO `industries` VALUES ('90', 'Civic &amp; Social Organization');
INSERT INTO `industries` VALUES ('91', 'Consumer Services');
INSERT INTO `industries` VALUES ('_C15', 'Transportation');
INSERT INTO `industries` VALUES ('92', 'Transportation/Trucking/Railroad');
INSERT INTO `industries` VALUES ('93', 'Warehousing');
INSERT INTO `industries` VALUES ('94', 'Airlines/Aviation');
INSERT INTO `industries` VALUES ('95', 'Maritime');

# --------------------------------------------------------

#
# Table structure for table `invitations`
#

CREATE TABLE `invitations` (
  `inv_id` bigint(20) NOT NULL auto_increment,
  `mem_id` bigint(20) NOT NULL default '0',
  `email` varchar(250) NOT NULL default '',
  `date` bigint(20) NOT NULL default '0',
  `stat` char(1) NOT NULL default 'p',
  PRIMARY KEY  (`inv_id`)
) TYPE=MyISAM AUTO_INCREMENT=7 ;

#
# Table structure for table `ips`
#

CREATE TABLE `ips` (
  `ip_id` int(11) NOT NULL auto_increment,
  `ip` text NOT NULL,
  PRIMARY KEY  (`ip_id`)
) TYPE=MyISAM COMMENT='Banned IP''s' AUTO_INCREMENT=6 ;

#
# Dumping data for table `ips`
#


# --------------------------------------------------------

#
# Table structure for table `listings`
#

CREATE TABLE `listings` (
  `lst_id` bigint(20) NOT NULL auto_increment,
  `cat_id` bigint(20) NOT NULL default '0',
  `sub_cat_id` bigint(20) NOT NULL default '0',
  `mem_id` bigint(20) NOT NULL default '0',
  `trb_id` bigint(20) NOT NULL default '0',
  `added` bigint(20) NOT NULL default '0',
  `title` varchar(250) NOT NULL default '',
  `description` text NOT NULL,
  `descr_part` varchar(250) NOT NULL default '',
  `photo` varchar(250) NOT NULL default '',
  `privacy` char(1) NOT NULL default 'n',
  `anonim` char(1) NOT NULL default 'n',
  `zip` int(10) NOT NULL default '0',
  `show_deg` char(3) NOT NULL default 'any',
  `stat` char(1) NOT NULL default 'p',
  `live` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`lst_id`)
) TYPE=MyISAM AUTO_INCREMENT=11 ;


#
# Table structure for table `lst_feedback`
#

CREATE TABLE `lst_feedback` (
  `fdb_id` bigint(20) NOT NULL auto_increment,
  `mem_id` bigint(20) NOT NULL default '0',
  `lst_id` bigint(20) NOT NULL default '0',
  `folder` varchar(50) NOT NULL default '',
  `pro` varchar(100) NOT NULL default '',
  `date` bigint(20) NOT NULL default '0',
  `new` char(3) NOT NULL default 'new',
  PRIMARY KEY  (`fdb_id`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;


#
# Table structure for table `member_package`
#

CREATE TABLE `member_package` (
  `package_id` int(11) NOT NULL auto_increment,
  `package_nam` varchar(150) NOT NULL default '',
  `package_grp` char(1) NOT NULL default 'N',
  `package_list` char(1) NOT NULL default 'N',
  `package_eve` char(1) NOT NULL default 'N',
  `package_blog` char(1) NOT NULL default 'N',
  `package_chat` char(1) NOT NULL default 'N',
  `package_forum` char(1) NOT NULL default 'N',
  `package_nphot` int(11) NOT NULL default '0',
  `package_amt` float(10,2) NOT NULL default '0.00',
  PRIMARY KEY  (`package_id`)
) TYPE=MyISAM COMMENT='Package Details' AUTO_INCREMENT=5 ;

#
# Dumping data for table `member_package`
#

INSERT INTO `member_package` VALUES (1, 'Silver', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 5, '0.00');
INSERT INTO `member_package` VALUES (2, 'Gold', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 10, '100.00');
INSERT INTO `member_package` VALUES (3, 'Free', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 0, '0.00');

# --------------------------------------------------------

#
# Table structure for table `members`
#

CREATE TABLE `members` (
  `mem_id` bigint(20) NOT NULL auto_increment,
  `email` varchar(250) NOT NULL default '',
  `password` varchar(100) NOT NULL default '',
  `fname` varchar(100) NOT NULL default '',
  `lname` varchar(100) NOT NULL default '',
  `zip` varchar(10) NOT NULL default '',
  `country` varchar(100) NOT NULL default '',
  `showloc` char(1) NOT NULL default '1',
  `showgender` char(1) NOT NULL default '1',
  `showage` char(1) NOT NULL default '1',
  `showonline` char(1) NOT NULL default '1',
  `notifications` char(1) NOT NULL default '1',
  `gender` char(1) NOT NULL default 'n',
  `birthday` bigint(20) NOT NULL default '0',
  `photo` varchar(250) NOT NULL default 'no',
  `photo_thumb` varchar(250) NOT NULL default 'no',
  `photo_b_thumb` varchar(250) NOT NULL default 'no',
  `verified` char(1) NOT NULL default 'n',
  `online` char(3) NOT NULL default 'off',
  `ban` char(1) NOT NULL default 'n',
  `visit` bigint(20) NOT NULL default '0',
  `current` bigint(20) NOT NULL default '0',
  `views` text NOT NULL,
  `joined` bigint(20) NOT NULL default '0',
  `filter` varchar(100) NOT NULL default 'any||any',
  `ignore_list` text NOT NULL,
  `tribes` text NOT NULL,
  `ad_notes` text NOT NULL,
  `history` text NOT NULL,
  `mem_stat` char(1) NOT NULL default 'F',
  `mem_acc` int(11) NOT NULL default '0',
  `pay_stat` char(1) NOT NULL default 'N',
  PRIMARY KEY  (`mem_id`)
) TYPE=MyISAM AUTO_INCREMENT=52 ;


#
# Table structure for table `message`
#

CREATE TABLE `message` (
  `messageid` int(11) NOT NULL auto_increment,
  `isread` char(1) NOT NULL default '0',
  `lockstatus` char(1) NOT NULL default '0',
  `message` longtext,
  `sender` varchar(50) NOT NULL default '',
  `recipient` varchar(50) NOT NULL default '',
  `date` timestamp(14) NOT NULL,
  PRIMARY KEY  (`messageid`),
  KEY `sender` (`sender`),
  KEY `recipient` (`recipient`),
  KEY `readstatus` (`recipient`,`isread`)
) TYPE=MyISAM AUTO_INCREMENT=5 ;


#
# Table structure for table `messages`
#

CREATE TABLE `messages` (
  `mes_id` int(11) NOT NULL default '0',
  `subject` varchar(250) NOT NULL default '',
  `body` text NOT NULL
) TYPE=MyISAM;

#
# Dumping data for table `messages`
#

INSERT INTO `messages` VALUES (0, 'Validation Email', 'Follow the link to verify the account:\r\n|link|');
INSERT INTO `messages` VALUES (1, 'Temp Password', 'Your new temp login data is:\r\nlogin: |email|\r\npassword |password|');
INSERT INTO `messages` VALUES (2, 'Registration Complete', 'Congratulations. Here\'s your login info.\r\nlogin: |email|\r\npassword: |password|');
INSERT INTO `messages` VALUES (3, 'Login Data Change', 'Your new login info is:\r\nlogin: |email|\r\npassword: |password|');
INSERT INTO `messages` VALUES (4, 'New Testimonial', '|user| just wrote testimonial that needs your approval.');
INSERT INTO `messages` VALUES (5, '|subject|', '|message|');
INSERT INTO `messages` VALUES (6, '|subject|', '|message|');

# --------------------------------------------------------

#
# Table structure for table `messages_system`
#

CREATE TABLE `messages_system` (
  `mes_id` bigint(20) NOT NULL auto_increment,
  `mem_id` bigint(20) NOT NULL default '0',
  `frm_id` bigint(20) NOT NULL default '0',
  `subject` varchar(250) NOT NULL default '',
  `body` text NOT NULL,
  `type` varchar(10) NOT NULL default '',
  `new` char(3) NOT NULL default 'new',
  `folder` varchar(20) NOT NULL default '',
  `date` bigint(20) NOT NULL default '0',
  `special` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`mes_id`)
) TYPE=MyISAM AUTO_INCREMENT=29 ;

#
# Dumping data for table `messages_system`
#



# --------------------------------------------------------

#
# Table structure for table `network`
#

CREATE TABLE `network` (
  `mem_id` bigint(20) NOT NULL default '0',
  `frd_id` bigint(20) NOT NULL default '0'
) TYPE=MyISAM;


#
# Table structure for table `photo`
#

CREATE TABLE `photo` (
  `pho_id` bigint(20) NOT NULL auto_increment,
  `mem_id` bigint(20) NOT NULL default '0',
  `photo` text NOT NULL,
  `photo_thumb` text NOT NULL,
  `photo_b_thumb` text NOT NULL,
  `capture` text NOT NULL,
  `updated` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`pho_id`)
) TYPE=MyISAM AUTO_INCREMENT=52 ;

#
# Table structure for table `profiles`
#

CREATE TABLE `profiles` (
  `mem_id` bigint(20) NOT NULL default '0',
  `here_for` varchar(250) NOT NULL default '',
  `interests` text NOT NULL,
  `hometown` varchar(250) NOT NULL default '',
  `schools` varchar(250) NOT NULL default '',
  `languages` varchar(250) NOT NULL default '',
  `website` varchar(250) NOT NULL default '',
  `books` text NOT NULL,
  `music` text NOT NULL,
  `movies` text NOT NULL,
  `travel` text NOT NULL,
  `clubs` text NOT NULL,
  `about` text NOT NULL,
  `meet_people` varchar(250) NOT NULL default '',
  `position` varchar(250) NOT NULL default '',
  `company` varchar(250) NOT NULL default '',
  `occupation` varchar(250) NOT NULL default '',
  `industry` varchar(250) NOT NULL default '',
  `specialities` varchar(250) NOT NULL default '',
  `overview` text NOT NULL,
  `skills` varchar(250) NOT NULL default '',
  `p_positions` varchar(250) NOT NULL default '',
  `p_companies` varchar(250) NOT NULL default '',
  `assotiations` varchar(250) NOT NULL default '',
  `answers` longtext NOT NULL,
  `updated` bigint(20) NOT NULL default '0'
) TYPE=MyISAM;

#
# Table structure for table `questions`
#

CREATE TABLE `questions` (
  `q_id` int(11) NOT NULL auto_increment,
  `q_que` text NOT NULL,
  PRIMARY KEY  (`q_id`)
) TYPE=MyISAM COMMENT='Profile Questions' AUTO_INCREMENT=7 ;


#
# Table structure for table `recurring`
#

CREATE TABLE `recurring` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `weekday` tinyint(4) NOT NULL default '0',
  `eventtime` time NOT NULL default '25:00:00',
  `schedule` enum('weekly','monthly','yearly') NOT NULL default 'weekly',
  `period` tinyint(4) default NULL,
  `month` tinyint(4) default NULL,
  `shortevent` varchar(50) NOT NULL default '',
  `longevent` varchar(255) NOT NULL default '',
  `userid` varchar(25) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `weekday` (`weekday`),
  KEY `eventtime` (`eventtime`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Dumping data for table `recurring`
#


# --------------------------------------------------------

#
# Table structure for table `replies`
#

CREATE TABLE `replies` (
  `top_id` bigint(20) NOT NULL default '0',
  `rep_id` bigint(20) NOT NULL auto_increment,
  `subject` varchar(250) NOT NULL default '',
  `post` text NOT NULL,
  `mem_id` bigint(20) NOT NULL default '0',
  `added` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`rep_id`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;


#
# Table structure for table `stats`
#

CREATE TABLE `stats` (
  `day_sgnin` bigint(20) NOT NULL default '0',
  `week_sgnin` bigint(20) NOT NULL default '0',
  `month_sgnin` bigint(20) NOT NULL default '0',
  `day_vis` bigint(20) NOT NULL default '0',
  `week_vis` bigint(20) NOT NULL default '0',
  `month_vis` bigint(20) NOT NULL default '0',
  `day_sgns` bigint(20) NOT NULL default '0',
  `week_sgns` bigint(20) NOT NULL default '0',
  `month_sgns` bigint(20) NOT NULL default '0',
  `vis` text NOT NULL,
  `updated` text NOT NULL
) TYPE=MyISAM;


#
# Table structure for table `sub_categories`
#

CREATE TABLE `sub_categories` (
  `cat_id` bigint(20) NOT NULL default '0',
  `sub_cat_id` bigint(20) NOT NULL default '0',
  `name` varchar(250) NOT NULL default ''
) TYPE=MyISAM;

#
# Dumping data for table `sub_categories`
#

INSERT INTO `sub_categories` VALUES (1000, 1001, ' arts / gallery openings');
INSERT INTO `sub_categories` VALUES (1000, 1002, ' events & parties');
INSERT INTO `sub_categories` VALUES (1000, 1003, ' other');
INSERT INTO `sub_categories` VALUES (1000, 1004, ' soap box');
INSERT INTO `sub_categories` VALUES (1000, 1005, ' tribes');
INSERT INTO `sub_categories` VALUES (2000, 2001, ' hot deals');
INSERT INTO `sub_categories` VALUES (7000, 7001, ' swap');
INSERT INTO `sub_categories` VALUES (7000, 7002, ' bikes');
INSERT INTO `sub_categories` VALUES (7000, 7003, ' books');
INSERT INTO `sub_categories` VALUES (7000, 7004, ' cars / trucks');
INSERT INTO `sub_categories` VALUES (7000, 7005, ' clothes / acc');
INSERT INTO `sub_categories` VALUES (7000, 7006, ' collectibles');
INSERT INTO `sub_categories` VALUES (7000, 7007, ' computer');
INSERT INTO `sub_categories` VALUES (7000, 7008, ' electronics');
INSERT INTO `sub_categories` VALUES (7000, 7009, ' free');
INSERT INTO `sub_categories` VALUES (7000, 7010, ' furniture');
INSERT INTO `sub_categories` VALUES (7000, 7011, ' garage sales');
INSERT INTO `sub_categories` VALUES (7000, 7012, ' general');
INSERT INTO `sub_categories` VALUES (7000, 7013, ' household');
INSERT INTO `sub_categories` VALUES (7000, 7014, ' looking for');
INSERT INTO `sub_categories` VALUES (7000, 7015, ' motorcycles');
INSERT INTO `sub_categories` VALUES (7000, 7016, ' music instruments');
INSERT INTO `sub_categories` VALUES (7000, 7017, ' sporting');
INSERT INTO `sub_categories` VALUES (7000, 7018, ' tickets');
INSERT INTO `sub_categories` VALUES (6000, 6001, ' apartments');
INSERT INTO `sub_categories` VALUES (6000, 6002, ' housing wanted');
INSERT INTO `sub_categories` VALUES (6000, 6003, ' office / commercial');
INSERT INTO `sub_categories` VALUES (6000, 6004, ' parking / storage');
INSERT INTO `sub_categories` VALUES (6000, 6005, ' real estate for sale');
INSERT INTO `sub_categories` VALUES (6000, 6006, ' roommates');
INSERT INTO `sub_categories` VALUES (6000, 6007, ' temporary / sublet');
INSERT INTO `sub_categories` VALUES (6000, 6008, ' vacation rentals / swap');
INSERT INTO `sub_categories` VALUES (9000, 9001, ' accounting / finance');
INSERT INTO `sub_categories` VALUES (9000, 9002, ' admin / office');
INSERT INTO `sub_categories` VALUES (9000, 9003, ' art / media / design');
INSERT INTO `sub_categories` VALUES (9000, 9004, ' biotech / science');
INSERT INTO `sub_categories` VALUES (9000, 9005, ' business / mgmt');
INSERT INTO `sub_categories` VALUES (9000, 9006, ' customer service');
INSERT INTO `sub_categories` VALUES (9000, 9007, ' education / teaching');
INSERT INTO `sub_categories` VALUES (9000, 9008, ' engineering / arch');
INSERT INTO `sub_categories` VALUES (9000, 9009, ' et cetera jobs');
INSERT INTO `sub_categories` VALUES (9000, 9010, ' human resources');
INSERT INTO `sub_categories` VALUES (9000, 9011, ' internet engineering');
INSERT INTO `sub_categories` VALUES (9000, 9012, ' legal  /  government');
INSERT INTO `sub_categories` VALUES (9000, 9013, ' marketing / pr / adv');
INSERT INTO `sub_categories` VALUES (9000, 9014, ' medical / healthcare');
INSERT INTO `sub_categories` VALUES (9000, 9015, ' multilevel marketing');
INSERT INTO `sub_categories` VALUES (9000, 9016, ' nonprofit');
INSERT INTO `sub_categories` VALUES (9000, 9017, ' part time / hourly');
INSERT INTO `sub_categories` VALUES (9000, 9018, ' retail / food / hosp');
INSERT INTO `sub_categories` VALUES (9000, 9019, ' sales / biz dev');
INSERT INTO `sub_categories` VALUES (9000, 9020, ' seeking');
INSERT INTO `sub_categories` VALUES (9000, 9021, ' skilled trade / craft');
INSERT INTO `sub_categories` VALUES (9000, 9022, ' software / qa / dba');
INSERT INTO `sub_categories` VALUES (9000, 9023, ' systems / networks');
INSERT INTO `sub_categories` VALUES (9000, 9024, ' technical support');
INSERT INTO `sub_categories` VALUES (9000, 9025, ' tv / film / video');
INSERT INTO `sub_categories` VALUES (9000, 9026, ' web / info design');
INSERT INTO `sub_categories` VALUES (9000, 9027, ' work at home');
INSERT INTO `sub_categories` VALUES (9000, 9028, ' writing / editing');
INSERT INTO `sub_categories` VALUES (4000, 4001, ' activity partners');
INSERT INTO `sub_categories` VALUES (4000, 4002, ' childcare');
INSERT INTO `sub_categories` VALUES (4000, 4003, ' classes');
INSERT INTO `sub_categories` VALUES (4000, 4004, ' events');
INSERT INTO `sub_categories` VALUES (4000, 4005, ' general');
INSERT INTO `sub_categories` VALUES (4000, 4006, ' lost & found');
INSERT INTO `sub_categories` VALUES (4000, 4007, ' musicians');
INSERT INTO `sub_categories` VALUES (4000, 4008, ' pets');
INSERT INTO `sub_categories` VALUES (4000, 4009, ' rideshare');
INSERT INTO `sub_categories` VALUES (4000, 4010, ' volunteers');
INSERT INTO `sub_categories` VALUES (5000, 5001, ' alternatives');
INSERT INTO `sub_categories` VALUES (5000, 5002, ' casual encounters');
INSERT INTO `sub_categories` VALUES (5000, 5003, ' men seeking men');
INSERT INTO `sub_categories` VALUES (5000, 5004, ' men seeking women');
INSERT INTO `sub_categories` VALUES (5000, 5005, ' missed connections');
INSERT INTO `sub_categories` VALUES (5000, 5006, ' women seeking women');
INSERT INTO `sub_categories` VALUES (5000, 5007, ' women seeking men');
INSERT INTO `sub_categories` VALUES (8000, 8001, ' computer');
INSERT INTO `sub_categories` VALUES (8000, 8002, ' creative');
INSERT INTO `sub_categories` VALUES (8000, 8003, ' erotic');
INSERT INTO `sub_categories` VALUES (8000, 8004, ' event');
INSERT INTO `sub_categories` VALUES (8000, 8005, ' household');
INSERT INTO `sub_categories` VALUES (8000, 8006, ' garden / labor / haul');
INSERT INTO `sub_categories` VALUES (8000, 8007, ' lessons');
INSERT INTO `sub_categories` VALUES (8000, 8008, ' looking for');
INSERT INTO `sub_categories` VALUES (8000, 8009, ' skilled trade');
INSERT INTO `sub_categories` VALUES (8000, 8010, ' sm biz ads');
INSERT INTO `sub_categories` VALUES (8000, 8011, ' therapeutic');

# --------------------------------------------------------

#
# Table structure for table `t_categories`
#

CREATE TABLE `t_categories` (
  `t_cat_id` bigint(20) NOT NULL auto_increment,
  `name` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`t_cat_id`)
) TYPE=MyISAM AUTO_INCREMENT=24 ;

#
# Dumping data for table `t_categories`
#

INSERT INTO `t_categories` VALUES (1, 'Alumni/Schools\r\n');
INSERT INTO `t_categories` VALUES (2, 'Automotive\r\n');
INSERT INTO `t_categories` VALUES (3, 'Business\r\n');
INSERT INTO `t_categories` VALUES (4, 'Cities & Neighborhoods\r\n');
INSERT INTO `t_categories` VALUES (5, 'Companies / Co-workers\r\n');
INSERT INTO `t_categories` VALUES (6, 'Computers & Internet\r\n');
INSERT INTO `t_categories` VALUES (7, 'Cultures & Community\r\n');
INSERT INTO `t_categories` VALUES (8, 'Entertainment & Arts\r\n');
INSERT INTO `t_categories` VALUES (9, 'Family & Home\r\n');
INSERT INTO `t_categories` VALUES (10, 'Games\r\n');
INSERT INTO `t_categories` VALUES (11, 'Government & Politics\r\n');
INSERT INTO `t_categories` VALUES (12, 'Health & Wellness\r\n');
INSERT INTO `t_categories` VALUES (13, 'Hobbies & Crafts\r\n');
INSERT INTO `t_categories` VALUES (14, 'Money & Investing\r\n');
INSERT INTO `t_categories` VALUES (15, 'Music\r\n');
INSERT INTO `t_categories` VALUES (16, 'Other\r\n');
INSERT INTO `t_categories` VALUES (17, 'Places & Travel\r\n');
INSERT INTO `t_categories` VALUES (18, 'Recreation & Sports\r\n');
INSERT INTO `t_categories` VALUES (19, 'Religion & Beliefs\r\n');
INSERT INTO `t_categories` VALUES (20, 'Romance & Relationships\r\n');
INSERT INTO `t_categories` VALUES (21, 'Schools & Education\r\n');
INSERT INTO `t_categories` VALUES (22, 'Science & History');
INSERT INTO `t_categories` VALUES (23, 'General');

# --------------------------------------------------------

#
# Table structure for table `testimonials`
#

CREATE TABLE `testimonials` (
  `tst_id` bigint(20) NOT NULL auto_increment,
  `mem_id` bigint(20) NOT NULL default '0',
  `from_id` bigint(20) NOT NULL default '0',
  `testimonial` text NOT NULL,
  `stat` char(1) NOT NULL default 'w',
  `added` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`tst_id`)
) TYPE=MyISAM AUTO_INCREMENT=6 ;



#
# Table structure for table `tips`
#

CREATE TABLE `tips` (
  `tip_id` bigint(20) NOT NULL auto_increment,
  `tip_header` varchar(250) NOT NULL default '',
  `tip` text NOT NULL,
  PRIMARY KEY  (`tip_id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Dumping data for table `tips`
#


# --------------------------------------------------------

#
# Table structure for table `tribe_photo`
#

CREATE TABLE `tribe_photo` (
  `trb_id` bigint(20) NOT NULL default '0',
  `photo` text NOT NULL,
  `photo_thumb` text NOT NULL,
  `photo_b_thumb` text NOT NULL,
  `capture` text NOT NULL,
  `updated` bigint(20) NOT NULL default '0'
) TYPE=MyISAM;


#
# Table structure for table `tribes`
#

CREATE TABLE `tribes` (
  `trb_id` bigint(20) NOT NULL auto_increment,
  `mem_id` bigint(20) NOT NULL default '0',
  `name` varchar(250) NOT NULL default '',
  `t_cat_id` bigint(20) NOT NULL default '0',
  `description` text NOT NULL,
  `type` varchar(10) NOT NULL default 'pub',
  `url` varchar(50) NOT NULL default '',
  `zip` varchar(10) NOT NULL default '',
  `country` varchar(250) NOT NULL default '',
  `photo` varchar(250) NOT NULL default '',
  `photo_thumb` varchar(250) NOT NULL default '',
  `photo_b_thumb` varchar(250) NOT NULL default '',
  `added` bigint(20) NOT NULL default '0',
  `members` text NOT NULL,
  `mem_num` bigint(20) NOT NULL default '1',
  `stat` char(1) NOT NULL default 'a',
  PRIMARY KEY  (`trb_id`)
) TYPE=MyISAM AUTO_INCREMENT=6 ;


#
# Table structure for table `user`
#

CREATE TABLE `user` (
  `userid` char(50) NOT NULL default '',
  `password` char(12) NOT NULL default '',
  `lastlogin` timestamp(14) NOT NULL,
  `newmessage` int(4) unsigned NOT NULL default '0',
  `companyid` char(10) default NULL,
  `departmentid` char(10) default NULL,
  `status` char(50) default NULL,
  PRIMARY KEY  (`userid`),
  KEY `loginuser` (`userid`,`lastlogin`)
) TYPE=MyISAM;


#
# Table structure for table `usergroup`
#

CREATE TABLE `usergroup` (
  `userid` char(50) NOT NULL default '',
  `usergroup` char(50) NOT NULL default '',
  `member` char(50) NOT NULL default '',
  PRIMARY KEY  (`userid`,`usergroup`,`member`)
) TYPE=MyISAM;


#
# Table structure for table `validate`
#

CREATE TABLE `validate` (
  `email` varchar(250) NOT NULL default '',
  `password` varchar(250) NOT NULL default '',
  `val_key` varchar(200) NOT NULL default ''
) TYPE=MyISAM;



#
# Table structure for table `zipData`
#

DROP TABLE IF EXISTS `zipData`;
CREATE TABLE `zipData` (
  `country` bigint(20) NOT NULL default '0',
  `zipcode` varchar(5) NOT NULL default '',
  `lon` varchar(8) NOT NULL default '',
  `lat` varchar(8) NOT NULL default '',
  `city` varchar(250) NOT NULL default '',
  `state` char(3) NOT NULL default ''
) TYPE=MyISAM;
