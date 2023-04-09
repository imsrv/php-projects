# Php-Jobsite 1.26 MySQL-Dump
#
# Host: localhost
#Php-Jobsite 1.26 - php-jobsite@bitmixsoft.com
#Php-Jobsite 1.26

#
# Table structure for table `delphpjob_companies`
#

CREATE TABLE delphpjob_companies (
  compid int(5) NOT NULL default '0',
  email varchar(255) NOT NULL default '',
  password varchar(20) NOT NULL default '',
  company varchar(255) NOT NULL default '',
  address varchar(255) NOT NULL default '',
  city varchar(255) NOT NULL default '',
  postalcode varchar(20) NOT NULL default '',
  province varchar(255) NOT NULL default '',
  locationid int(3) NOT NULL default '0',
  phone varchar(20) NOT NULL default '',
  fax varchar(20) NOT NULL default '',
  logo varchar(10) NOT NULL default '',
  description blob NOT NULL,
  url varchar(255) NOT NULL default '',
  hide_address char(3) NOT NULL default '',
  hide_location char(3) NOT NULL default '',
  hide_phone char(3) NOT NULL default '',
  hide_fax char(3) NOT NULL default '',
  hide_email char(3) NOT NULL default '',
  discount float(3,2) NOT NULL default '0.00',
  signupdate date NOT NULL default '0000-00-00',
  lastlogin datetime NOT NULL default '0000-00-00 00:00:00',
  lastip varchar(50) NOT NULL default '',
  featured tinyint(1) NOT NULL default '0',
  expire date NOT NULL default '0000-00-00',
  KEY compid (compid)
);

#
# Table structure for table `delphpjob_invoices`
#

CREATE TABLE delphpjob_invoices (
  opid int(10) NOT NULL default '0',
  op_type int(1) NOT NULL default '0',
  compid int(5) NOT NULL default '0',
  pricing_type mediumint(2) NOT NULL default '0',
  jobs int(3) NOT NULL default '0',
  featuredjobs int(3) NOT NULL default '0',
  contacts int(3) NOT NULL default '0',
  1job float(10,2) NOT NULL default '0.00',
  1featuredjob float(10,2) NOT NULL default '0.00',
  1contact float(10,2) NOT NULL default '0.00',
  date_added date NOT NULL default '0000-00-00',
  info varchar(255) NOT NULL default '',
  currency char(5) NOT NULL default '',
  listprice float(10,2) NOT NULL default '0.00',
  discount float(3,2) NOT NULL default '0.00',
  vat float(3,2) NOT NULL default '0.00',
  totalprice float(10,2) NOT NULL default '0.00',
  paid char(1) NOT NULL default '',
  payment_mode mediumint(2) NOT NULL default '0',
  payment_date date NOT NULL default '0000-00-00',
  description varchar(255) NOT NULL default '',
  updated char(1) NOT NULL default 'N',
  validated char(1) NOT NULL default 'N',
  KEY opid (opid)
);

#
# Table structure for table `delphpjob_jobs`
#

CREATE TABLE delphpjob_jobs (
  jobid int(5) NOT NULL default '0',
  compid int(5) NOT NULL default '0',
  jobtitle varchar(100) NOT NULL default '',
  description blob NOT NULL,
  jobcategoryid int(2) NOT NULL default '0',
  locationid int(3) NOT NULL default '0',
  degreeid int(2) NOT NULL default '0',
  jobtypeids varchar(25) NOT NULL default '0',
  salary varchar(20) NOT NULL default '0',
  city varchar(100) NOT NULL default '',
  province varchar(100) NOT NULL default '',
  skills varchar(255) NOT NULL default '',
  featuredjob char(1) NOT NULL default '',
  jobdate date NOT NULL default '0000-00-00',
  postlanguage char(2) NOT NULL default '',
  languageids varchar(50) NOT NULL default '',
  experience int(2) NOT NULL default '0',
  hide_compname char(3) NOT NULL default '',
  contact_name varchar(100) NOT NULL default '',
  hide_contactname char(3) NOT NULL default '',
  contact_email varchar(100) NOT NULL default '',
  hide_contactemail char(3) NOT NULL default '',
  contact_phone varchar(32) NOT NULL default '',
  hide_contactphone char(3) NOT NULL default '',
  contact_fax varchar(32) NOT NULL default '',
  hide_contactfax char(3) NOT NULL default '',
  job_link varchar(255) NOT NULL default '',
  jobexpire date NOT NULL default '0000-00-00',
  KEY jobid (jobid)
);

#
# Table structure for table `delphpjob_membership`
#

CREATE TABLE delphpjob_membership (
  compid int(5) NOT NULL default '0',
  pricing_id mediumint(3) NOT NULL default '0'
);

#
# Table structure for table `delphpjob_persons`
#

CREATE TABLE delphpjob_persons (
  persid int(5) NOT NULL auto_increment,
  email varchar(255) NOT NULL default '',
  password varchar(20) NOT NULL default '',
  name varchar(255) NOT NULL default '',
  address varchar(255) NOT NULL default '',
  city varchar(255) NOT NULL default '',
  postalcode varchar(20) NOT NULL default '',
  province varchar(255) NOT NULL default '',
  locationid int(3) NOT NULL default '0',
  phone varchar(20) NOT NULL default '',
  fax varchar(20) NOT NULL default '',
  gender char(1) NOT NULL default '',
  birthyear varchar(4) NOT NULL default '0000',
  url varchar(255) NOT NULL default '',
  hide_name char(3) NOT NULL default '',
  hide_address char(3) NOT NULL default '',
  hide_location char(3) NOT NULL default '',
  hide_phone char(3) NOT NULL default '',
  hide_email char(3) NOT NULL default '',
  signupdate date NOT NULL default '0000-00-00',
  lastlogin datetime NOT NULL default '0000-00-00 00:00:00',
  lastip varchar(50) NOT NULL default '',
  PRIMARY KEY  (persid)
);

#
# Table structure for table `delphpjob_resumes`
#

CREATE TABLE delphpjob_resumes (
  resumeid int(5) NOT NULL auto_increment,
  persid int(5) NOT NULL default '0',
  summary varchar(100) NOT NULL default '',
  resume blob NOT NULL,
  education blob NOT NULL,
  workexperience blob NOT NULL,
  degreeid int(2) NOT NULL default '1',
  confidential char(1) NOT NULL default '',
  jobtypeids varchar(15) NOT NULL default '',
  locationids blob NOT NULL,
  jobcategoryids blob NOT NULL,
  salary varchar(20) NOT NULL default '0',
  skills blob NOT NULL,
  jobmail int(1) NOT NULL default '0',
  lastmaildate date NOT NULL default '0000-00-00',
  resumedate date NOT NULL default '0000-00-00',
  languageids varchar(50) NOT NULL default '',
  postlanguage char(1) NOT NULL default '',
  experience int(2) NOT NULL default '0',
  resume_city varchar(60) NOT NULL default '',
  resume_province varchar(60) NOT NULL default '',
  resumeexpire date NOT NULL default '0000-00-00',
  resume_cv varchar(100) NOT NULL default '',
  PRIMARY KEY  (resumeid)
);

#
# Table structure for table `phpjob_cctransactions`
#

CREATE TABLE phpjob_cctransactions (
  transid varchar(32) NOT NULL default '0',
  opid int(5) NOT NULL default '0',
  cc_name varchar(255) NOT NULL default '',
  cc_type varchar(255) NOT NULL default '',
  cc_num varchar(255) NOT NULL default '',
  cc_cvc varchar(255) NOT NULL default '',
  cc_exp varchar(255) NOT NULL default '',
  cc_street varchar(255) NOT NULL default '',
  cc_city varchar(255) NOT NULL default '',
  cc_state varchar(255) NOT NULL default '',
  cc_zip varchar(255) NOT NULL default '',
  cc_country varchar(255) NOT NULL default '',
  cc_phone varchar(255) NOT NULL default '',
  cc_email varchar(255) NOT NULL default '',
  PRIMARY KEY  (transid),
  KEY opid (opid)
);

#
# Table structure for table `phpjob_companies`
#

CREATE TABLE phpjob_companies (
  compid int(5) NOT NULL auto_increment,
  email varchar(255) NOT NULL default '',
  password varchar(20) NOT NULL default '',
  company varchar(255) NOT NULL default '',
  address varchar(255) NOT NULL default '',
  city varchar(255) NOT NULL default '',
  postalcode varchar(20) NOT NULL default '',
  province varchar(255) NOT NULL default '',
  locationid int(3) NOT NULL default '0',
  phone varchar(20) NOT NULL default '',
  fax varchar(20) NOT NULL default '',
  logo varchar(10) NOT NULL default '',
  description blob NOT NULL,
  url varchar(255) NOT NULL default '',
  hide_address char(3) NOT NULL default '',
  hide_location char(3) NOT NULL default '',
  hide_phone char(3) NOT NULL default '',
  hide_fax char(3) NOT NULL default '',
  hide_email char(3) NOT NULL default '',
  discount float(3,2) NOT NULL default '0.00',
  signupdate date NOT NULL default '0000-00-00',
  lastlogin datetime NOT NULL default '0000-00-00 00:00:00',
  lastip varchar(50) NOT NULL default '',
  featured tinyint(1) NOT NULL default '0',
  expire date NOT NULL default '0000-00-00',
  PRIMARY KEY  (compid)
);

#
# Table structure for table `phpjob_companycredits`
#

CREATE TABLE phpjob_companycredits (
  compid int(5) NOT NULL default '0',
  jobs int(3) NOT NULL default '0',
  featuredjobs int(3) NOT NULL default '0',
  contacts int(4) NOT NULL default '0',
  PRIMARY KEY  (compid)
);

#
# Table structure for table `phpjob_cronjobs`
#

CREATE TABLE phpjob_cronjobs (
  cron_type enum('jobmail','resumemail','expire') NOT NULL default 'jobmail',
  cron_date datetime NOT NULL default '0000-00-00 00:00:00',
  cron_start timestamp(14) NOT NULL,
  cron_status enum('done','running') NOT NULL default 'done',
  cron_priority tinyint(1) NOT NULL default '0'
);

#
# Dumping data for table `phpjob_cronjobs`
#

INSERT INTO phpjob_cronjobs VALUES ('expire', DATE_ADD(NOW(), INTERVAL 10 HOUR), NOW(), 'done', 1);
INSERT INTO phpjob_cronjobs VALUES ('jobmail', DATE_ADD(NOW(), INTERVAL 10 HOUR), NOW(), 'done', 2);
INSERT INTO phpjob_cronjobs VALUES ('resumemail', DATE_ADD(NOW(), INTERVAL 10 HOUR), NOW(), 'done', 3);
    
#
# Table structure for table `phpjob_help_en`
#

DROP TABLE IF EXISTS phpjob_help_en;
CREATE TABLE phpjob_help_en (
  help_id int(11) NOT NULL auto_increment,
  help_catid int(3) NOT NULL default '0',
  help_subcatid int(5) NOT NULL default '0',
  help_title varchar(255) NOT NULL default '',
  help_text text NOT NULL,
  PRIMARY KEY  (help_id)
);

#
# Dumping data for table `phpjob_help_en`
#

INSERT INTO phpjob_help_en VALUES (15, 3, 7, 'Q: I lost my password, what should  I do?', 'You can get your password using the <a href="forgot_passwords.php?jobseeker=true" target="_blank">"Forgot password form"</a>. You only need the email address used for registration to the system.');
INSERT INTO phpjob_help_en VALUES (14, 3, 7, 'Q: How many jobs can I view?', 'There is no limit for searching and viewing jobs.');
INSERT INTO phpjob_help_en VALUES (8, 3, 7, 'Q: How can I register as a Jobseeker?', 'A: Jobseeker registration is free. You don\'t have to pay anything for that.\r\nClick <a href="personal.php?action=new" target="_blank">Here</a>\r\nClick <a href="jobseeker.php" target="_blank">Here</a> to post your resume.');
INSERT INTO phpjob_help_en VALUES (9, 3, 9, 'Q: Employer registartion is free?', 'A: No the employer registration is not free.\r\n<a href="http://computer5.server.intranet/work/job1_20/company.php?action=new" target="_blank">Employer Registration Link</a> some real things "Help System" now.');
INSERT INTO phpjob_help_en VALUES (12, 3, 7, 'Q: Do I need to register as a jobseeker for searching jobs?', 'No. You don\'t have to register as a jobseeker to be able to search for jobs.\r\nBut you will need to register and post your resume to be able to apply online for a job.');
INSERT INTO phpjob_help_en VALUES (16, 4, 10, 'Search companies', 'In this Section you can search for all the registered employers.\r\nSearch criteria are:\r\n    <br> - employer email address\r\n    <br> - employer name\r\n    <br>- employer location (selecting "All Locations" will list all the registered employers from the system)\r\nClick <a href="admin_search.php?company=yes" target="_blank">here</a> to go there.');
INSERT INTO phpjob_help_en VALUES (10, 4, 10, 'Search jobs', 'In this Section you can search for all the posted jobs in the system by employers.\r\nSearch criteria are:\r\n    <br> - Job Title\r\n    <br> - Employer  name\r\n    <br>- Job Category (selecting "All Categories" will list all the rposted jobs from the system)\r\nClick <a href="admin_search.php?jobs=yes" target="_blank">here</a> to go there.');
INSERT INTO phpjob_help_en VALUES (13, 6, 12, 'Jobseeker Login', 'Enter your  email address and password to login to your free account.\r\nThe email address and password are the same with those used for registration.\r\nIf you are not registered use the <a href="personal.php?action=new" target="_blank">Registration</a> link to register to our system.');
# --------------------------------------------------------

#
# Table structure for table `phpjob_help_ge`
#

CREATE TABLE phpjob_help_ge (
  help_id int(11) NOT NULL auto_increment,
  help_catid int(3) NOT NULL default '0',
  help_subcatid int(5) NOT NULL default '0',
  help_title varchar(255) NOT NULL default '',
  help_text text NOT NULL,
  PRIMARY KEY  (help_id)
);

#
# Dumping data for table `phpjob_help_ge`
#

INSERT INTO phpjob_help_ge select * from phpjob_help_en;
# --------------------------------------------------------

#
# Table structure for table `phpjob_help_sp`
#

CREATE TABLE phpjob_help_sp (
  help_id int(11) NOT NULL auto_increment,
  help_catid int(3) NOT NULL default '0',
  help_subcatid int(5) NOT NULL default '0',
  help_title varchar(255) NOT NULL default '',
  help_text text NOT NULL,
  PRIMARY KEY  (help_id)
);

#
# Dumping data for table `phpjob_help_sp`
#

INSERT INTO phpjob_help_sp select * from phpjob_help_en;
# --------------------------------------------------------

#
# Table structure for table `phpjob_help_fr`
#

CREATE TABLE phpjob_help_fr (
  help_id int(11) NOT NULL auto_increment,
  help_catid int(3) NOT NULL default '0',
  help_subcatid int(5) NOT NULL default '0',
  help_title varchar(255) NOT NULL default '',
  help_text text NOT NULL,
  PRIMARY KEY  (help_id)
);

#
# Dumping data for table `phpjob_help_fr`
#

INSERT INTO phpjob_help_fr select * from phpjob_help_en;
# --------------------------------------------------------

#
# Table structure for table `phpjob_helpcat_en`
#

DROP TABLE IF EXISTS phpjob_helpcat_en;
CREATE TABLE phpjob_helpcat_en (
  help_catid int(3) NOT NULL auto_increment,
  help_category varchar(255) NOT NULL default '',
  help_type tinyint(2) NOT NULL default '0',
  PRIMARY KEY  (help_catid)
);

#
# Dumping data for table `phpjob_helpcat_en`
#

INSERT INTO phpjob_helpcat_en VALUES (3, 'FAQ', 1);
INSERT INTO phpjob_helpcat_en VALUES (4, 'Admin', 2);
INSERT INTO phpjob_helpcat_en VALUES (6, 'Help', 1);
# --------------------------------------------------------

#
# Table structure for table `phpjob_helpcat_ge`
#

CREATE TABLE phpjob_helpcat_ge (
  help_catid int(3) NOT NULL auto_increment,
  help_category varchar(255) NOT NULL default '',
  help_type tinyint(2) NOT NULL default '0',
  PRIMARY KEY  (help_catid)
);

#
# Dumping data for table `phpjob_helpcat_ge`
#

INSERT INTO phpjob_helpcat_ge select * from phpjob_helpcat_en;
# --------------------------------------------------------

#
# Table structure for table `phpjob_helpcat_sp`
#

CREATE TABLE phpjob_helpcat_sp (
  help_catid int(3) NOT NULL auto_increment,
  help_category varchar(255) NOT NULL default '',
  help_type tinyint(2) NOT NULL default '0',
  PRIMARY KEY  (help_catid)
);

#
# Dumping data for table `phpjob_helpcat_sp`
#

INSERT INTO phpjob_helpcat_sp select * from phpjob_helpcat_en;
# --------------------------------------------------------

#
# Table structure for table `phpjob_helpcat_fr`
#

CREATE TABLE phpjob_helpcat_fr (
  help_catid int(3) NOT NULL auto_increment,
  help_category varchar(255) NOT NULL default '',
  help_type tinyint(2) NOT NULL default '0',
  PRIMARY KEY  (help_catid)
);

#
# Dumping data for table `phpjob_helpcat_fr`
#

INSERT INTO phpjob_helpcat_fr select * from phpjob_helpcat_en;
# --------------------------------------------------------

#
# Table structure for table `phpjob_helpsubcat_en`
#

DROP TABLE IF EXISTS phpjob_helpsubcat_en;
CREATE TABLE phpjob_helpsubcat_en (
  help_subcatid int(5) NOT NULL auto_increment,
  help_catid int(3) NOT NULL default '0',
  help_subcategory varchar(255) NOT NULL default '',
  PRIMARY KEY  (help_subcatid)
);

#
# Dumping data for table `phpjob_helpsubcat_en`
#

INSERT INTO phpjob_helpsubcat_en VALUES (10, 4, 'Employers Section');
INSERT INTO phpjob_helpsubcat_en VALUES (7, 3, 'Jobseeker\'s');
INSERT INTO phpjob_helpsubcat_en VALUES (9, 3, 'Employer\'s');
INSERT INTO phpjob_helpsubcat_en VALUES (12, 6, 'Jobseeker');
INSERT INTO phpjob_helpsubcat_en VALUES (13, 6, 'Employer');
# --------------------------------------------------------

#
# Table structure for table `phpjob_helpsubcat_ge`
#

CREATE TABLE phpjob_helpsubcat_ge (
  help_subcatid int(5) NOT NULL auto_increment,
  help_catid int(3) NOT NULL default '0',
  help_subcategory varchar(255) NOT NULL default '',
  PRIMARY KEY  (help_subcatid)
);

#
# Dumping data for table `phpjob_helpsubcat_ge`
#

INSERT INTO phpjob_helpsubcat_ge select * from phpjob_helpsubcat_en;
# --------------------------------------------------------

#
# Table structure for table `phpjob_helpsubcat_sp`
#

CREATE TABLE phpjob_helpsubcat_sp (
  help_subcatid int(5) NOT NULL auto_increment,
  help_catid int(3) NOT NULL default '0',
  help_subcategory varchar(255) NOT NULL default '',
  PRIMARY KEY  (help_subcatid)
);

#
# Dumping data for table `phpjob_helpsubcat_sp`
#

INSERT INTO phpjob_helpsubcat_sp select * from phpjob_helpsubcat_en;
# --------------------------------------------------------

#
# Table structure for table `phpjob_helpsubcat_fr`
#

CREATE TABLE phpjob_helpsubcat_fr (
  help_subcatid int(5) NOT NULL auto_increment,
  help_catid int(3) NOT NULL default '0',
  help_subcategory varchar(255) NOT NULL default '',
  PRIMARY KEY  (help_subcatid)
);

#
# Dumping data for table `phpjob_helpsubcat_fr`
#

INSERT INTO phpjob_helpsubcat_fr select * from phpjob_helpsubcat_en;
# --------------------------------------------------------

#
# Table structure for table `phpjob_helptoc_en`
#

DROP TABLE IF EXISTS phpjob_helptoc_en;
CREATE TABLE phpjob_helptoc_en (
  help_tocid bigint(20) NOT NULL auto_increment,
  help_toclabel varchar(255) NOT NULL default '',
  help_type tinyint(2) NOT NULL default '0',
  help_id int(5) NOT NULL default '0',
  help_catid int(3) NOT NULL default '0',
  help_subcatid int(3) NOT NULL default '0',
  help_word varchar(80) NOT NULL default '',
  PRIMARY KEY  (help_tocid),
  KEY help_word (help_word)
);

#
# Dumping data for table `phpjob_helptoc_en`
#

INSERT INTO phpjob_helptoc_en VALUES (91, 'FAQ', 1, 0, 3, 0, 'faq');
INSERT INTO phpjob_helptoc_en VALUES (93, 'Jobseeker\'s', 1, 0, 3, 7, 'jobseeker');
INSERT INTO phpjob_helptoc_en VALUES (92, 'Employer\'s', 1, 0, 3, 9, 'employer');
INSERT INTO phpjob_helptoc_en VALUES (357, 'Q: How can I register as a Jobseeker?', 1, 8, 3, 7, 'post');
INSERT INTO phpjob_helptoc_en VALUES (358, 'Q: How can I register as a Jobseeker?', 1, 8, 3, 7, 'your');
INSERT INTO phpjob_helptoc_en VALUES (356, 'Q: How can I register as a Jobseeker?', 1, 8, 3, 7, 'here');
INSERT INTO phpjob_helptoc_en VALUES (355, 'Q: How can I register as a Jobseeker?', 1, 8, 3, 7, 'click');
INSERT INTO phpjob_helptoc_en VALUES (354, 'Q: How can I register as a Jobseeker?', 1, 8, 3, 7, 'that');
INSERT INTO phpjob_helptoc_en VALUES (353, 'Q: How can I register as a Jobseeker?', 1, 8, 3, 7, 'for');
INSERT INTO phpjob_helptoc_en VALUES (351, 'Q: How can I register as a Jobseeker?', 1, 8, 3, 7, 'pay');
INSERT INTO phpjob_helptoc_en VALUES (352, 'Q: How can I register as a Jobseeker?', 1, 8, 3, 7, 'anything');
INSERT INTO phpjob_helptoc_en VALUES (350, 'Q: How can I register as a Jobseeker?', 1, 8, 3, 7, 'have');
INSERT INTO phpjob_helptoc_en VALUES (348, 'Q: How can I register as a Jobseeker?', 1, 8, 3, 7, 'you');
INSERT INTO phpjob_helptoc_en VALUES (122, 'Q: Employer registartion is free?', 1, 9, 3, 9, 'help');
INSERT INTO phpjob_helptoc_en VALUES (121, 'Q: Employer registartion is free?', 1, 9, 3, 9, 'things');
INSERT INTO phpjob_helptoc_en VALUES (349, 'Q: How can I register as a Jobseeker?', 1, 8, 3, 7, 'don');
INSERT INTO phpjob_helptoc_en VALUES (347, 'Q: How can I register as a Jobseeker?', 1, 8, 3, 7, 'free');
INSERT INTO phpjob_helptoc_en VALUES (120, 'Q: Employer registartion is free?', 1, 9, 3, 9, 'real');
INSERT INTO phpjob_helptoc_en VALUES (119, 'Q: Employer registartion is free?', 1, 9, 3, 9, 'some');
INSERT INTO phpjob_helptoc_en VALUES (118, 'Q: Employer registartion is free?', 1, 9, 3, 9, 'link');
INSERT INTO phpjob_helptoc_en VALUES (117, 'Q: Employer registartion is free?', 1, 9, 3, 9, 'not');
INSERT INTO phpjob_helptoc_en VALUES (116, 'Q: Employer registartion is free?', 1, 9, 3, 9, 'registration');
INSERT INTO phpjob_helptoc_en VALUES (115, 'Q: Employer registartion is free?', 1, 9, 3, 9, 'the');
INSERT INTO phpjob_helptoc_en VALUES (114, 'Q: Employer registartion is free?', 1, 9, 3, 9, 'free');
INSERT INTO phpjob_helptoc_en VALUES (113, 'Q: Employer registartion is free?', 1, 9, 3, 9, 'registartion');
INSERT INTO phpjob_helptoc_en VALUES (112, 'Q: Employer registartion is free?', 1, 9, 3, 9, 'employer');
INSERT INTO phpjob_helptoc_en VALUES (125, 'Admin', 2, 0, 4, 0, 'admin');
INSERT INTO phpjob_helptoc_en VALUES (89, 'Employers Section', 2, 0, 4, 10, 'employers');
INSERT INTO phpjob_helptoc_en VALUES (90, 'Employers Section', 2, 0, 4, 10, 'section');
INSERT INTO phpjob_helptoc_en VALUES (346, 'Q: How can I register as a Jobseeker?', 1, 8, 3, 7, 'registration');
INSERT INTO phpjob_helptoc_en VALUES (345, 'Q: How can I register as a Jobseeker?', 1, 8, 3, 7, 'jobseeker');
INSERT INTO phpjob_helptoc_en VALUES (344, 'Q: How can I register as a Jobseeker?', 1, 8, 3, 7, 'register');
INSERT INTO phpjob_helptoc_en VALUES (343, 'Q: How can I register as a Jobseeker?', 1, 8, 3, 7, 'can');
INSERT INTO phpjob_helptoc_en VALUES (342, 'Q: How can I register as a Jobseeker?', 1, 8, 3, 7, 'how');
INSERT INTO phpjob_helptoc_en VALUES (123, 'Q: Employer registartion is free?', 1, 9, 3, 9, 'system');
INSERT INTO phpjob_helptoc_en VALUES (124, 'Q: Employer registartion is free?', 1, 9, 3, 9, 'now');
INSERT INTO phpjob_helptoc_en VALUES (483, 'Q: Do I need to register as a jobseeker for searching jobs?', 1, 12, 3, 7, 'job');
INSERT INTO phpjob_helptoc_en VALUES (482, 'Q: Do I need to register as a jobseeker for searching jobs?', 1, 12, 3, 7, 'online');
INSERT INTO phpjob_helptoc_en VALUES (481, 'Q: Do I need to register as a jobseeker for searching jobs?', 1, 12, 3, 7, 'apply');
INSERT INTO phpjob_helptoc_en VALUES (480, 'Q: Do I need to register as a jobseeker for searching jobs?', 1, 12, 3, 7, 'resume');
INSERT INTO phpjob_helptoc_en VALUES (462, 'Q: How many jobs can I view?', 1, 14, 3, 7, 'and');
INSERT INTO phpjob_helptoc_en VALUES (463, 'Q: How many jobs can I view?', 1, 14, 3, 7, 'viewing');
INSERT INTO phpjob_helptoc_en VALUES (461, 'Q: How many jobs can I view?', 1, 14, 3, 7, 'searching');
INSERT INTO phpjob_helptoc_en VALUES (460, 'Q: How many jobs can I view?', 1, 14, 3, 7, 'for');
INSERT INTO phpjob_helptoc_en VALUES (459, 'Q: How many jobs can I view?', 1, 14, 3, 7, 'limit');
INSERT INTO phpjob_helptoc_en VALUES (458, 'Q: How many jobs can I view?', 1, 14, 3, 7, 'there');
INSERT INTO phpjob_helptoc_en VALUES (457, 'Q: How many jobs can I view?', 1, 14, 3, 7, 'view');
INSERT INTO phpjob_helptoc_en VALUES (456, 'Q: How many jobs can I view?', 1, 14, 3, 7, 'can');
INSERT INTO phpjob_helptoc_en VALUES (455, 'Q: How many jobs can I view?', 1, 14, 3, 7, 'jobs');
INSERT INTO phpjob_helptoc_en VALUES (454, 'Q: How many jobs can I view?', 1, 14, 3, 7, 'many');
INSERT INTO phpjob_helptoc_en VALUES (453, 'Q: How many jobs can I view?', 1, 14, 3, 7, 'how');
INSERT INTO phpjob_helptoc_en VALUES (310, 'Search companies', 2, 10, 4, 10, 'click');
INSERT INTO phpjob_helptoc_en VALUES (309, 'Search companies', 2, 10, 4, 10, 'system');
INSERT INTO phpjob_helptoc_en VALUES (308, 'Search companies', 2, 10, 4, 10, 'from');
INSERT INTO phpjob_helptoc_en VALUES (307, 'Search companies', 2, 10, 4, 10, 'list');
INSERT INTO phpjob_helptoc_en VALUES (306, 'Search companies', 2, 10, 4, 10, 'will');
INSERT INTO phpjob_helptoc_en VALUES (305, 'Search companies', 2, 10, 4, 10, 'locations');
INSERT INTO phpjob_helptoc_en VALUES (304, 'Search companies', 2, 10, 4, 10, 'selecting');
INSERT INTO phpjob_helptoc_en VALUES (303, 'Search companies', 2, 10, 4, 10, 'location');
INSERT INTO phpjob_helptoc_en VALUES (302, 'Search companies', 2, 10, 4, 10, 'name');
INSERT INTO phpjob_helptoc_en VALUES (301, 'Search companies', 2, 10, 4, 10, 'address');
INSERT INTO phpjob_helptoc_en VALUES (300, 'Search companies', 2, 10, 4, 10, 'email');
INSERT INTO phpjob_helptoc_en VALUES (299, 'Search companies', 2, 10, 4, 10, 'employer');
INSERT INTO phpjob_helptoc_en VALUES (298, 'Search companies', 2, 10, 4, 10, 'are');
INSERT INTO phpjob_helptoc_en VALUES (297, 'Search companies', 2, 10, 4, 10, 'criteria');
INSERT INTO phpjob_helptoc_en VALUES (296, 'Search companies', 2, 10, 4, 10, 'employers');
INSERT INTO phpjob_helptoc_en VALUES (295, 'Search companies', 2, 10, 4, 10, 'registered');
INSERT INTO phpjob_helptoc_en VALUES (292, 'Search companies', 2, 10, 4, 10, 'for');
INSERT INTO phpjob_helptoc_en VALUES (294, 'Search companies', 2, 10, 4, 10, 'the');
INSERT INTO phpjob_helptoc_en VALUES (293, 'Search companies', 2, 10, 4, 10, 'all');
INSERT INTO phpjob_helptoc_en VALUES (290, 'Search companies', 2, 10, 4, 10, 'you');
INSERT INTO phpjob_helptoc_en VALUES (291, 'Search companies', 2, 10, 4, 10, 'can');
INSERT INTO phpjob_helptoc_en VALUES (288, 'Search companies', 2, 10, 4, 10, 'this');
INSERT INTO phpjob_helptoc_en VALUES (289, 'Search companies', 2, 10, 4, 10, 'section');
INSERT INTO phpjob_helptoc_en VALUES (287, 'Search companies', 2, 10, 4, 10, 'companiesin');
INSERT INTO phpjob_helptoc_en VALUES (286, 'Search companies', 2, 10, 4, 10, 'search');
INSERT INTO phpjob_helptoc_en VALUES (311, 'Search companies', 2, 10, 4, 10, 'here');
INSERT INTO phpjob_helptoc_en VALUES (312, 'Search companies', 2, 10, 4, 10, 'there');
INSERT INTO phpjob_helptoc_en VALUES (524, 'asssdera', 2, 16, 4, 10, 'asssderamy');
INSERT INTO phpjob_helptoc_en VALUES (479, 'Q: Do I need to register as a jobseeker for searching jobs?', 1, 12, 3, 7, 'your');
INSERT INTO phpjob_helptoc_en VALUES (478, 'Q: Do I need to register as a jobseeker for searching jobs?', 1, 12, 3, 7, 'post');
INSERT INTO phpjob_helptoc_en VALUES (477, 'Q: Do I need to register as a jobseeker for searching jobs?', 1, 12, 3, 7, 'and');
INSERT INTO phpjob_helptoc_en VALUES (476, 'Q: Do I need to register as a jobseeker for searching jobs?', 1, 12, 3, 7, 'will');
INSERT INTO phpjob_helptoc_en VALUES (475, 'Q: Do I need to register as a jobseeker for searching jobs?', 1, 12, 3, 7, 'but');
INSERT INTO phpjob_helptoc_en VALUES (474, 'Q: Do I need to register as a jobseeker for searching jobs?', 1, 12, 3, 7, 'search');
INSERT INTO phpjob_helptoc_en VALUES (473, 'Q: Do I need to register as a jobseeker for searching jobs?', 1, 12, 3, 7, 'able');
INSERT INTO phpjob_helptoc_en VALUES (472, 'Q: Do I need to register as a jobseeker for searching jobs?', 1, 12, 3, 7, 'have');
INSERT INTO phpjob_helptoc_en VALUES (471, 'Q: Do I need to register as a jobseeker for searching jobs?', 1, 12, 3, 7, 'don');
INSERT INTO phpjob_helptoc_en VALUES (470, 'Q: Do I need to register as a jobseeker for searching jobs?', 1, 12, 3, 7, 'you');
INSERT INTO phpjob_helptoc_en VALUES (469, 'Q: Do I need to register as a jobseeker for searching jobs?', 1, 12, 3, 7, 'jobs');
INSERT INTO phpjob_helptoc_en VALUES (468, 'Q: Do I need to register as a jobseeker for searching jobs?', 1, 12, 3, 7, 'searching');
INSERT INTO phpjob_helptoc_en VALUES (467, 'Q: Do I need to register as a jobseeker for searching jobs?', 1, 12, 3, 7, 'for');
INSERT INTO phpjob_helptoc_en VALUES (466, 'Q: Do I need to register as a jobseeker for searching jobs?', 1, 12, 3, 7, 'jobseeker');
INSERT INTO phpjob_helptoc_en VALUES (465, 'Q: Do I need to register as a jobseeker for searching jobs?', 1, 12, 3, 7, 'register');
INSERT INTO phpjob_helptoc_en VALUES (464, 'Q: Do I need to register as a jobseeker for searching jobs?', 1, 12, 3, 7, 'need');
INSERT INTO phpjob_helptoc_en VALUES (397, 'Employer', 1, 0, 6, 13, 'employer');
INSERT INTO phpjob_helptoc_en VALUES (396, 'Jobseeker', 1, 0, 6, 12, 'jobseeker');
INSERT INTO phpjob_helptoc_en VALUES (395, 'Help', 1, 0, 6, 0, 'help');
INSERT INTO phpjob_helptoc_en VALUES (431, 'Jobseeker Login', 1, 13, 6, 12, 'used');
INSERT INTO phpjob_helptoc_en VALUES (430, 'Jobseeker Login', 1, 13, 6, 12, 'those');
INSERT INTO phpjob_helptoc_en VALUES (429, 'Jobseeker Login', 1, 13, 6, 12, 'with');
INSERT INTO phpjob_helptoc_en VALUES (428, 'Jobseeker Login', 1, 13, 6, 12, 'same');
INSERT INTO phpjob_helptoc_en VALUES (427, 'Jobseeker Login', 1, 13, 6, 12, 'are');
INSERT INTO phpjob_helptoc_en VALUES (426, 'Jobseeker Login', 1, 13, 6, 12, 'the');
INSERT INTO phpjob_helptoc_en VALUES (425, 'Jobseeker Login', 1, 13, 6, 12, 'account');
INSERT INTO phpjob_helptoc_en VALUES (424, 'Jobseeker Login', 1, 13, 6, 12, 'free');
INSERT INTO phpjob_helptoc_en VALUES (423, 'Jobseeker Login', 1, 13, 6, 12, 'login');
INSERT INTO phpjob_helptoc_en VALUES (422, 'Jobseeker Login', 1, 13, 6, 12, 'password');
INSERT INTO phpjob_helptoc_en VALUES (421, 'Jobseeker Login', 1, 13, 6, 12, 'and');
INSERT INTO phpjob_helptoc_en VALUES (420, 'Jobseeker Login', 1, 13, 6, 12, 'address');
INSERT INTO phpjob_helptoc_en VALUES (419, 'Jobseeker Login', 1, 13, 6, 12, 'email');
INSERT INTO phpjob_helptoc_en VALUES (418, 'Jobseeker Login', 1, 13, 6, 12, 'your');
INSERT INTO phpjob_helptoc_en VALUES (417, 'Jobseeker Login', 1, 13, 6, 12, 'loginenter');
INSERT INTO phpjob_helptoc_en VALUES (416, 'Jobseeker Login', 1, 13, 6, 12, 'jobseeker');
INSERT INTO phpjob_helptoc_en VALUES (432, 'Jobseeker Login', 1, 13, 6, 12, 'for');
INSERT INTO phpjob_helptoc_en VALUES (433, 'Jobseeker Login', 1, 13, 6, 12, 'registration');
INSERT INTO phpjob_helptoc_en VALUES (434, 'Jobseeker Login', 1, 13, 6, 12, 'you');
INSERT INTO phpjob_helptoc_en VALUES (435, 'Jobseeker Login', 1, 13, 6, 12, 'not');
INSERT INTO phpjob_helptoc_en VALUES (436, 'Jobseeker Login', 1, 13, 6, 12, 'registered');
INSERT INTO phpjob_helptoc_en VALUES (437, 'Jobseeker Login', 1, 13, 6, 12, 'use');
INSERT INTO phpjob_helptoc_en VALUES (438, 'Jobseeker Login', 1, 13, 6, 12, 'link');
INSERT INTO phpjob_helptoc_en VALUES (439, 'Jobseeker Login', 1, 13, 6, 12, 'register');
INSERT INTO phpjob_helptoc_en VALUES (440, 'Jobseeker Login', 1, 13, 6, 12, 'our');
INSERT INTO phpjob_helptoc_en VALUES (441, 'Jobseeker Login', 1, 13, 6, 12, 'system');
INSERT INTO phpjob_helptoc_en VALUES (521, 'Q: I lost my password, what should  I do?', 1, 15, 3, 7, 'for');
INSERT INTO phpjob_helptoc_en VALUES (520, 'Q: I lost my password, what should  I do?', 1, 15, 3, 7, 'used');
INSERT INTO phpjob_helptoc_en VALUES (519, 'Q: I lost my password, what should  I do?', 1, 15, 3, 7, 'address');
INSERT INTO phpjob_helptoc_en VALUES (518, 'Q: I lost my password, what should  I do?', 1, 15, 3, 7, 'email');
INSERT INTO phpjob_helptoc_en VALUES (517, 'Q: I lost my password, what should  I do?', 1, 15, 3, 7, 'need');
INSERT INTO phpjob_helptoc_en VALUES (516, 'Q: I lost my password, what should  I do?', 1, 15, 3, 7, 'only');
INSERT INTO phpjob_helptoc_en VALUES (515, 'Q: I lost my password, what should  I do?', 1, 15, 3, 7, 'form');
INSERT INTO phpjob_helptoc_en VALUES (514, 'Q: I lost my password, what should  I do?', 1, 15, 3, 7, 'forgot');
INSERT INTO phpjob_helptoc_en VALUES (513, 'Q: I lost my password, what should  I do?', 1, 15, 3, 7, 'the');
INSERT INTO phpjob_helptoc_en VALUES (512, 'Q: I lost my password, what should  I do?', 1, 15, 3, 7, 'using');
INSERT INTO phpjob_helptoc_en VALUES (511, 'Q: I lost my password, what should  I do?', 1, 15, 3, 7, 'your');
INSERT INTO phpjob_helptoc_en VALUES (510, 'Q: I lost my password, what should  I do?', 1, 15, 3, 7, 'get');
INSERT INTO phpjob_helptoc_en VALUES (509, 'Q: I lost my password, what should  I do?', 1, 15, 3, 7, 'can');
INSERT INTO phpjob_helptoc_en VALUES (508, 'Q: I lost my password, what should  I do?', 1, 15, 3, 7, 'you');
INSERT INTO phpjob_helptoc_en VALUES (507, 'Q: I lost my password, what should  I do?', 1, 15, 3, 7, 'should');
INSERT INTO phpjob_helptoc_en VALUES (506, 'Q: I lost my password, what should  I do?', 1, 15, 3, 7, 'what');
INSERT INTO phpjob_helptoc_en VALUES (505, 'Q: I lost my password, what should  I do?', 1, 15, 3, 7, 'password');
INSERT INTO phpjob_helptoc_en VALUES (504, 'Q: I lost my password, what should  I do?', 1, 15, 3, 7, 'lost');
INSERT INTO phpjob_helptoc_en VALUES (522, 'Q: I lost my password, what should  I do?', 1, 15, 3, 7, 'registration');
INSERT INTO phpjob_helptoc_en VALUES (523, 'Q: I lost my password, what should  I do?', 1, 15, 3, 7, 'system');
INSERT INTO phpjob_helptoc_en VALUES (525, 'asssdera', 2, 16, 4, 10, 'help');
INSERT INTO phpjob_helptoc_en VALUES (526, 'asssdera', 2, 16, 4, 10, 'system');
# --------------------------------------------------------

#
# Table structure for table `phpjob_helptoc_ge`
#

CREATE TABLE phpjob_helptoc_ge (
  help_tocid bigint(20) NOT NULL auto_increment,
  help_toclabel varchar(255) NOT NULL default '',
  help_type tinyint(2) NOT NULL default '0',
  help_id int(5) NOT NULL default '0',
  help_catid int(3) NOT NULL default '0',
  help_subcatid int(3) NOT NULL default '0',
  help_word varchar(80) NOT NULL default '',
  PRIMARY KEY  (help_tocid),
  KEY help_word (help_word)
);

#
# Dumping data for table `phpjob_helptoc_ge`
#

INSERT INTO phpjob_helptoc_ge select * from phpjob_helptoc_en;
# --------------------------------------------------------

#
# Table structure for table `phpjob_helptoc_sp`
#

CREATE TABLE phpjob_helptoc_sp (
  help_tocid bigint(20) NOT NULL auto_increment,
  help_toclabel varchar(255) NOT NULL default '',
  help_type tinyint(2) NOT NULL default '0',
  help_id int(5) NOT NULL default '0',
  help_catid int(3) NOT NULL default '0',
  help_subcatid int(3) NOT NULL default '0',
  help_word varchar(80) NOT NULL default '',
  PRIMARY KEY  (help_tocid),
  KEY help_word (help_word)
);

#
# Dumping data for table `phpjob_helptoc_sp`
#

INSERT INTO phpjob_helptoc_sp select * from phpjob_helptoc_en;
# --------------------------------------------------------

#
# Table structure for table `phpjob_helptoc_fr`
#

CREATE TABLE phpjob_helptoc_fr (
  help_tocid bigint(20) NOT NULL auto_increment,
  help_toclabel varchar(255) NOT NULL default '',
  help_type tinyint(2) NOT NULL default '0',
  help_id int(5) NOT NULL default '0',
  help_catid int(3) NOT NULL default '0',
  help_subcatid int(3) NOT NULL default '0',
  help_word varchar(80) NOT NULL default '',
  PRIMARY KEY  (help_tocid),
  KEY help_word (help_word)
);

#
# Dumping data for table `phpjob_helptoc_fr`
#

INSERT INTO phpjob_helptoc_fr select * from phpjob_helptoc_en;
# --------------------------------------------------------

#
# Table structure for table `phpjob_invoices`
#

CREATE TABLE phpjob_invoices (
  opid int(10) NOT NULL auto_increment,
  op_type int(1) NOT NULL default '0',
  compid int(5) NOT NULL default '0',
  pricing_type mediumint(2) NOT NULL default '0',
  jobs int(3) NOT NULL default '0',
  featuredjobs int(3) NOT NULL default '0',
  contacts int(3) NOT NULL default '0',
  1job float(10,2) NOT NULL default '0.00',
  1featuredjob float(10,2) NOT NULL default '0.00',
  1contact float(10,2) NOT NULL default '0.00',
  date_added date NOT NULL default '0000-00-00',
  info varchar(255) NOT NULL default '',
  currency char(5) NOT NULL default '',
  listprice float(10,2) NOT NULL default '0.00',
  discount float(3,2) NOT NULL default '0.00',
  vat float(3,2) NOT NULL default '0.00',
  totalprice float(10,2) NOT NULL default '0.00',
  paid char(1) NOT NULL default '',
  payment_mode mediumint(2) NOT NULL default '0',
  payment_date date NOT NULL default '0000-00-00',
  description varchar(255) NOT NULL default '',
  updated char(1) NOT NULL default 'N',
  validated char(1) NOT NULL default 'N',
  PRIMARY KEY  (opid)
);

#
# Table structure for table `phpjob_jobcategories_en`
#

CREATE TABLE phpjob_jobcategories_en (
  jobcategoryid int(2) NOT NULL auto_increment,
  jobcategory varchar(100) NOT NULL default '',
  PRIMARY KEY  (jobcategoryid)
);

#
# Dumping data for table `phpjob_jobcategories_en`
#

INSERT INTO phpjob_jobcategories_en VALUES (10, 'Accounting');
INSERT INTO phpjob_jobcategories_en VALUES (11, 'Administrative');
INSERT INTO phpjob_jobcategories_en VALUES (12, 'Advertising');
INSERT INTO phpjob_jobcategories_en VALUES (13, 'Architecture/Design');
INSERT INTO phpjob_jobcategories_en VALUES (14, 'Automotive');
INSERT INTO phpjob_jobcategories_en VALUES (15, 'Aviation/Aerospace');
INSERT INTO phpjob_jobcategories_en VALUES (16, 'Beauty/Fashion');
INSERT INTO phpjob_jobcategories_en VALUES (17, 'Biotech/Life Sciences');
INSERT INTO phpjob_jobcategories_en VALUES (18, 'Broadcast/Publishing');
INSERT INTO phpjob_jobcategories_en VALUES (19, 'Consulting');
INSERT INTO phpjob_jobcategories_en VALUES (20, 'Creative Arts/Media');
INSERT INTO phpjob_jobcategories_en VALUES (21, 'Customer Service');
INSERT INTO phpjob_jobcategories_en VALUES (22, 'Education/Training');
INSERT INTO phpjob_jobcategories_en VALUES (23, 'Engineering');
INSERT INTO phpjob_jobcategories_en VALUES (24, 'Finance/Banking');
INSERT INTO phpjob_jobcategories_en VALUES (25, 'Government/Social');
INSERT INTO phpjob_jobcategories_en VALUES (26, 'Health Services');
INSERT INTO phpjob_jobcategories_en VALUES (27, 'Hospitality/Travel');
INSERT INTO phpjob_jobcategories_en VALUES (28, 'HR/Recruiting');
INSERT INTO phpjob_jobcategories_en VALUES (29, 'Info Technology');
INSERT INTO phpjob_jobcategories_en VALUES (30, 'Insurance');
INSERT INTO phpjob_jobcategories_en VALUES (31, 'Internet/New Media');
INSERT INTO phpjob_jobcategories_en VALUES (32, 'Law Enforcement');
INSERT INTO phpjob_jobcategories_en VALUES (33, 'Legal');
INSERT INTO phpjob_jobcategories_en VALUES (34, 'Manufacturing');
INSERT INTO phpjob_jobcategories_en VALUES (35, 'Marketing/PR');
INSERT INTO phpjob_jobcategories_en VALUES (36, 'Military');
INSERT INTO phpjob_jobcategories_en VALUES (37, 'Military Veteran');
INSERT INTO phpjob_jobcategories_en VALUES (38, 'NON PROFIT');
INSERT INTO phpjob_jobcategories_en VALUES (39, 'Other');
INSERT INTO phpjob_jobcategories_en VALUES (40, 'Phy Science');
INSERT INTO phpjob_jobcategories_en VALUES (41, 'Real Estate');
INSERT INTO phpjob_jobcategories_en VALUES (42, 'Retail');
INSERT INTO phpjob_jobcategories_en VALUES (43, 'Sales/Sales Mgmt');
INSERT INTO phpjob_jobcategories_en VALUES (44, 'Sports/Fitness');
INSERT INTO phpjob_jobcategories_en VALUES (45, 'Telecommunication');
INSERT INTO phpjob_jobcategories_en VALUES (46, 'Trades/Const');
# --------------------------------------------------------

#
# Table structure for table `phpjob_jobcategories_ge`
#

CREATE TABLE phpjob_jobcategories_ge (
  jobcategoryid int(2) NOT NULL auto_increment,
  jobcategory varchar(100) NOT NULL default '',
  PRIMARY KEY  (jobcategoryid)
);

#
# Dumping data for table `phpjob_jobcategories_ge`
#
INSERT INTO phpjob_jobcategories_ge select * from phpjob_jobcategories_en;
# --------------------------------------------------------

#
# Table structure for table `phpjob_jobcategories_sp`
#

CREATE TABLE phpjob_jobcategories_sp (
  jobcategoryid int(2) NOT NULL auto_increment,
  jobcategory varchar(100) NOT NULL default '',
  PRIMARY KEY  (jobcategoryid)
);

#
# Dumping data for table `phpjob_jobcategories_sp`
#

INSERT INTO phpjob_jobcategories_sp select * from phpjob_jobcategories_en;
# --------------------------------------------------------

#
# Table structure for table `phpjob_jobcategories_fr`
#

CREATE TABLE phpjob_jobcategories_fr (
  jobcategoryid int(2) NOT NULL auto_increment,
  jobcategory varchar(100) NOT NULL default '',
  PRIMARY KEY  (jobcategoryid)
);

#
# Dumping data for table `phpjob_jobcategories_fr`
#

INSERT INTO phpjob_jobcategories_fr select * from phpjob_jobcategories_en;
# --------------------------------------------------------

#
# Table structure for table `phpjob_jobmail`
#

CREATE TABLE phpjob_jobmail (
  jobmail_id int(5) NOT NULL auto_increment,
  persid int(5) NOT NULL default '0',
  jobmail_type int(3) NOT NULL default '0',
  jmail_lang varchar(40) NOT NULL default '',
  jobmail_lastdate date NOT NULL default '0000-00-00',
  PRIMARY KEY  (jobmail_id)
);

#
# Table structure for table `phpjob_jobs`
#

CREATE TABLE phpjob_jobs (
  jobid int(5) NOT NULL auto_increment,
  compid int(5) NOT NULL default '0',
  jobtitle varchar(100) NOT NULL default '',
  description blob NOT NULL,
  jobcategoryid int(2) NOT NULL default '0',
  locationid int(3) NOT NULL default '0',
  degreeid int(2) NOT NULL default '1',
  jobtypeids varchar(25) NOT NULL default '0',
  salary varchar(20) NOT NULL default '0',
  city varchar(100) NOT NULL default '',
  province varchar(100) NOT NULL default '',
  skills blob NOT NULL,
  featuredjob char(1) NOT NULL default '',
  jobdate date NOT NULL default '0000-00-00',
  postlanguage char(2) NOT NULL default '',
  languageids varchar(50) NOT NULL default '',
  experience int(2) NOT NULL default '0',
  hide_compname char(3) NOT NULL default '',
  contact_name varchar(100) NOT NULL default '',
  hide_contactname char(3) NOT NULL default '',
  contact_email varchar(100) NOT NULL default '',
  hide_contactemail char(3) NOT NULL default '',
  contact_phone varchar(32) NOT NULL default '',
  hide_contactphone char(3) NOT NULL default '',
  contact_fax varchar(32) NOT NULL default '',
  hide_contactfax char(3) NOT NULL default '',
  job_link varchar(255) NOT NULL default '',
  jobexpire date NOT NULL default '0000-00-00',
  PRIMARY KEY  (jobid)
);

#
# Table structure for table `phpjob_jobtypes_en`
#

CREATE TABLE phpjob_jobtypes_en (
  jobtypeid int(1) NOT NULL auto_increment,
  jobtype varchar(60) NOT NULL default '',
  PRIMARY KEY  (jobtypeid)
);

#
# Dumping data for table `phpjob_jobtypes_en`
#

INSERT INTO phpjob_jobtypes_en VALUES (1, 'Full Time');
INSERT INTO phpjob_jobtypes_en VALUES (2, 'Part Time');
INSERT INTO phpjob_jobtypes_en VALUES (3, 'Contract');
INSERT INTO phpjob_jobtypes_en VALUES (4, 'Intern');
INSERT INTO phpjob_jobtypes_en VALUES (5, 'Student');
INSERT INTO phpjob_jobtypes_en VALUES (6, 'Voluntary');
INSERT INTO phpjob_jobtypes_en VALUES (7, 'Temporary');
# --------------------------------------------------------

#
# Table structure for table `phpjob_jobtypes_ge`
#

CREATE TABLE phpjob_jobtypes_ge (
  jobtypeid int(1) NOT NULL auto_increment,
  jobtype varchar(60) NOT NULL default '',
  PRIMARY KEY  (jobtypeid)
);

#
# Dumping data for table `phpjob_jobtypes_ge`
#

INSERT INTO phpjob_jobtypes_ge select * from phpjob_jobtypes_en;
# --------------------------------------------------------

#
# Table structure for table `phpjob_jobtypes_sp`
#

CREATE TABLE phpjob_jobtypes_sp (
  jobtypeid int(1) NOT NULL auto_increment,
  jobtype varchar(60) NOT NULL default '',
  PRIMARY KEY  (jobtypeid)
);

#
# Dumping data for table `phpjob_jobtypes_sp`
#

INSERT INTO phpjob_jobtypes_sp select * from phpjob_jobtypes_en;
# --------------------------------------------------------

#
# Table structure for table `phpjob_jobtypes_fr`
#

CREATE TABLE phpjob_jobtypes_fr (
  jobtypeid int(1) NOT NULL auto_increment,
  jobtype varchar(60) NOT NULL default '',
  PRIMARY KEY  (jobtypeid)
);

#
# Dumping data for table `phpjob_jobtypes_fr`
#

INSERT INTO phpjob_jobtypes_fr select * from phpjob_jobtypes_en;
# --------------------------------------------------------

#
# Table structure for table `phpjob_jobview`
#

CREATE TABLE phpjob_jobview (
  jobid int(5) NOT NULL default '0',
  viewed int(11) NOT NULL default '0',
  lastdate datetime NOT NULL default '0000-00-00 00:00:00',
  KEY jobid (jobid)
);

#
# Table structure for table `phpjob_locations`
#

CREATE TABLE phpjob_locations_en (
  locationid int(3) NOT NULL auto_increment,
  location varchar(150) NOT NULL default '',
  PRIMARY KEY  (locationid),
  KEY location (location)
);

#
# Dumping data for table `phpjob_locations_en`
#

INSERT INTO phpjob_locations_en VALUES (500, 'USA');
INSERT INTO phpjob_locations_en VALUES (184, 'Albania');
INSERT INTO phpjob_locations_en VALUES (301, 'Algeria');
INSERT INTO phpjob_locations_en VALUES (240, 'American Samoa');
INSERT INTO phpjob_locations_en VALUES (241, 'Andorra');
INSERT INTO phpjob_locations_en VALUES (302, 'Angola');
INSERT INTO phpjob_locations_en VALUES (303, 'Anguilla');
INSERT INTO phpjob_locations_en VALUES (304, 'Antigua');
INSERT INTO phpjob_locations_en VALUES (115, 'Antilles');
INSERT INTO phpjob_locations_en VALUES (305, 'Argentina');
INSERT INTO phpjob_locations_en VALUES (185, 'Armenia');
INSERT INTO phpjob_locations_en VALUES (306, 'Aruba');
INSERT INTO phpjob_locations_en VALUES (307, 'Australia');
INSERT INTO phpjob_locations_en VALUES (308, 'Austria');
INSERT INTO phpjob_locations_en VALUES (186, 'Azerbaijan');
INSERT INTO phpjob_locations_en VALUES (187, 'Azores');
INSERT INTO phpjob_locations_en VALUES (309, 'Bahamas');
INSERT INTO phpjob_locations_en VALUES (310, 'Bahrain');
INSERT INTO phpjob_locations_en VALUES (311, 'Bangladesh');
INSERT INTO phpjob_locations_en VALUES (312, 'Barbados');
INSERT INTO phpjob_locations_en VALUES (313, 'Barbuda');
INSERT INTO phpjob_locations_en VALUES (315, 'Belgium');
INSERT INTO phpjob_locations_en VALUES (316, 'Belize');
INSERT INTO phpjob_locations_en VALUES (314, 'Belorus');
INSERT INTO phpjob_locations_en VALUES (317, 'Benin');
INSERT INTO phpjob_locations_en VALUES (318, 'Bermuda');
INSERT INTO phpjob_locations_en VALUES (319, 'Bhutan');
INSERT INTO phpjob_locations_en VALUES (320, 'Bolivia');
INSERT INTO phpjob_locations_en VALUES (321, 'Bonaire');
INSERT INTO phpjob_locations_en VALUES (188, 'Bosnia-Hercegovina');
INSERT INTO phpjob_locations_en VALUES (322, 'Botswana');
INSERT INTO phpjob_locations_en VALUES (324, 'Br. Virgin Islands');
INSERT INTO phpjob_locations_en VALUES (323, 'Brazil');
INSERT INTO phpjob_locations_en VALUES (325, 'Brunei');
INSERT INTO phpjob_locations_en VALUES (326, 'Bulgaria');
INSERT INTO phpjob_locations_en VALUES (327, 'Burkina Faso');
INSERT INTO phpjob_locations_en VALUES (328, 'Burundi');
INSERT INTO phpjob_locations_en VALUES (189, 'Caicos Island');
INSERT INTO phpjob_locations_en VALUES (329, 'Cameroon');
INSERT INTO phpjob_locations_en VALUES (330, 'Canada');
INSERT INTO phpjob_locations_en VALUES (190, 'Canary Islands');
INSERT INTO phpjob_locations_en VALUES (331, 'Cape Verde');
INSERT INTO phpjob_locations_en VALUES (332, 'Cayman Islands');
INSERT INTO phpjob_locations_en VALUES (333, 'Central African Republic');
INSERT INTO phpjob_locations_en VALUES (334, 'Chad');
INSERT INTO phpjob_locations_en VALUES (335, 'Channel Islands');
INSERT INTO phpjob_locations_en VALUES (336, 'Chile');
INSERT INTO phpjob_locations_en VALUES (337, 'China');
INSERT INTO phpjob_locations_en VALUES (338, 'Colombia');
INSERT INTO phpjob_locations_en VALUES (191, 'Commonwealth of Ind');
INSERT INTO phpjob_locations_en VALUES (339, 'Congo');
INSERT INTO phpjob_locations_en VALUES (242, 'Cook Islands');
INSERT INTO phpjob_locations_en VALUES (192, 'Cooper Island');
INSERT INTO phpjob_locations_en VALUES (340, 'Costa Rica');
INSERT INTO phpjob_locations_en VALUES (193, 'Cote D\'Ivoire');
INSERT INTO phpjob_locations_en VALUES (194, 'Croatia');
INSERT INTO phpjob_locations_en VALUES (341, 'Curacao');
INSERT INTO phpjob_locations_en VALUES (342, 'Cyprus');
INSERT INTO phpjob_locations_en VALUES (343, 'Czech Republic');
INSERT INTO phpjob_locations_en VALUES (344, 'Denmark');
INSERT INTO phpjob_locations_en VALUES (345, 'Djibouti');
INSERT INTO phpjob_locations_en VALUES (346, 'Dominica');
INSERT INTO phpjob_locations_en VALUES (347, 'Dominican Republic');
INSERT INTO phpjob_locations_en VALUES (348, 'Ecuador');
INSERT INTO phpjob_locations_en VALUES (349, 'Egypt');
INSERT INTO phpjob_locations_en VALUES (350, 'El Salvador');
INSERT INTO phpjob_locations_en VALUES (351, 'England');
INSERT INTO phpjob_locations_en VALUES (352, 'Equatorial Guinea');
INSERT INTO phpjob_locations_en VALUES (353, 'Estonia');
INSERT INTO phpjob_locations_en VALUES (354, 'Ethiopia');
INSERT INTO phpjob_locations_en VALUES (355, 'Fiji');
INSERT INTO phpjob_locations_en VALUES (356, 'Finland');
INSERT INTO phpjob_locations_en VALUES (357, 'France');
INSERT INTO phpjob_locations_en VALUES (358, 'French Guiana');
INSERT INTO phpjob_locations_en VALUES (243, 'French Polynesia');
INSERT INTO phpjob_locations_en VALUES (254, 'Futuna Island');
INSERT INTO phpjob_locations_en VALUES (359, 'Gabon');
INSERT INTO phpjob_locations_en VALUES (360, 'Gambia');
INSERT INTO phpjob_locations_en VALUES (215, 'Georgia');
INSERT INTO phpjob_locations_en VALUES (361, 'Germany');
INSERT INTO phpjob_locations_en VALUES (362, 'Ghana');
INSERT INTO phpjob_locations_en VALUES (216, 'Gibraltar');
INSERT INTO phpjob_locations_en VALUES (363, 'Greece');
INSERT INTO phpjob_locations_en VALUES (364, 'Grenada');
INSERT INTO phpjob_locations_en VALUES (217, 'Grenland');
INSERT INTO phpjob_locations_en VALUES (365, 'Guadeloupe');
INSERT INTO phpjob_locations_en VALUES (366, 'Guam');
INSERT INTO phpjob_locations_en VALUES (367, 'Guatemala');
INSERT INTO phpjob_locations_en VALUES (368, 'Guinea');
INSERT INTO phpjob_locations_en VALUES (369, 'Guinea-Bissau');
INSERT INTO phpjob_locations_en VALUES (370, 'Guyana');
INSERT INTO phpjob_locations_en VALUES (195, 'Haiti');
INSERT INTO phpjob_locations_en VALUES (244, 'Holland');
INSERT INTO phpjob_locations_en VALUES (371, 'Honduras');
INSERT INTO phpjob_locations_en VALUES (372, 'Hong Kong');
INSERT INTO phpjob_locations_en VALUES (373, 'Hungary');
INSERT INTO phpjob_locations_en VALUES (374, 'Iceland');
INSERT INTO phpjob_locations_en VALUES (375, 'India');
INSERT INTO phpjob_locations_en VALUES (376, 'Indonesia');
INSERT INTO phpjob_locations_en VALUES (377, 'Iran');
INSERT INTO phpjob_locations_en VALUES (196, 'Iraq');
INSERT INTO phpjob_locations_en VALUES (378, 'Ireland, Northern');
INSERT INTO phpjob_locations_en VALUES (379, 'Ireland, Republic of');
INSERT INTO phpjob_locations_en VALUES (197, 'Isle of Man');
INSERT INTO phpjob_locations_en VALUES (380, 'Israel');
INSERT INTO phpjob_locations_en VALUES (381, 'Italy');
INSERT INTO phpjob_locations_en VALUES (382, 'Ivory Coast');
INSERT INTO phpjob_locations_en VALUES (383, 'Jamaica');
INSERT INTO phpjob_locations_en VALUES (384, 'Japan');
INSERT INTO phpjob_locations_en VALUES (385, 'Jordan');
INSERT INTO phpjob_locations_en VALUES (198, 'Jost Van Dyke Island');
INSERT INTO phpjob_locations_en VALUES (218, 'Kampuchea');
INSERT INTO phpjob_locations_en VALUES (199, 'Kazakhstan');
INSERT INTO phpjob_locations_en VALUES (386, 'Kenya');
INSERT INTO phpjob_locations_en VALUES (219, 'Kiribati');
INSERT INTO phpjob_locations_en VALUES (239, 'Korea');
INSERT INTO phpjob_locations_en VALUES (387, 'Korea, South');
INSERT INTO phpjob_locations_en VALUES (256, 'Kosrae');
INSERT INTO phpjob_locations_en VALUES (388, 'Kuwait');
INSERT INTO phpjob_locations_en VALUES (200, 'Kyrgyzstan');
INSERT INTO phpjob_locations_en VALUES (220, 'Laos');
INSERT INTO phpjob_locations_en VALUES (389, 'Latvia');
INSERT INTO phpjob_locations_en VALUES (390, 'Lebanon');
INSERT INTO phpjob_locations_en VALUES (391, 'Lesotho');
INSERT INTO phpjob_locations_en VALUES (221, 'Liberia');
INSERT INTO phpjob_locations_en VALUES (392, 'Liechtenstein');
INSERT INTO phpjob_locations_en VALUES (393, 'Lithuania');
INSERT INTO phpjob_locations_en VALUES (394, 'Luxembourg');
INSERT INTO phpjob_locations_en VALUES (395, 'Macau');
INSERT INTO phpjob_locations_en VALUES (222, 'Macedonia');
INSERT INTO phpjob_locations_en VALUES (396, 'Madagascar');
INSERT INTO phpjob_locations_en VALUES (201, 'Madeira Islands');
INSERT INTO phpjob_locations_en VALUES (202, 'Malagasy');
INSERT INTO phpjob_locations_en VALUES (397, 'Malawi');
INSERT INTO phpjob_locations_en VALUES (398, 'Malaysia');
INSERT INTO phpjob_locations_en VALUES (399, 'Maldives');
INSERT INTO phpjob_locations_en VALUES (100, 'Mali');
INSERT INTO phpjob_locations_en VALUES (101, 'Malta');
INSERT INTO phpjob_locations_en VALUES (102, 'Marshall Islands');
INSERT INTO phpjob_locations_en VALUES (103, 'Martinique');
INSERT INTO phpjob_locations_en VALUES (104, 'Mauritania');
INSERT INTO phpjob_locations_en VALUES (105, 'Mauritius');
INSERT INTO phpjob_locations_en VALUES (106, 'Mexico');
INSERT INTO phpjob_locations_en VALUES (107, 'Micronesia');
INSERT INTO phpjob_locations_en VALUES (203, 'Moldova');
INSERT INTO phpjob_locations_en VALUES (108, 'Monaco');
INSERT INTO phpjob_locations_en VALUES (223, 'Mongolia');
INSERT INTO phpjob_locations_en VALUES (109, 'Montserrat');
INSERT INTO phpjob_locations_en VALUES (110, 'Morocco');
INSERT INTO phpjob_locations_en VALUES (111, 'Mozambique');
INSERT INTO phpjob_locations_en VALUES (224, 'Myanmar');
INSERT INTO phpjob_locations_en VALUES (112, 'Namibia');
INSERT INTO phpjob_locations_en VALUES (225, 'Nauru');
INSERT INTO phpjob_locations_en VALUES (113, 'Nepal');
INSERT INTO phpjob_locations_en VALUES (114, 'Netherlands');
INSERT INTO phpjob_locations_en VALUES (204, 'Nevis');
INSERT INTO phpjob_locations_en VALUES (246, 'Nevis (St. Kitts)');
INSERT INTO phpjob_locations_en VALUES (116, 'New Caledonia');
INSERT INTO phpjob_locations_en VALUES (117, 'New Zealand');
INSERT INTO phpjob_locations_en VALUES (118, 'Nicaragua');
INSERT INTO phpjob_locations_en VALUES (119, 'Niger');
INSERT INTO phpjob_locations_en VALUES (120, 'Nigeria');
INSERT INTO phpjob_locations_en VALUES (226, 'Niue');
INSERT INTO phpjob_locations_en VALUES (258, 'Norfolk Island');
INSERT INTO phpjob_locations_en VALUES (205, 'Norman Island');
INSERT INTO phpjob_locations_en VALUES (257, 'Northern Mariana Island');
INSERT INTO phpjob_locations_en VALUES (121, 'Norway');
INSERT INTO phpjob_locations_en VALUES (122, 'Oman');
INSERT INTO phpjob_locations_en VALUES (123, 'Pakistan');
INSERT INTO phpjob_locations_en VALUES (124, 'Palau');
INSERT INTO phpjob_locations_en VALUES (125, 'Panama');
INSERT INTO phpjob_locations_en VALUES (126, 'Papua New Guinea');
INSERT INTO phpjob_locations_en VALUES (127, 'Paraguay');
INSERT INTO phpjob_locations_en VALUES (128, 'Peru');
INSERT INTO phpjob_locations_en VALUES (129, 'Philippines');
INSERT INTO phpjob_locations_en VALUES (130, 'Poland');
INSERT INTO phpjob_locations_en VALUES (260, 'Ponape');
INSERT INTO phpjob_locations_en VALUES (131, 'Portugal');
INSERT INTO phpjob_locations_en VALUES (132, 'Qatar');
INSERT INTO phpjob_locations_en VALUES (133, 'Reunion');
INSERT INTO phpjob_locations_en VALUES (134, 'Romania');
INSERT INTO phpjob_locations_en VALUES (261, 'Rota');
INSERT INTO phpjob_locations_en VALUES (135, 'Russia');
INSERT INTO phpjob_locations_en VALUES (136, 'Rwanda');
INSERT INTO phpjob_locations_en VALUES (137, 'Saba');
INSERT INTO phpjob_locations_en VALUES (147, 'Saipan');
INSERT INTO phpjob_locations_en VALUES (228, 'San Marino');
INSERT INTO phpjob_locations_en VALUES (229, 'Sao Tome');
INSERT INTO phpjob_locations_en VALUES (148, 'Saudi Arabia');
INSERT INTO phpjob_locations_en VALUES (149, 'Scotland');
INSERT INTO phpjob_locations_en VALUES (150, 'Senegal');
INSERT INTO phpjob_locations_en VALUES (207, 'Serbia');
INSERT INTO phpjob_locations_en VALUES (151, 'Seychelles');
INSERT INTO phpjob_locations_en VALUES (152, 'Sierra Leone');
INSERT INTO phpjob_locations_en VALUES (153, 'Singapore');
INSERT INTO phpjob_locations_en VALUES (208, 'Slovakia');
INSERT INTO phpjob_locations_en VALUES (209, 'Slovenia');
INSERT INTO phpjob_locations_en VALUES (210, 'Solomon Islands');
INSERT INTO phpjob_locations_en VALUES (154, 'Somalia');
INSERT INTO phpjob_locations_en VALUES (155, 'South Africa');
INSERT INTO phpjob_locations_en VALUES (156, 'Spain');
INSERT INTO phpjob_locations_en VALUES (157, 'Sri Lanka');
INSERT INTO phpjob_locations_en VALUES (138, 'St. Barthelemy');
INSERT INTO phpjob_locations_en VALUES (206, 'St. Christopher');
INSERT INTO phpjob_locations_en VALUES (139, 'St. Croix');
INSERT INTO phpjob_locations_en VALUES (140, 'St. Eustatius');
INSERT INTO phpjob_locations_en VALUES (141, 'St. John');
INSERT INTO phpjob_locations_en VALUES (142, 'St. Kitts');
INSERT INTO phpjob_locations_en VALUES (143, 'St. Lucia');
INSERT INTO phpjob_locations_en VALUES (144, 'St. Maarten');
INSERT INTO phpjob_locations_en VALUES (245, 'St. Martin');
INSERT INTO phpjob_locations_en VALUES (145, 'St. Thomas');
INSERT INTO phpjob_locations_en VALUES (146, 'St. Vincent');
INSERT INTO phpjob_locations_en VALUES (158, 'Sudan');
INSERT INTO phpjob_locations_en VALUES (159, 'Suriname');
INSERT INTO phpjob_locations_en VALUES (160, 'Swaziland');
INSERT INTO phpjob_locations_en VALUES (161, 'Sweden');
INSERT INTO phpjob_locations_en VALUES (162, 'Switzerland');
INSERT INTO phpjob_locations_en VALUES (163, 'Syria');
INSERT INTO phpjob_locations_en VALUES (247, 'Tahiti');
INSERT INTO phpjob_locations_en VALUES (164, 'Taiwan');
INSERT INTO phpjob_locations_en VALUES (211, 'Tajikistan');
INSERT INTO phpjob_locations_en VALUES (165, 'Tanzania');
INSERT INTO phpjob_locations_en VALUES (166, 'Thailand');
INSERT INTO phpjob_locations_en VALUES (248, 'Tinian');
INSERT INTO phpjob_locations_en VALUES (167, 'Togo');
INSERT INTO phpjob_locations_en VALUES (230, 'Tonaga');
INSERT INTO phpjob_locations_en VALUES (249, 'Tonga');
INSERT INTO phpjob_locations_en VALUES (250, 'Tortola');
INSERT INTO phpjob_locations_en VALUES (168, 'Trinidad and Tobago');
INSERT INTO phpjob_locations_en VALUES (251, 'Truk');
INSERT INTO phpjob_locations_en VALUES (169, 'Tunisia');
INSERT INTO phpjob_locations_en VALUES (170, 'Turkey');
INSERT INTO phpjob_locations_en VALUES (212, 'Turkmenistan');
INSERT INTO phpjob_locations_en VALUES (171, 'Turks and Caicos Island');
INSERT INTO phpjob_locations_en VALUES (231, 'Tuvalu');
INSERT INTO phpjob_locations_en VALUES (175, 'U.S. Virgin Islands');
INSERT INTO phpjob_locations_en VALUES (172, 'Uganda');
INSERT INTO phpjob_locations_en VALUES (173, 'Ukraine');
INSERT INTO phpjob_locations_en VALUES (252, 'Union Island');
INSERT INTO phpjob_locations_en VALUES (174, 'United Arab Emirates');
INSERT INTO phpjob_locations_en VALUES (176, 'Uruguay');
INSERT INTO phpjob_locations_en VALUES (262, 'United Kingdom');
INSERT INTO phpjob_locations_en VALUES (232, 'Uzbekistan');
INSERT INTO phpjob_locations_en VALUES (233, 'Vanuatu');
INSERT INTO phpjob_locations_en VALUES (177, 'Vatican City');
INSERT INTO phpjob_locations_en VALUES (178, 'Venezuela');
INSERT INTO phpjob_locations_en VALUES (234, 'Vietnam');
INSERT INTO phpjob_locations_en VALUES (235, 'Virgin Islands (Brit');
INSERT INTO phpjob_locations_en VALUES (236, 'Virgin Islands (U.S.');
INSERT INTO phpjob_locations_en VALUES (237, 'Wake Island');
INSERT INTO phpjob_locations_en VALUES (179, 'Wales');
INSERT INTO phpjob_locations_en VALUES (253, 'Wallis Island');
INSERT INTO phpjob_locations_en VALUES (238, 'Western Samoa');
INSERT INTO phpjob_locations_en VALUES (255, 'Yap');
INSERT INTO phpjob_locations_en VALUES (180, 'Yemen, Republic of');
INSERT INTO phpjob_locations_en VALUES (213, 'Yugoslavia');
INSERT INTO phpjob_locations_en VALUES (181, 'Zaire');
INSERT INTO phpjob_locations_en VALUES (182, 'Zambia');
INSERT INTO phpjob_locations_en VALUES (183, 'Zimbabwe');
# --------------------------------------------------------

#
# Table structure for table `phpjob_locations_ge`
#

CREATE TABLE phpjob_locations_ge (
  locationid int(4) NOT NULL auto_increment,
  location varchar(120) NOT NULL default '',
  PRIMARY KEY  (locationid),
  KEY location (location)
);

#
# Dumping data for table `phpjob_locations_ge`
#

INSERT INTO phpjob_locations_ge select * from phpjob_locations_en;
# --------------------------------------------------------

#
# Table structure for table `phpjob_locations_sp`
#

CREATE TABLE phpjob_locations_sp (
  locationid int(4) NOT NULL auto_increment,
  location varchar(120) NOT NULL default '',
  PRIMARY KEY  (locationid),
  KEY location (location)
);

#
# Dumping data for table `phpjob_locations_sp`
#

INSERT INTO phpjob_locations_sp select * from phpjob_locations_en;
# --------------------------------------------------------

#
# Table structure for table `phpjob_locations_fr`
#

CREATE TABLE phpjob_locations_fr (
  locationid int(4) NOT NULL auto_increment,
  location varchar(120) NOT NULL default '',
  PRIMARY KEY  (locationid),
  KEY location (location)
);

#
# Dumping data for table `phpjob_locations_fr`
#

INSERT INTO phpjob_locations_fr select * from phpjob_locations_en;
# --------------------------------------------------------

#
# Table structure for table `phpjob_membership`
#

CREATE TABLE phpjob_membership (
  compid int(5) NOT NULL default '0',
  pricing_id mediumint(3) NOT NULL default '0'
);

#
# Table structure for table `phpjob_persons`
#

CREATE TABLE phpjob_persons (
  persid int(5) NOT NULL auto_increment,
  email varchar(255) NOT NULL default '',
  password varchar(20) NOT NULL default '',
  name varchar(255) NOT NULL default '',
  address varchar(255) NOT NULL default '',
  city varchar(255) NOT NULL default '',
  postalcode varchar(20) NOT NULL default '',
  province varchar(255) NOT NULL default '',
  locationid int(3) NOT NULL default '0',
  phone varchar(20) NOT NULL default '',
  fax varchar(20) NOT NULL default '',
  gender char(1) NOT NULL default '',
  birthyear varchar(4) NOT NULL default '0000',
  url varchar(255) NOT NULL default '',
  hide_name char(3) NOT NULL default '',
  hide_address char(3) NOT NULL default '',
  hide_location char(3) NOT NULL default '',
  hide_phone char(3) NOT NULL default '',
  hide_email char(3) NOT NULL default '',
  signupdate date NOT NULL default '0000-00-00',
  lastlogin datetime NOT NULL default '0000-00-00 00:00:00',
  lastip varchar(50) NOT NULL default '',
  PRIMARY KEY  (persid)
);

#
# Table structure for table `phpjob_pricing_en`
#

CREATE TABLE phpjob_pricing_en (
  pricing_id mediumint(3) NOT NULL default '0',
  pricing_title varchar(255) NOT NULL default '',
  pricing_avjobs mediumint(3) NOT NULL default '0',
  pricing_avsearch mediumint(3) NOT NULL default '0',
  pricing_fjobs mediumint(3) NOT NULL default '0',
  pricing_fcompany char(3) NOT NULL default '0',
  pricing_period mediumint(2) NOT NULL default '0',
  pricing_price float(10,2) NOT NULL default '0.00',
  pricing_currency char(5) NOT NULL default '',
  pricing_default tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (pricing_id)
);

#
# Dumping data for table `phpjob_pricing_en`
#

INSERT INTO phpjob_pricing_en VALUES (1, 'Free Plan', 3, 25, 0, 'no', 3, 0, 'USD', 1);
INSERT INTO phpjob_pricing_en VALUES (2, 'Basic Plan', 5, 50, 0, 'no', 3, 50, 'USD', 0);
INSERT INTO phpjob_pricing_en VALUES (3, 'Standard Plan', 7, 250, 1, 'no', 3, 75, 'USD', 0);
INSERT INTO phpjob_pricing_en VALUES (4, 'Professional Plan', 15, 999, 3, 'yes', 6, 150, 'USD', 0);
INSERT INTO phpjob_pricing_en VALUES (5, 'Ultra Plan', 999, 999, 10, 'yes', 6, 250, 'USD', 0);
INSERT INTO phpjob_pricing_en VALUES (0, 'Additional job shopping', 0, 0, 0, 'no', 0, 0, '', 0);
# --------------------------------------------------------

#
# Table structure for table `phpjob_pricing_ge`
#

CREATE TABLE phpjob_pricing_ge (
  pricing_id mediumint(3) NOT NULL default '0',
  pricing_title varchar(255) NOT NULL default '',
  pricing_avjobs mediumint(3) NOT NULL default '0',
  pricing_avsearch mediumint(3) NOT NULL default '0',
  pricing_fjobs mediumint(3) NOT NULL default '0',
  pricing_fcompany char(3) NOT NULL default '0',
  pricing_period mediumint(2) NOT NULL default '0',
  pricing_price float(10,2) NOT NULL default '0.00',
  pricing_currency char(5) NOT NULL default '',
  pricing_default tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (pricing_id)
);

#
# Dumping data for table `phpjob_pricing_ge`
#

INSERT INTO phpjob_pricing_ge select * from phpjob_pricing_en;
# --------------------------------------------------------

#
# Table structure for table `phpjob_pricing_sp`
#

CREATE TABLE phpjob_pricing_sp (
  pricing_id mediumint(3) NOT NULL default '0',
  pricing_title varchar(255) NOT NULL default '',
  pricing_avjobs mediumint(3) NOT NULL default '0',
  pricing_avsearch mediumint(3) NOT NULL default '0',
  pricing_fjobs mediumint(3) NOT NULL default '0',
  pricing_fcompany char(3) NOT NULL default '0',
  pricing_period mediumint(2) NOT NULL default '0',
  pricing_price float(10,2) NOT NULL default '0.00',
  pricing_currency char(5) NOT NULL default '',
  pricing_default tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (pricing_id)
);

#
# Dumping data for table `phpjob_pricing_sp`
#

INSERT INTO phpjob_pricing_sp select * from phpjob_pricing_en;
# --------------------------------------------------------

#
# Table structure for table `phpjob_pricing_fr`
#

CREATE TABLE phpjob_pricing_fr (
  pricing_id mediumint(3) NOT NULL default '0',
  pricing_title varchar(255) NOT NULL default '',
  pricing_avjobs mediumint(3) NOT NULL default '0',
  pricing_avsearch mediumint(3) NOT NULL default '0',
  pricing_fjobs mediumint(3) NOT NULL default '0',
  pricing_fcompany char(3) NOT NULL default '0',
  pricing_period mediumint(2) NOT NULL default '0',
  pricing_price float(10,2) NOT NULL default '0.00',
  pricing_currency char(5) NOT NULL default '',
  pricing_default tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (pricing_id)
);

#
# Dumping data for table `phpjob_pricing_fr`
#

INSERT INTO phpjob_pricing_fr select * from phpjob_pricing_en;
# --------------------------------------------------------

#
# Table structure for table `phpjob_resumemail`
#

CREATE TABLE phpjob_resumemail (
  resumemail_id int(5) NOT NULL auto_increment,
  compid int(5) NOT NULL default '0',
  resumemail_type int(3) NOT NULL default '0',
  rmail_lang varchar(40) NOT NULL default '',
  resumemail_lastdate date NOT NULL default '0000-00-00',
  PRIMARY KEY  (resumemail_id)
);

#
# Table structure for table `phpjob_resumes`
#

CREATE TABLE phpjob_resumes (
  resumeid int(5) NOT NULL auto_increment,
  persid int(5) NOT NULL default '0',
  summary varchar(100) NOT NULL default '',
  resume blob NOT NULL,
  education blob NOT NULL,
  workexperience blob NOT NULL,
  degreeid int(2) NOT NULL default '1',
  confidential char(1) NOT NULL default '',
  jobtypeids varchar(15) NOT NULL default '',
  locationids blob NOT NULL,
  jobcategoryids blob NOT NULL,
  salary varchar(20) NOT NULL default '0',
  skills blob NOT NULL,
  jobmail int(1) NOT NULL default '0',
  lastmaildate date NOT NULL default '0000-00-00',
  resumedate date NOT NULL default '0000-00-00',
  languageids varchar(50) NOT NULL default '',
  postlanguage char(1) NOT NULL default '',
  experience int(2) NOT NULL default '0',
  resume_city varchar(60) NOT NULL default '',
  resume_province varchar(60) NOT NULL default '',
  resumeexpire date NOT NULL default '0000-00-00',
  resume_cv varchar(100) NOT NULL default '',
  PRIMARY KEY  (resumeid)
);

#
# Table structure for table `phpjob_sendmail`
#

CREATE TABLE phpjob_sendmail (
  sendmailid int(5) NOT NULL auto_increment,
  persid int(5) NOT NULL default '0',
  sendmail_type enum('jobmail','resumemail') NOT NULL default 'jobmail',
  sendmail_email varchar(60) NOT NULL default '',
  sendmail_header text NOT NULL,
  sendmail_message text NOT NULL,
  sendmail_footer text NOT NULL,
  sendmail_subject text NOT NULL,
  PRIMARY KEY  (sendmailid)
);
