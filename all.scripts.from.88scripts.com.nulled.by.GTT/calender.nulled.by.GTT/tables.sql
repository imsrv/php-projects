CREATE TABLE calendar_config (
  private_flag tinyint(1) NOT NULL default '0',
  queue_flag tinyint(1) NOT NULL default '0',
  html_flag tinyint(1) NOT NULL default '0',
  smily_flag tinyint(1) NOT NULL default '0',
  link_flag tinyint(1) NOT NULL default '0'
) TYPE=MyISAM;

#
# Dumping data for table `calendar_config`
#

INSERT INTO calendar_config VALUES (0, 1, 0, 0, 0);
# --------------------------------------------------------

#
# Table structure for table `calendar_user`
#


#
# Table structure for table `calendar_event`
#

CREATE TABLE calendar_event (
  event_id int(11) NOT NULL auto_increment,
  subject varchar(200) NOT NULL default '',
  detail tinytext NOT NULL,
  event_date datetime NOT NULL default '0000-00-00 00:00:00',
  event_recur tinyint(1) NOT NULL default '0',
  queue_flag tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (event_id)
) TYPE=MyISAM;



CREATE TABLE calendar_user (
  user_id int(11) NOT NULL auto_increment,
  username varchar(20) binary NOT NULL default '',
  password varchar(20) binary NOT NULL default '',
  email varchar(200) NOT NULL default '',
  fullname varchar(50) NOT NULL default '',
  user_right tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (user_id)
) TYPE=MyISAM;

#
# Dumping data for table `calendar_user`
# Replace username, password, email, and name with your own

INSERT INTO calendar_user VALUES (1, 'username', 'password', 'email@email.com', 'name', 1);