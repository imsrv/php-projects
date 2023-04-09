-- phpMyAdmin SQL Dump
-- version 2.6.0-pl2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Oct 24, 2004 at 10:28 PM
-- Server version: 4.0.18
-- PHP Version: 4.3.6
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `site_projects`
-- 

CREATE TABLE `site_projects` (
  `project_id` int(11) NOT NULL auto_increment,
  `project_name` varchar(200) NOT NULL default '',
  `project_user` int(11) NOT NULL default '0',
  `project_description` text NOT NULL,
  PRIMARY KEY  (`project_id`)
) TYPE=MyISAM AUTO_INCREMENT=8 ;

-- 
-- Dumping data for table `site_projects`
-- 

INSERT INTO `site_projects` VALUES (1, '122 Maple', 4, 'Site 22 located at 122 Maple. Lot size is 220 x 130');
INSERT INTO `site_projects` VALUES (7, '144 Maple', 2, 'Site 44 in the Glen View Subdivision. Site is flat, with some trees.');

-- --------------------------------------------------------

-- 
-- Table structure for table `site_task_cats`
-- 

CREATE TABLE `site_task_cats` (
  `cat_id` int(11) NOT NULL auto_increment,
  `cat_name` varchar(200) NOT NULL default '',
  PRIMARY KEY  (`cat_id`)
) TYPE=MyISAM AUTO_INCREMENT=7 ;

-- 
-- Dumping data for table `site_task_cats`
-- 

INSERT INTO `site_task_cats` VALUES (1, 'Paperwork');
INSERT INTO `site_task_cats` VALUES (2, 'Landscaping');
INSERT INTO `site_task_cats` VALUES (3, 'Framing');
INSERT INTO `site_task_cats` VALUES (4, 'Cement');
INSERT INTO `site_task_cats` VALUES (5, 'Site Prep');
INSERT INTO `site_task_cats` VALUES (6, 'Permits');

-- --------------------------------------------------------

-- 
-- Table structure for table `site_task_comments`
-- 

CREATE TABLE `site_task_comments` (
  `comment_id` int(11) NOT NULL auto_increment,
  `comment_task` int(11) NOT NULL default '0',
  `comment_title` varchar(200) NOT NULL default '',
  `comment_date` int(11) NOT NULL default '0',
  `comment_user` int(11) NOT NULL default '0',
  `comment_body` text NOT NULL,
  `new_admin` int(1) NOT NULL default '1',
  `new_user` int(1) NOT NULL default '1',
  PRIMARY KEY  (`comment_id`)
) TYPE=MyISAM AUTO_INCREMENT=14 ;

-- 
-- Dumping data for table `site_task_comments`
-- 

INSERT INTO `site_task_comments` VALUES (8, 14, 'sdfg sd', 1097678002, 3, 'fgs dgfsd fgds', 0, 1);
INSERT INTO `site_task_comments` VALUES (6, 14, 'dsgsd', 1097675217, 3, 'fgsdfgsfg', 0, 1);
INSERT INTO `site_task_comments` VALUES (7, 22, 'sdg sdgf', 1097675297, 3, ' fs dfgsfd gdsg ', 0, 1);
INSERT INTO `site_task_comments` VALUES (5, 14, 'sdgsd', 1097675195, 3, 'gsdfgsdgfsf', 0, 1);
INSERT INTO `site_task_comments` VALUES (9, 20, 'asfasfd', 1097678573, 2, 'asf asdfadsf', 0, 1);
INSERT INTO `site_task_comments` VALUES (10, 20, 'asfasfd', 1097678750, 2, 'asf asdfadsf', 0, 0);
INSERT INTO `site_task_comments` VALUES (11, 29, 'Where on the site?', 1097940359, 4, 'Where on the site will the home be placed? Can we schedule a meeting on site to deterimine this?', 0, 0);
INSERT INTO `site_task_comments` VALUES (12, 29, 'Site location', 1097940430, 3, 'Mary, we can meet anytime to do this. I''ll give you a call when we get to that point.', 0, 1);
INSERT INTO `site_task_comments` VALUES (13, 28, 'Deed', 1097940523, 3, 'Mary, please bring the deed by the permit office for final approval.', 0, 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `site_task_status`
-- 

CREATE TABLE `site_task_status` (
  `status_id` int(11) NOT NULL auto_increment,
  `status_name` varchar(200) NOT NULL default '',
  PRIMARY KEY  (`status_id`)
) TYPE=MyISAM AUTO_INCREMENT=6 ;

-- 
-- Dumping data for table `site_task_status`
-- 

INSERT INTO `site_task_status` VALUES (1, 'Planning');
INSERT INTO `site_task_status` VALUES (2, 'In Progress');
INSERT INTO `site_task_status` VALUES (3, 'Waiting for another task');
INSERT INTO `site_task_status` VALUES (4, 'Almost Complete');
INSERT INTO `site_task_status` VALUES (5, 'Complete');

-- --------------------------------------------------------

-- 
-- Table structure for table `site_tasks`
-- 

CREATE TABLE `site_tasks` (
  `task_id` int(11) NOT NULL auto_increment,
  `task_project` int(11) NOT NULL default '0',
  `task_name` varchar(200) NOT NULL default '',
  `task_description` text NOT NULL,
  `task_date` int(11) NOT NULL default '0',
  `date_ecompleted` int(11) NOT NULL default '0',
  `date_ecompleted_day` int(2) NOT NULL default '0',
  `date_ecompleted_month` int(2) NOT NULL default '0',
  `date_ecompleted_year` int(4) NOT NULL default '0',
  `date_completed` int(11) NOT NULL default '0',
  `date_completed_day` int(2) NOT NULL default '0',
  `date_completed_month` int(2) NOT NULL default '0',
  `date_completed_year` int(4) NOT NULL default '0',
  `task_cat` int(11) NOT NULL default '0',
  `task_status` int(11) NOT NULL default '0',
  PRIMARY KEY  (`task_id`)
) TYPE=MyISAM AUTO_INCREMENT=31 ;

-- 
-- Dumping data for table `site_tasks`
-- 

INSERT INTO `site_tasks` VALUES (7, 0, 'asfdasdfasdf sdf', '', 1097614800, -1, 0, 0, 0, -1, 0, 0, 0, 1, 1);
INSERT INTO `site_tasks` VALUES (6, 0, 'asfdasdf', '', 1097614800, -1, 0, 0, 0, -1, 0, 0, 0, 1, 1);
INSERT INTO `site_tasks` VALUES (4, 2, 'Test Task', 'bla bla lba', 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1);
INSERT INTO `site_tasks` VALUES (5, 2, 'last task', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0);
INSERT INTO `site_tasks` VALUES (26, 7, 'Survey', '', 1097812800, 1098936000, 28, 10, 2004, -1, 0, 0, 0, 1, 1);
INSERT INTO `site_tasks` VALUES (28, 1, 'Building Permit', 'Permits have been submitted. Waiting for approval.', 1097899200, 1100840400, 19, 11, 2004, -1, 0, 0, 0, 6, 2);
INSERT INTO `site_tasks` VALUES (29, 1, 'Site Excavation', 'Preparing the site for a foundation.', 1097899200, 1101099600, 0, 0, 0, -1, 0, 0, 0, 5, 3);
INSERT INTO `site_tasks` VALUES (30, 1, 'Developer Approval', 'Developer needs to approve the site plan.', 1098331200, 1101704400, 29, 11, 2004, -1, 0, 0, 0, 1, 2);

-- --------------------------------------------------------

-- 
-- Table structure for table `site_users`
-- 

CREATE TABLE `site_users` (
  `user_id` int(11) NOT NULL auto_increment,
  `user_name` varchar(100) NOT NULL default '',
  `user_login` varchar(100) NOT NULL default '',
  `user_password` varchar(100) NOT NULL default '',
  `user_level` int(1) NOT NULL default '0',
  PRIMARY KEY  (`user_id`)
) TYPE=MyISAM AUTO_INCREMENT=5 ;

-- 
-- Dumping data for table `site_users`
-- 

INSERT INTO `site_users` VALUES (3, 'Admin', 'Admin', 'test', 0);
INSERT INTO `site_users` VALUES (2, 'Jon Doe', 'Jon', 'jon', 1);
INSERT INTO `site_users` VALUES (4, 'Mary Jane', 'Mary', 'mary', 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `site_vars`
-- 

CREATE TABLE `site_vars` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(200) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=17 ;

-- 
-- Dumping data for table `site_vars`
-- 

INSERT INTO `site_vars` VALUES (12, 'home', '1');
INSERT INTO `site_vars` VALUES (13, 'title', '15');
INSERT INTO `site_vars` VALUES (14, 'task_user', '1');
INSERT INTO `site_vars` VALUES (15, 'ipp', '5');
INSERT INTO `site_vars` VALUES (16, 'ppp', '4');
