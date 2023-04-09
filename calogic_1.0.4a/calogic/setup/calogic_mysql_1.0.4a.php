<?php
# phpMyAdmin MySQL-Dump
# version 2.2.3
# http://phpwizard.net/phpMyAdmin/
# http://phpmyadmin.sourceforge.net/ (download page)
#
# Generation Time: Jun 16, 2002 at 12:37 PM
# Server version: 3.23.47
# PHP Version: 4.1.1
# --------------------------------------------------------

#
# Table structure for table `".$tabpre."_cal_event_rems`
#

$sqlstr = "DROP TABLE IF EXISTS ".$tabpre."_cal_event_rems";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "CREATE TABLE ".$tabpre."_cal_event_rems (
  remid int(11) NOT NULL auto_increment,
  calid varchar(32) NOT NULL default '',
  uid int(11) NOT NULL default '0',
  evid int(11) NOT NULL default '0',
  contyp char(1) NOT NULL default '',
  conid int(11) NOT NULL default '0',
  PRIMARY KEY  (remid)
) TYPE=MyISAM COMMENT='CaLogic Event Reminder List'";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

# --------------------------------------------------------

#
# Table structure for table `".$tabpre."_cal_events`
#

$sqlstr = "DROP TABLE IF EXISTS ".$tabpre."_cal_events";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "CREATE TABLE ".$tabpre."_cal_events (
  evid int(11) NOT NULL auto_increment,
  uid int(11) NOT NULL default '0',
  calid varchar(32) NOT NULL default '',
  title varchar(50) NOT NULL default '',
  description text NOT NULL,
  catid int(11) NOT NULL default '0',
  startday char(2) NOT NULL default '',
  startmonth char(2) NOT NULL default '',
  startyear varchar(4) NOT NULL default '',
  isallday tinyint(4) NOT NULL default '0',
  starthour char(2) NOT NULL default '',
  startmin char(2) NOT NULL default '',
  endhour char(2) NOT NULL default '',
  endmin char(2) NOT NULL default '',
  sendreminder tinyint(4) NOT NULL default '0',
  srint tinyint(4) NOT NULL default '0',
  srval int(11) NOT NULL default '0',
  iseventseries tinyint(4) NOT NULL default '0',
  estype tinyint(4) NOT NULL default '0',
  estd tinyint(4) NOT NULL default '0',
  estdint int(11) NOT NULL default '0',
  estwint int(11) NOT NULL default '0',
  estwd varchar(7) NOT NULL default '0000000',
  estm tinyint(4) NOT NULL default '0',
  estm1d char(2) NOT NULL default '',
  estm1int int(11) NOT NULL default '0',
  estm2dp int(11) NOT NULL default '0',
  estm2wd int(11) NOT NULL default '0',
  estm2int int(11) NOT NULL default '0',
  esty tinyint(4) NOT NULL default '0',
  esty1d char(2) NOT NULL default '',
  esty1m char(2) NOT NULL default '',
  esty2dp int(11) NOT NULL default '0',
  esty2wd int(11) NOT NULL default '0',
  esty2m char(2) NOT NULL default '',
  ese tinyint(4) NOT NULL default '0',
  eseaoint int(11) NOT NULL default '0',
  esed char(2) NOT NULL default '',
  esem char(2) NOT NULL default '',
  esey varchar(4) NOT NULL default '',
  endafterdate varchar(10) NOT NULL default '',
  endafterdays bigint(20) NOT NULL default '0',
  PRIMARY KEY  (evid)
) TYPE=MyISAM COMMENT='CaLogic Calendar Events Table'";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

# --------------------------------------------------------

#
# Table structure for table `".$tabpre."_cal_ini`
#

$sqlstr = "DROP TABLE IF EXISTS ".$tabpre."_cal_ini";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "CREATE TABLE ".$tabpre."_cal_ini (
  tuid int(11) NOT NULL auto_increment,
  calid varchar(32) NOT NULL default '0',
  calname varchar(50) NOT NULL default '',
  userid int(11) NOT NULL default '0',
  username varchar(10) NOT NULL default '',
  caltitle varchar(100) NOT NULL default '',
  caltype tinyint(4) NOT NULL default '0',
  showweek tinyint(4) NOT NULL default '1',
  preferedview varchar(20) NOT NULL default '',
  weekstartonmonday tinyint(4) NOT NULL default '1',
  weekselreact tinyint(4) NOT NULL default '1',
  daybeginhour varchar(5) NOT NULL default '0000',
  dayendhour varchar(5) NOT NULL default '0000',
  timetype tinyint(4) NOT NULL default '0',
  gcbgimg varchar(100) NOT NULL default '',
  gcprevcolor varchar(20) NOT NULL default '',
  gcprevbgcolor varchar(20) NOT NULL default '',
  gcprevstyle varchar(50) NOT NULL default '',
  gcnextcolor varchar(20) NOT NULL default '',
  gcnextbgcolor varchar(20) NOT NULL default '',
  gcnextstyle varchar(50) NOT NULL default '',
  gcprefcolor varchar(20) NOT NULL default '',
  gcprefstyle varchar(50) NOT NULL default '',
  gccssc varchar(20) NOT NULL default '',
  mcdividerlinecolor varchar(20) NOT NULL default '',
  mcttcolor varchar(20) NOT NULL default '',
  mcttbgcolor varchar(20) NOT NULL default '',
  mcttstyle varchar(50) NOT NULL default '',
  mcttcellcolor varchar(20) NOT NULL default '',
  mcheaderwdcolor varchar(20) NOT NULL default '',
  mcheaderwdbgcolor varchar(20) NOT NULL default '',
  mcheaderwecolor varchar(20) NOT NULL default '',
  mcheaderwebgcolor varchar(20) NOT NULL default '',
  mcwdcolor varchar(20) NOT NULL default '',
  mcwdbgcolor varchar(20) NOT NULL default '',
  mcwdstyle varchar(50) NOT NULL default '',
  mcwdcellcolor varchar(20) NOT NULL default '',
  mcwecolor varchar(20) NOT NULL default '',
  mcwebgcolor varchar(20) NOT NULL default '',
  mcwestyle varchar(50) NOT NULL default '',
  mcwecellcolor varchar(20) NOT NULL default '',
  mccdcolor varchar(20) NOT NULL default '',
  mccdbgcolor varchar(20) NOT NULL default '',
  mccdstyle varchar(50) NOT NULL default '',
  mccdcellcolor varchar(20) NOT NULL default '',
  mcnccolor varchar(20) NOT NULL default '',
  mcncbgcolor varchar(20) NOT NULL default '',
  mcncstyle varchar(50) NOT NULL default '',
  mcnccellcolor varchar(20) NOT NULL default '',
  mcdwecellcolor varchar(20) NOT NULL default '',
  yvdividerlinecolor varchar(20) NOT NULL default '',
  yvheadercolor varchar(20) NOT NULL default '',
  yvttcolor varchar(20) NOT NULL default '',
  yvttbgcolor varchar(20) NOT NULL default '',
  yvttstyle varchar(50) NOT NULL default '',
  yvttcellcolor varchar(20) NOT NULL default '',
  yvheaderwdcolor varchar(20) NOT NULL default '',
  yvheaderwdbgcolor varchar(20) NOT NULL default '',
  yvheaderwecolor varchar(20) NOT NULL default '',
  yvheaderwebgcolor varchar(20) NOT NULL default '',
  yvwdcolor varchar(20) NOT NULL default '',
  yvwdbgcolor varchar(20) NOT NULL default '',
  yvwdstyle varchar(50) NOT NULL default '',
  yvwdcellcolor varchar(20) NOT NULL default '',
  yvwecolor varchar(20) NOT NULL default '',
  yvwebgcolor varchar(20) NOT NULL default '',
  yvwestyle varchar(50) NOT NULL default '',
  yvwecellcolor varchar(20) NOT NULL default '',
  yvcdcolor varchar(20) NOT NULL default '',
  yvcdbgcolor varchar(20) NOT NULL default '',
  yvcdstyle varchar(50) NOT NULL default '',
  yvcdcellcolor varchar(20) NOT NULL default '',
  yvnccellcolor varchar(20) NOT NULL default '',
  yvdwecellcolor varchar(20) NOT NULL default '',
  mvdividerlinecolor varchar(20) NOT NULL default '',
  mvheadercolor varchar(20) NOT NULL default '',
  mvheaderwdcolor varchar(20) NOT NULL default '',
  mvheaderwdbgcolor varchar(20) NOT NULL default '',
  mvheaderwecolor varchar(20) NOT NULL default '',
  mvheaderwebgcolor varchar(20) NOT NULL default '',
  mvwdcolor varchar(20) NOT NULL default '',
  mvwdbgcolor varchar(20) NOT NULL default '',
  mvwdstyle varchar(50) NOT NULL default '',
  mvwdcellcolor varchar(20) NOT NULL default '',
  mvwecolor varchar(20) NOT NULL default '',
  mvwebgcolor varchar(20) NOT NULL default '',
  mvwestyle varchar(50) NOT NULL default '',
  mvwecellcolor varchar(20) NOT NULL default '',
  mvcdcolor varchar(20) NOT NULL default '',
  mvcdbgcolor varchar(20) NOT NULL default '',
  mvcdstyle varchar(50) NOT NULL default '',
  mvcdcellcolor varchar(20) NOT NULL default '',
  mvnccolor varchar(20) NOT NULL default '',
  mvncbgcolor varchar(20) NOT NULL default '',
  mvncstyle varchar(50) NOT NULL default '',
  mvnccellcolor varchar(20) NOT NULL default '',
  mvwlcolor varchar(20) NOT NULL default '',
  mvwlbgcolor varchar(20) NOT NULL default '',
  mvwlstyle varchar(50) NOT NULL default '',
  wvdividerlinecolor varchar(20) NOT NULL default '',
  wvheadercolor varchar(20) NOT NULL default '',
  wvheaderwdcolor varchar(20) NOT NULL default '',
  wvheaderwdbgcolor varchar(20) NOT NULL default '',
  wvheaderwdstyle varchar(50) NOT NULL default '',
  wvheaderwdcellcolor varchar(20) NOT NULL default '',
  wvheaderwecolor varchar(20) NOT NULL default '',
  wvheaderwebgcolor varchar(20) NOT NULL default '',
  wvheaderwestyle varchar(50) NOT NULL default '',
  wvheaderwecellcolor varchar(20) NOT NULL default '',
  wvheadercdcolor varchar(20) NOT NULL default '',
  wvheadercdbgcolor varchar(20) NOT NULL default '',
  wvheadercdstyle varchar(50) NOT NULL default '',
  wvheadercdcellcolor varchar(20) NOT NULL default '',
  wvheaderadcolor varchar(20) NOT NULL default '',
  wvheaderadbgcolor varchar(20) NOT NULL default '',
  wvheaderadcellcolor varchar(20) NOT NULL default '',
  wvawdcolor varchar(20) NOT NULL default '',
  wvawdbgcolor varchar(20) NOT NULL default '',
  wvawdcellcolor varchar(20) NOT NULL default '',
  wvawecolor varchar(20) NOT NULL default '',
  wvawebgcolor varchar(20) NOT NULL default '',
  wvawecellcolor varchar(20) NOT NULL default '',
  wvacdcolor varchar(20) NOT NULL default '',
  wvacdbgcolor varchar(20) NOT NULL default '',
  wvacdcellcolor varchar(20) NOT NULL default '',
  wvwdcolor varchar(20) NOT NULL default '',
  wvwdbgcolor varchar(20) NOT NULL default '',
  wvwdcellcolor varchar(20) NOT NULL default '',
  wvwecolor varchar(20) NOT NULL default '',
  wvwebgcolor varchar(20) NOT NULL default '',
  wvwecellcolor varchar(20) NOT NULL default '',
  wvcdcolor varchar(20) NOT NULL default '',
  wvcdbgcolor varchar(20) NOT NULL default '',
  wvcdcellcolor varchar(20) NOT NULL default '',
  wvtccolor varchar(20) NOT NULL default '',
  wvtcbgcolor varchar(20) NOT NULL default '',
  wvtccellcolor varchar(20) NOT NULL default '',
  dvdividerlinecolor varchar(20) NOT NULL default '',
  dvheadercolor varchar(20) NOT NULL default '',
  dvadcolor varchar(20) NOT NULL default '',
  dvadbgcolor varchar(20) NOT NULL default '',
  dvadcellcolor varchar(20) NOT NULL default '',
  dvawdcolor varchar(20) NOT NULL default '',
  dvawdbgcolor varchar(20) NOT NULL default '',
  dvawdcellcolor varchar(20) NOT NULL default '',
  dvawecolor varchar(20) NOT NULL default '',
  dvawebgcolor varchar(20) NOT NULL default '',
  dvawecellcolor varchar(20) NOT NULL default '',
  dvacdcolor varchar(20) NOT NULL default '',
  dvacdbgcolor varchar(20) NOT NULL default '',
  dvacdcellcolor varchar(20) NOT NULL default '',
  dvwdcolor varchar(20) NOT NULL default '',
  dvwdbgcolor varchar(20) NOT NULL default '',
  dvwdcellcolor varchar(20) NOT NULL default '',
  dvwecolor varchar(20) NOT NULL default '',
  dvwebgcolor varchar(20) NOT NULL default '',
  dvwecellcolor varchar(20) NOT NULL default '',
  dvcdcolor varchar(20) NOT NULL default '',
  dvcdbgcolor varchar(20) NOT NULL default '',
  dvcdcellcolor varchar(20) NOT NULL default '',
  dvtccolor varchar(20) NOT NULL default '',
  dvtcbgcolor varchar(20) NOT NULL default '',
  dvtccellcolor varchar(20) NOT NULL default '',
  PRIMARY KEY  (tuid),
  KEY calid (calid),
  KEY calname (calname),
  KEY userid (userid),
  KEY username (username)
) TYPE=MyISAM COMMENT='CaLogic Calendar Configuration Table'";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

#
# Dumping data for table `".$tabpre."_cal_ini`
#

$sqlstr = "INSERT INTO ".$tabpre."_cal_ini VALUES (1, '0', 'Default', 0, 'Default', 'Default', 0, 1, 'Month', 1, 1, '0000', '0000', 1, './img/stonbk.jpg', '#0000FF', '', 'underline', '#0000FF', '', 'underline', '#0000FF', 'underline', '#FFFF80', '#000000', '#B04040', '#FFFFFF', 'none', '#FFFFFF', '#FF0000', '#80FFFF', '#0000FF', '#FFFF80', '#000000', '#C0C0C0', 'none', '#C0C0C0', '#000000', '#808080', 'none', '#808080', '#0000FF', '#FFFF80', 'none', '#FFFF80', '#000000', '#FFFFFF', 'none', '#FFFFFF', 'Lightpink', '#000000', '#000000', '#B04040', '#FFFFFF', 'none', '#FFFFFF', '#FF0000', '#80FFFF', '#0000FF', '#FFFF80', '#000000', '#C0C0C0', 'none', '#C0C0C0', '#000000', '#808080', 'none', '#808080', '#0000FF', '#FFFF80', 'none', '#FFFF80', '#FFFFFF', 'Lightpink', '#000000', '#000000', '#FF0000', '#80FFFF', '#0000FF', '#FFFF80', '#000000', '#C0C0C0', 'none', '#C0C0C0', '#000000', '#808080', 'none', '#808080', '#0000FF', '#FFFF80', 'none', '#FFFF80', '#000000', '#FFFFFF', 'none', '#FFFFFF', '#B04040', '', 'none', '#000000', '#000000', '#FF0000', '#80FFFF', 'none', '#80FFFF', '#0000FF', '#FFFF80', 'none', '#FFFF80', '#0000FF', '#FFFF80', 'none', '#FFFF80', '#000000', '#008000', '#008000', '#000000', '#C0C0C0', '#C0C0C0', '#000000', '#808080', '#808080', '#000000', '#FFFF80', '#FFFF80', '#000000', '#C0C0C0', '#C0C0C0', '#000000', '#808080', '#808080', '#000000', '#FFFF80', '#FFFF80', '#000000', '#FFFFFF', '#FFFFFF', '#000000', '#000000', '#000000', '#008000', '#008000', '#000000', '#008000', '#008000', '#000000', '#008000', '#008000', '#000000', '#008000', '#008000', '#000000', '#C0C0C0', '#C0C0C0', '#000000', '#808080', '#808080', '#000000', '#FFFF80', '#FFFF80', '#000000', '#FFFFFF', '#FFFFFF')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

# --------------------------------------------------------

#
# Table structure for table `".$tabpre."_languages`
#
#
# Global Languages table
# The Actual Language entry is added with the laguage file.
#

$sqlstr = "DROP TABLE IF EXISTS ".$tabpre."_languages";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "CREATE TABLE ".$tabpre."_languages (
  uid int(10) unsigned NOT NULL auto_increment,
  name varchar(20) NOT NULL default '',
  remark varchar(50) default NULL,
  PRIMARY KEY  (uid),
  UNIQUE KEY name (name),
  KEY name_2 (name)
) TYPE=MyISAM COMMENT='CaLogic Languages table'";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);



#
# Table structure for table `".$tabpre."_rem_log`
#

$sqlstr = "DROP TABLE IF EXISTS ".$tabpre."_rem_log";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "CREATE TABLE ".$tabpre."_rem_log (
  logid int(11) NOT NULL auto_increment,
  calid varchar(32) NOT NULL default '',
  evid int(11) NOT NULL default '0',
  chk_date varchar(10) NOT NULL default '0000-00-00',
  ev_date varchar(10) NOT NULL default '0000-00-00',
  PRIMARY KEY  (logid)
) TYPE=MyISAM COMMENT='CaLogic Event Reminder Log'";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

# --------------------------------------------------------


#
# Table structure for table `".$tabpre."_user_cat`
#

$sqlstr = "DROP TABLE IF EXISTS ".$tabpre."_user_cat";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "CREATE TABLE ".$tabpre."_user_cat (
  catid int(11) NOT NULL auto_increment,
  uid int(11) NOT NULL default '0',
  calid varchar(32) NOT NULL default '0',
  catname varchar(20) NOT NULL default '',
  catcolortext varchar(20) NOT NULL default '',
  catcolorbg varchar(20) NOT NULL default '',
  PRIMARY KEY  (catid),
  KEY uid (uid),
  KEY calid (calid)
) TYPE=MyISAM COMMENT='CaLogic User Categories'";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

# --------------------------------------------------------

#
# Table structure for table `".$tabpre."_user_con`
#

$sqlstr = "DROP TABLE IF EXISTS ".$tabpre."_user_con";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "CREATE TABLE ".$tabpre."_user_con (
  conid int(11) NOT NULL auto_increment,
  uid int(11) NOT NULL default '0',
  congp int(11) NOT NULL default '0',
  fname varchar(30) NOT NULL default '',
  lname varchar(30) NOT NULL default '',
  email varchar(50) NOT NULL default '',
  bday varchar(10) NOT NULL default '',
  tzos int(11) NOT NULL default '0',
  tel1 varchar(20) NOT NULL default '',
  tel2 varchar(20) NOT NULL default '',
  tel3 varchar(20) NOT NULL default '',
  fax varchar(20) NOT NULL default '',
  address text NOT NULL,
  PRIMARY KEY  (conid),
  KEY uid (uid)
) TYPE=MyISAM COMMENT='CaLogic User Contacts Table'";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

# --------------------------------------------------------

#
# Table structure for table `".$tabpre."_user_con_grp`
#

$sqlstr = "DROP TABLE IF EXISTS ".$tabpre."_user_con_grp";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "CREATE TABLE ".$tabpre."_user_con_grp (
  congpid int(11) NOT NULL auto_increment,
  uid int(11) NOT NULL default '0',
  gpname varchar(20) NOT NULL default '',
  PRIMARY KEY  (congpid)
) TYPE=MyISAM COMMENT='CaLogic User Contact Groups'";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

# --------------------------------------------------------

#
# Table structure for table `".$tabpre."_user_reg`
#

$sqlstr = "DROP TABLE IF EXISTS ".$tabpre."_user_reg";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "CREATE TABLE ".$tabpre."_user_reg (
  uid int(10) unsigned NOT NULL auto_increment,
  uname varchar(10) NOT NULL default '',
  fname varchar(20) NOT NULL default '',
  lname varchar(20) NOT NULL default '',
  email varchar(50) NOT NULL default '',
  isadmin tinyint(1) NOT NULL default '0',
  pw varchar(32) NOT NULL default '',
  newpw varchar(32) default NULL,
  emok tinyint(4) NOT NULL default '0',
  langid int(11) NOT NULL default '0',
  language varchar(20) NOT NULL default '',
  startcalid varchar(32) NOT NULL default '0',
  startcalname varchar(50) NOT NULL default '',
  tzos int(11) NOT NULL default '0',
  regtime int(11) NOT NULL default '0',
  conftime int(11) NOT NULL default '0',
  regkey varchar(32) NOT NULL default '',
  session varchar(32) NOT NULL default '',
  cookie varchar(32) NOT NULL default '',
  PRIMARY KEY  (uid),
  KEY langid (langid),
  KEY language (language),
  KEY uname (uname),
  KEY email (email)
) TYPE=MyISAM COMMENT='CaLogic User Registration Table'";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

# --------------------------------------------------------
?>