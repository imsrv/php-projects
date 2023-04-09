<?php

#   CaLogic Language Table
#
#
#   ENGLISH
#
#
# Remove old global language table entry

$sqlstr = "delete from ".$tabpre."_languages where name = 'English'";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

#
# Add entry to global language table
#

$sqlstr = "INSERT INTO ".$tabpre."_languages VALUES (1, 'English', 'Entered by Philip Boone')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

# --------------------------------------------------------

#
# Table structure for table `".$tabpre."_lang_English`
#

$sqlstr = "DROP TABLE IF EXISTS ".$tabpre."_lang_English";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "CREATE TABLE ".$tabpre."_lang_English (
  uid int(11) NOT NULL auto_increment,
  keyid varchar(30) NOT NULL default '',
  phrase mediumtext,
  remark varchar(254) default NULL,
  PRIMARY KEY  (uid),
  UNIQUE KEY keyid (keyid)
) TYPE=MyISAM COMMENT='A CaLogic Language Table'";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

#
# Dumping data for table `".$tabpre."_lang_English`
#

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (1, 'wdnl1', 'Monday', 'Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (2, 'wdnl2', 'Tuesday', 'Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (3, 'wdnl3', 'Wednesday', 'Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (4, 'wdnl4', 'Thursday', 'Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (5, 'wdnl5', 'Friday', 'Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (6, 'wdnl6', 'Saturday', 'Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (7, 'wdnl7', 'Sunday', 'Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (8, 'wdns1', 'Mon', 'Abbr. Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (9, 'wdns2', 'Tue', 'Abbr. Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (10, 'wdns3', 'Wed', 'Abbr. Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (11, 'wdns4', 'Thu', 'Abbr. Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (12, 'wdns5', 'Fri', 'Abbr. Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (13, 'wdns6', 'Sat', 'Abbr. Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (14, 'wdns7', 'Sun', 'Abbr. Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (15, 'mnl1', 'January', 'Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (16, 'mnl2', 'February', 'Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (17, 'mnl3', 'March', 'Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (18, 'mnl4', 'April', 'Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (19, 'mnl5', 'May', 'Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (20, 'mnl6', 'June', 'Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (21, 'mnl7', 'July', 'Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (22, 'mnl8', 'August', 'Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (23, 'mnl9', 'September', 'Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (24, 'mnl10', 'October', 'Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (25, 'mnl11', 'November', 'Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (26, 'mnl12', 'December', 'Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (27, 'mns1', 'Jan', 'Abbr. Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (28, 'mns2', 'Feb', 'Abbr. Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (29, 'mns3', 'Mar', 'Abbr. Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (30, 'mns4', 'Apr', 'Abbr. Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (31, 'mns5', 'May', 'Abbr. Abbr. Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (32, 'mns6', 'Jun', 'Abbr. Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (33, 'mns7', 'Jul', 'Abbr. Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (34, 'mns8', 'Aug', 'Abbr. Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (35, 'mns9', 'Sep', 'Abbr. Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (36, 'mns10', 'Oct', 'Abbr. Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (37, 'mns11', 'Nov', 'Abbr. Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (38, 'mns12', 'Dec', 'Abbr. Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (39, 'dnl', 'Day', 'Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (40, 'dns', 'Dy', 'Abbr. for Day, Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (41, 'wnl', 'Week', 'Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (42, 'wns', 'WK', 'Abbr. for Week, Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (43, 'mnl', 'Month', 'Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (44, 'mns', 'Mn', 'Abbr. for Month, Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (45, 'ynl', 'Year', 'Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (46, 'yns', 'Yr', 'Abbr. for Year, Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (47, 'prefl', 'Setup', 'Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (48, 'prefs', 'Prefs', 'Abbr. for Preferences, Used in the different calendar views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (49, 'butgo', 'GO', 'Button Text')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (50, 'butnew', 'New', 'Button Text')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (51, 'butedit', 'Edit', 'Button Text')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (52, 'prev', 'Previous', 'Button Text')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (53, 'next', 'Next', 'Button Text')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (54, 'allday', 'All Day', 'Used on the Week and Day views')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (55, 'events', 'Events', 'Button Text')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (56, 'event', 'Event', 'Button Text')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (57, 'nyrt', 'What? Not a registered user yet?<br>Well, you\'re just about 3 clicks away from becoming a Registered User.<br>As a Registered User you will be able to create and configure your very own Online Web Calendar.<br>', 'Used on Login Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (58, 'liw', 'Login', 'Used on Login Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (59, 'low', 'Logout', 'Button Text')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (60, 'lsel', 'Select a Language', 'Used on Login Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (61, 'pli', 'Please enter your User Name and Password', 'Used on Login Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (62, 'un', 'User Name', 'User registration Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (63, 'pw', 'Password', 'User registration Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (64, 'subut', 'Submit', 'Button Text')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (65, 'rebut', 'Reset', 'Button Text')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (66, 'rlnk', 'Click here to register.', 'Used on Login Form as a link to the registration form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (67, 'urth', 'User Registration', 'User registration Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (68, 'urfh', 'Field', 'User registration Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (69, 'ureh', 'Entry', 'User registration Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (70, 'urrh', 'Remarks', 'User registration Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (71, 'fnt', 'First Name', 'User registration Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (72, 'lnt', 'Last Name', 'User registration Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (73, 'emt', 'E-Mail', 'User registration Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (74, 'pwa', 'Password Again', 'User registration Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (75, 'llt', 'Language', 'User registration Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (76, 'ungt', 'Choose a <b> User Name</b>. You will use this to log into the Calendar. This must be a unique name and can be no longer than 10 characters. It can contain only letters and numbers, no spaces or any other special characters should be used.', 'User registration Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (77, 'fngt', 'Please enter your <b>First Name</b>', 'User registration Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (78, 'lngt', 'Please enter your <b>Last Name</b>', 'User registration Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (79, 'emgt', 'Please enter your <b> E-Mail address</b>. This must be a real address. After submitting the registration form, you will be sent a confirmation E-Mail. You must follow the link in the E-Mail in order to complete the registration process.', 'User registration Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (80, 'pwgt', 'Please enter a <b>Password</b>. Your Password will be encrypted. Blank spaces at the front and back will be trimmed.', 'User registration Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (81, 'pwagt', 'Please confirm your <b>Password</b>.', 'User registration Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (82, 'llgt', 'Please choose the <b>Language</b> you wish to use from the list of available languages.', 'User Registraton Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (83, 'rega1', 'You forgot to fill in the User Name field. Please correct it and re-submit.', 'User Registraton Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (84, 'rega2', 'You forgot to fill in the First Name field. Please correct it and re-submit.', 'User Registraton Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (85, 'rega3', 'You forgot to fill in the Last Name field. Please correct it and re-submit.', 'User Registraton Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (86, 'rega4', 'You forgot to fill in the E-Mail field. Please correct it and re-submit.', 'User Registraton Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (87, 'rega5', 'You forgot to fill in the Password field. Please correct it and re-submit.', 'User Registraton Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (88, 'rega6', 'You forgot to fill in the Password Conformation field. Please correct it and re-submit.', 'User Registraton Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (89, 'rega7', 'The Passwords don\'t match. Please correct it and re-submit.', 'User Registraton Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (90, 'emar', 'The E-Mail you entered is already in my database. Please go back and try again.', 'User Registration Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (91, 'badem', 'The E-Mail you entered doesn\'t seem to be properly formated. Please correct and try again.', 'User Registration Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (92, 'pwreg', 'Please wait while your registration gets processed....', 'User Registration Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (93, 'badun', 'The User Name you have requested, has already been taken. Please go back and choose a different one. <b>Don\'t forget, capitalization matters both with the User Name and Password!</b>', 'User Registration Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (94, 'ldbp', 'There\'s a problem with the Language Database. Please contact the Administrator', 'User Registration Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (95, 'regok', '<br><br>Thank you. <br><br>Your registration has been submitted. <br>The confirmation E-Mail has also been sent. You must follow the link in the confirmation E-Mail before you can begin using the calendar. <br><br>If you do not confirm your registration within 7 days, it will be nullified and you will have to re-register if you want to use the calendar.<br>', 'User Registration Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (96, 'pier', '<br><br>The Database has indicated an Insert Error. If the problem persists, please don\'t hesitate to contact the Administrator.<br><br>Thank You', 'User Registration Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (97, 'regconf', '<br>Welcome Back %name% <br> <br>Thank you for confirming your registration. You may now continue to the login and create yourself a Calendar.<br><br>Please inform me of any trouble you experience. If you need to, <a href=\"FAQ.php\">click here to check out the FAQ\'s</A><br><br><a href=\"%index%\">Or click here to view your Calendar!</A>', 'User Registration confirmed')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (98, 'regfu', '<br>I\'m sorry, we are unable to locate the confirmaton key you submitted. You may have waited too long. <br><br><a href=\"userreg.php\">Please click here to register.</a>', 'User Registration Confirmation Error')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (99, 'rereg', '<br>The confirmation key you submitted has already been used. <br><br><a href=\"%index%\">Please click here to login.</a>', 'User Registration Re-Confirmation Error')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (100, 'regnotconf', '<br>You have not yet confirmed your registration. Please follow the link in your confirmation E-Mail which has just been re-sent to you. The Email address you submitted is: %email% <br>If this is not your Email address, you will have to re-register to be able to use this Calendar.', 'User Registration not yet confirmed')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (101, 'wrongli', 'Invalid Login. Please try again.', 'Login failed')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (102, 'goli', '<br>You have been loged on. <A HREF=\"%s\">click here</A> if your browser does not support automatic reloading...', 'no longer needed')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (103, 'tuid', 'not used', 'not used')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (104, 'calid', 'not used', 'not used')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (105, 'calname', 'Calendar Name', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (106, 'userid', 'not used', 'not used')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (107, 'username', 'not used', 'not used')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (108, 'caltitle', 'Calendar Title', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (109, 'caltype', 'Calendar Type', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (110, 'showweek', 'Show Week Numbers', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (111, 'preferedview', 'Preferred View', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (112, 'weekstartonmonday', 'Week Starts on', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (113, 'weekselreact', 'Week Select Box React', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (114, 'daybeginhour', 'Day Starts at', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (115, 'dayendhour', 'Day Ends at', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (116, 'timetype', '12 or 24 Hour Format', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (117, 'gcbgimg', 'Enter the URL for the Back Ground Image to use through out your Calendar', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (118, 'gcprevcolor', '\"Previous\" Link Color ', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (119, 'gcprevbgcolor', '\"Previous\" Link Background Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (120, 'gcprevstyle', '\"Previous\" Link Style', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (121, 'gcnextcolor', '\"Next\" Link Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (122, 'gcnextbgcolor', '\"Next\" Link Background Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (123, 'gcnextstyle', '\"Next\" Link Style', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (124, 'mcdividerlinecolor', 'Divider Line Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (125, 'mcttcolor', 'Month Link Header Font Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (126, 'mcttbgcolor', 'Month Link Header Font Background Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (127, 'mcttstyle', 'Month Link Header Style', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (128, 'mcttcellcolor', 'Month Link Header Cell Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (129, 'mcheaderwdcolor', 'Weekday Header Font Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (130, 'mcheaderwdbgcolor', 'Weekday Header Font Background Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (131, 'mcheaderwecolor', 'Weekend Header Font Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (132, 'mcheaderwebgcolor', 'Weekend Header Font Background Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (133, 'mcwdcolor', 'Weekday Link Font Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (134, 'mcwdbgcolor', 'Weekday Link Font Background Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (135, 'mcwdstyle', 'Weekday Link Style', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (136, 'mcwdcellcolor', 'Weekday Cell Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (137, 'mcwecolor', 'Weekend Day Link Font Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (138, 'mcwebgcolor', 'Weekend Day Link Font Background Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (139, 'mcwestyle', 'Weekend Day Link Style', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (140, 'mcwecellcolor', 'Weekend Cell Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (141, 'mccdcolor', 'Current Day Link Font Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (142, 'mccdbgcolor', 'Current Day Link Font Background Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (143, 'mccdstyle', 'Current Day Link Style', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (144, 'mccdcellcolor', 'Current Day Cell Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (145, 'mcnccolor', 'Out of Month Day Link Font Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (146, 'mcncbgcolor', 'Out of Month Day Link Font Background Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (147, 'mcncstyle', 'Out of Month Day Link Style', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (148, 'mcnccellcolor', 'Out of Month Day Cell Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (149, 'yvdividerlinecolor', 'Divider Line Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (150, 'yvheadercolor', 'Header Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (151, 'yvttcolor', 'Month Link Header Font Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (152, 'yvttbgcolor', 'Month Link Header Font Background Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (153, 'yvttstyle', 'Month Link Header Style', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (154, 'yvttcellcolor', 'Month Link Header Cell Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (155, 'yvheaderwdcolor', 'Weekday Header Font Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (156, 'yvheaderwdbgcolor', 'Weekday Header Font Background Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (157, 'yvheaderwecolor', 'Weekend Header Font Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (158, 'yvheaderwebgcolor', 'Weekend Header Font Background Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (159, 'yvwdcolor', 'Weekday Link Font Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (160, 'yvwdbgcolor', 'Weekday Link Font Background Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (161, 'yvwdstyle', 'Weekday Link Style', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (162, 'yvwdcellcolor', 'Weekday Cell Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (163, 'yvwecolor', 'Weekend Day Link Font Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (164, 'yvwebgcolor', 'Weekend Day Link Font Background Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (165, 'yvwestyle', 'Weekend Day Link Style', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (166, 'yvwecellcolor', 'Weekend Cell Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (167, 'yvcdcolor', 'Current Day Link Font Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (168, 'yvcdbgcolor', 'Current Day Link Font Background Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (169, 'yvcdstyle', 'Current Day Link Style', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (170, 'yvcdcellcolor', 'Current Cell Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (171, 'yvnccellcolor', 'Out of Month Cell Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (172, 'mvdividerlinecolor', 'Divider Line Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (173, 'mvheadercolor', 'Header Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (174, 'mvheaderwdcolor', 'Header Weekday Font Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (175, 'mvheaderwdbgcolor', 'Header Weekday Cell Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (176, 'mvheaderwecolor', 'Header Weekend Font Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (177, 'mvheaderwebgcolor', 'Header Weekend Cell Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (178, 'mvwdcolor', 'Weekday Link Font Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (179, 'mvwdbgcolor', 'Weekday Link Font Background Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (180, 'mvwdstyle', 'Weekday Link Style', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (181, 'mvwdcellcolor', 'Weekday Cell Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (182, 'mvwecolor', 'Weekend Day Link Font Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (183, 'mvwebgcolor', 'Weekend Day Link Font Background Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (184, 'mvwestyle', 'Weekend Day Link Style', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (185, 'mvwecellcolor', 'Weekend Day Cell Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (186, 'mvcdcolor', 'Current Day Link Font Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (187, 'mvcdbgcolor', 'Current Day Link Font Background Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (188, 'mvcdstyle', 'Current Day Link Style', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (189, 'mvcdcellcolor', 'Current Day Cell Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (190, 'mvnccolor', 'Out of Month Day Link Font Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (191, 'mvncbgcolor', 'Out of Month Day Link Font Background Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (192, 'mvncstyle', 'Out of Month Day Link Style', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (193, 'mvnccellcolor', 'Out of Month Day Cell Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (194, 'mvwlcolor', 'Week Link Font Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (195, 'mvwlbgcolor', 'Week Link Font Background Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (196, 'mvwlstyle', 'Week Link Style', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (197, 'wvdividerlinecolor', 'Divider Line Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (198, 'wvheadercolor', 'Header Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (199, 'wvheaderwdcolor', 'Header Weekday Link Font Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (200, 'wvheaderwdbgcolor', 'Header Weekday Link Font Background Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (201, 'wvheaderwdstyle', 'Header Weekday Link Style', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (202, 'wvheaderwdcellcolor', 'Header Weekday Link Cell Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (203, 'wvheaderwecolor', 'Header Weekend Day Link Font Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (204, 'wvheaderwebgcolor', 'Header Weekend Day Link Font Background Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (205, 'wvheaderwestyle', 'Header Weekend Day Link Style', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (206, 'wvheaderwecellcolor', 'Header Weekend Day Link Cell Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (207, 'wvheadercdcolor', 'Header Current Day Link Font Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (208, 'wvheadercdbgcolor', 'Header Current Day Link Font Background Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (209, 'wvheadercdstyle', 'Header Current Day Link Style', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (210, 'wvheadercdcellcolor', 'Header Current Day Link Cell Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (211, 'wvheaderadcolor', 'All Day Events Header Font Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (212, 'wvheaderadbgcolor', 'All Day Events Header Font Background Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (213, 'wvheaderadcellcolor', 'All Day Events Header Cell Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (214, 'wvawdcolor', 'not used', 'not used')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (215, 'wvawdbgcolor', 'not used', 'not used')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (216, 'wvawdcellcolor', 'All Day Events Weekday Cell Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (217, 'wvawecolor', 'not used', 'not used')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (218, 'wvawebgcolor', 'not used', 'not used')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (219, 'wvawecellcolor', 'All Day Events Weekend Cell Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (220, 'wvacdcolor', 'not used', 'not used')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (221, 'wvacdbgcolor', 'not used', 'not used')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (222, 'wvacdcellcolor', 'All Day Events Current Day Cell Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (223, 'wvwdcolor', 'not used', 'not used')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (224, 'wvwdbgcolor', 'not used', 'not used')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (225, 'wvwdcellcolor', 'Weekday Cell Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (226, 'wvwecolor', 'not used', 'not used')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (227, 'wvwebgcolor', 'not used', 'not used')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (228, 'wvwecellcolor', 'Weekend Cell Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (229, 'wvcdcolor', 'not used', 'not used')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (230, 'wvcdbgcolor', 'not used', 'not used')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (231, 'wvcdcellcolor', 'Current Day Cell Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (232, 'wvtccolor', 'Hour Font Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (233, 'wvtcbgcolor', 'Hour Font Background Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (234, 'wvtccellcolor', 'Hour Cell Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (235, 'dvdividerlinecolor', 'Divider Line Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (236, 'dvheadercolor', 'Header Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (237, 'dvadcolor', 'All Day Events Header Font Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (238, 'dvadbgcolor', 'All Day Events Header Font Background Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (239, 'dvadcellcolor', 'All Day Events Header Cell Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (240, 'dvawdcolor', 'not used', 'not used')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (241, 'dvawdbgcolor', 'not used', 'not used')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (242, 'dvawdcellcolor', 'All Day Events Weekday Cell Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (243, 'dvawecolor', 'not used', 'not used')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (244, 'dvawebgcolor', 'not used', 'not used')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (245, 'dvawecellcolor', 'All Day Events Weekend Cell Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (246, 'dvacdcolor', 'not used', 'not used')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (247, 'dvacdbgcolor', 'not used', 'not used')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (248, 'dvacdcellcolor', 'All Day Events Current Day Cell Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (249, 'dvwdcolor', 'not used', 'not used')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (250, 'dvwdbgcolor', 'not used', 'not used')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (251, 'dvwdcellcolor', 'Weekday Cell Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (252, 'dvwecolor', 'not used', 'not used')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (253, 'dvwebgcolor', 'not used', 'not used')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (254, 'dvwecellcolor', 'Weekend Cell Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (255, 'dvcdcolor', 'not used', 'not used')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (256, 'dvcdbgcolor', 'not used', 'not used')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (257, 'dvcdcellcolor', 'Current Day Cell Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (258, 'dvtccolor', 'Hour Font Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (259, 'dvtcbgcolor', 'Hour Font Background Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (260, 'dvtccellcolor', 'Hour Cell Color', 'Calendar Setup Form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (261, 'gcprefcolor', 'Setup / Logoff Link Color', 'Used in all Headers')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (262, 'gcprefstyle', 'Setup / Logoff Link Style', 'Used in all Headers')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (263, 'gccssc', 'Current Setup Section Button Cell Background Color', 'Used in the setup to highlight the current section button')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (264, 'alcn', 'The Calendar Name must not be blank.', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (265, 'alct', 'The Calendar Title must not be blank.', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (266, 'alts', 'The Day Begin Time cannot be higher than the Day End Time.', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (267, 'alncc', 'Do you really want to create a new Calendar styled like', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (268, 'calword', 'Calendar', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (269, 'aldel1', 'Do you really want to delete the', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (270, 'aldel2', 'Deleting the', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (271, 'aldel3', 'Calendar will also delete all of the events associated with it, are you sure?', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (272, 'funcan', 'Function canceled', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (273, 'scgbut', 'General', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (274, 'sgcbut', 'Global', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (275, 'smcbut', 'Mini Calendar', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (276, 'syvbut', 'Year View', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (277, 'smvbut', 'Month View', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (278, 'swvbut', 'Week View', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (279, 'sdvbut', 'Day View', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (280, 'srvbut', 'Rights', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (281, 'ssvbut', 'Subscriptions', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (282, 'scabut', 'Categories', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (283, 'mycword', 'My Calendars:', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (284, 'opcalword', 'Other (Open / Public) Calendars:', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (285, 'butadd', 'Add', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (286, 'butdel', 'Delete', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (287, 'fcalname', 'This is the name of your Calendar. It must be unique among the names of your Calendars. Enter up to 50 characters.', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (288, 'fcaltitle', 'The Calendar Title shows up on each view.', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (289, 'fcaltype', 'There are three types of Calendars, some of which may be disabled by the Site Admin.<br><b>Open</b>: Any user / group may view and or add / delete entries. Any user / group may subscribe to Open Calendars.<br><b>Public</b>: Any user / group may view and or subscribe to this type of Calendar, but only those users / groups specified by you may add / delete entries.<br><b>Private</b>: You must specify what each user may do. View, Add, Delete, and Subscribe rights are all set individually for each user.', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (290, 'fshowweek', 'Select Yes if you would like to see the Week Numbers in the Month View.', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (291, 'fpreview', 'Select your Preferred View. This view is used as your starting view.', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (292, 'fmondays', 'Mondays', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (293, 'fsundays', 'Sundays', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (294, 'fwson', 'Choose whether you want your Calendar to begin on Mondays or Sundays.', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (295, 'wfyes', 'Yes', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (296, 'wfno', 'No', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (297, 'wftype1', 'Type1', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (298, 'wftype2', 'Type2', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (299, 'ftype', '<b>Type1</b>: The Week Selection Box will pre-select the Current Week, if it is within three months of the actual viewed date, otherwise the first week of the Month viewed will be pre-selected.<br><b>Type 2</b>: The first week of the Month viewed will always be preselected.', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (300, 'ftimetype', 'Select whether you want the 24 hour display or the 12 hour with am and pm.', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (301, 'wf12', '12 Hour', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (302, 'wf24', '24 Hour', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (303, 'fdayst', 'Select the Start Hour for the Week and Day Views', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (304, 'fdayen', 'Select the End Hour for the Week and Day Views.', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (305, 'ffcaltxt', '<b>You must complete this initial setup form before continuing.</b>', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (306, 'butsavech', 'Save Changes', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (307, 'butpv', 'Previous Values', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (308, 'butgoc', 'Go to Calendar', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (309, 'fnword', 'none', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (310, 'funword', 'underline', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (311, 'folword', 'overline', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (312, 'fstword', 'line through', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (313, 'funolword', 'underline and overline', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (314, 'edlt1', 'Editing the ', 'Language Editor')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (315, 'edltt', 'Language Table', 'Language Editor')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (316, 'keyidt', 'KEYID (cannot be changed)', 'Language Editor')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (317, 'pht', 'Phrase (HTML allowed)', 'Language Editor')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (318, 'leaved', 'Leave Editor Without Saving Changes', 'Language Editor')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (319, 'descword', 'Description', 'Language Editor')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (320, 'edlang', 'Edit Language:', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (321, 'mkst', 'Make Standard', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (322, 'entry', 'Entry', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (323, 'opcw', 'Open', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (324, 'pucw', 'Public', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (325, 'prcw', 'Private', 'Setup Area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (326, 'userlo', 'You have been Logged Off', 'Logon Screen')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (327, 'linff', 'The User Name cannot be blank.', 'Logon Screen')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (328, 'lipff', 'The Password cannot be blank.', 'Logon Screen')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (329, 'endwelc', 'Congratulations! You have set up your first CaLogic Calendar.<br><br>The Calendar has been set up with the default Style, <br><a href=\"%index%?goprefs=1\">click here go to the setup</a> and design the Calendar to your liking.<br>Or <a href=\"%index%\">click here to view your Calendar.</a><br><br>You may return to the setup at any time.', 'First Cal Setup Success')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (330, 'pwsnc1', 'Saving Calendar Config', 'First Calendar Save')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (331, 'pwsnc2', 'Please wait while your Calendar', 'First Calendar Save')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (332, 'pwsnc3', 'gets saved....', 'First Calendar Save')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (333, 'pwlet', 'Saving Language', 'Language Save')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (334, 'pwles', 'Please wait while the changes get saved', 'Language Save')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (335, 'pwlec', 'Save complete.', 'Language Save')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (336, 'butgoset', 'Go to Setup', 'Language Save')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (337, 'butgoled', 'Continue Editing Selected Language', 'Language Save')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (338, 'badcalnt', 'Calendar Name Already Taken', 'Calendar Save')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (339, 'pctta', 'Please click here to try again.', 'Calendar Save')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (340, 'badcaln', 'You already have a Calendar by the name of', 'Calendar Save')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (341, 'dvdtsl', 'Daylight Saving Time is in effect on the server where CaLogic is running.', 'Day View DTS Text')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (342, 'dtss', 'DST', 'Day Light Saving Time')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (343, 'calownerword', 'Calendar Owner', 'used in the setup area')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (344, 'tzofword', 'Timezone Offset', 'used on the login form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (345, 'tztext', 'This is your Timezone Offset from GMT and is shown in hours. It is based on your computers time and country settings. The Timezone Offset is needed in order to show the correct date and time and to ensure that your reminders get sent on time.<br>If the Timezone Offset is not correct, then your computers time settings are wrong. You should not adjust the Timezone Offset, but rather correct your computers time settings.', 'used on the login form')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (346, 'mcdwecellcolor', 'Day With Event Cell Color', 'Calendar Setup')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_lang_English VALUES (347, 'yvdwecellcolor', 'Day With Event Cell Color', 'Calendar Setup')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

# --------------------------------------------------------

?>