<html>
<head>
<title>Seir Anphin Installer</title>
<style type="text/css">
A:hover {
 color: #0000a0;
 text-decoration: underline;
}
A:link {
 text-decoration: underline;
}
A:visited {
 text-decoration: underline;
}
td.cell {
 background-color: #c0c0c0;
 padding: 3px;
}
table {
 background-color: #808080;
}
</style>
</head>
<body text="#000000" bgcolor="#e0e0e0" link="#000000" vlink="#000000">
<br>
<font face="tahoma" size="-0"><b>Seir Anphin v1.1.1 Beta Installer</b></font><br><br>
<font size="-1" face="arial">
<br><br><br>
<?php

$install=1;
$installname=$PHP_SELF;

include './lib/config.php';

if ($dbuser=='' || $dbpass=='' || $dbname=='') {
	echo "You have not specified the database connectivity info in the configuration file. Seir Anphin cannot be installed until you do.";
	exit();
}

$dbconnect=mysql_connect($dbhost, $dbuser, $dbpass);
if (!$dbconnect) {
	echo "<p>Unable to connect to the database server.<br>MySQL says: " . mysql_error() . "</p>";
	exit();
}
if (!mysql_select_db($dbname) ) {
	echo "<p>Unable to select the database <b>$dbname</b>.<br>MySQL says: " . mysql_error() . "</p>";
	exit();
}

$errors = array();

if (isset($HTTP_POST_VARS['action']))
	$action=$HTTP_POST_VARS['action'];

if (empty($action))
	$action=$HTTP_GET_VARS['action'];

if ($action=='')
	$action = 'form';

switch ($action) {
	case 'Empty Database':
		$sql = mysql_query("SHOW tables");
		while ($arr = mysql_fetch_array($sql)) {
			mysql_query("DROP TABLE IF EXISTS $arr[0]");
		}
		echo "
		     <br><br><br>Your database has been utterly destroyed.
				<form action=\"$installname\" method=\"post\">
				  <input type=\"submit\" name=\"action\" value=\"Create Tables\" />
				</form>
		     ";
		break;

	case 'form':
		echo '
			<center>
			<form action="'.$installname.'" method="post">
			  <table class="table" cellspacing="0" cellpadding="0"><tr><td>
			  <table width="350" cellspacing="1">
			    <tr>
			      <td colspan="2" width="100%" class="cell">
			      	<p align="justify"><font size="-1" face="arial">
			      		This script will install Seir Anphin on your web server. Seir Anphin prefers apache
			      		on any flavour of unix but will tolerate an NT server too.
			      		If you want to do a complete install and want to ensure that we\'re operating on
			      		an empty database click "Empty Database". If you\'re sure your database is already
			      		empty click "Create Tables" and if you want to upgrade from version 1.1.0 click
			      		"Update Table Structure".<br><br>
			      	</font></p>
			      </td>
			    </tr>
			      <td colspan="2" width="100%" align="center" class="cell">
    				  <input type="submit" name="action" value="Empty Database" /> <br>
    				  <input type="submit" name="action" value="Create Tables" /> <br>
    				  <input type="submit" name="action" value="Update table structure" />
			      </td>
			    </tr>
			  </table>
			</td></tr></table>
			</form>
			</center>
			 ';
		break;

	case 'Update table structure':
		// upgrade from v1.1.0
		$sql = mysql_query("SELECT * FROM arc_misc");
		$arr = mysql_fetch_array($sql);
		if (empty($arr['pageviews'])) {
			echo "It seems the database is currently running the Seir v1.1.1 table structure.
			Go back and empty the database or <a href=\"$installname?action=add_data\">click here</a>
			to try adding the default data.";
			exit();
		}

		$q[]="alter table arc_note drop noteusername";

		$q[]="alter table arc_styleset add reqtemplateset varchar(80) not null default ''";

		$q[]="alter table arc_styleset drop header, drop footer";

		$q[]="alter table arc_user add timeonline int(11) unsigned not null default '0'";

		$q[]="alter table arc_pagebit add numcomments smallint(5) unsigned not null default '0'";

		$q[]="alter table arc_misc add (
 numnotes int(10) unsigned not null default '0',
 numpolls int(10) unsigned not null default '0',
 maxquote smallint(5) unsigned not null default '1')";

 		$q[]="alter table arc_misc drop pageviews";

		$q[]="create table arc_dlcat (
 dlcatid int(10) unsigned not null auto_increment,
 name varchar(250) not null,
 description mediumtext not null,
 parentid int(10) unsigned not null default '0',
 displayorder tinyint(3) unsigned not null default '1',
 files smallint(5) unsigned not null default '0',
 primary key (dlcatid))";

		$q[]="create table arc_download (
 downloadid int(10) unsigned not null auto_increment,
 name varchar(250) not null,
 filesize varchar(30) not null,
 filepath varchar(250) not null,
 description mediumtext not null,
 catid int(10) unsigned not null default '0',
 downloads int(10) unsigned not null default '0',
 date_added int(11) unsigned not null default '0',
 primary key (downloadid))";

 		$q[]="DELETE FROM arc_wordbit WHERE wordbitname='nousersinforum'
 		OR wordbitid=51 OR wordbitid=52 OR wordbitid=160 OR wordbitid=177
 		OR wordbitid=251";

 		$q[]="ALTER TABLE arc_wordbit ADD UNIQUE (wordbitname)";

 		$q[]="DELETE FROM arc_setting WHERE settingid=171";

 		$q[]="ALTER TABLE arc_setting ADD UNIQUE (settingname)";
  		foreach ($q as $query)
  			mysql_query($query) or $errors[]=$query.'<br>'.mysql_error().'<br><br>';

  		$numerrors = count($errors);

		if ($numerrors>0) {
			echo "There were <b>$numerrors</b> errors in the table creation process.<br>Here are the errors and the queries which caused them:<br><br>";
			foreach ($errors as $val)
				echo $val;
		} else {
			echo "
				All tables have been successfully updated. Click \"Proceed\" to enter Seir's updated data.
				This will return all settings and wordbits to their default values, as well as replace the
				\"default\"template set. If you wanted to keep your default template set you should have
				read the readme.
				<br><br>
				<form action=\"$installname?action=add_data\" method=\"post\">
				  <input type=\"submit\" name=\"\" value=\"Proceed\" />
				</form>
				 ";
		}

		break;

	case 'Create Tables':

		$q[]="CREATE TABLE arc_avatar (
  avatarid smallint(5) unsigned NOT NULL auto_increment,
  avatar varchar(250) NOT NULL default '',
  PRIMARY KEY  (avatarid))";

		$q[]="CREATE TABLE arc_dlcat (
  dlcatid int(10) unsigned NOT NULL auto_increment,
  name varchar(250) NOT NULL default '',
  description mediumtext NOT NULL,
  parentid int(10) unsigned NOT NULL default '0',
  files smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (dlcatid))";

		$q[]="CREATE TABLE arc_download (
  downloadid int(10) unsigned NOT NULL auto_increment,
  name varchar(250) NOT NULL default '',
  filesize varchar(30) NOT NULL,
  filepath varchar(250) NOT NULL,
  description mediumtext NOT NULL,
  catid int(10) unsigned NOT NULL default '0',
  downloads int(10) unsigned NOT NULL default '0',
  date_added int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (downloadid))";

		$q[]="CREATE TABLE arc_event (
  eventid mediumint(8) unsigned NOT NULL auto_increment,
  title varchar(80) NOT NULL default '',
  day tinyint(2) unsigned NOT NULL default '0',
  month tinyint(2) unsigned NOT NULL default '0',
  year smallint(4) unsigned NOT NULL default '0',
  userid int(10) unsigned NOT NULL default '0',
  description text NOT NULL,
  isprivate tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (eventid))";

		$q[]="CREATE TABLE arc_faq (
  faqid int(10) unsigned NOT NULL auto_increment,
  faqq varchar(250) NOT NULL default '',
  faqa mediumtext NOT NULL,
  faqgroup varchar(80) NOT NULL default '',
  faqhits int(20) unsigned NOT NULL default '0',
  PRIMARY KEY  (faqid))";

		$q[]="CREATE TABLE arc_faqgroup (
  faqgroupid tinyint(4) unsigned NOT NULL auto_increment,
  faqgroupname varchar(80) NOT NULL default '',
  faqgrouporder tinyint(4) unsigned NOT NULL default '1',
  PRIMARY KEY  (faqgroupid),
  KEY faqgrouporder (faqgrouporder))";

		$q[]="CREATE TABLE arc_forum (
  forumid smallint(5) unsigned NOT NULL auto_increment,
  forumname varchar(100) NOT NULL default '',
  description mediumtext NOT NULL,
  parentid smallint(5) unsigned NOT NULL default '0',
  lasttopicid varchar(80) NOT NULL default '',
  lastposterid varchar(80) NOT NULL default '',
  topiccount int(10) unsigned NOT NULL default '0',
  postcount int(10) unsigned NOT NULL default '0',
  open tinyint(4) NOT NULL default '1',
  private tinyint(4) unsigned NOT NULL default '0',
  forder tinyint(4) unsigned NOT NULL default '0',
  modid int(20) unsigned NOT NULL default '0',
  modusername varchar(80) NOT NULL default '',
  showextras tinyint(4) unsigned NOT NULL default '1',
  isforum tinyint(4) unsigned NOT NULL default '1',
  forumtype tinyint(4) unsigned NOT NULL default '1',
  accesslvl int(10) unsigned NOT NULL default '1',
  lastposttime int(11) unsigned NOT NULL default '0',
  fpassword varchar(20) NOT NULL default '',
  linkurl varchar(255) NOT NULL default '',
  PRIMARY KEY  (forumid))";

		$q[]="CREATE TABLE arc_leechattempt (
  domain varchar(255) NOT NULL default '',
  fileid int(10) unsigned NOT NULL default '0')";

		$q[]="CREATE TABLE arc_log (
  logid int(20) unsigned NOT NULL auto_increment,
  logpage varchar(250) NOT NULL default '',
  logip varchar(15) NOT NULL default '10.0.0.1',
  loghostname varchar(250) NOT NULL default 'unable to deteremine',
  fielda mediumtext NOT NULL,
  fieldb mediumtext NOT NULL,
  fieldc mediumtext NOT NULL,
  PRIMARY KEY  (logid))";

		$q[]="CREATE TABLE arc_misc (
  banned_ips mediumtext NOT NULL,
  adminname varchar(80) NOT NULL default 'Administrator',
  modname varchar(80) NOT NULL default 'Moderator',
  lastuserid int(20) unsigned NOT NULL default '1',
  lastusername varchar(50) NOT NULL default 'Admin',
  setupdate int(11) unsigned NOT NULL default '0',
  numusers int(10) unsigned NOT NULL default '0',
  numtopics int(10) unsigned NOT NULL default '0',
  numposts int(10) unsigned NOT NULL default '0',
  mostusersonline mediumint(5) unsigned NOT NULL default '0',
  numnotes int(10) unsigned NOT NULL default '0',
  numpolls int(10) unsigned NOT NULL default '0',
  maxquote smallint(5) unsigned not null default '1',
  PRIMARY KEY (adminname))";

		$q[]="CREATE TABLE arc_note (
  noteid int(20) unsigned NOT NULL auto_increment,
  noteusername varchar(80) NOT NULL default '',
  noteuserid int(10) unsigned NOT NULL default '0',
  notemessage varchar(250) NOT NULL default '',
  ntimestamp int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (noteid),
  KEY noteuserid (noteuserid))";

		$q[]="CREATE TABLE arc_pagebit (
  pagebitid smallint(5) unsigned NOT NULL auto_increment,
  ptitle varchar(80) NOT NULL default '',
  pcontent text NOT NULL,
  page varchar(80) NOT NULL default '',
  porder smallint(5) default '0',
  pdate int(10) NOT NULL default '0',
  shrinekey char(3) NOT NULL default '',
  convertnewline tinyint(4) unsigned NOT NULL default '1',
  puserid int(20) unsigned NOT NULL default '1',
  numcomments smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (pagebitid),
  UNIQUE KEY pagebitid (pagebitid),
  KEY porder (porder),
  KEY shrinekey (shrinekey))";

		$q[]="CREATE TABLE arc_poll (
  pollid int(10) unsigned NOT NULL auto_increment,
  question varchar(120) NOT NULL default '',
  pvotes int(10) unsigned NOT NULL default '0',
  pollstart int(11) unsigned NOT NULL default '0',
  polldays smallint(5) NOT NULL default '1',
  pollclosed tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (pollid))";


		$q[]="CREATE TABLE arc_polla (
  pollaid int(10) unsigned NOT NULL auto_increment,
  answer varchar(250) NOT NULL default '',
  votes int(10) unsigned NOT NULL default '0',
  pollid int(10) unsigned NOT NULL default '0',
  users mediumtext NOT NULL,
  PRIMARY KEY  (pollaid))";

		$q[]="CREATE TABLE arc_post (
  postid int(10) unsigned NOT NULL auto_increment,
  parentident varchar(20) NOT NULL default '',
  parentid int(10) NOT NULL default '0',
  postuserid int(10) NOT NULL default '0',
  postusername varchar(50) NOT NULL default '',
  posttitle varchar(100) NOT NULL default '',
  postcontent text NOT NULL,
  postdate int(10) NOT NULL default '0',
  ipaddr varchar(15) NOT NULL default '',
  editusername varchar(100) NOT NULL default '',
  parseurls tinyint(3) unsigned NOT NULL default '1',
  PRIMARY KEY  (postid),
  KEY userid (postuserid),
  KEY parentid (parentid),
  KEY parentident (parentident),
  KEY postid (postid))";


		$q[]="CREATE TABLE arc_privatemsg (
  privatemsgid int(30) unsigned NOT NULL auto_increment,
  senderid int(10) unsigned NOT NULL default '0',
  recipientid int(10) unsigned NOT NULL default '0',
  msgtitle varchar(50) NOT NULL default '',
  msgcontent mediumtext NOT NULL,
  msgdate int(10) unsigned NOT NULL default '0',
  isread tinyint(4) unsigned NOT NULL default '0',
  PRIMARY KEY  (privatemsgid),
  KEY senderid (senderid),
  KEY recipientid (recipientid),
  KEY msgdate (msgdate))";

		$q[]="CREATE TABLE arc_quote (
  quoteid smallint(5) unsigned NOT NULL auto_increment,
  quote mediumtext NOT NULL,
  PRIMARY KEY  (quoteid))";

		$q[]="CREATE TABLE arc_rank (
  rankid smallint(5) unsigned NOT NULL auto_increment,
  rank varchar(80) NOT NULL default '',
  minlvl int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (rankid),
  KEY minlvl (minlvl))";

		$q[]="CREATE TABLE arc_searchwords (
  word varchar(50) default NULL,
  wid int(11) default NULL,
  tablename varchar(11) default NULL,
  KEY word (word))";

		$q[]="CREATE TABLE arc_setting (
  settingid smallint(4) unsigned NOT NULL auto_increment,
  settingname varchar(80) NOT NULL default '',
  settinggroup varchar(80) NOT NULL default '',
  settingdesc mediumtext NOT NULL,
  settingvalue mediumtext NOT NULL,
  PRIMARY KEY  (settingid),
  UNIQUE KEY settingname (settingname))";

		$q[]="CREATE TABLE arc_shrine (
  shrineid int(20) unsigned NOT NULL auto_increment,
  shrinekey char(3) NOT NULL default '',
  suserid int(20) unsigned NOT NULL default '0',
  susername varchar(50) NOT NULL default '',
  stitle varchar(80) NOT NULL default '',
  summary mediumtext NOT NULL,
  lastmodified int(11) unsigned NOT NULL default '0',
  saccesslvl int(10) unsigned NOT NULL default '1',
  shits int(30) unsigned NOT NULL default '0',
  scomments int(10) unsigned NOT NULL default '0',
  active tinyint(4) unsigned NOT NULL default '0',
  header text NOT NULL,
  footer text NOT NULL,
  pagebit text NOT NULL,
  PRIMARY KEY  (shrineid),
  KEY shrinekey (shrinekey),
  KEY suserid (suserid))";

		$q[]="CREATE TABLE arc_styleset (
  stylesetid smallint(5) unsigned NOT NULL auto_increment,
  stylesetname varchar(80) NOT NULL default '',
  headtaginsert mediumtext NOT NULL,
  bodytaginsert mediumtext NOT NULL,
  fontcolor varchar(7) NOT NULL default '#c0c0c0',
  bgcolor varchar(20) NOT NULL default '#323c58',
  linkcolor varchar(7) NOT NULL default '#818fa7',
  alinkcolor varchar(7) NOT NULL default '#f09000',
  vlinkcolor varchar(7) NOT NULL default '#818fa7',
  linkdecoration varchar(15) NOT NULL default 'none',
  linkweight varchar(7) NOT NULL default 'bold',
  linkcursor varchar(15) NOT NULL default '',
  hovercolor varchar(7) NOT NULL default '#f09000',
  hoverstyle varchar(20) NOT NULL default 'normal',
  hoverweight varchar(7) NOT NULL default 'bold',
  cursor varchar(20) NOT NULL default 'default',
  tablebgcolor varchar(7) NOT NULL default '#212b47',
  alttablebgcolor varchar(7) NOT NULL default '#525c78',
  tablebordercolor varchar(7) NOT NULL default '#525c78',
  tdbgcolor varchar(7) NOT NULL default '#212b47',
  tdheadbgcolor varchar(7) NOT NULL default '#17213d',
  tdendbgcolor varchar(7) NOT NULL default '#17213d',
  hilightcolor varchar(7) NOT NULL default '#525c78',
  shadowcolor varchar(7) NOT NULL default '#000000',
  smallfont mediumtext NOT NULL,
  normalfont mediumtext NOT NULL,
  largefont mediumtext NOT NULL,
  cs mediumtext NOT NULL,
  cn mediumtext NOT NULL,
  cl mediumtext NOT NULL,
  bodycss mediumtext NOT NULL,
  logo varchar(250) NOT NULL default 'lib/images/mikelogo.jpg',
  newtopicpath varchar(250) NOT NULL default 'lib/images/mikenewtopic.gif',
  newreplypath varchar(250) NOT NULL default 'lib/images/mikenewreply.gif',
  formwidth tinyint(3) unsigned NOT NULL default '70',
  textarea_rows tinyint(3) unsigned NOT NULL default '10',
  reqtemplateset varchar(50) NOT NULL default'',
  PRIMARY KEY  (stylesetid))";

		$q[]="CREATE TABLE arc_template (
  templateid int(6) unsigned NOT NULL auto_increment,
  templatename varchar(80) NOT NULL default '',
  templatedesc mediumtext NOT NULL,
  templatevalue text NOT NULL,
  templategroup varchar(20) NOT NULL default '',
  PRIMARY KEY  (templateid),
  KEY templatename (templatename))";

		$q[]="CREATE TABLE arc_threadicons (
  iconid int(10) unsigned NOT NULL auto_increment,
  iconpath varchar(255) NOT NULL default '',
  icontitle varchar(50) NOT NULL default '',
  PRIMARY KEY  (iconid))";

		$q[]="CREATE TABLE arc_topic (
  topicid smallint(5) unsigned NOT NULL auto_increment,
  ttitle varchar(150) NOT NULL default '',
  tdescription mediumtext NOT NULL,
  tusername varchar(50) NOT NULL default '',
  tuserid int(10) unsigned NOT NULL default '0',
  tlastposter varchar(80) NOT NULL default '',
  tforumid smallint(5) unsigned NOT NULL default '0',
  topicopen smallint(5) unsigned NOT NULL default '1',
  treplies smallint(5) unsigned NOT NULL default '0',
  topichits int(20) unsigned NOT NULL default '0',
  topicdate int(10) unsigned NOT NULL default '0',
  tlastposterid int(10) NOT NULL default '0',
  pollid int(10) unsigned NOT NULL default '0',
  ispinned tinyint(3) unsigned NOT NULL default '0',
  isclosed tinyint(3) unsigned NOT NULL default '0',
  topicicon varchar(250) NOT NULL default 'lib/images/default.gif',
  PRIMARY KEY  (topicid),
  UNIQUE KEY topicid (topicid),
  KEY ttitle (ttitle),
  KEY tforumid (tforumid))";

		$q[]="CREATE TABLE arc_user (
  userid int(10) unsigned NOT NULL auto_increment,
  username varchar(50) NOT NULL default '',
  rank varchar(50) NOT NULL default '',
  password varchar(80) NOT NULL default '',
  avatar varchar(250) NOT NULL default '',
  exp int(30) unsigned NOT NULL default '0',
  level int(5) unsigned NOT NULL default '1',
  hp int(10) unsigned NOT NULL default '20',
  mp int(10) unsigned NOT NULL default '5',
  email varchar(80) NOT NULL default '',
  homepage varchar(100) NOT NULL default '',
  occupation varchar(80) NOT NULL default '',
  biography mediumtext NOT NULL,
  post_header mediumtext NOT NULL,
  post_footer mediumtext NOT NULL,
  usertext varchar(50) NOT NULL default '',
  reg_date int(11) unsigned NOT NULL default '0',
  post_count int(10) unsigned NOT NULL default '0',
  last_post int(10) unsigned NOT NULL default '0',
  user_ip varchar(15) NOT NULL default '0',
  last_page varchar(80) NOT NULL default '',
  last_active int(10) unsigned NOT NULL default '0',
  note_count int(10) NOT NULL default '0',
  showonlineusers tinyint(4) unsigned NOT NULL default '1',
  shownotes tinyint(4) unsigned NOT NULL default '1',
  showquotes tinyint(4) unsigned NOT NULL default '1',
  colorset varchar(80) NOT NULL default '1',
  layout varchar(80) NOT NULL default 'default',
  lastpostid int(20) unsigned NOT NULL default '0',
  lastnoteid int(20) unsigned NOT NULL default '0',
  lastpostdate int(10) unsigned NOT NULL default '0',
  timeoffset char(3) NOT NULL default '0',
  lastnotetime int(10) unsigned NOT NULL default '0',
  profilehits int(10) unsigned NOT NULL default '0',
  topics int(5) unsigned NOT NULL default '0',
  location varchar(50) NOT NULL default '',
  caneditprofile tinyint(3) unsigned NOT NULL default '1',
  isbanned tinyint(3) unsigned NOT NULL default '0',
  displayname varchar(80) NOT NULL default '',
  notepad mediumtext NOT NULL,
  viewposttemps tinyint(3) unsigned NOT NULL default '1',
  showquickreply tinyint(3) unsigned NOT NULL default '1',
  access tinyint(3) unsigned NOT NULL default '1',
  lastread int(11) unsigned NOT NULL default '0',
  bday_day tinyint(3) unsigned NOT NULL default '1',
  bday_month tinyint(3) unsigned NOT NULL default '1',
  bday_year smallint(5) unsigned NOT NULL default '1969',
  timeonline int(11) unsigned not null default '0',
  PRIMARY KEY  (userid),
  KEY last_page (last_page),
  KEY last_active (last_active))";

		$q[]="CREATE TABLE arc_visitor (
  visitorid int(10) unsigned NOT NULL auto_increment,
  visitorip varchar(15) NOT NULL default '10.0.0.1',
  visitorhost varchar(120) NOT NULL default 'server doesn''t know',
  visitorlastpage varchar(80) NOT NULL default '',
  visitortimestamp varchar(40) NOT NULL default '',
  PRIMARY KEY  (visitorid))";

		$q[]="CREATE TABLE arc_wordbit (
  wordbitid int(4) unsigned NOT NULL auto_increment,
  wordbitname varchar(30) NOT NULL,
  wordbitvalue mediumtext NOT NULL,
  wordbitgroup varchar(80) NOT NULL default '',
  PRIMARY KEY  (wordbitid),
  UNIQUE KEY wordbitname_2 (wordbitname))";


  		foreach ($q as $query)
  			mysql_query($query) or $errors[]=$query.'<br>'.mysql_error().'<br><br>';

  		$numerrors = count($errors);

		if ($numerrors>0) {
			echo "There were <b>$numerrors</b> errors in the table creation process.<br>Here are the errors and the queries which caused them:<br><br>";
			foreach ($errors as $val)
				echo $val;
		} else {
			echo "
				All tables have been successfully created.
				<br><br>
				<form action=\"$installname?action=add_data\" method=\"post\">
				  <input type=\"submit\" name=\"\" value=\"Click here to add the default data\" />
				</form>
				 ";
		}
		break;

	case 'add_data':
		if (isset($HTTP_SERVER_VARS['HTTP_HOST'])) {
			$webroot="http://$HTTP_SERVER_VARS[HTTP_HOST]";
		} else {
			$webroot='';
		}
		$q[]="INSERT INTO arc_forum SET forumname='Default Category', parentid=0, forder=1, isforum=0, forumtype=1, accesslvl=1";
		$q[]="INSERT INTO arc_forum SET forumname='Default Forum', parentid=1, forder=1, isforum=1, forumtype=1, accesslvl=1";
		$q[]="REPLACE arc_misc VALUES ('', 'Administrator', 'Moderator', 1, 'Admin', ".time().", 1, 0, 0, 1, 0, 0, 1)";
		$q[]="REPLACE arc_quote VALUES (1,'No quotes have been added to the database, to get rid of this message, either replace it with something funny by going to \"Random Quotes\" in the control panel or changing the setting \"doquotes\".')";
		$q[]="REPLACE arc_rank VALUES (1,'Guest','')";
		$q[]="REPLACE arc_rank VALUES (2,'Weak Little Newbie',1)";
		$q[]="REPLACE arc_rank VALUES (3,'Livestock',2)";
		$q[]="REPLACE arc_rank VALUES (4,'Mobile Sprout',3)";
		$q[]="REPLACE arc_rank VALUES (5,'Almost Somebody',4)";
		$q[]="REPLACE arc_rank VALUES (6,'Rookie',5)";
		$q[]="REPLACE arc_rank VALUES (7,'Indentured Servant',6)";
		$q[]="REPLACE arc_rank VALUES (8,'Animated Doorstop',7)";
		$q[]="REPLACE arc_rank VALUES (9,'Human Capital',8)";
		$q[]="REPLACE arc_rank VALUES (10,'Accounting Zombie',9)";
		$q[]="REPLACE arc_rank VALUES (11,'Middle-Management',10)";
		$q[]="REPLACE arc_rank VALUES (12,'Egret Peasant',11)";
		$q[]="REPLACE arc_rank VALUES (13,'Potted Plant',12)";
		$q[]="REPLACE arc_rank VALUES (14,'Random Demeaning Phrase',13)";
		$q[]="REPLACE arc_setting VALUES (2, 'doquotes', 'performance', 'Display a random quote each time page loads.', '0')";
		$q[]="REPLACE arc_setting VALUES (4, 'topic_limit', 'limit', 'Number of items to display per page in topic lists.', '30')";
		$q[]="REPLACE arc_setting VALUES (3, 'logging_enabled', 'performance', 'Build visitor database', '1')";
		$q[]="REPLACE arc_setting VALUES (36, 'gzcompress', 'performance', 'Enable GZIP Compression (10-15% faster page loads)', '1')";
		$q[]="REPLACE arc_setting VALUES (5, 'useavatars', 'display', 'Gives user option have avatar displayed beside every post.', '1')";
		$q[]="REPLACE arc_setting VALUES (1, 'postextras', 'display', 'Displays user selected html-enabled post header and footer profile fields before and after each post.', '1')";
		$q[]="REPLACE arc_setting VALUES (6, 'memberlist_limit', 'limit', 'Number of items to display per page in the memberlist.', '50')";
		$q[]="REPLACE arc_setting VALUES (7, 'post_limit', 'limit', 'Number of items to display per page in post lists.', '20')";
		$q[]="REPLACE arc_setting VALUES (8, 'template_limit', 'limit', 'Number of items to display per page in template lists.', '14')";
		$q[]="REPLACE arc_setting VALUES (9, 'category_limit', 'limit', 'Number of items to display per page in the category lists.', '10')";
		$q[]="REPLACE arc_setting VALUES (10, 'forum_limit', 'limit', 'Number of items to display per page in forum lists.', '15')";
		$q[]="REPLACE arc_setting VALUES (11, 'pagebit_limit', 'limit', 'Number of items to display per page in pagebit lists.', '15')";
		$q[]="REPLACE arc_setting VALUES (12, 'webroot', 'config', 'The HTTP path to the directory you installed Endust.', '$webroot')";
		$q[]="REPLACE arc_setting VALUES (13, 'sitename', 'config', 'The name of your site', 'Seir Anphin')";
		$q[]="REPLACE arc_setting VALUES (15, 'setting_limit', 'limit', 'Number of Settings to be displayed in setting lists', '15')";
		$q[]="REPLACE arc_setting VALUES (33, 'wordbit_limit', 'limit', 'Number of items to be displayed per page in wordbit lists.', '15')";
		$q[]="REPLACE arc_setting VALUES (17, 'faq_limit', 'limit', 'The number of FAQ items to be displayed per page in FAQ lists.', '25')";
		$q[]="REPLACE arc_setting VALUES (74, 'note_min_exp', 'user', 'Minimum experience points gained for posting a note.', '3')";
		$q[]="REPLACE arc_setting VALUES (71, 'showtotalstats', 'performance', 'If set to 1, then the topics counters for forums will reflect the total numbers since the beginning of your installation. If set to 0 they will be counted on every page load so the results are always accurate.', '')";
		$q[]="REPLACE arc_setting VALUES (70, 'reviewoldestfirst', 'display', 'Display posts oldest first in topic review.', '')";
		$q[]="REPLACE arc_setting VALUES (69, 'adminemail', 'config', 'Administrators contact email address.', 'wdyl@hush.com')";
		$q[]="REPLACE arc_setting VALUES (27, 'guestbook_limit', 'limit', 'Number of items to be displayed per page in the Guestbook.', '15')";
		$q[]="REPLACE arc_setting VALUES (28, 'users_online', 'style', 'Who\'s Online Box HTML', '<table><tr><td>Whose Online?</td></tr></table>')";
		$q[]="REPLACE arc_setting VALUES (29, 'display_online_users', 'performance', 'Display Online Users Table', '')";
		$q[]="REPLACE arc_setting VALUES (30, 'quote_limit', 'limit', 'Number of items to be displayed per page in quote lists.', '12')";
		$q[]="REPLACE arc_setting VALUES (87, 'newuserrestricted', 'user', 'If set to 1 new users will be restricted (can\'t read-banned) until approved by an Administrator.', '')";
		$q[]="REPLACE arc_setting VALUES (32, 'styleset_limit', 'limit', 'Number of items to be displayed per page in styleset lists.', '14')";
		$q[]="REPLACE arc_setting VALUES (35, 'avatar_limit', 'limit', 'Number of items to be displayed per page in avatar lists.', '30')";
		$q[]="REPLACE arc_setting VALUES (37, 'user_limit', 'limit', 'Number of items to be displayed per page in user lists.', '100')";
		$q[]="REPLACE arc_setting VALUES (38, 'rank_limit', 'limit', 'Number of items to be displayed per page in rank lists.', '100')";
		$q[]="REPLACE arc_setting VALUES (53, 'levelup', 'rpg', 'Number of experience needed to gain (every) level.', '1700')";
		$q[]="REPLACE arc_setting VALUES (40, 'min_hp_gain', 'rpg', 'Minimum HP a user can gain per level.', '20')";
		$q[]="REPLACE arc_setting VALUES (41, 'max_hp_gain', 'rpg', 'Maximum amount of HP a user can gain on level up.', '35')";
		$q[]="REPLACE arc_setting VALUES (42, 'min_mp_gain', 'rpg', 'Minimum MP a user can gain on level up.', '5')";
		$q[]="REPLACE arc_setting VALUES (43, 'max_mp_gain', 'rpg', 'Maximum MP a user can gain on level up.', '15')";
		$q[]="REPLACE arc_setting VALUES (44, 'post_min_exp', 'user', 'Minimum number of experience points to be awarded to a user after each post.', '43')";
		$q[]="REPLACE arc_setting VALUES (45, 'post_max_exp', 'user', 'Maximum number of experience points to be awarded to a user after each post.', '76')";
		$q[]="REPLACE arc_setting VALUES (46, 'level_factor', 'rpg', 'Number to multiply by level to determine HP and MP gained on level up.', '1.625')";
		$q[]="REPLACE arc_setting VALUES (47, 'guest_limit', 'limit', 'Number of items to be displayed per page in Guestbook lists.', '20')";
		$q[]="REPLACE arc_setting VALUES (48, 'guestoldestfirst', 'mod', 'Display guestbook with oldest entries first (1=yes, 0=no)', '1')";
		$q[]="REPLACE arc_setting VALUES (49, 'guestscanread', 'permissions', 'Allow guests to view site. If set to 0 guests will always see the \'user\' page.', '1')";
		$q[]="REPLACE arc_setting VALUES (50, 'avatarlistsize', 'user', 'Size of avatar select list', '10')";
		$q[]="REPLACE arc_setting VALUES (51, 'startinghp', 'rpg', 'Amount of HP a new user starts out with.', '20')";
		$q[]="REPLACE arc_setting VALUES (52, 'caneditnames', 'user', 'Users can edit their own usernames.', '1')";
		$q[]="REPLACE arc_setting VALUES (54, 'topicoldestfirst', 'display', 'Determines whether topics are displayed oldest first in forums. 1=yes 0=no. Normally you would wan the newest first and therefore have this set at zero.', '0')";
		$q[]="REPLACE arc_setting VALUES (55, 'startingmp', 'rpg', 'Starting MP value for new users.', '5')";
		$q[]="REPLACE arc_setting VALUES (56, 'deletevisitors', 'config', 'If set to \"0\" (zero) visitor entries older then the selected logout time will *not* be deleted from the database thus building a list of all visitors by their IPs.', '0')";
		$q[]="REPLACE arc_setting VALUES (57, 'logouttime', 'user', 'Time in minutes it takes for inactive users to stop displaying in the online display and, if deletevisitors is set to \'1\' this will be the time until they are flushed from the system.', '30')";
		$q[]="REPLACE arc_setting VALUES (58, 'donotes', 'performance', 'Shows column of recently posted notes on every page.', '1')";
		$q[]="REPLACE arc_setting VALUES (59, 'notesperpage', 'display', 'Number of notes to display per page. shownotes must be set at \"1\" for this to work.', '10')";
		$q[]="REPLACE arc_setting VALUES (73, 'showlatestuser', 'display', 'Makes <latestuser> available to the header template.', '1')";
		$q[]="REPLACE arc_setting VALUES (61, 'adminshowonlineusers', 'performance', 'Enables online users display on every page.', '1')";
		$q[]="REPLACE arc_setting VALUES (62, 'notesoldestfirst', 'display', 'Determines whether notes are displayed oldest first. 1=yes 0=no. Setting shownotes and it\'s corresponding user setting must both be enabled for this feature to work.', '1')";
		$q[]="REPLACE arc_setting VALUES (63, 'guestscanviewforums', 'permissions', 'If set to 0 guests will not be able to view the forums.', '1')";
		$q[]="REPLACE arc_setting VALUES (64, 'allowhtml', 'config', 'Allow users to post HTML.', '1')";
		$q[]="REPLACE arc_setting VALUES (72, 'dopms', 'performance', 'Displays private message info on every page', '1')";
		$q[]="REPLACE arc_setting VALUES (65, 'floodtime', 'config', 'Time, in seconds, a user must wait between posts.', '30')";
		$q[]="REPLACE arc_setting VALUES (169, 'profile_lastread_timestamp', 'display', '', 'l F j \\a\\t g:i A')";
		$q[]="REPLACE arc_setting VALUES (67, 'noteboxsize', 'display', 'Size for note input textarea on all pages.', '20')";
		$q[]="REPLACE arc_setting VALUES (68, 'postsintopicreview', 'display', 'Number of recent posts to display on reply form page.', '5')";
		$q[]="REPLACE arc_setting VALUES (75, 'note_max_exp', 'user', 'Maximum experience gained when posting notes.', '10')";
		$q[]="REPLACE arc_setting VALUES (76, 'topic_min_exp', 'user', 'Minimum experience gained for posting a new topic.', '80')";
		$q[]="REPLACE arc_setting VALUES (77, 'topic_max_exp', 'user', 'Maximum experience gained when posting a new topic.', '120')";
		$q[]="REPLACE arc_setting VALUES (78, 'login_min_exp', 'user', 'Minimum experience gained for logging in.', '3')";
		$q[]="REPLACE arc_setting VALUES (79, 'login_max_exp', 'user', 'maximum experience gained for logging in.', '10')";
		$q[]="REPLACE arc_setting VALUES (80, 'showreadreport', 'display', 'Shows the user how many experience points they recieved for reading a topic.', '')";
		$q[]="REPLACE arc_setting VALUES (81, 'readpost_min_exp', 'user', '', '1')";
		$q[]="REPLACE arc_setting VALUES (82, 'readpost_max_exp', 'user', '', '1')";
		$q[]="REPLACE arc_setting VALUES (83, 'explevelmultiplier', 'rpg', 'Turn this on to multiply the \"level_factor\" setting into the experience needed for each new level to make levels progressively harder to attain.', '1')";
		$q[]="REPLACE arc_setting VALUES (84, 'shrine_limit', 'limit', '', '14')";
		$q[]="REPLACE arc_setting VALUES (85, 'sitetimeoffset', 'config', 'Offset, in hours, of Endusts default time.', '')";
		$q[]="REPLACE arc_setting VALUES (86, 'maxusersonline', 'display', 'Maximum number of usernames to display in the users online display.', '10')";
		$q[]="REPLACE arc_setting VALUES (88, 'notesatonce', 'display', '', '80')";
		$q[]="REPLACE arc_setting VALUES (89, 'notepagerefreshtime', 'config', '', '30')";
		$q[]="REPLACE arc_setting VALUES (90, 'notepageoldestfirst', 'config', '', '')";
		$q[]="REPLACE arc_setting VALUES (91, 'shrinesorder', 'display', 'Valid values: shrineid, shrinekey, suserid, susername, stitle, lastmodified, saccesslvl, shits, scomments', 'stitle')";
		$q[]="REPLACE arc_setting VALUES (92, 'max_image_size', 'config', '', '9999999')";
		$q[]="REPLACE arc_setting VALUES (93, 'post_timestamp', 'display', 'See for help on format strings.', 'l, F d \\a\\t g:i  A')";
		$q[]="REPLACE arc_setting VALUES (94, 'header_timestamp', 'display', 'See for help on format strings.', 'l, F d g:i A')";
		$q[]="REPLACE arc_setting VALUES (95, 'pagebit_timestamp', 'display', 'See for help on format strings.', 'l, F d')";
		$q[]="REPLACE arc_setting VALUES (96, 'shrine_timestamp', 'display', 'See for help on format strings.', 'l, F d g:i A')";
		$q[]="REPLACE arc_setting VALUES (97, 'showquickreply', 'display', 'Displays a quick reply form on post display pages.', '1')";
		$q[]="REPLACE arc_setting VALUES (98, 'note_timestamp', 'display', 'See for help on format strings.', '\\[H:i:s\\]')";
		$q[]="REPLACE arc_setting VALUES (99, 'replyprefix', 'config', 'The title prefix for replies.', 'Re: ')";
		$q[]="REPLACE arc_setting VALUES (100, 'mods_see_private_forums', 'permissions', 'Allows moderators to view forums marked as \"private\". 1=allow. 0=disallow.', '1')";
		$q[]="REPLACE arc_setting VALUES (101, 'max_topic_chars', 'limit', 'Maximum  characters allowed in a topic title.', '50')";
		$q[]="REPLACE arc_setting VALUES (102, 'default_colorset', 'config', 'ID of the colorset shown by default.', '3')";
		$q[]="REPLACE arc_setting VALUES (103, 'all_see_private_forums', 'permissions', 'Allows regular users to see private forums. 1=allow. 0=disallow.', '')";
		$q[]="REPLACE arc_setting VALUES (104, 'inputwidth', 'display', 'Sets width of common textareas.', '70')";
		$q[]="REPLACE arc_setting VALUES (105, 'max_poll_options', 'config', 'Maximum choices allowable in a poll.', '10')";
		$q[]="REPLACE arc_setting VALUES (106, 'max_file_size', 'config', 'Maximum size, in bytes, permitted for user uploaded files.', '9999999')";
		$q[]="REPLACE arc_setting VALUES (107, 'profile_timestamp', 'display', 'Format string used for profile \"date registered\" display', 'F d Y')";
		$q[]="REPLACE arc_setting VALUES (108, 'mailer_is_on', 'config', 'Enables use of a form mailer to members and guests. As usual 1=enable, 0=disable', '1')";
		$q[]="REPLACE arc_setting VALUES (110, 'onlineusers_timestamp', 'display', 'Format string for the online users display', 'g:i A')";
		$q[]="REPLACE arc_setting VALUES (111, 'topic_exp_report', 'display', 'Displays a report when a user posts a new topic. 1=show, 0=don\'t show', '1')";
		$q[]="REPLACE arc_setting VALUES (112, 'show_latest_posts', 'performance', 'Toggles latest posts displayed in header', '1')";
		$q[]="REPLACE arc_setting VALUES (113, 'number_latest_posts', 'limit', 'Number of posts to show in \"latest posts\"', '5')";
		$q[]="REPLACE arc_setting VALUES (114, 'latest_post_timestamp', 'display', '', 'M d \\a\\t g:i A')";
		$q[]="REPLACE arc_setting VALUES (115, 'current_template_set', 'config', 'Controls which template group is listed in the cp.', 'default')";
		$q[]="REPLACE arc_setting VALUES (116, 'showcomments', 'performance', 'Sends html comments demarking the beginning and end of each template', '')";
		$q[]="REPLACE arc_setting VALUES (117, 'addnocacheheaders', 'performance', 'Sends HTTP headers to the browsers instructing them not to cache the page. Some browsers ignore these but they can be quite effective.', '')";
		$q[]="REPLACE arc_setting VALUES (118, 'poll_limit', 'limit', '', '14')";
		$q[]="REPLACE arc_setting VALUES (119, 'polla_limit', 'limit', '', '14')";
		$q[]="REPLACE arc_setting VALUES (120, 'faqgroup_limit', 'limit', '', '14')";
		$q[]="REPLACE arc_setting VALUES (121, 'shrinepagelistorder', 'display', 'arc_pagebit.ptitle,arc_pagebit.page,arc_pagebit.pdate', 'arc_pagebit.ptitle')";
		$q[]="REPLACE arc_setting VALUES (122, 'alternatetdbgcolors', 'display', 'Controls whether the table cell background color should alternate between rows (where the <alt_bg> tag is used).', '1')";
		$q[]="REPLACE arc_setting VALUES (124, 'default_templateset', 'config', 'Controls the template set viewed by guests.', 'default')";
		$q[]="REPLACE arc_setting VALUES (129, 'find_postsperpage', 'limit', 'Number of posts to display in \"find posts by\" functions', '50')";
		$q[]="REPLACE arc_setting VALUES (123, 'shrinepage_limit', 'limit', '', '20')";
		$q[]="REPLACE arc_setting VALUES (125, 'config', 'hideadmins', 'Shows a wordbit for Administrators locations instead of their script uri.', '')";
		$q[]="REPLACE arc_setting VALUES (147, 'damage_attack_multiplier', 'rpg', '', '3.5')";
		$q[]="REPLACE arc_setting VALUES (126, 'clan_limit', 'mod', '', '15')";
		$q[]="REPLACE arc_setting VALUES (127, 'experience_type', 'config', 'Controls how users earn experience, whether it is randomly generated numbers between preset bounds for each action, or whether it is based on the number of characters going typed.\r\nvalid values are: \"characters\" and \"random\"', 'random')";
		$q[]="REPLACE arc_setting VALUES (128, 'character_exp_value', 'config', 'Controls how much experience a user gains for each character sent to the database in posts and notes.', '0.14')";
		$q[]="REPLACE arc_setting VALUES (130, 'find_truncatewords', 'limit', 'Truncate posts in \"find posts by\" results to this many words.', '20')";
		$q[]="REPLACE arc_setting VALUES (131, 'showcommentsinprofile', 'display', 'If set to 1 profile comments will be shown on the profile page.\r\nIf set to 0 just the toolbar will display to a separate page containing profile comments.', '')";
		$q[]="REPLACE arc_setting VALUES (132, 'sellrate', 'rpg', 'Number by which any item sold by a user to the itemshop is divided to conculate money returned for selling old equipment.', '2')";
		$q[]="REPLACE arc_setting VALUES (133, 'startinggold', 'rpg', 'Amount of gold each user starts out with.', '500')";
		$q[]="REPLACE arc_setting VALUES (134, 'damage_variance', 'rpg', 'This number is multiplied into the base attack damage to determine jow much is can vary above or below the normal formula of attack power * 3.5.', '.05')";
		$q[]="REPLACE arc_setting VALUES (135, '2hand_multiplier', 'rpg', 'When a users left hand is empty this number is multiplied by the users strength and added to the the users attack power.', '0.25')";
		$q[]="REPLACE arc_setting VALUES (136, 'class_limit', 'limit', '', '10')";
		$q[]="REPLACE arc_setting VALUES (137, 'race_limit', 'limit', '', '10')";
		$q[]="REPLACE arc_setting VALUES (138, 'gold_exp_ratio', 'rpg', 'This number is multiplied by the experience a user gains from all exp-yielding actions to determine the godl they are awarded.', '0.45')";
		$q[]="REPLACE arc_setting VALUES (139, 'battle_action_sort', 'rpg', '', 'ORDER BY timestamp DESC')";
		$q[]="REPLACE arc_setting VALUES (140, 'battle_action_timestamp', 'rpg', '', '[H:i:s]')";
		$q[]="REPLACE arc_setting VALUES (141, 'dead_unit_opacity', 'rpg', '', '40')";
		$q[]="REPLACE arc_setting VALUES (142, 'battle_limit', 'rpg', '', '50')";
		$q[]="REPLACE arc_setting VALUES (143, 'battle_timestamp', 'rpg', '', 'M d g:i A')";
		$q[]="REPLACE arc_setting VALUES (144, 'battle_list_sort', 'rpg', '', 'ORDER BY started DESC')";
		$q[]="REPLACE arc_setting VALUES (145, 'monster_list_sort', 'rpg', '', 'ORDER BY level ASC')";
		$q[]="REPLACE arc_setting VALUES (146, 'monster_limit', 'rpg', '', '25')";
		$q[]="REPLACE arc_setting VALUES (148, 'damage_resist_multiplier', 'rpg', '', '1.5')";
		$q[]="REPLACE arc_setting VALUES (149, 'p2p_exp_won', 'rpg', 'This number is multiplied by a defeated users experience to determine the amount of experience their killer gets for winning.', '0.0002')";
		$q[]="REPLACE arc_setting VALUES (150, 'inn_price', 'rpg', '', '100')";
		$q[]="REPLACE arc_setting VALUES (151, 'sp_exp_ratio', 'rpg', '', '0.02')";
		$q[]="REPLACE arc_setting VALUES (152, 'default_sprite', 'rpg', '', 'lib/images/characters/bof3/ryu.gif')";
		$q[]="REPLACE arc_setting VALUES (153, 'flip_default_sprite', 'rpg', '', '1')";
		$q[]="REPLACE arc_setting VALUES (154, 'monster_level_difference', 'rpg', 'Maximum number of levels above a users level of monsters will be seen in list.', '10')";
		$q[]="REPLACE arc_setting VALUES (155, 'rpg_flag', 'rpg', 'Changes a various things to do with the battle script. Unless you have them you should leave this at 0.', '0')";
		$q[]="REPLACE arc_setting VALUES (156, 'search_limit', 'limit', 'Number of results displayed per page in search results.', '30')";
		$q[]="REPLACE arc_setting VALUES (157, 'onlinepage_refresh', 'config', 'Number of seconds before the Whose Online page is refreshed.', '30')";
		$q[]="REPLACE arc_setting VALUES (158, 'showforumjump', 'performance', 'Display a forum jump select menu on any forums page. Adds one query per page it is displayed.', '1')";
		$q[]="REPLACE arc_setting VALUES (159, 'showpoll', 'performance', '', '1')";
		$q[]="REPLACE arc_setting VALUES (160, 'max_avatar_width', 'display', 'Maximum width allowed for custom avatars.', '120')";
		$q[]="REPLACE arc_setting VALUES (161, 'max_avatar_height', 'display', 'Maximum height allowed for custom avatars.', '120')";
		$q[]="REPLACE arc_setting VALUES (162, 'weekview_short_events', 'display', 'Replaces the <avatar> and <event_description> replacement tags in the event template with nothing on the calendar week view page.', '1')";
		$q[]="REPLACE arc_setting VALUES (163, 'event_title_maxchars', 'limit', 'Number of characters shown in event titles in calendar.', '30')";
		$q[]="REPLACE arc_setting VALUES (164, 'users_can_post_events', 'permissions', 'Allows normal users to post events on the calendar.', '1')";
		$q[]="REPLACE arc_setting VALUES (165, 'users_can_post_public_events', 'permissions', 'Allows normal users to post public events on the calendar (users_can_post_events must be enabled).', '1')";
		$q[]="REPLACE arc_setting VALUES (166, 'latest_articles_limit', 'limit', 'Number of recent articles to display in \'latest articles\' box.', '5')";
		$q[]="REPLACE arc_setting VALUES (167, 'replies_for_hot_topic', 'limit', 'Number of replies a thread can have before the icon changes to a hot icon.', '25')";
		$q[]="REPLACE arc_setting VALUES (168, 'site_is_on', 'config', 'Allows administrator to disable viewing of site by non adminstrators for maintenance or other purposes. ', '1')";
		$q[]="REPLACE arc_setting VALUES (170, 'note_limit', 'limit', '', '30')";
		$q[]="REPLACE arc_setting VALUES (172, 'allow_html_in_post_templates', 'user', 'If set to 1, normal users will be able to use html in their post templates regardless of whether \"allowhtml\" is set to 0.', '1')";
		$q[]="REPLACE arc_setting VALUES (173, 'dlcat_columns', 'display', 'Number of columns for displaying download categories in the category list.', '3')";
		$q[]="REPLACE arc_setting VALUES (174, 'download_limit', 'limit', '', '20')";
		$q[]="REPLACE arc_setting VALUES (175, 'download_timestamp', 'config', '', 'F j,  Y')";
		$q[]="REPLACE arc_setting VALUES (176, 'dlcat_limit', 'limit', 'limit', '10')";
		$q[]="REPLACE arc_setting VALUES (177, 'guests_can_download', 'permissions', 'Flag determines whether guests are permitted to download files. 1=can download, 0=can\'t download', '0')";
		$q[]="REPLACE arc_styleset VALUES (3, 'Sickly Pallor', '', '', '#e0e0e0', '#7080a0', '#e0e0e0', '#ffffff', '#e0e0e0', 'none', 'bold', 'default', '#ffffff', 'normal', 'bold', 'default', '#405070', '#7080a0', '#90a0c0', '#607090', '#405070', '#506080', '#ffffff', '#000000', '<span style=\"font-size: 11px; font-family: verdana; color: #ffffff;\">', '<span style=\"font-size: 12px; font-family: verdana; color: #ffffff;\">', '<span style=\"font-size: 16px; font-family: verdana; color: #ffffff;\">', '</span>', '</span>', '</span>', 'scrollbar-face-color: #607090; scrollbar-arrow-color: #d0d0d0; scrollbar-track-color: #405070; scrollbar-darkshadow-color: #d0d0d0; scrollbar-3dlight-color: #d0d0d0; scrollbar-shadow-color: #607090; scrollbar-highlight-color: #607090;', 'lib/images/mikelogo.jpg', 'lib/images/mikenewtopic.gif', 'lib/images/mikenewreply.gif', 50, 15, '')";
		$q[]="REPLACE arc_styleset VALUES (11, 'Seir Anphin', '', '', '#eeeeee', '#557799', '#eeeeee', '#ffffff', '#eeeeee', 'none', 'bold', 'hand', '#ffffff', 'normal', 'bold', 'default', '#557799', '#7799bb', '#ffffff', '#6688aa', '#88aacc', '#557799', '#ffffff', '#000000', '<font face=\"verdana\" size=\"-2\">', '<font face=\"verdana\" size=\"-1\">', '<font face=\"verdana\" size=\"-0\">', '</font>', '</font>', '</font>', 'scrollbar-face-color: #d6dce5; \r\nscrollbar-highlight-color: #d6dce5; \r\nscrollbar-shadow-color: #d6dce5; \r\nscrollbar-3dlight-color: #000000; \r\nscrollbar-darkshadow-color: #000000;\r\nscrollbar-arrow-color: #000000; \r\nscrollbar-track-color: #e6ecf5; \r\n', 'lib/images/default.gif', 'lib/images/mikenewtopic.gif', 'lib/images/mikenewreply.gif', 50, 15, '')";
		$q[]="DELETE FROM arc_template WHERE templategroup='default'";
		$q[]="REPLACE arc_template VALUES (1870, 'quoteuser', 'HTML around the a users quote.', '<table cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"<fontcolor>\"><tr><td><table cellspacing=\"1\" cellpadding=\"0\"><tr><td bgcolor=\"<tdendbgcolor>\"><normalfont><content><cn></td></tr></table></td></tr></table>', 'default')";
		$q[]="REPLACE arc_template VALUES (1869, 'quickreplyform', 'Quick reply code for topic display pages.', '<table bgcolor=\"<tablebordercolor>\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\" ><tr><td>\r\n<table cellspacing=\"1\" cellpadding=\"2\" border=\"0\" width=\"100%\">\r\n<form action=\"post.php?action=newcomment\" name=\"quickreply\" method=\"post\">\r\n<input type=\"hidden\" name=\"parentident\" value=\"<parentident>\" />\r\n<input type=\"hidden\" name=\"parentid\" value=\"<parentid>\" />\r\n<input type=\"hidden\" name=\"postuserid\" value=\"<userid>\" />\r\n<input type=\"hidden\" name=\"postusername\" value=\"<username>\" />\r\n<input type=\"hidden\" name=\"posttitle\" value=\"Re: <posttitle>\" />\r\n  <tr>\r\n    <td bgcolor=\"<tdbgcolor>\" align=\"center\" valign=\"top\">\r\n        <normalfont><a name=\"quickreply\">Quick Reply</a><br /><cn>\r\n        <textarea name=\"postcontent\" rows=\"7\" cols=\"90\" wrap></textarea><br />\r\n        <input type=\"submit\" value=\"Submit Post\" name=\"quickreply\" />\r\n    </td>\r\n  </tr>\r\n</table>\r\n</td>\r\n</tr>\r\n</table>\r\n', 'default')";
		$q[]="REPLACE arc_template VALUES (1868, 'profiletoolbar', 'profile post list toolbar', '<table width=\"100%\">\r\n  <tr>\r\n    <td align=\"left\" width=\"70%\">\r\n        <normalfont>Comments <displayname>\'s profile: <b><numposts></b>\r\n        <cn>\r\n    </td>\r\n    <td align=\"right\" width=\"30%\">\r\n        <normalfont>\r\n        Profile Hits: <b><profilehits></b><br />\r\n        <newcommentlink>\r\n        <cn>\r\n    </td>\r\n  </tr>\r\n</table>', 'default')";
		$q[]="REPLACE arc_template VALUES (1867, 'profilerow', 'Looping code for profile post display.', '<tr>\r\n  <td bgcolor=\\\"<tdheadbgcolor>\\\" align=\\\"center\\\">\r\n<normalfont>\r\n<a name=\\\"<postid>\\\" href=\\\"<webroot>/user.php?action=profile&id=<userid>\\\"><displayname></a>\r\n<cn>\r\n  </td>\r\n  <td bgcolor=\\\"<tdheadbgcolor>\\\">\r\n    <smallfont>\r\n<i>\r\n<posttitle>\r\n<msgtitle>\r\n</i>\r\n<cs>\r\n  </td>\r\n</tr>\r\n<tr>\r\n  <td bgcolor=\\\"<alt_bg>\\\" align=\\\"center\\\" valign=\\\"top\\\" width=\\\"150\\\">\r\n<replybutton>\r\n<img src=\\\"<avatar>\\\" border=\\\"0\\\" align=\\\"center\\\" /><br>\r\n<center><smallfont><usertext></center><br>\r\n<div align=\\\"left\\\">\r\n<smallfont>\r\n<b>Location:</b> <location><br>\r\n<b>Posts:</b> <post_count><br>\r\n<b>Threads:</b> <thread_count><br>\r\n<b>Notes:</b> <note_count>\r\n<cs>\r\n<img src=\\\"<webroot>/lib/images/avatars/default.gif\\\" border=\\\"0\\\" height=\\\"1\\\" width=\\\"100\\\" />\r\n  </td>\r\n  <td width=\\\"100%\\\" bgcolor=\\\"<alt_bg>\\\" align=\\\"left\\\" valign=\\\"top\\\">\r\n<normalfont>\r\n<post_header>\r\n<postcontent><msgcontent><br>\r\n<post_footer>\r\n<cn>\r\n  </td>\r\n</tr>\r\n<tr>\r\n  <td bgcolor=\\\"<alt_bg>\\\" align=\\\"center\\\">\r\n<smallfont>\r\n<rank>\r\n<cs>\r\n  </td>\r\n  <td bgcolor=\\\"<alt_bg>\\\" valign=\\\"top\\\">\r\n<smallfont>\r\n[<a href=\\\"post.php?action=editcomment&id=<postid>\\\">Edit</a>] \r\n[<a href=\\\"privatemsg.php?action=compose&id=<userid>\\\">Send PM</a>] \r\n[<a href=\\\"mail.php?id=<userid>\\\">Send Mail</a>] \r\n[<a href=\\\"<homepage>\\\" target=\\\"_blank\\\">View Website</a>] \r\n<quickreply>\r\nPosted: <b><posted></b>\r\n<br>\r\n<cs>\r\n  </td>\r\n</tr>\r\n', 'default')";
		$q[]="REPLACE arc_template VALUES (1863, 'privatemsg', 'Private Messages -privatemsgrow', '<div align=\\\"left\\\">\r\n  <largefont><b>Private Messages: <page></b><cl>\r\n</div>\r\n<table bgcolor=\\\"<tablebordercolor>\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" class=\\\"3dcell\\\" width=\\\"100%\\\" align=\\\"center\\\"><tr><td width=\\\"100%\\\">\r\n<table cellpadding=\\\"1\\\" cellspacing=\\\"1\\\" border=\\\"0\\\"  width=\\\"100%\\\">\r\n  <tr>\r\n    <td width=\\\"60%\\\" bgcolor=\\\"<tdendbgcolor>\\\">\r\n<normalfont>Title <cn>\r\n    </td>\r\n    <td width=\\\"20%\\\" bgcolor=\\\"<tdendbgcolor>\\\">\r\n<normalfont>Sender <cn>\r\n    </td>\r\n    <td width=\\\"10%\\\" bgcolor=\\\"<tdendbgcolor>\\\">\r\n<normalfont>Is Read <cn>\r\n    </td>\r\n  </tr>\r\n<privatemsgrow>\r\n</table>\r\n</td></tr></table>', 'default')";
		$q[]="REPLACE arc_template VALUES (1864, 'privatemsgmenu', 'Links at the top of privatemsg.php', '      <table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" bgcolor=\\\"<tablebordercolor>\\\"  align=\\\"center\\\">\r\n        <tr>\r\n          <td>\r\n            <table cellpadding=\\\"1\\\" cellspacing=\\\"1\\\" border=\\\"0\\\"  width=\\\"100%\\\">\r\n              <tr>\r\n                <td align=\\\"center\\\" valign=\\\"top\\\" bgcolor=\\\"<tdheadbgcolor>\\\">\r\n<normalfont>\r\n<a class=\\\"nav\\\" href=\\\"user.php\\\">User CP</a> | \r\n<a class=\\\"nav\\\" href=\\\"privatemsg.php?action=Inbox\\\">Inbox</a> | \r\n<a class=\\\"nav\\\" href=\\\"privatemsg.php?action=Inbox&sent=\\\">Sent Messages</a> | \r\n<a class=\\\"nav\\\" href=\\\"privatemsg.php?action=Compose\\\">Compose</a><br><cs>\r\n</td></tr></table>\r\n</td></tr></table>', 'default')";
		$q[]="REPLACE arc_template VALUES (1865, 'privatemsgrow', '-msgtitle,sender,isread', '<tr>\r\n  <td bgcolor=\\\"<alt_bg>\\\">\r\n<normalfont><msgtitle> <deleter> <cn>\r\n  </td>\r\n  <td bgcolor=\\\"<alt_bg>\\\">\r\n<normalfont><sender> <cn>\r\n  </td>\r\n  <td bgcolor=\\\"<alt_bg>\\\">\r\n<normalfont><isread> <cn>\r\n  </td>\r\n</tr>', 'default')";
		$q[]="REPLACE arc_template VALUES (1866, 'profile', 'Template for browsing user profiles.', '<table width=\\\"98%\\\" bgcolor=\\\"<tablebordercolor>\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\"><tr><td>\r\n<table width=\\\"100%\\\" cellspacing=\\\"1\\\" cellpadding=\\\"2\\\">\r\n<tr>\r\n<td bgcolor=\\\"<tdheadbgcolor>\\\" colspan=\\\"2\\\" align=\\\"center\\\">\r\n<smallfont><b>::USER PROFILE::</b><cs>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td bgcolor=\\\"<tdbgcolor>\\\">\r\n  <img src=\\\"<avatar>\\\" border=\\\"0\\\" align=\\\"left\\\" />\r\n<largefont><displayname><cl>\r\n<br>\r\n<smallfont>\r\n<rank><br>\r\n\\\"<usertext>\\\"\r\n<cs>\r\n</td>\r\n<td bgcolor=\\\"<tdbgcolor>\\\" valign=\\\"top\\\">\r\n<div align=\\\"center\\\"><smallfont>Contact</div>\r\n<a href=\\\"mail.php?id=<userid>\\\">Email</a><br>\r\n<a href=\\\"privatemsg.php?action=Compose&id=<userid>\\\">Private Message</a>\r\n<br>\r\n<a href=\\\"post.php?action=postcomment&ident=profile&id=<userid>\\\">Leave Comment</a>\r\n<cs>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td bgcolor=\\\"<tdbgcolor>\\\" valign=\\\"top\\\" width=\\\"50%\\\">\r\n<smallfont>\r\n<center>Profile</center>\r\n<b>Website:</b>\r\n<a href=\\\"<homepage>\\\" target=\\\"_blank\\\"><homepage></a><br>\r\n<b>Location:</b> <location><br>\r\n<b>Occupation:</b> <occupation><br>\r\n<b>Birthday:</b> <birthday><br>\r\n<b>Registered:</b> <regdate>\r\n<cs>\r\n</td>\r\n<td bgcolor=\\\"<tdbgcolor>\\\" valign=\\\"top\\\" width=\\\"50%\\\">\r\n<smallfont>\r\n<div align=\\\"center\\\">Account Stats</div>\r\n<b>Topics:</b> <topics><br>\r\n<b>Posts:</b> <post_count> (<a href=\\\"find.php?postid=<userid>\\\">Find</a>)<br>\r\n<b>Notes:</b> <note_count><br>\r\n<b>Login Time:</b> <timeonline><br>\r\n<b>Last Online:</b> <last_active>\r\n<cs>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td bgcolor=\\\"<tdbgcolor>\\\" valign=\\\"top\\\" colspan=\\\"2\\\">\r\n<div align=\\\"center\\\"><smallfont>Biography<cs></div>\r\n  <normalfont><post_header><br>\r\n  <biography><br>\r\n  <post_footer><cn>\r\n</td></tr>\r\n<tr>\r\n<td bgcolor=\\\"<tdbgcolor>\\\" valign=\\\"top\\\" colspan=\\\"2\\\">\r\n<smallfont>Last Post: <lastpostlink><br><cs>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td bgcolor=\\\"<tdbgcolor>\\\" valign=\\\"top\\\" colspan=\\\"2\\\">\r\n<smallfont>Last Note: <lastnote><br /><cs>\r\n</td>\r\n</tr>\r\n</table></td></tr></table>\r\n<smallfont>\r\n<banlink>\r\n<cs>', 'default')";
		$q[]="REPLACE arc_template VALUES (1852, 'notes_menu', '', '      <table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" bgcolor=\"<tablebordercolor>\">\r\n        <tr>\r\n          <td>\r\n            <table cellpadding=\"1\" cellspacing=\"1\" border=\"0\"  width=\"100%\">\r\n              <tr>\r\n                <td align=\"center\" valign=\"top\" bgcolor=\"<tdheadbgcolor>\">\r\n<normalfont>\r\n<a class=\"nav\" href=\"note.php?action=Archive\">Note Archive</a> | \r\n<a class=\"nav\" href=\"note.php\">Chat Room</a>\r\n<cn>\r\n</td></tr></table>\r\n</td></tr></table>', 'default')";
		$q[]="REPLACE arc_template VALUES (1853, 'onlinedisplay', 'Users Online List', '<a href=\\\"<webroot>/online.php\\\">Online Users:</a> <users_online><br>', 'default')";
		$q[]="REPLACE arc_template VALUES (1854, 'onlinemenu', '', '      <table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" bgcolor=\"<tablebordercolor>\"  align=\"center\">\r\n        <tr>\r\n          <td>\r\n            <table cellpadding=\"1\" cellspacing=\"1\" border=\"0\"  width=\"100%\">\r\n              <tr>\r\n                <td align=\"center\" valign=\"top\" bgcolor=\"<tdheadbgcolor>\">\r\n<normalfont>\r\n<a class=\"nav\" href=\"online.php?todays_users=1\">View Users Online in Last 24 Hours</a> | \r\n<a class=\"nav\" href=\"online.php\">Currently Online Users</a>\r\n<br>\r\n<cn>\r\n    </td>\r\n  </tr>\r\n</table>\r\n    </td>\r\n  </tr>\r\n</table>', 'default')";
		$q[]="REPLACE arc_template VALUES (1855, 'onlinepagerow', '-username,where,last_active', '<tr>\r\n  <td bgcolor=\"<tdbgcolor>\">\r\n<smallfont><username><br /><cs>\r\n  </td>\r\n  <td bgcolor=\"<tdbgcolor>\">\r\n<smallfont><where><br /><cs>\r\n  </td>\r\n  <td bgcolor=\"<tdbgcolor>\">\r\n<smallfont><last_active><br /><cs>\r\n  </td>\r\n</tr>', 'default')";
		$q[]="REPLACE arc_template VALUES (1856, 'pagebit', 'Looping pagebit HTML', '<table style=\\\"border: 1px solid <tablebordercolor>; padding: 5px;\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" width=\\\"90%\\\"><tr><td>\r\n  <largefont>\r\n    <b><pagebit_title></b>\r\n  <cl>\r\n<br>\r\n<smallfont>Posted by: <a href=\\\"user.php?action=profile&id=<userid>\\\"><username></a> on <b><pdate></b>\r\n<br>\r\n<img src=\\\"<avatar>\\\" align=\\\"left\\\" border=\\\"0\\\" /> <readcomments> (<numreplies>) <postcomment>\r\n<cs>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td bgcolor=\\\"<bgcolor>\\\">\r\n<normalfont>\r\n  <pagebit_content>\r\n<cn>\r\n</td></tr></table>\r\n<br>', 'default')";
		$q[]="REPLACE arc_template VALUES (1857, 'pagebitfull', '-pagebitrow', '<pagebitrow>\r\n', 'default')";
		$q[]="REPLACE arc_template VALUES (1858, 'pagebitrow', 'Post HTML for comments on pagebits.', '<tr>\r\n  <td bgcolor=\\\"<tdheadbgcolor>\\\" align=\\\"center\\\">\r\n<normalfont>\r\n<a name=\\\"<postid>\\\" href=\\\"<webroot>/user.php?action=profile&id=<userid>\\\"><displayname></a>\r\n<cn>\r\n  </td>\r\n  <td bgcolor=\\\"<tdheadbgcolor>\\\">\r\n    <smallfont>\r\n<i>\r\n<posttitle>\r\n<msgtitle>\r\n</i>\r\n<cs>\r\n  </td>\r\n</tr>\r\n<tr>\r\n  <td bgcolor=\\\"<alt_bg>\\\" align=\\\"center\\\" valign=\\\"top\\\" width=\\\"150\\\">\r\n<replybutton>\r\n<img src=\\\"<avatar>\\\" border=\\\"0\\\" align=\\\"center\\\" /><br>\r\n<center><smallfont><usertext></center><br>\r\n<div align=\\\"left\\\">\r\n<smallfont>\r\n<b>Location:</b> <location><br>\r\n<b>Posts:</b> <post_count><br>\r\n<b>Threads:</b> <thread_count><br>\r\n<b>Notes:</b> <note_count>\r\n<cs>\r\n<img src=\\\"<webroot>/lib/images/avatars/default.gif\\\" border=\\\"0\\\" height=\\\"1\\\" width=\\\"100\\\" />\r\n  </td>\r\n  <td width=\\\"100%\\\" bgcolor=\\\"<alt_bg>\\\" align=\\\"left\\\" valign=\\\"top\\\">\r\n<normalfont>\r\n<post_header>\r\n<postcontent><msgcontent><br>\r\n<post_footer>\r\n<cn>\r\n  </td>\r\n</tr>\r\n<tr>\r\n  <td bgcolor=\\\"<alt_bg>\\\" align=\\\"center\\\">\r\n<smallfont>\r\n<rank>\r\n<cs>\r\n  </td>\r\n  <td bgcolor=\\\"<alt_bg>\\\" valign=\\\"top\\\">\r\n<smallfont>\r\n[<a href=\\\"post.php?action=editcomment&id=<postid>\\\">Edit</a>] \r\n[<a href=\\\"privatemsg.php?action=compose&id=<userid>\\\">Send PM</a>] \r\n[<a href=\\\"mail.php?id=<userid>\\\">Send Mail</a>] \r\n[<a href=\\\"<homepage>\\\" target=\\\"_blank\\\">View Website</a>] \r\n<quickreply>\r\nPosted: <b><posted></b>\r\n<br>\r\n<cs>\r\n  </td>\r\n</tr>\r\n', 'default')";
		$q[]="REPLACE arc_template VALUES (1859, 'pagebittoolbar', 'Toolbar displayed when post parent is pagebit.', '<table bgcolor=\"<tablebordercolor>\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" class=\"3dcell\" width=\"100%\" align=\"center\">\r\n<tr><td width=\"100%\">\r\n<table cellpadding=\"1\" cellspacing=\"1\" border=\"0\"  width=\"100%\">\r\n  <tr>\r\n    <td bgcolor=\"<tdbgcolor>\" align=\"left\" width=\"70%\">\r\n        <normalfont><pagebitlink><br />\r\n        Comments on this page: <b><numposts></b>\r\n        <cn>\r\n    </td>\r\n    <td bgcolor=\"<tdbgcolor>\" align=\"right\" width=\"30%\">\r\n        <newcommentlink>\r\n    </td>\r\n  </tr>\r\n</table>\r\n</td></tr>\r\n</table>', 'default')";
		$q[]="REPLACE arc_template VALUES (1860, 'pollvoteform', '', '<input type=\"submit\" value=\"  Vote  \" />\r\n\r\n', 'default')";
		$q[]="REPLACE arc_template VALUES (1861, 'post', 'Post display table header', '<replybutton><center><normalfont><reviewdesc><cn>\r\n<normalfont><pagelinks> <cn>\r\n<table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" width=\\\"100%\\\" bgcolor=\\\"<tablebordercolor>\\\"><tr><td>\r\n<table cellpadding=\\\"3\\\" cellspacing=\\\"1\\\" border=\\\"0\\\">\r\n<postrow>\r\n</table>\r\n</td></tr></table>\r\n<normalfont><pagelinks> <cn></center>', 'default')";
		$q[]="REPLACE arc_template VALUES (1862, 'postrow', 'Post HTML for topics.-post_count,location,rank', '<tr>\r\n  <td bgcolor=\\\"<tdheadbgcolor>\\\" align=\\\"center\\\">\r\n<normalfont>\r\n<a name=\\\"<postid>\\\" href=\\\"<webroot>/user.php?action=profile&id=<userid>\\\"><displayname></a>\r\n<cn>\r\n  </td>\r\n  <td bgcolor=\\\"<tdheadbgcolor>\\\">\r\n    <smallfont>\r\n<i>\r\n<posttitle>\r\n<msgtitle>\r\n</i>\r\n<cs>\r\n  </td>\r\n</tr>\r\n<tr>\r\n  <td bgcolor=\\\"<alt_bg>\\\" align=\\\"center\\\" valign=\\\"top\\\" width=\\\"150\\\">\r\n<replybutton>\r\n<img src=\\\"<avatar>\\\" border=\\\"0\\\" align=\\\"center\\\" /><br>\r\n<center><smallfont><usertext></center><br>\r\n<div align=\\\"left\\\">\r\n<smallfont>\r\n<b>Location:</b> <location><br>\r\n<b>Posts:</b> <post_count><br>\r\n<b>Threads:</b> <thread_count><br>\r\n<b>Notes:</b> <note_count>\r\n<cs>\r\n<img src=\\\"<webroot>/lib/images/avatars/default.gif\\\" border=\\\"0\\\" height=\\\"1\\\" width=\\\"100\\\" />\r\n  </td>\r\n  <td width=\\\"100%\\\" bgcolor=\\\"<alt_bg>\\\" align=\\\"left\\\" valign=\\\"top\\\">\r\n<normalfont>\r\n<post_header>\r\n<postcontent><msgcontent><br>\r\n<post_footer>\r\n<cn>\r\n  </td>\r\n</tr>\r\n<tr>\r\n  <td bgcolor=\\\"<alt_bg>\\\" align=\\\"center\\\">\r\n<smallfont>\r\n<rank>\r\n<cs>\r\n  </td>\r\n  <td bgcolor=\\\"<alt_bg>\\\" valign=\\\"top\\\">\r\n<smallfont>\r\n[<a href=\\\"post.php?action=editcomment&id=<postid>\\\">Edit</a>] \r\n[<a href=\\\"privatemsg.php?action=compose&id=<userid>\\\">Send PM</a>] \r\n[<a href=\\\"mail.php?id=<userid>\\\">Send Mail</a>] \r\n[<a href=\\\"<homepage>\\\" target=\\\"_blank\\\">View Website</a>] \r\n<quickreply>\r\nPosted: <b><posted></b>\r\n<br>\r\n<cs>\r\n  </td>\r\n</tr>\r\n', 'default')";
		$q[]="REPLACE arc_template VALUES (1850, 'noterow', 'HTML for single note entries.-timestamp', '<tr><td class=\\\"cel\\\">\r\n<span class=\\\"txt\\\"><b><<username>></b> <content><br></span>\r\n</td></tr>\r\n', 'default')";
		$q[]="REPLACE arc_template VALUES (1851, 'notes', 'HTML before looping note entries.', '<table class=\\\"tbl\\\" width=\\\"100%\\\" border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" bgcolor=\\\"<bgcolor>\\\">\r\n  <tr><td><table width=\\\"100%\\\" cellspacing=\\\"1\\\" border=\\\"0\\\" cellpadding=\\\"0\\\"><tr><td bgcolor=\\\"<tablebgcolor>\\\" align=\\\"center\\\" height=\\\"25\\\">\r\n<font face=\\\"verdana\\\" size=\\\"-2\\\"><b><u><prevpage> Displaying notes <offset> to <offsetplus> of <totalnotes> <status> <nextpage></u></b> </font> </td></tr>\r\n<noterow>\r\n<tr><td class=\\\"cel\\\" align=\\\"center\\\">\r\n<submitbutton>  \r\n</td></tr></table></td></tr></table>\r\n<center><smallfont><pagelinks> </center>\r\n</form>\r\n', 'default')";
		$q[]="REPLACE arc_template VALUES (1847, 'latest_articles', '', '<span class=\"navheader\"><number_articles> Latest Articles</span>\r\n<table width=\"100%\" cellpadding=\"1\" cellspacing=\"1\">\r\n  <latest_articlerows>\r\n</table>\r\n\r\n', 'default')";
		$q[]="REPLACE arc_template VALUES (1848, 'level_up', '-exp,levxp,gold,rank', '<smallfont><a href=\"<webroot>/user.php?action=profile&id=<userid>\"><displayname></a> has reached level <level>.<br>\r\n<b>HP:</b> <hp>+<hpplus>-&gt;<newhp><br>\r\n<b>MP:</b> <mp>+<mpplus>-&gt;<newmp><br>\r\n<b>Str:</b> <str>+<strplus>-&gt;<newstr><br>\r\n<b>End</b> <end>+<endplus>-&gt;<newend><br>\r\n<b>Int:</b> <int>+<intplus>-&gt;<newint><br>\r\n<b>Wil:</b> <wil>+<wilplus>-&gt;<newwil><br>\r\n<b>Dex:</b> <dex>+<dexplus>-&gt;<newdex>\r\n<br>\r\nYou have gained <b><expmod></b> experience points and <b><goldmod></b> gold.\r\n<cs>', 'default')";
		$q[]="REPLACE arc_template VALUES (1849, 'memberlistchoices', '', '<form name=\"order_by\" action=\"user.php?action=list\" method=\"get\">\r\n<select name=\"orderby\">\r\n<option selected value=\"\">Order Members By:\r\n<option value=\"displayname\">Display Name\r\n<option value=\"userid\">UserID\r\n<option value=\"rank\">Rank\r\n<option value=\"level DESC\">Level\r\n<option value=\"exp DESC\">Experience\r\n<option value=\"hp DESC\">HP\r\n<option value=\"mp DESC\">MP\r\n<option value=\"post_count DESC\">Post Count\r\n<option value=\"occupation,userid\">Occupation,UserID\r\n<option value=\"reg_date DESC\">Date Registered\r\n</select>\r\n<input type=\"hidden\" name=\"action\" value=\"list\" />\r\n<input type=\"submit\" value=\"Sort\" />\r\n</form>\r\n<center>\r\n<smallfont>Browse users by the first letter of their displayname.\r\n<cs>\r\n<br />\r\n<normalfont>\r\n<a href=\"user.php?action=list&letter=a\">A</a> \r\n<a href=\"user.php?action=list&letter=b\">B</a> \r\n<a href=\"user.php?action=list&letter=c\">C</a> \r\n<a href=\"user.php?action=list&letter=d\">D</a> \r\n<a href=\"user.php?action=list&letter=e\">E</a> \r\n<a href=\"user.php?action=list&letter=f\">F</a> \r\n<a href=\"user.php?action=list&letter=g\">G</a> \r\n<a href=\"user.php?action=list&letter=h\">H</a> \r\n<a href=\"user.php?action=list&letter=i\">I</a> \r\n<a href=\"user.php?action=list&letter=j\">J</a> \r\n<a href=\"user.php?action=list&letter=k\">K</a> \r\n<a href=\"user.php?action=list&letter=l\">L</a> \r\n<a href=\"user.php?action=list&letter=m\">M</a> \r\n<a href=\"user.php?action=list&letter=n\">N</a> \r\n<a href=\"user.php?action=list&letter=o\">O</a> \r\n<a href=\"user.php?action=list&letter=p\">P</a> \r\n<a href=\"user.php?action=list&letter=q\">Q</a> \r\n<a href=\"user.php?action=list&letter=r\">R</a> \r\n<a href=\"user.php?action=list&letter=s\">S</a> \r\n<a href=\"user.php?action=list&letter=t\">T</a> \r\n<a href=\"user.php?action=list&letter=u\">U</a> \r\n<a href=\"user.php?action=list&letter=v\">V</a> \r\n<a href=\"user.php?action=list&letter=w\">W</a> \r\n<a href=\"user.php?action=list&letter=x\">X</a> \r\n<a href=\"user.php?action=list&letter=y\">Y</a> \r\n<a href=\"user.php?action=list&letter=z\">Z</a> \r\n<cn>\r\n</center>', 'default')";
		$q[]="REPLACE arc_template VALUES (1996, 'usercpmenu', '', '      <table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" bgcolor=\\\"<tablebordercolor>\\\"  align=\\\"center\\\">\r\n        <tr>\r\n          <td>\r\n            <table cellpadding=\\\"1\\\" cellspacing=\\\"1\\\" border=\\\"0\\\"  width=\\\"100%\\\">\r\n              <tr>\r\n                <td align=\\\"center\\\" valign=\\\"top\\\" bgcolor=\\\"<tdheadbgcolor>\\\">\r\n<normalfont>\r\n<a class=\\\"nav\\\" href=\\\"privatemsg.php\\\">Private Message CP</a> | \r\n<a class=\\\"nav\\\" href=\\\"user.php\\\">Notepad</a> | \r\n<a class=\\\"nav\\\" href=\\\"user.php?action=profile&id=<userid>\\\">View Profile</a> | \r\n<a class=\\\"nav\\\" href=\\\"user.php?action=editprofile\\\">Modify Profile</a> | \r\n<a class=\\\"nav\\\" href=\\\"user.php?action=editoptions\\\">Options</a> | \r\n<a class=\\\"nav\\\" href=\\\"user.php?action=edittemplates\\\">Post Templates</a>\r\n<cn>\r\n</td></tr></table>\r\n</td></tr></table>', 'default')";
		$q[]="REPLACE arc_template VALUES (1997, 'userlist', 'Memberlist table top', '<center><normalfont><pagelinks><br /><cn></center>\r\n<table width=\\\"100%\\\" bgcolor=\\\"<tablebordercolor>\\\" cellspacing=\\\"0\\\" cellpadding=\\\"0\\\" border=\\\"0\\\">\r\n<tr><td>\r\n<table width=\\\"100%\\\" cellspacing=\\\"1\\\" cellpadding=\\\"3\\\">\r\n  <tr>\r\n    <td colspan=\\\"7\\\" bgcolor=\\\"<tablebgcolor>\\\" align=\\\"left\\\">\r\n<normalfont><sitename> Member List sorted by <orderby><cn>\r\n    </td>\r\n  </tr>\r\n  <tr>\r\n    <td width=\\\"10%\\\" bgcolor=\\\"<tablebgcolor>\\\" align=\\\"center\\\">\r\n<normalfont><b>ID</b> <cn>\r\n    </td>\r\n    <td width=\\\"40%\\\" bgcolor=\\\"<tablebgcolor>\\\" width=\\\"100\\\" align=\\\"center\\\">\r\n<normalfont><b>Username</b> <cn>\r\n    </td>\r\n    <td width=\\\"10%\\\" bgcolor=\\\"<tablebgcolor>\\\" align=\\\"center\\\">\r\n<normalfont><b>Web Site</b> <cn>\r\n    </td>\r\n    <td width=\\\"10%\\\" bgcolor=\\\"<tablebgcolor>\\\" align=\\\"center\\\">\r\n<normalfont><b>Email</b> <cn>\r\n    </td>\r\n    <td width=\\\"10%\\\" bgcolor=\\\"<tablebgcolor>\\\" align=\\\"center\\\">\r\n<normalfont><b>Topics</b> <cn>\r\n    </td>\r\n    <td width=\\\"10%\\\" bgcolor=\\\"<tablebgcolor>\\\" align=\\\"center\\\">\r\n<normalfont><b>Posts</b> <cn>\r\n    </td>\r\n    <td width=\\\"10%\\\" bgcolor=\\\"<tablebgcolor>\\\" align=\\\"center\\\">\r\n<normalfont><b>Notes</b> <cn>\r\n    </td>\r\n  </tr>\r\n<userlistrow>\r\n     </td>\r\n  </tr>\r\n</table>\r\n</td></tr></table>\r\n<center><normalfont><pagelinks> <cn></center>\r\n', 'default')";
		$q[]="REPLACE arc_template VALUES (1995, 'topictoolbar', 'Toolbar displayed when post parent is topic.', '<table cellpadding=\"1\" cellspacing=\"1\" border=\"0\"  width=\"100%\">\r\n  <tr>\r\n    <td align=\"left\" valign=\"top\" width=\"70%\">\r\n        <normalfont><forumhome> &gt; <catlink> &gt; <forumlink> &gt;<br /><topiclink><br /><cn>\r\n    </td>\r\n    <td align=\"center\" valign=\"top\" width=\"30%\">\r\n        <smallfont>\r\n        Replies: <b><numposts></b> &nbsp; &nbsp; Views: <b><numhits></b><br />\r\n        <newcommentlink>\r\n        <cs>\r\n    </td>\r\n  </tr>\r\n</table>\r\n<center>\r\n<normalfont>\r\n<downloadfile><threadcontrol>\r\n<cn>\r\n</center>', 'default')";
		$q[]="REPLACE arc_template VALUES (1994, 'topicrow', 'Looping Topic display in topic lists (forums).', '<tr>\r\n  <td bgcolor=\"<tdbgcolor>\">\r\n<smallfont><newposts><cs>\r\n  </td>\r\n  <td bgcolor=\"<tdbgcolor>\">\r\n<topicicon>\r\n  </td>\r\n  <td onclick=\"window.location.href=\'post.php?action=readcomments&ident=topic&id=<topicid>\'\" onmouseover=\"this.className=\'mover\'\" onmouseout=\"this.className=\'mout\'\" valign=\"middle\" bgcolor=\"<tdbgcolor>\">\r\n<normalfont>\r\n<topic_poll>\r\n<b><u>\r\n<a href=\"post.php?action=readcomments&ident=topic&id=<topicid>\"><threadicon><topicname></a></u></b>\r\n<pagelinks> \r\n<topic_closed>\r\n<topic_pinned> <cn><br>\r\n<smallfont><description> <cs>\r\n  </td>\r\n  <td onclick=\"window.location.href=\'user.php?action=profile&id=<topic_starterid>\'\" onmouseover=\"this.className=\'mout\'\" onmouseout=\"this.className=\'mover\'\" bgcolor=\"<alttablebgcolor>\" valign=\"middle\" align=\"center\">\r\n<smallfont><a href=\"user.php?action=profile&id=<topic_starterid>\"><topic_starter></a> <cs>\r\n  </td>\r\n  <td onclick=\"window.location.href=\'user.php?action=profile&id=<last_posterid>\'\" onmouseover=\"this.className=\'mover\'\" onmouseout=\"this.className=\'mout\'\" bgcolor=\"<tdbgcolor>\" valign=\"middle\" align=\"center\">\r\n<smallfont><a href=\"user.php?action=profile&id=<last_posterid>\"><last_poster></a> <cs>\r\n  </td>\r\n  <td bgcolor=\"<alttablebgcolor>\" valign=\"middle\" align=\"center\">\r\n<normalfont><b><replies></b> <cn>\r\n  </td>\r\n  <td bgcolor=\"<tdbgcolor>\" valign=\"middle\" align=\"center\">\r\n<normalfont><b><hits></b><selectbox> <cn>\r\n  </td>\r\n</tr>', 'default')";
		$q[]="REPLACE arc_template VALUES (1993, 'topic', 'Topic List code.', '<center><normalfont><pagelinks> <cn></center>\r\n<table bgcolor=\"<tablebordercolor>\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\" align=\"center\">\r\n<tr><td width=\"100%\">\r\n<table cellpadding=\"1\" cellspacing=\"1\" border=\"0\"  width=\"100%\">\r\n<tr><td bgcolor=\"<tdheadbgcolor>\" align=\"center\" colspan=\"3\">\r\n<smallfont>Topic <cs>\r\n</td><td bgcolor=\"<tdheadbgcolor>\" align=\"center\">\r\n<smallfont>Starter <cs>\r\n</td><td bgcolor=\"<tdheadbgcolor>\" align=\"center\">\r\n<smallfont>Last Poster <cs>\r\n</td><td bgcolor=\"<tdheadbgcolor>\" align=\"center\">\r\n<smallfont>Replies <cs>\r\n</td><td bgcolor=\"<tdheadbgcolor>\" align=\"center\">\r\n<smallfont>Views <cs>\r\n</td></tr>\r\n<topicrow>\r\n</table>\r\n</td></tr></table>\r\n<center><normalfont><pagelinks> <cn></center>', 'default')";
		$q[]="REPLACE arc_template VALUES (1990, 'stats_page', '', '<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"<tablebordercolor>\">\r\n<tr><td>\r\n<table width=\"100%\" cellspacing=\"1\" cellpadding=\"3\"><tr>\r\n<td bgcolor=\"<tdheadbgcolor>\">\r\n<normalfont><a href=\"<webroot>\"><sitename></a> &raquo; Statistics<cn>\r\n</td></tr><tr><td bgcolor=\"<tdbgcolor>\">\r\n\r\n<table width=\"100%\" cellspacing=\"5\">\r\n<tr><td width=\"50%\" valign=\"top\">\r\n<smallfont>\r\n<b>-Totals-</b><br>\r\nMembers: <numusers><br>\r\nForums: <numforums><br>\r\nTopics: <numtopics><br>\r\nPolls: <numpolls><br>\r\nPosts: <numposts><br>\r\nDays Running: <days_running><br>\r\n<cs>\r\n</td>\r\n<td width=\"50%\" valign=\"top\">\r\n<smallfont>\r\n<b>-Averages-</b><br>\r\nPosts Per Member: <postspermember><br>\r\nPosts Per Topic: <postspertopic><br>\r\nPosts Per Forum: <postsperforum><br>\r\nPosts Per Day: <postsperday><br>\r\nMembers Per Day: <membersperday><br>\r\n<cs>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td valign=\"top\"> \r\n<smallfont>\r\n<b>-<limit> Topics with the most views-</b><br>\r\n<topics2>\r\n<cs>\r\n</td>\r\n<td valign=\"top\">\r\n<smallfont>\r\n<b>-<limit> Topics with the most replies-</b><br>\r\n<topics1>\r\n<cs>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td valign=\"top\">\r\n<smallfont>\r\n<b>-<limit> Most Active Users-</b><br>\r\n<users1>\r\n<cs>\r\n</td>\r\n<td valign=\"top\">\r\n<smallfont>\r\n<b>-<limit> Most Recent Topics-</b><br>\r\n<topics3>\r\n<cs>\r\n</td></tr></table></td></tr></table>\r\n</td></tr></table>', 'default')";
		$q[]="REPLACE arc_template VALUES (1991, 'threadpoll', 'Top code for the poll posted as a thread.', '<table bgcolor=\"<tablebordercolor>\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" class=\"3dcell\" width=\"100%\" align=\"center\">\r\n<tr><td width=\"100%\">\r\n<table cellpadding=\"1\" cellspacing=\"1\" border=\"0\"  width=\"100%\">\r\n<tr><td bgcolor=\"<tdheadbgcolor>\">\r\n<normalfont>Answer<br /><cn>\r\n</td><td bgcolor=\"<tdheadbgcolor>\" align=\"center\">\r\n<normalfont>Votes (Total: <b><totalvotes></b>)<br /><cn>\r\n</td></tr>\r\n<threadpoll_row>\r\n</table></td></tr></table>', 'default')";
		$q[]="REPLACE arc_template VALUES (1992, 'threadpoll_row', 'Looping code for polls posted as a thread.', '<tr><td bgcolor=\"<tdheadbgcolor>\">\r\n<normalfont><answer>&nbsp;&nbsp;&nbsp;<votebutton><br /><cn>\r\n</td><td bgcolor=\"<tdheadbgcolor>\" width=\"140\">\r\n<normalfont>\r\n\r\n<img src=\"lib/images/bar/barleft.gif\" height=\"10\" border=\"0\" /><img src=\"lib/images/bar/bar-on.gif\" height=\"10\" border=\"0\" width=\"<votepercent>\" /><img src=\"lib/images/bar/bar-off.gif\" width=\"<leftover>\" height=\"10\" border=\"0\" /><img src=\"lib/images/bar/barright.gif\" height=\"10\" border=\"0\" /> \r\n\r\n<b><votesnum></b><br /><cn>\r\n</td></tr>', 'default')";
		$q[]="REPLACE arc_template VALUES (1989, 'statstable', 'Stats Table (extras vars: onlinecount, pageviews, buildtime)', '      <table bgcolor=\"<tablebordercolor>\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" class=\"3dcell\" width=\"100%\" align=\"center\">\r\n        <tr>\r\n          <td width=\"100%\">\r\n            <table cellpadding=\"1\" cellspacing=\"1\" border=\"0\"  width=\"100%\">\r\n              <tr>\r\n                <td width=\"100%\" valign=\"middle\" bgcolor=\"<tdendbgcolor>\">\r\n                  <smallfont>\r\n<div align=\"center\">\r\n<smallfont>»Registered Users: <b><numusers></b> | Users Online: <b><onlinecount></b> | Visitors Online: <b><visitorcount></b> | Views: <b><pageviews></b> | Page built in: <b><buildtime></b> seconds« <br /><cs>\r\n</div>\r\n                  <cs>\r\n                </td>\r\n              </tr>\r\n            </table>\r\n          </td>\r\n        </tr>\r\n      </table>', 'default')";
		$q[]="REPLACE arc_template VALUES (1980, 'shrine', '-shrinerow', '<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\"><tr><td bgcolor=\"<tablebordercolor>\"><table width=\"100%\" cellpadding=\"3\" cellspacing=\"1\"><tr>\r\n<td width=\"79%\" bgcolor=\"<tdendbgcolor>\">\r\n<normalfont>Shrine<br /><cn></td>\r\n<td bgcolor=\"<tdendbgcolor>\" width=\"7%\"><smallfont><b>Hits</b><br /><cn>\r\n</td>\r\n<td bgcolor=\"<tdendbgcolor>\" width=\"7%\"><smallfont><b>Posts</b><br /><cn>\r\n</td>\r\n<td bgcolor=\"<tdendbgcolor>\" width=\"7%\"><smallfont><b>Level</b><br /><cn>\r\n</td>\r\n</tr>\r\n<shrinerow>\r\n</table></td></tr></table>\r\n<center><normalfont><pagelinks><cn></center>\r\n<img src=\"lib/images/avatars/default.gif\" border=\"0\" width=\"10\" height=\"10\"></img>', 'default')";
		$q[]="REPLACE arc_template VALUES (1981, 'shrinepage', 'Shrine page index header -shrinekey,shrinepagerow', '<br />\r\n<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">\r\n  <tr>\r\n    <td bgcolor=\"<tablebordercolor>\">\r\n        <table width=\"100%\" cellpadding=\"3\" cellspacing=\"1\">\r\n          <tr>\r\n            <td width=\"15\" bgcolor=\"<tdheadbgcolor>\" align=\"center\">\r\n<smallfont>ID<br /><cs>\r\n            </td>\r\n            <td bgcolor=\"<tdheadbgcolor>\">\r\n<smallfont>\r\n<a href=\"index.php?action=shrines\">Shrines Index</a> &gt; <b><shrinekey></b> pages\r\n<br /><cs>\r\n            </td>\r\n            <td width=\"200\" bgcolor=\"<tdheadbgcolor>\">\r\n<smallfont>Last Modified<br /><cs>\r\n            </td>\r\n          </tr>\r\n<shrinepagerow>\r\n        </table>\r\n    </td>\r\n  </tr>\r\n</table>\r\n<center><normalfont><pagelinks><br /><cn></center>\r\n', 'default')";
		$q[]="REPLACE arc_template VALUES (1982, 'shrinepagerow', 'Shrine page list row -pagebitid,ptitle,pdate,userid,displayname', '<tr>\r\n  <td onclick=\"window.location.href=\'index.php?id=<pagebitid>\'\" onmouseover=\"this.className=\'mover\'\" onmouseout=\"this.className=\'mout\'\" bgcolor=\"<tdbgcolor>\" align=\"center\">\r\n<smallfont><a href=\"index.php?id=<pagebitid>\"><pagebitid></a><br /><cs>\r\n  </td>\r\n  <td onclick=\"window.location.href=\'index.php?action=<page>\'\" onmouseover=\"this.className=\'mover\'\" onmouseout=\"this.className=\'mout\'\" bgcolor=\"<tdbgcolor>\">\r\n<smallfont><a href=\"index.php?action=<page>\"><ptitle></a><br /><cs>\r\n  </td>\r\n  <td bgcolor=\"<tdbgcolor>\">\r\n<smallfont><pdate><br /><cs>\r\n  </td>\r\n</tr>', 'default')";
		$q[]="REPLACE arc_template VALUES (1983, 'shrinerow', '', '<tr><td width=\"79%\" bgcolor=\"<tdbgcolor>\">\r\n<normalfont><a href=\"staff.php?action=sindex&sid=<shrinekey>\"><stitle></a><cn><smallfont>-<a href=\"user.php?action=profile&id=<suserid>\"><susername></a>&nbsp;<i>Last modified: <lastmodified></i><br />\r\n<summary><br /><cs></td>\r\n<td bgcolor=\"<tdbgcolor>\" width=\"7%\" align=\"center\">\r\n<normalfont><b><shits></b><br /><cn>\r\n</td>\r\n<td bgcolor=\"<tdbgcolor>\" width=\"7%\" align=\"center\">\r\n<normalfont><b><scomments></b><br /><cn>\r\n</td>\r\n<td bgcolor=\"<tdbgcolor>\" width=\"7%\" align=\"center\">\r\n<normalfont><b><saccesslvl></b><br /><cn></td></tr>', 'default')";
		$q[]="REPLACE arc_template VALUES (1986, 'shrine_listrow', '', '<page><a href=\"', 'default')";
		$q[]="REPLACE arc_template VALUES (1987, 'stafflink', 'Shown when a logged in user has one or more shrines.', '<smallfont><a href=\\\"staff.php?action=listpagebits\\\">Shrine CP</a> <cs>', 'default')";
		$q[]="REPLACE arc_template VALUES (1988, 'staffmenu', '', '      <table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" bgcolor=\\\"<tablebordercolor>\\\"  align=\\\"center\\\">\r\n        <tr>\r\n          <td>\r\n            <table cellpadding=\\\"1\\\" cellspacing=\\\"1\\\" border=\\\"0\\\"  width=\\\"100%\\\">\r\n              <tr>\r\n                <td align=\\\"center\\\" valign=\\\"top\\\" bgcolor=\\\"<tdheadbgcolor>\\\">\r\n<normalfont>\r\n<a class=\\\"nav\\\" href=\\\"staff.php?action=Change\\\">Set Shrine</a> | \r\n<a class=\\\"nav\\\" href=\\\"staff.php?action=Edit_Shrine\\\">Edit Shrine Info</a> | \r\n<a class=\\\"nav\\\" href=\\\"staff.php?action=listpagebits\\\">View Pages</a> | \r\n<a class=\\\"nav\\\" href=\\\"staff.php?action=new_pagebit\\\">Add Page</a>\r\n<br>\r\n<cn>\r\n    </td>\r\n  </tr>\r\n</table>\r\n    </td>\r\n  </tr>\r\n</table>', 'default')";
		$q[]="REPLACE arc_template VALUES (1944, 'itopic', 'Topic code for image forums.', '<center><normalfont><pagelinks> <cn></center>\r\n<table bgcolor=\"<tablebordercolor>\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" class=\"3dcell\" width=\"100%\" align=\"center\">\r\n<tr><td width=\"100%\">\r\n<table cellpadding=\"1\" cellspacing=\"1\" border=\"0\"  width=\"100%\">\r\n<tr><td bgcolor=\"<tdheadbgcolor>\" align=\"center\" colspan=\"3\">\r\n<smallfont>Topic <cs>\r\n</td><td bgcolor=\"<tdheadbgcolor>\" align=\"center\">\r\n<smallfont>Starter <cs>\r\n</td><td bgcolor=\"<tdheadbgcolor>\" align=\"center\">\r\n<smallfont>Last Poster <cs>\r\n</td><td bgcolor=\"<tdheadbgcolor>\" align=\"center\">\r\n<smallfont>Replies <cs>\r\n</td><td bgcolor=\"<tdheadbgcolor>\" align=\"center\">\r\n<smallfont>Views <cs>\r\n</td></tr>\r\n<topicrow>\r\n</table>\r\n</td></tr></table>\r\n<center><normalfont><pagelinks> <cn></center>', 'default')";
		$q[]="REPLACE arc_template VALUES (1945, 'itopicrow', 'Looping topic display code in image forums.', '<tr>\r\n  <td bgcolor=\"<tdbgcolor>\">\r\n<newposts>\r\n  </td>\r\n  <td bgcolor=\"<tdbgcolor>\">\r\n<topicicon>\r\n  </td>\r\n  <td onclick=\"window.location.href=\'post.php?action=readcomments&ident=topic&id=<topicid>\'\" onmouseover=\"this.className=\'mover\'\" onmouseout=\"this.className=\'mout\'\" valign=\"middle\" bgcolor=\"<tdbgcolor>\">\r\n<a href=\"<description>\" target=\"_blank\" title=\"Click here to open this image in a new window\" ><img src=\"lib/images/download.jpg\" border=\"0\" /></a><normalfont>\r\n<topic_poll><b><u><a href=\"post.php?action=readcomments&ident=topic&id=<topicid>\"><threadicon><topicname></a></u></b> \r\n<pagelinks> \r\n<topic_closed><topic_pinned> <cn>\r\n  </td>\r\n  <td onclick=\"window.location.href=\'user.php?action=profile&id=<topic_starterid>\'\" onmouseover=\"this.className=\'mout\'\" onmouseout=\"this.className=\'mover\'\" bgcolor=\"<alttablebgcolor>\" valign=\"middle\" align=\"center\">\r\n<smallfont><a href=\"user.php?action=profile&id=<topic_starterid>\"><topic_starter></a> <cs>\r\n  </td>\r\n  <td onclick=\"window.location.href=\'user.php?action=profile&id=<last_posterid>\'\" onmouseover=\"this.className=\'mover\'\" onmouseout=\"this.className=\'mout\'\" bgcolor=\"<tdbgcolor>\" valign=\"middle\" align=\"center\">\r\n<smallfont><a href=\"user.php?action=profile&id=<last_posterid>\"><last_poster></a> <cs>\r\n  </td>\r\n  <td bgcolor=\"<alttablebgcolor>\" valign=\"middle\" align=\"center\">\r\n<normalfont><b><replies></b> <cn>\r\n  </td>\r\n  <td bgcolor=\"<tdbgcolor>\" valign=\"middle\" align=\"center\">\r\n<normalfont><b><hits></b><selectbox> <cn>\r\n  </td>\r\n</tr>', 'default')";
		$q[]="REPLACE arc_template VALUES (1946, 'latestpostrow', '-postuserid,postusername,topicid,postid,postdate,ident', '              <tr>\r\n                <td onclick=\"window.location.href=\'post.php?action=readcomments&ident=<ident>&id=<topicid>#<postid>\'\" onmouseover=\"this.className=\'lpover\'\" onmouseout=\"this.className=\'lpout\'\" bgcolor=\"<tablebgcolor>\" class=\"lpout\">\r\n                    <smallfont><a href=\"user.php?action=profile&id=<postuserid>\"><postusername></a> in <a href=\"post.php?action=readcomments&ident=<ident>&id=<topicid>#<postid>\"><ttitle></a> on <postdate> <newposts><br><cn>\r\n                </td>\r\n              </tr>', 'default')";
		$q[]="REPLACE arc_template VALUES (1947, 'latestposts', 'Latest post header -number_latest_posts', '<span class=\"navheader\">Latest Threads</span>\r\n                  <table width=\"100%\" cellpadding=\"1\" cellspacing=\"2\">\r\n<latestpostrow>\r\n                  </table>\r\n', 'default')";
		$q[]="REPLACE arc_template VALUES (1948, 'latest_articlerow', '', '              <tr>\r\n                <td onclick=\\\"window.location.href=\'?action=<page>\'\\\" onmouseover=\\\"this.className=\'lpover\'\\\" onmouseout=\\\"this.className=\'lpout\'\\\" bgcolor=\\\"<tablebgcolor>\\\" class=\\\"lpout\\\">\r\n<smallfont><a href=\\\"?action=<page>\\\"><ptitle></a> on <pdate> <cs>\r\n                </td>\r\n              </tr>\r\n', 'default')";
		$q[]="REPLACE arc_template VALUES (1999, 'usermenu', '', '<select class=\\\"selects\\\" name=\\\"action\\\" onChange=\\\"window.location=(\'<webroot>/\'+this.options[this.selectedIndex].value);\\\">\r\n<option value=\\\"index.php\\\" selected=\\\"selected\\\">:: User Menu ::</option>\r\n<option value=\\\"user.php\\\">View Notepad</option>\r\n<option value=\\\"user.php?action=EditProfile\\\">Edit Profile</option>\r\n<option value=\\\"user.php?action=EditOptions\\\">Edit Options</option>\r\n<option value=\\\"user.php?action=EditTemplates\\\">Edit Post Templates</option>\r\n<option value=\\\"privatemsg.php?action=Inbox\\\">PM Inbox</option>\r\n<option value=\\\"user.php?action=Logout\\\">Logout</option>\r\n</select>', 'default')";
		$q[]="REPLACE arc_template VALUES (1998, 'userlistrow', 'Looping memberlist content', '  <tr>\r\n    <td bgcolor=\\\"<alt_bg>\\\" align=\\\"center\\\">\r\n<smallfont><deleter><userid></a> <cs>\r\n    </td>\r\n    <td bgcolor=\\\"<alt_bg>\\\" align=\\\"center\\\">\r\n<smallfont><a href=\'user.php?action=profile&id=<userid>\'><username></a> <cs>\r\n    </td>\r\n    <td bgcolor=\\\"<alt_bg>\\\" align=\\\"center\\\">\r\n<smallfont><a href=\\\"<homepage>\\\">WWW</a> <cs>\r\n    </td>\r\n    <td bgcolor=\\\"<alt_bg>\\\" align=\\\"center\\\">\r\n<smallfont><a href=\\\"mail.php?id=<userid>\\\">Send Mail</a> <cs>\r\n    </td>\r\n    <td bgcolor=\\\"<alt_bg>\\\" align=\\\"center\\\">\r\n<smallfont><topic_count> <cs>\r\n    </td>\r\n    <td bgcolor=\\\"<alt_bg>\\\" align=\\\"center\\\">\r\n<smallfont><post_count> <cs>\r\n    </td>\r\n    <td bgcolor=\\\"<alt_bg>\\\" align=\\\"center\\\">\r\n<smallfont><note_count> <cs>\r\n    </td>\r\n  </tr>', 'default')";
		$q[]="REPLACE arc_template VALUES (1935, 'globalpoll', '', '<table class=\\\"tbl\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" width=\\\"95%\\\" align=\\\"center\\\">\r\n<tr><td width=\\\"100%\\\">\r\n<table cellpadding=\\\"1\\\" cellspacing=\\\"1\\\" border=\\\"0\\\"  width=\\\"100%\\\">\r\n<tr><td colspan=\\\"2\\\" bgcolor=\\\"<tdheadbgcolor>\\\">\r\n<largefont>Latest Poll: <question> <cl>\r\n</td></tr>\r\n<tr><td bgcolor=\\\"<tdheadbgcolor>\\\">\r\n<smallfont>Answer<br><cs>\r\n</td><td width=\\\"140\\\" bgcolor=\\\"<tdheadbgcolor>\\\" align=\\\"center\\\">\r\n<smallfont>Votes (Total: <b><totalvotes></b>)<br><cs>\r\n</td></tr>\r\n<globalpoll_row>\r\n</table></td></tr></table>\r\n<center><votebutton></center>', 'default')";
		$q[]="REPLACE arc_template VALUES (1936, 'globalpoll_row', '', '<tr><td bgcolor=\\\"<alt_bg>\\\">\r\n<smallfont><answer> <votebutton><br><cs>\r\n</td><td bgcolor=\\\"<alt_bg>\\\">\r\n<smallfont>\r\n<img src=\\\"lib/images/bar/barleft.gif\\\" height=\\\"10\\\" border=\\\"0\\\" /><img src=\\\"lib/images/bar/bar-on.gif\\\" height=\\\"10\\\" border=\\\"0\\\" width=\\\"<votepercent>\\\" /><img src=\\\"lib/images/bar/bar-off.gif\\\" width=\\\"<leftover>\\\" height=\\\"10\\\" border=\\\"0\\\" /><img src=\\\"lib/images/bar/barright.gif\\\" height=\\\"10\\\" border=\\\"0\\\" /> \r\n\r\n<b><votesnum></b><br><cs>\r\n</td></tr>', 'default')";
		$q[]="REPLACE arc_template VALUES (1937, 'global_fighter', 'level,hp,mp,curhp,curmp,avatar,name,gold,sp,spritepath', 'Welcome, <name> <br>', 'default')";
		$q[]="REPLACE arc_template VALUES (1938, 'guestmenu', 'Code insert into header or footer when not logged in.', '<form action=\\\"user.php?action=login_confirm\\\" method=\\\"post\\\">\r\n<smallfont>\r\n<a href=\\\"<webroot>/user.php?action=Register\\\">Register</a>\r\n<br>\r\nUsername:<br>\r\n<input type=\\\"text\\\" size=\\\"15\\\" maxlength=\\\"80\\\" name=\\\"lusername\\\" />\r\n<br>\r\nPassword:<br>\r\n<input type=\\\"password\\\" size=\\\"15\\\" maxlength=\\\"80\\\" name=\\\"lpassword\\\" />\r\n<br>\r\n<input type=\\\"hidden\\\" name=\\\"referer\\\" value=\\\"<webroot>\\\" />\r\n<input type=\\\"submit\\\" value=\\\"Login\\\" /> \r\n<cs>\r\n</form>\r\n', 'default')";
		$q[]="REPLACE arc_template VALUES (1939, 'header', 'Page Header', '<meta HTTP-EQUIV=\\\"content-type\\\" CONTENT=\\\"text/html; charset=UTF-8\\\">\r\n<meta name=\\\"category\\\" content=\\\"home page\\\" />\r\n<meta name=\\\"robots\\\" content=\\\"index,follow\\\" />\r\n<meta name=\\\"revisit-after\\\" content=\\\"3 days\\\" />\r\n<style type=\\\"text/css\\\">\r\nBODY {\r\n<bodycss>\r\n cursor: <cursor>;\r\n margin: 0px;\r\n }\r\nINPUT, TEXTAREA, SELECT {\r\n background: <tdendbgcolor>;\r\n font-family: arial;\r\n font-size: 12px;\r\n color: <fontcolor>;\r\n border: 1px solid <tablebordercolor>;\r\n}\r\nA:LINK {\r\n color: <linkcolor>;\r\n font-weight: <linkweight>;\r\n text-decoration: <linkdecoration>;\r\n cursor: <linkcursor>;\r\n }\r\nA:VISITED {\r\n color: <vlinkcolor>;\r\n font-weight: <linkweight>;\r\n text-decoration: <linkdecoration>;\r\n cursor: <linkcursor>;\r\n }\r\nA:ACTIVE {\r\n color: <alinkcolor>;\r\n font-weight: <linkweight>;\r\n text-decoration: <linkdecoration>;\r\n cursor: <linkcursor>;\r\n }\r\nA:HOVER {\r\n color: <hovercolor>;\r\n font-weight: <hoverweight>;\r\n font-style: <hoverstyle>;\r\n cursor: <linkcursor>;\r\n }\r\n.lpover {\r\n background: <alttablebgcolor>; \r\n border: 1px solid <tablebordercolor>;\r\n} \r\n.lpout { \r\n background: <tdbgcolor>; \r\n border: 1px solid <tdbgcolor>;\r\n }\r\n.mover { \r\n background: <alttablebgcolor>; \r\n }\r\n.mout { \r\n background: <tdbgcolor>; \r\n }\r\n.selects {\r\n font-size: 10px;\r\n}\r\n.nav {\r\n font-family: \\\"Arial,Verdana,Tahoma\\\";\r\n font-size: 11px;\r\n }\r\n.navcell {\r\n width: 190px;\r\n height: 90px; \r\n font-size: 11px; \r\n overflow: auto;\r\n clip: rect(); \r\n}\r\n.navheader {\r\n text-align: center;\r\n font-family: verdana,arial,tahoma;\r\n font-size: 11px;\r\n width: 100%;\r\n background: <tdheadbgcolor>;\r\n border-top: 1px solid #eeeeee;\r\n border-left: 1px solid #eeeeee;\r\n border-right: 1px solid #000000;\r\n border-bottom: 1px solid #000000;\r\n}\r\n.navselect {\r\n font-size: 10px;\r\n font-family: verdana,arial,tahoma;\r\n}\r\ntd.cel {\r\n background-color: <tdbgcolor>;\r\n padding-left: 5px;\r\n padding-right: 5px;\r\n}\r\n.tbl {\r\n border: 1px solid <tablebordercolor>; \r\n margin-bottom: 10px;\r\n}\r\n.txt {\r\n font-family: verdana, tahoma, arial;;\r\n font-size: 11px;\r\n} \r\n</style>\r\n<script type=\\\"text/javascript\\\" language=\\\"Javascript\\\">\r\n// <!--\r\nfunction popitem(url, width, height)\r\n{	\r\nwoptions=\\\"scrollbars=yes\\\"+\\\",width=\\\"+width+\\\",height=\\\"+height;\r\nspiffy=window.open(url, \\\"itemwindow\\\", woptions);\r\nspiffy.focus();\r\n}\r\n\r\nfunction disablesubmit(theform) {\r\n  if (document.all || document.getElementById) {\r\n    for (i = 0; i < theform.length; i++) {\r\n      var tempobj = theform.elements[i];\r\n      if (tempobj.type.toLowerCase() == \\\"submit\\\" || tempobj.type.toLowerCase() == \\\"reset\\\")\r\n        tempobj.disabled = true;\r\n    }\r\n    return true;\r\n  } else {\r\n    return false;\r\n  }\r\n}\r\n// -->\r\n</script>\r\n<js>\r\n<headtaginsert>\r\n</head>\r\n<body bgcolor=\\\"<bgcolor>\\\" text=\\\"<fontcolor>\\\" link=\\\"<linkcolor>\\\" alink=\\\"<alinkcolor>\\\" vlink=\\\"<vlinkcolor>\\\" <bodytaginsert>>\r\n<header>\r\n<form>\r\n<table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" bgcolor=\\\"<tablebordercolor>\\\">\r\n  <tr>\r\n    <td>\r\n      <table cellpadding=\\\"4\\\" cellspacing=\\\"0\\\" border=\\\"0\\\"  width=\\\"100%\\\">\r\n        <tr>\r\n          <td style=\\\"cellpadding: 0px;\\\" bgcolor=\\\"<tablebgcolor>\\\" valign=\\\"middle\\\" rowspan=\\\"2\\\" align=\\\"center\\\">\r\n<a href=\\\"<webroot>\\\"><img src=\\\"<webroot>/<logo>\\\" border=\\\"0\\\" /></a>\r\n          </td>\r\n          <td colspan=\\\"3\\\" bgcolor=\\\"<tablebgcolor>\\\" align=\\\"center\\\">\r\n<smallfont>\r\n<a href=\\\"<webroot>/?action=News\\\">Home</a> | \r\n<a href=\\\"<webroot>/forums.php\\\">Forums</a> |\r\n<a href=\\\"<webroot>/?action=Shrines\\\">Shrines</a> |\r\n<a href=\\\"<webroot>/download.php\\\">Downloads</a> |\r\n<a href=\\\"<webroot>/faq.php\\\">FAQ</a> |\r\n<a href=\\\"<webroot>/search.php\\\">Search</a> |\r\n<a href=\\\"<webroot>/calendar.php\\\">Calendar</a> | \r\n<a href=\\\"<webroot>/user.php?action=list\\\">Members</a> |\r\n<a href=\\\"<webroot>/note.php?action=Archive\\\">Notes</a> | \r\n<a href=\\\"<webroot>/stats.php\\\">Stats</a> \r\n<cs>\r\n          </td>\r\n</tr>\r\n<tr>\r\n  <td bgcolor=\\\"<tablebgcolor>\\\" valign=\\\"top\\\" align=\\\"left\\\">\r\n<div class=\\\"navcell\\\"><table width=\\\"170\\\" border=\\\"0\\\" cellspacing=\\\"0\\\" cellpadding=\\\"1\\\"><tr><td valign=\\\"top\\\">\r\n</form>\r\n<center><smallfont>\r\n<adminmenu>\r\n<global_fighter>\r\n<usermenu><guestmenu><br>\r\n<stafflink>\r\n<cs>\r\n</center>\r\n<cn>\r\n</td></tr></table></div>\r\n\r\n</td><td align=\\\"center\\\" bgcolor=\\\"<tablebgcolor>\\\">\r\n\r\n<div class=\\\"navcell\\\"><table width=\\\"100%\\\" border=\\\"0\\\" cellspacing=\\\"0\\\" cellpadding=\\\"1\\\"><tr><td valign=\\\"top\\\">\r\n<span class=\\\"navheader\\\">Statistics </span>\r\n<normalfont><span class=\\\"nav\\\">\r\n<b>Latest User:</b> <latestuser><br>\r\n<b>Members:</b> <numusers><br>\r\n<b>Topics:</b> <numtopics><br>\r\n<b>Posts:</b> <numposts><br>\r\n<b>Notes:</b> <numnotes><br>\r\n<b>Online Users:</b> <onlinecount><br>\r\n<b>Online Guests:</b> <visitorcount><br>\r\n<b>Most Users Online:</b> <mostusersonline><b><br>\r\n<onlinedisplay>\r\n</span>\r\n</td></tr></table></div>\r\n\r\n</td><td align=\\\"center\\\" bgcolor=\\\"<tablebgcolor>\\\">\r\n\r\n<div class=\\\"navcell\\\"><table width=\\\"100%\\\" border=\\\"0\\\" cellspacing=\\\"0\\\" cellpadding=\\\"1\\\"><tr><td valign=\\\"top\\\">\r\n<latest>\r\n</td></tr></table></div>\r\n\r\n</td></tr></table></td></tr></table>\r\n<center>\r\n<table style=\\\"margin-top: 10px;\\\" width=\\\"95%\\\" border=\\\"0\\\" cellspacing=\\\"0\\\" cellpadding=\\\"0\\\"><tr><td align=\\\"center\\\">\r\n<usercpmenu><staffmenu><privatemsgmenu><pagemenu>\r\n<smallfont><newpms> <battlemsg><cs><br>\r\n<forums_menu>\r\n', 'default')";
		$q[]="REPLACE arc_template VALUES (1933, 'ftopic', '-ftopicrow', '<center><normalfont><pagelinks> <cn></center>\r\n<table bgcolor=\"<tablebordercolor>\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\" align=\"center\">\r\n<tr><td width=\"100%\">\r\n<table cellpadding=\"1\" cellspacing=\"1\" border=\"0\"  width=\"100%\">\r\n<tr><td bgcolor=\"<tdheadbgcolor>\" align=\"center\" colspan=\"3\">\r\n<smallfont>Topic <cs>\r\n</td><td bgcolor=\"<tdheadbgcolor>\" align=\"center\">\r\n<smallfont>Starter <cs>\r\n</td><td bgcolor=\"<tdheadbgcolor>\" align=\"center\">\r\n<smallfont>Last Poster <cs>\r\n</td><td bgcolor=\"<tdheadbgcolor>\" align=\"center\">\r\n<smallfont>Replies <cs>\r\n</td><td bgcolor=\"<tdheadbgcolor>\" align=\"center\">\r\n<smallfont>Views <cs>\r\n</td></tr>\r\n<topicrow>\r\n</table>\r\n</td></tr></table>\r\n<center><normalfont><pagelinks> <cn></center>', 'default')";
		$q[]="REPLACE arc_template VALUES (1934, 'ftopicrow', '', '<tr>\r\n  <td bgcolor=\"<tdbgcolor>\">\r\n<newposts>\r\n  </td>\r\n  <td bgcolor=\"<tdbgcolor>\">\r\n<topicicon>\r\n  </td>\r\n  <td onclick=\"window.location.href=\'post.php?action=readcomments&ident=topic&id=<topicid>\'\" onmouseover=\"this.className=\'mover\'\" onmouseout=\"this.className=\'mout\'\" valign=\"middle\" bgcolor=\"<tdbgcolor>\">\r\n<a href=\"<description>\" target=\"_blank\" title=\"Click here to open this image in a new window\" ><img src=\"lib/images/download.jpg\" border=\"0\" /></a><normalfont>\r\n<topic_poll><b><u><a href=\"post.php?action=readcomments&ident=topic&id=<topicid>\"><threadicon><topicname></a></u></b> \r\n<pagelinks> \r\n<topic_closed><topic_pinned> <cn>\r\n  </td>\r\n  <td onclick=\"window.location.href=\'user.php?action=profile&id=<topic_starterid>\'\" onmouseover=\"this.className=\'mout\'\" onmouseout=\"this.className=\'mover\'\" bgcolor=\"<alttablebgcolor>\" valign=\"middle\" align=\"center\">\r\n<smallfont><a href=\"user.php?action=profile&id=<topic_starterid>\"><topic_starter></a> <cs>\r\n  </td>\r\n  <td onclick=\"window.location.href=\'user.php?action=profile&id=<last_posterid>\'\" onmouseover=\"this.className=\'mover\'\" onmouseout=\"this.className=\'mout\'\" bgcolor=\"<tdbgcolor>\" valign=\"middle\" align=\"center\">\r\n<smallfont><a href=\"user.php?action=profile&id=<last_posterid>\"><last_poster></a> <cs>\r\n  </td>\r\n  <td bgcolor=\"<alttablebgcolor>\" valign=\"middle\" align=\"center\">\r\n<normalfont><b><replies></b> <cn>\r\n  </td>\r\n  <td bgcolor=\"<tdbgcolor>\" valign=\"middle\" align=\"center\">\r\n<normalfont><b><hits></b><selectbox> <cn>\r\n  </td>\r\n</tr>', 'default')";
		$q[]="REPLACE arc_template VALUES (1900, 'banned', '', '<sitename> has been disabled by it\'s webmaster.', 'default')";
		$q[]="REPLACE arc_template VALUES (1919, 'faq2', '-faqrow', '<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\"><tr><td bgcolor=\"<tablebordercolor>\"><table width=\"100%\" cellpadding=\"3\" cellspacing=\"1\">\r\n<tr><td bgcolor=\"<tdheadbgcolor>\">\r\n\r\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"<tdbgcolor>\">\r\n<tr><td>\r\n<smallfont>Question<br /><cs>\r\n</td><td width=\"30\">\r\n<smallfont>Hits<br /><cs></td></tr>\r\n<faqrow>\r\n</table>\r\n</td></tr>\r\n</table></td></tr></table>', 'default')";
		$q[]="REPLACE arc_template VALUES (1920, 'faqgroup', '-faqgrouprow', '<img src=\"<webroot>/lib/images/avatars/default.gif\" border=\"0\" height=\"8\" /><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\"><tr><td bgcolor=\"<tablebordercolor>\"><table width=\"100%\" cellpadding=\"3\" cellspacing=\"1\">\r\n<faqgrouprow>\r\n</table></td></tr></table>', 'default')";
		$q[]="REPLACE arc_template VALUES (1921, 'faqgrouprow', '-faqgroupname', '<tr><td class=\"3dcell\" width=\"100%\" bgcolor=\"<tdheadbgcolor>\" align=\"center\"><normalfont><faqgroupname><br /><cn>\r\n</td></tr>', 'default')";
		$q[]="REPLACE arc_template VALUES (1922, 'faqrow', '', '<tr>\r\n  <td>\r\n<smallfont><a href=\"faq.php?action=View&id=<faqid>\"><faqq></a><br><cs>\r\n  </td>\r\n  <td><smallfont><b><faqhits></b><br><cs>\r\n  </td>\r\n</tr>', 'default')";
		$q[]="REPLACE arc_template VALUES (1923, 'faqtoolbar', 'Displayed everywhere on the faq.php file.', '', 'default')";
		$q[]="REPLACE arc_template VALUES (1924, 'findpostlist', 'template used for posts retrieved with *find all posts* links', '<center>\r\n<normalfont><msg><br />\r\n<pagelinks>\r\n<cn>\r\n<div align=\"right\">\r\n<smallfont>Total: <totalposts><cs>\r\n</div>\r\n<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\"><tr><td bgcolor=\"<tablebordercolor>\"><table width=\"100%\" cellpadding=\"3\" cellspacing=\"1\">\r\n<findpostlistrows>\r\n</table>\r\n</td>\r\n</tr></table>\r\n<normalfont>\r\n<pagelinks>\r\n<cn>\r\n</center>', 'default')";
		$q[]="REPLACE arc_template VALUES (1925, 'findpostlistrow', 'tags: displayname,postcontent,postdate', '<tr>\r\n<td bgcolor=\"<alt_bg>\" width=\"30%\" valign=\"top\">\r\n<smallfont><a href=\"user.php?action=profile&id=<postuserid>\"><displayname></a>\r\n<br><msg>\r\n<cs>\r\n</td>\r\n<td bgcolor=\"<alt_bg>\" width=\"70%\" valign=\"top\">\r\n<smallfont>\r\n<b>Excerpt:</b> <postcontent>\r\n<br>\r\n<b>Posted:</b> <postdate>\r\n<cs>\r\n</td>\r\n</tr>\r\n', 'default')";
		$q[]="REPLACE arc_template VALUES (1926, 'footer', 'Page Footer', '<br>\r\n<forumjump>\r\n<br>\r\n<poll>\r\n<notes>\r\n<smallfont><randomquote><cs>\r\n<br>\r\n<smallfont>Powered by Seir Anphin [WDYL] Rls</a> <version><br>\r\n[ GZIP Compression <b>active</b> | \r\nSQL Queries Performed: <b><numberqueries></b> | \r\nPage built in: <b><buildtime></b> ]\r\n<br><cs>\r\n</td></tr></table>\r\n</center>\r\n</body>\r\n</html>', 'default')";
		$q[]="REPLACE arc_template VALUES (1830, 'forumtoolbar', 'Link toolbar shown in forums.', '<table width=\"100%\">\r\n  <tr>\r\n    <td align=\"left\" valign=\"top\" width=\"65%\">\r\n        <normalfont><forumhome> &gt; <catlink> &gt; <b><forumname></b><br /><cn>\r\n<newtopiclink>\r\n    </td>\r\n    <td align=\"center\" valign=\"top\" width=\"35%\">\r\n        <normalfont>\r\n        Topics: <b><topics></b> &nbsp; &nbsp; Posts: <b><posts></b>\r\n        <cn>\r\n <form method=\"get\" action=\"topic.php\">\r\n  <select name=\"poll\">\r\n    <option selected=\"selected\" value=\"2\">2\r\n    <option value=\"3\">3\r\n    <option value=\"4\">4\r\n    <option value=\"5\">5\r\n    <option value=\"6\">6\r\n    <option value=\"7\">7\r\n    <option value=\"8\">8\r\n    <option value=\"9\">9\r\n    <option value=\"10\">10\r\n  </select>\r\n  <input type=\"hidden\" name=\"action\" value=\"newtopic\" />\r\n  <input type=\"hidden\" name=\"fid\" value=\"<fid>\" />\r\n  <input type=\"submit\" value=\"Post Poll\" />\r\n </form>\r\n    </td>\r\n  </tr>\r\n</table>\r\n<center>', 'default')";
		$q[]="REPLACE arc_template VALUES (1829, 'forums_menu', '', '<div align=\"right\">\r\n      <table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" bgcolor=\"<tablebordercolor>\">\r\n        <tr>\r\n          <td>\r\n            <table cellpadding=\"1\" cellspacing=\"1\" border=\"0\"  width=\"100%\">\r\n              <tr>\r\n                <td align=\"center\" valign=\"top\" bgcolor=\"<tdheadbgcolor>\">\r\n<normalfont>\r\n<a class=\"nav\" href=\"forums.php?markread=1\">Update Read Markers</a> | \r\n<a class=\"nav\" href=\"find.php?action=posts&todays_posts=1\">Today\'s Posts</a> | \r\n<a class=\"nav\" href=\"find.php?action=posts&unread_posts=1\">Unread Posts</a>\r\n<cn>\r\n</td></tr></table>\r\n</td></tr></table>\r\n</div>', 'default')";
		$q[]="REPLACE arc_template VALUES (1828, 'forumrow', 'Looping HTML for forum lists.', '<tr>\r\n  <td bgcolor=\"<tdbgcolor>\">\r\n<smallfont><newposts><cs>\r\n  </td>\r\n  <td onclick=\"window.location.href=\'topic.php?action=Forum&fid=<fid>\'\" onmouseover=\"this.className=\'mover\'\" onmouseout=\"this.className=\'mout\'\" valign=\"middle\" bgcolor=\"<tdbgcolor>\" width=\"62%\">\r\n<normalfont><forumname><cn><smallfont> Moderator: <b><moderator></b> <br>\r\n<description><br><cs>\r\n  </td>\r\n  <td onclick=\"window.location.href=\'post.php?action=readcomments&ident=topic&id=<lasttopicid>\'\"  onmouseover=\"this.className=\'mout\'\" onmouseout=\"this.className=\'mover\'\" bgcolor=\"<alttablebgcolor>\" width=\"26%\">\r\n<smallfont><lastposter> -&gt; <lasttopic> <a title=\"Would somebody please design an icon to replace this ugly thing?\" href=\"post.php?action=readcomments&ident=topic&id=<lasttopicid>&lastpage=1\">[*]</a>\r\n<cs>\r\n  </td>\r\n  <td bgcolor=\"<tdbgcolor>\" align=\"center\" width=\"6%\"valign=\"middle\">\r\n<normalfont><b><forum_topics></b><br /><cn>\r\n  </td>\r\n  <td bgcolor=\"<alttablebgcolor>\" align=\"center\" width=\"6%\" valign=\"middle\">\r\n<normalfont><b><forum_posts></b><br /><cn>\r\n  </td>\r\n</tr>', 'default')";
		$q[]="REPLACE arc_template VALUES (2000, 'onlinepage', 'Who\'s online display (online page)', '<table bgcolor=\"<tablebordercolor>\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" class=\"3dcell\" width=\"100%\" align=\"center\">\r\n<tr><td width=\"100%\">\r\n<table cellpadding=\"1\" cellspacing=\"1\" border=\"0\"  width=\"100%\">\r\n<tr>\r\n<td bgcolor=\"<tdendbgcolor>\">\r\n<smallfont>Username<br><cs>\r\n</td><td bgcolor=\"<tdendbgcolor>\">\r\n<smallfont>Last Viewing<br><cs>\r\n</td><td bgcolor=\"<tdendbgcolor>\">\r\n<smallfont>Last Active<br><cs>\r\n</td>\r\n</tr>\r\n<onlinepagerow>\r\n</table>\r\n</td></tr></table>\r\n<center>\r\n<normalfont>\r\n<pagelinks>\r\n<cn>\r\n</center>', 'default')";
		$q[]="REPLACE arc_template VALUES (1827, 'forum', 'Forum List Code -forumrow', '<table bgcolor=\"<tablebordercolor>\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" class=\"3dcell\" width=\"100%\" align=\"center\">\r\n<tr><td width=\"100%\">\r\n<table cellpadding=\"1\" cellspacing=\"1\" border=\"0\"  width=\"100%\">\r\n<tr><td bgcolor=\"<tdheadbgcolor>\" width=\"62%\" colspan=\"2\">\r\n<smallfont>Forum<br /><cs>\r\n</td><td bgcolor=\"<tdheadbgcolor>\" align=\"center\" width=\"26%\">\r\n<smallfont>Last Post<br /><cs>\r\n</td><td bgcolor=\"<tdheadbgcolor>\" align=\"center\" width=\"6%\">\r\n<smallfont>Threads<br /><cs>\r\n</td><td bgcolor=\"<tdheadbgcolor>\" align=\"center\" width=\"6%\">\r\n<smallfont>Posts<br /><cs>\r\n</td></tr>\r\n<forumrow>\r\n</table>\r\n</td></tr></table>', 'default')";
		$q[]="REPLACE arc_template VALUES (2001, 'dlcatlist', 'Download category list', '      <table style=\\\"border: 1px solid <tablebordercolor>;\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" bgcolor=\\\"<tablebordercolor>\\\"  width=\\\"90%\\\" align=\\\"center\\\">\r\n        <tr>\r\n          <td>\r\n            <table cellpadding=\\\"3\\\" cellspacing=\\\"0\\\" border=\\\"0\\\"  width=\\\"100%\\\">\r\n              <tr>\r\n                <td colspan=\\\"<dlcat_columns>\\\" align=\\\"center\\\" valign=\\\"top\\\" bgcolor=\\\"<tdendbgcolor>\\\">\r\n                  <largefont><uponelevel> <parentcategory> <cl><br>\r\n                </td>\r\n              </tr>\r\n              <dlcatlistrows>\r\n            </table>\r\n          </td>\r\n        </tr>\r\n      </table>', 'default')";
		$q[]="REPLACE arc_template VALUES (1815, 'expchanged', '-expmod,spmod,sp,goldmod,levxp,change,userid,displayname,exptogo,exp,gold', '<smallfont>\r\nYou have <change> <b><expmod></b> EXP,  <b><spmod></b> SP and <b><goldmod></b> gold.\r\n<cs>', 'default')";
		$q[]="REPLACE arc_template VALUES (1816, 'faq', '', '<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\"><tr><td bgcolor=\"<tablebordercolor>\"><table width=\"100%\" cellpadding=\"3\" cellspacing=\"1\">\r\n<tr><td bgcolor=\"<tdheadbgcolor>\">\r\n<normalfont><a href=\"faq.php\">FAQ Index</a> &gt; <faqq><br /><cn>\r\n</td></tr>\r\n<tr><td width=\"100%\" bgcolor=\"<tdbgcolor>\">\r\n<normalfont><faqa><br /><cn>\r\n</td></tr>\r\n</table>\r\n</td></tr></table>\r\n<center><smallfont>This FAQ has been viewed <b><faqhits></b> times.<br /><cs></center>', 'default')";
		$q[]="REPLACE arc_template VALUES (2002, 'dlcatlistrow', 'Download category list rows. These are wrapped in &lt;tr&gt; tags to form rows every x number of columns where x is the value of the display setting dlcat_columns.', '                <td width=\"<width>\" bgcolor=\"<tdbgcolor>\" align=\"center\" valign=\"top\">\r\n<normalfont>\r\n<a href=\"download.php?category=<id>\"><name></a> (<files>)<br>\r\n<description> \r\n<cn>\r\n                </td>', 'default')";
		$q[]="REPLACE arc_template VALUES (2003, 'downloadlist', 'Download file list.', '      <table style=\"border: 1px solid <tablebordercolor>;\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" bgcolor=\"<bgcolor>\"  width=\"90%\" align=\"center\">\r\n        <tr>\r\n          <td>\r\n            <table cellpadding=\"3\" cellspacing=\"0\" border=\"0\"  width=\"100%\">\r\n              <tr>\r\n                <td width=\"60%\" bgcolor=\"<tdheadbgcolor>\">\r\n                  <smallfont><b><u>File Name</u></b> <cs>\r\n                </td>\r\n                <td align=\"center\" width=\"30%\" bgcolor=\"<tdheadbgcolor>\">\r\n                  <smallfont><b><u>Date Added</u></b> <cs>\r\n                </td>\r\n                <td align=\"center\" width=\"10%\" bgcolor=\"<tdheadbgcolor>\">\r\n                  <smallfont><b><u>Downloads </u></b> <cs>\r\n                </td>\r\n              </tr>\r\n              <downloadlistrows>\r\n            </table>\r\n          </td>\r\n        </tr>\r\n      </table>\r\n<normalfont><pagelinks> <cn>', 'default')";
		$q[]="REPLACE arc_template VALUES (1810, 'cp_mainpage', 'Control panel main code', '<center><font size=\\\"5\\\" face=\\\"helvetica\\\"><b>Seir Anphin Administrative Control Panel</b></font>\r\n</center>\r\n<table style=\\\"border: 1px solid #000000;\\\" border=\\\"0\\\" width=\\\"100%\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" bgcolor=\\\"#ffffff\\\"><tr><td>\r\n<table width=\\\"100%\\\" cellspacing=\\\"1\\\" cellpadding=\\\"3\\\"><tr>\r\n<td colspan=\\\"3\\\" bgcolor=\\\"#000000\\\" align=\\\"center\\\" height=\\\"25\\\">\r\n<font size=\\\"-2\\\" face=\\\"verdana\\\" color=\\\"#ffffff\\\">\r\n<b><u>Database Overview</u></b>\r\n</font>\r\n</td></tr>\r\n<td bgcolor=\\\"#d0d0d0\\\" width=\\\"33%\\\">\r\n<font size=\\\"-2\\\" face=\\\"verdana\\\" color=\\\"#000000\\\">\r\nForums: <forums><br>\r\nForum Categories: <forum_categories><br>\r\nTopics: <topics><br>\r\nPosts: <posts><br>\r\nPolls: <polls><br>\r\nNotes: <notes><br>\r\n</font>\r\n</td>\r\n<td bgcolor=\\\"#d0d0d0\\\" width=\\\"33%\\\">\r\n<font size=\\\"-2\\\" face=\\\"verdana\\\" color=\\\"#000000\\\">\r\nTemplates: <templates><br>\r\nStylesets: <styles><br>\r\nDownloads: <downloads><br>\r\nDownload Categories: <dlcats><br>\r\nFAQs: <faqs><br>\r\nFAQ Groups: <faqgroups><br>\r\n</font>\r\n</td>\r\n<td bgcolor=\\\"#d0d0d0\\\" width=\\\"33%\\\">\r\n<font size=\\\"-2\\\" face=\\\"verdana\\\" color=\\\"#000000\\\">\r\nMembers: <users><br>\r\nGuests: <visitors><br>\r\nAvatars: <avatars><br>\r\nPrivate Messages: <pms><br>\r\nShrines: <shrines><br>\r\nRandom Quotes: <quotes><br>\r\n</font>\r\n</td>\r\n</tr></table>\r\n</td></tr></table>\r\n<br>\r\n<table width=\\\"100%\\\" border=\\\"0\\\"><tr><td align=\\\"center\\\">\r\n<font size=\\\"-2\\\" face=\\\"verdana\\\" color=\\\"#000000\\\">\r\n\r\n[ <a href=\\\"<webroot>\\\" target=\\\"_self\\\"><sitename></a> | <a href=\\\"http://www.wdyl.com\\\" target=\\\"_self\\\">Anphin Development [WDYL] Rls</a> ]\r\n\r\n<br><br>\r\nYou have reached the Administrative control panel for Seir Anphin. Unless you are an Administrator you will only be able to view lists of the various items in the database.\r\n<br><br>\r\nThis site is running Seir Anphin <version>.\r\n</font>\r\n</td></tr></table>\r\n<br>\r\n<center>\r\n<font size=\\\"-1\\\" face=\\\"verdana\\\">Copyright © Anphin Development 2002,2003 [WDYL] Rls</font>\r\n</center>\r\n<br>', 'default')";
		$q[]="REPLACE arc_template VALUES (1809, 'common_message', 'Table used to show various messages', '<table border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\r\n  <tr>\r\n    <td>\r\n      <table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" bgcolor=\"<tablebordercolor>\"  width=\"100%\" align=\"center\">\r\n        <tr>\r\n          <td>\r\n            <table cellpadding=\"1\" cellspacing=\"1\" border=\"0\"  width=\"100%\">\r\n              <tr>\r\n                <td align=\"center\" valign=\"top\" bgcolor=\"<tdendbgcolor>\">\r\n                    <normalfont><message><br /><cn>                    \r\n                </td>\r\n              </tr>\r\n            </table>\r\n          </td>\r\n        </tr>\r\n      </table>\r\n    </td>\r\n  </tr>\r\n</table>    ', 'default')";
		$q[]="REPLACE arc_template VALUES (1898, 'adminmenu', '', '<a href=\\\"<webroot>/cp/\\\">Control Panel</a><br>\r\n', 'default')";
		$q[]="REPLACE arc_template VALUES (1899, 'adminuseroptions', 'Options which appear for Administrators and Moderators on profile pages.', '<center>\r\n<smallfont><a href=\"user.php?action=ban&id=<userid>\" title=\"Stops this users ip address from viewing anything on the site\">Ban User</a> | <a href=\"user.php?action=lockout&id=<userid>\" title=\"Use this to punish abuse of post templates or avatars\">Lock This Users Profile</a> | <a href=\"user.php?action=cookieban&id=<userid>\" title=\"Use this to ban users who have dynamic a ip\">Set Ban Cookie</a>\r\n</center>', 'default')";
		$q[]="REPLACE arc_template VALUES (1806, 'calendar_event', '', '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\">\r\n  <tr>\r\n    <td width=\"20%\" align=\"center\" valign=\"top\">\r\n     <normalfont>\r\n     <a href=\"user.php?action=profile&id=<userid>\"><displayname></a>\r\n     <cn>\r\n     <br>\r\n     <img src=\"<avatar>\" border=\"0\" />\r\n    </td>\r\n    <td width=\"80%\" valign=\"top\">\r\n     <normalfont>\r\n     <b><event_title></b><br>\r\n     <event_description>\r\n     <cn>\r\n    </td>\r\n  </tr>\r\n</table>', 'default')";
		$q[]="REPLACE arc_template VALUES (1807, 'category', 'Category code on forums and category display. -categoryrow', '<img src=\"<webroot>/lib/images/avatars/default.gif\" height=\"6\" width=\"50\" /><table bgcolor=\"<tablebordercolor>\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" class=\"3dcell\" width=\"100%\" align=\"center\">\r\n<tr><td width=\"100%\">\r\n<table cellpadding=\"1\" cellspacing=\"1\" border=\"0\"  width=\"100%\">\r\n<categoryrow>\r\n</table>\r\n</td></tr></table>\r\n', 'default')";
		$q[]="REPLACE arc_template VALUES (1808, 'categoryrow', 'Looping HTML for describing categories in list.', '<tr><td class=\"3dcell\" width=\"100%\" valign=\"middle\" bgcolor=\"<tdendbgcolor>\">\r\n<largefont><b><categoryname></b><br /><cl><smallfont>&nbsp;&nbsp;<categorydesc><br /><cs>\r\n</td></tr>', 'default')";
		$q[]="REPLACE arc_template VALUES (2004, 'downloadlistrow', 'Download file list rows.', '              <tr>\r\n                <td bgcolor=\"<alt_bg>\">\r\n                  <smallfont><a href=\"download.php?file=<id>\"><name></a> <cs>\r\n                </td>\r\n                <td align=\"center\" bgcolor=\"<alt_bg>\">\r\n                  <smallfont><date_added> <cs>\r\n                </td>\r\n                <td align=\"center\" bgcolor=\"<alt_bg>\">\r\n                  <smallfont><downloads> <cs>\r\n                </td>\r\n              </tr>', 'default')";
		$q[]="REPLACE arc_threadicons VALUES (1,'lib/images/threadicons/default.gif','Default')";
		$q[]="REPLACE arc_threadicons VALUES (2,'lib/images/threadicons/paper.gif','Paper')";
		$q[]="REPLACE arc_threadicons VALUES (3,'lib/images/threadicons/bulb.gif','Lightbulb')";
		$q[]="REPLACE arc_threadicons VALUES (4,'lib/images/threadicons/question.gif','Question Mark')";
		$q[]="REPLACE arc_threadicons VALUES (5,'lib/images/threadicons/warning.gif','Caution')";
		$q[]="REPLACE arc_threadicons VALUES (6,'lib/images/threadicons/thumbup.gif','Thumbs Up')";
		$q[]="REPLACE arc_threadicons VALUES (7,'lib/images/threadicons/thumbdown.gif','Thumbs Down')";
		$q[]="REPLACE arc_wordbit VALUES (1, 'login_confirmed', '<br>\r\nThank you for logging in.<br />\r\n<a href=\"<referurl>\">Click here to return to the page you were visiting previously</a>.', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (2, 'logout_confirmed', 'You have successfully been logged out.', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (3, 'readcomments', '<a href=\"post.php?action=readcomments&ident=pagebit&id=<id>\">Read Comments</a>', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (4, 'postcomment', '<a href=\"post.php?action=postcomment&ident=pagebit&id=<id>\">Post Comment</a>', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (5, 'mailsent', 'Your message has been sent. This does not necessarily mean it was recieved.', 'mail')";
		$q[]="REPLACE arc_wordbit VALUES (6, 'mailnotsent', 'Your message could not be sent.', 'mail')";
		$q[]="REPLACE arc_wordbit VALUES (7, 'mailto', 'To: ', 'mail')";
		$q[]="REPLACE arc_wordbit VALUES (8, 'mailfrom', 'From: ', 'mail')";
		$q[]="REPLACE arc_wordbit VALUES (9, 'mailmsg', 'Message: ', 'mail')";
		$q[]="REPLACE arc_wordbit VALUES (10, 'mailfile', 'Add Attachment: ', 'mail')";
		$q[]="REPLACE arc_wordbit VALUES (11, 'mailsub', 'Subject: ', 'mail')";
		$q[]="REPLACE arc_wordbit VALUES (12, 'mailsubmit', 'Lose my email', 'mail')";
		$q[]="REPLACE arc_wordbit VALUES (13, 'mailreset', 'Scratch that', 'mail')";
		$q[]="REPLACE arc_wordbit VALUES (14, 'nousersonline', 'There are no registered users online', 'misc')";
		$q[]="REPLACE arc_wordbit VALUES (104, 'wrongpass', 'The password you entered did not match the username in our records.', 'error')";
		$q[]="REPLACE arc_wordbit VALUES (15, 'post_noident', 'Error: the ident variable was missing from the GET query string.', 'error')";
		$q[]="REPLACE arc_wordbit VALUES (16, 'post_noid', 'It appears the link you used to get here is out of date as it specifies an invalid id number.', 'error')";
		$q[]="REPLACE arc_wordbit VALUES (17, 'reg_submit', 'Register Me', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (18, 'reg_reset', 'You guys seem sort of cheesy', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (19, 'reg_username', 'Desired login name. Your login name is what you\'ll use to login. Unlike your publicly displayed name this will not be viewable by other users and will not ever change. Required field.', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (20, 'reg_password', 'Password - Required field', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (21, 'reg_usertext', 'Your special little message to the world', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (22, 'reg_email', 'Your email address', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (23, 'reg_homepage', 'Your Website URL', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (24, 'reg_occupation', 'Your Occupation', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (25, 'reg_biography', 'A few details about yourself', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (26, 'reg_post_header', 'Post Header', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (27, 'reg_post_footer', 'Post Footer', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (28, 'reg_confirmed', 'Thank you for registering. <a href=\"user.php?action=login\">Click here</a> to login.', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (29, 'noreplies', 'There are no posts for this topic.', 'error')";
		$q[]="REPLACE arc_wordbit VALUES (30, 'replybit', '[post reply]', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (31, 'post_added', 'Post added. That makes it <b><post_count></b> posts for you already.<br />\r\n<br />\r\n<topiclink> \r\n<forumlink><br />\r\n<br />', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (143, 'reg_blank_fields', 'You could not be registered because either username or password was missing from the registration form.', 'error')";
		$q[]="REPLACE arc_wordbit VALUES (294, 'file_already_exists', 'A file with the name you have specified already exists.', 'error')";
		$q[]="REPLACE arc_wordbit VALUES (293, 'newtopic_icon', 'Thread Icon', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (289, 'normaliconpath', 'lib/images/thread.gif', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (290, 'hoticonpath', 'lib/images/hotthread.gif', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (291, 'closediconpath', 'lib/images/closedthread.gif', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (292, 'old_posts_icon', '<img src=\"lib/images/circle_off.gif\" border=\"0\" />', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (32, 'mustregister', 'This site requires that you register before post comments. Registration is free and does not involve any confirmation (or even strictly require an email address).<br />\r\n<a href=\"user.php?action=register\">Click here to register</a> or <a href=\"user.php?action=login\">click here to login</a>.', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (40, 'notloggedin', 'The desired operation could not be completed because you either have not registered or are not logged in. <a href=\"user.php?action=Register\">Click here to register</a> or <a href=\"user.php?action=login\">click here to login</a>.', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (303, 'can_download', 'Click here to download this file', 'misc')";
		$q[]="REPLACE arc_wordbit VALUES (304, 'cant_download', '<b>You must be logged in to download this file</b>', 'misc')";
		$q[]="REPLACE arc_wordbit VALUES (302, 'download_nofiles', 'There are no files in this category.', 'misc')";
		$q[]="REPLACE arc_wordbit VALUES (301, 'nopagebits', 'There are no pagebits to display on this page.', 'misc')";
		$q[]="REPLACE arc_wordbit VALUES (300, 'guests_not_allowed_in_topic', 'You must be logged in to view this topic.', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (298, 'file_not_uploaded', 'The selected file was unable to be uploaded to the server.', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (299, 'guests_not_allowed_in_forum', 'You must be logged in to view this forum.', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (297, 'forum_notopics', 'This forum does not have any topics.', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (296, 'topic_noposts', 'There are no replies in this topic.', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (50, 'badcookie', 'The encrypted password stored in your cookie does not match our records. You should be able to fix this by manually logging out and back in.', 'error')";
		$q[]="REPLACE arc_wordbit VALUES (53, 'edit_displayname', 'Publicly Viewable Username', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (54, 'edit_password', 'Change your password? (leave blank if not)', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (55, 'edit_usertext', 'Usertext', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (56, 'edit_email', 'Email Address', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (57, 'edit_homepage', 'Homepage', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (58, 'edit_occupation', 'Occupation', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (164, 'newpagebittitle', 'Pagebit Title', 'shrine')";
		$q[]="REPLACE arc_wordbit VALUES (59, 'edit_biography', 'A few details about yourself', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (60, 'edit_post_header', 'Your Current Post header (<a href=\"faq.php?action=View&id=20\" target=\"_blank\">help</a>)', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (61, 'edit_post_footer', 'Current Post Footer (<a href=\"faq.php?action=View&id=20\" target=\"_blank\">help</a>)', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (62, 'edit_avatar', 'Please Select an Avatar', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (63, 'reg_avatar', 'Choose an avatar', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (64, 'profilesaved', 'Your profile has been modified.', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (295, 'invalid_forum_id', 'The forum ID given in the URL does not specify an existing forum.', 'error')";
		$q[]="REPLACE arc_wordbit VALUES (66, 'forumsnotloggedin', 'You must be logged in to view the forums.<br /><a href=\"user.php?action=login\">Click here to login</a>.<br />', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (67, 'topicclosed', '[topic closed]', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (68, 'nolastposter', 'None', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (69, 'alreadyloggedin', 'Action cannot be taken because you are already logged into the system.', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (70, 'newtopic', '<img src=\"<newtopicpath>\" border=\"0\" title=\"Click here to start a new topic in this forum\"></img>', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (71, 'topic_name', 'New Topic Title - Required', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (72, 'topic_desc', 'New topic description', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (73, 'topic_you', 'You', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (74, 'topic_content', 'Topic Content - Required', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (75, 'topic_submit', 'Create New Topic', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (76, 'topic_reset', 'Cancel New Topic', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (77, 'nonotesyet', 'There are not yet any notes to display here.', 'misc')";
		$q[]="REPLACE arc_wordbit VALUES (78, 'submitnote', 'Submit', 'misc')";
		$q[]="REPLACE arc_wordbit VALUES (79, 'cantpostnote', 'You cannot post notes until you have logged in and your note cannot be blank.', 'error')";
		$q[]="REPLACE arc_wordbit VALUES (80, 'note_added', 'Your note has been added.', 'misc')";
		$q[]="REPLACE arc_wordbit VALUES (81, 'noviewforums', 'The Administrator has disabled guest access to the forums. Tough luck for you.', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (82, 'oldestnotemessage', '[oldest first]', 'misc')";
		$q[]="REPLACE arc_wordbit VALUES (83, 'newestnotemessage', '[newest first]', 'misc')";
		$q[]="REPLACE arc_wordbit VALUES (84, 'nopostsinforum', 'There are no posts in this forum.', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (85, 'nousersinforum', ' -None- ', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (87, 'edit_useownavatar', 'Or, input the URL of your avatar. If it\'s too big (size or filesize) you will be asked to change it.', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (88, 'post_author', 'Post Author', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (89, 'post_title', 'Post Title', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (90, 'edit_submit', 'Edit Post', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (91, 'edit_reset', 'Restore Post Data', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (92, 'post_submit', 'Submit Post', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (93, 'post_reset', 'Empty Fields', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (94, 'post_content', 'Post Content - Required', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (95, 'editpost', '[edit post]', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (96, 'editcomment', '[edit comment]', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (97, 'guestusername', 'Guest', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (101, 'editedbymsg', '<br />Edited by <username>.', 'misc')";
		$q[]="REPLACE arc_wordbit VALUES (98, 'version', 'v1.1.1', 'misc')";
		$q[]="REPLACE arc_wordbit VALUES (100, 'floodcheck', 'The Administrator has activated flood control. You cannot post until <floodtime> seconds have passed since your last post.\r\n<br /><br />\r\n<elapsed> seconds have passed. Some browsers will resend the information if you refresh the page, so you don\'t have to make your post again, only wait until the time has passed.\r\n', 'error')";
		$q[]="REPLACE arc_wordbit VALUES (99, 'sitename', 'Seir Anphin', 'misc')";
		$q[]="REPLACE arc_wordbit VALUES (102, 'postedited', 'The post has been edited. <a href=\"post.php?action=readcomments&ident=<parentident>&id=<parentid>#<postid>\">Click here to go back to the post</a>.', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (103, 'noguestsonline', 'There are no guests online.', 'misc')";
		$q[]="REPLACE arc_wordbit VALUES (105, 'edit_showonline', 'Display Who\'s Online on every page', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (106, 'edit_showforums', 'Display Forums Navigation on all pages', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (107, 'edit_shownotes', 'Display \"Latest Notes\" on all pages.', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (108, 'nomod', 'None', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (109, 'adminonline', 'His spiffy computer screen.', 'misc')";
		$q[]="REPLACE arc_wordbit VALUES (110, 'gototopic', 'Click here to return to topic <topic>', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (111, 'gotoforum', 'or<br />\r\nClick here to return to forum <forum>', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (112, 'forumhomelink', '<sitename> Forums', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (113, 'noeditpermission', 'It appears you do not have permission to edit this post.', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (114, 'pmnotloggedin', 'You cannot view your private message Inbox becauseyou are either not a registered user or are a registered user who has tried to view their private messages without logging in.<br />', 'error')";
		$q[]="REPLACE arc_wordbit VALUES (115, 'pm_recipient', 'Recipient', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (116, 'pm_msgtitle', 'Message Title', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (117, 'pm_msgcontent', 'Message Content', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (118, 'pm_submit', 'Send New Private Message', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (119, 'pm_reset', 'I\'ve lost my nerve', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (120, 'cantsendpm', 'The private message could not be sent. This is probably because you forgot to fill in one of more fields.<br />Please go back and try again.', 'error')";
		$q[]="REPLACE arc_wordbit VALUES (121, 'pmsent', 'Your private message has been sent.', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (122, 'sendpm', '[send pm]', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (123, 'sendpmalt', 'Click here to send this user a private message', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (124, 'deletepm', '[delete]', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (125, 'pm_deleted', 'Your private message has been deleted.', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (126, 'pm_nopermission', 'You do not have permission to delete this users private message.', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (127, 'reviewdesc', 'Topic Review: Last <b><limit></b> replies displayed newest first.', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (128, 'pm_notownmsg', 'You do not have permission to read this users message.', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (129, 'edit_showquotes', 'Display Random Quotes', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (130, 'newpms', 'You have <b><numunread></b> unread out of <b><totalpms></b> private messages in your <a href=\"privatemsg.php?action=Inbox\">inbox</a>.<br />', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (131, 'pm_replymsg', 'Send Reply', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (132, 'quoteuser', '[quote]', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (133, 'edit_colorset', 'Edit your colorset', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (134, 'loginsubmit', 'Login', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (135, 'loginreset', 'Reset', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (136, 'pm_norecipient', 'No user was located who matches the criterion you supplied for the recipient field. This is because you either input a nonexistant UserID or mispelled the username. Feel free to go back and try again but unless you do something different next time you\'re going to be seeing more of this message.', 'error')";
		$q[]="REPLACE arc_wordbit VALUES (137, 'pm_emptyfields', 'It seems you have forgotten to fill out the Title and/or Message Content fields in your private message. Please go back, check your input and try again.', 'error')";
		$q[]="REPLACE arc_wordbit VALUES (138, 'latestuser', 'Latest User: <link>', 'misc')";
		$q[]="REPLACE arc_wordbit VALUES (140, 'exp_up', 'gained', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (141, 'exp_down', 'lost', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (142, 'note_max_exp', 'Maximum experience gained when posting a note.', '7')";
		$q[]="REPLACE arc_wordbit VALUES (144, 'reg_name_in_use', 'That username you have selected it in use. <a href=\"user.php?action=register\">Click here</a> to reload the last page (your browser may have stored your input).', 'error')";
		$q[]="REPLACE arc_wordbit VALUES (145, 'postreply', '<a href=\"post.php?action=postcomment&ident=<ident>&id=<id>\"><img src=\"<newreplypath>\" border=\"0\" /></a>', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (146, 'shrine_key', 'Shrine Key', 'shrine')";
		$q[]="REPLACE arc_wordbit VALUES (147, 'shrine_title', 'Shrine Title', 'shrine')";
		$q[]="REPLACE arc_wordbit VALUES (148, 'shrine_summary', 'Shrine Summary', 'shrine')";
		$q[]="REPLACE arc_wordbit VALUES (149, 'shrine_accesslvl', 'Level Required for Access (guests are level 1)', 'shrine')";
		$q[]="REPLACE arc_wordbit VALUES (150, 'shrine_submit', 'Update Shrine', 'shrine')";
		$q[]="REPLACE arc_wordbit VALUES (151, 'shrine_reset', 'Undo All Changes', 'shrine')";
		$q[]="REPLACE arc_wordbit VALUES (152, 'shrine_notloggedin', 'You cannot edit your shrine information until you have <a href=\"user.php?action=login\">logged in</a>.', 'shrine')";
		$q[]="REPLACE arc_wordbit VALUES (153, 'shrine_noshrines', 'Your user account does not have any shrines.', 'shrine')";
		$q[]="REPLACE arc_wordbit VALUES (154, 'shrine_saved', 'Shrine <b><shrinekey></b> has been updated.', 'shrine')";
		$q[]="REPLACE arc_wordbit VALUES (155, 'shrine_notset', 'You have not selected a working shrine or do not have one created for your user account. ', 'shrine')";
		$q[]="REPLACE arc_wordbit VALUES (156, 'shrine_pageadded', 'Pagebit <b><pagebit></b> has been added.', 'shrine')";
		$q[]="REPLACE arc_wordbit VALUES (157, 'shrine_pagesaved', 'Pagebit <b><pagebit></b> has been updated.', 'shrine')";
		$q[]="REPLACE arc_wordbit VALUES (158, 'shrine_change', 'Select an active shrine to Administer', 'shrine')";
		$q[]="REPLACE arc_wordbit VALUES (159, 'shrine_selected', 'New shrine selection has been made.', 'shrine')";
		$q[]="REPLACE arc_wordbit VALUES (161, 'shrine_accesstoohi', 'You have set the shrines access level higher then your level, which is silly and against the rules, therefore your changes have not been saved. Better luck next time sucker.', 'shrine')";
		$q[]="REPLACE arc_wordbit VALUES (162, 'edit_timeoffset', 'Time offset from server (an integer which describes the difference between your time zone and the servers time zone).', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (163, 'edit_location', 'Location', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (165, 'newpagebitcontent', 'Pagebit Content', 'shrine')";
		$q[]="REPLACE arc_wordbit VALUES (166, 'reg_displayname', 'Your desired publicly viewable username. You will be able to change this in your profile. Required field.', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (167, 'edit_loginname', 'Private Login Name', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (168, 'newpagebitaction', 'Page Name (<a href=\"faq.php?action=view&id=11\" target=\"_blank\">help</a>)', 'shrine')";
		$q[]="REPLACE arc_wordbit VALUES (169, 'newpagebitorder', 'Pagebit Order (<a href=\"faq.php?action=View&id=18\" target=\"_blank\" title=\"Click here to open an explanation of pagebit orders in a new window\">help</a>)', 'shrine')";
		$q[]="REPLACE arc_wordbit VALUES (170, 'newpagebitnl2br', 'Convert newlines to line breaks', 'shrine')";
		$q[]="REPLACE arc_wordbit VALUES (171, 'templatesaved', 'Your template has been saved.', 'shrine')";
		$q[]="REPLACE arc_wordbit VALUES (172, 'topic_imgname', 'Image Name', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (173, 'topic_image', 'Image', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (174, 'topic_imgdesc', 'Image Description', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (175, 'shrine_noaccess', 'You do not have access to the selected area.', 'shrine')";
		$q[]="REPLACE arc_wordbit VALUES (176, 'newtopic_emptyfields', 'You did not fill in the required fields, Topic Name and Topic Content.', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (178, 'post_emptyfields', 'You did not fill out the required field Post Content.', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (179, 'topicnamedefault', 'An informative topic title is a sign of proper breeding', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (180, 'optionssaved', 'Your options have been saved.', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (181, 'templatessaved', 'Your post templates have been saved.', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (182, 'postsampletext', '<br />\r\nSpiffy sample text.\r\n<br />', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (183, 'edit_notepad', 'Your Notepad', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (184, 'notepad_default', 'The notepad will holds whatever text you need for later. It cannot be viewed by any other users.', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (185, 'post_save_notepad', 'Save this post to my Notepad for later', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (186, 'postsaved', 'Your post has been saved to the notepad, which you can access <a href=\"user.php?action=home\">here</a>.', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (187, 'newtopictitle', ' Forums creating a new topic in forum <forumname>.', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (188, 'topictitleunchanged', 'To be frank, your topic title sucks. Unless you come up with something better, your topic will never see the light of day. At least here that is, but if you go somewhere else we don\'t care, because they probably won\'t like topics with such silly titles any more then we do.', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (189, 'edit_postextras', 'Display post header/footers', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (190, 'cannoteditprofile', 'It appears that you have been locked out of your profile by the Administration. If this is the case you probably deserved it. If, however, you believe this to be in error, simply contact the Administrator via the notes, his/her email address or by posting (if you have not been barred from that activity as well).', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (191, 'quickreplylink', '[<a href=\"#quickreply\">Reply</a>]', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (192, 'nodoubleposting', 'Endust has a feature called \"edit post\". Use it. You are seeing this message because you are already the last user to reply in this topic and are just trying to get some extra experience.', 'error')";
		$q[]="REPLACE arc_wordbit VALUES (193, 'file_copied', 'File <b><thefilename></b> has been successfully uploaded to the server.', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (194, 'front_page_title', 'Seir Anphin Content Management System', 'misc')";
		$q[]="REPLACE arc_wordbit VALUES (196, 'no_prune_amount', 'You need to select a number to prune by.', 'cp')";
		$q[]="REPLACE arc_wordbit VALUES (197, 'prune_by_date', 'Select an amount and unit and every post and topic older then the result will be deleted.', 'cp')";
		$q[]="REPLACE arc_wordbit VALUES (198, 'datepruneconfirm', 'All posts made before <b><date></b> have been deleted.', 'cp')";
		$q[]="REPLACE arc_wordbit VALUES (199, 'parseurls', 'Parse URLs', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (200, 'topic_filename', 'File Name - Required', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (201, 'topic_filepath', 'File - Oddly enough, not required', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (202, 'topic_filedesc', 'File Description - Required', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (203, 'passwordforum_noaccess', '<br />\r\nThis forum has been designated private and requires a password.<br />\r\n<br />\r\n<form method=\"post\" action=\"topic.php?action=forum&fid=<fid>\">\r\n<input type=\"text\" name=\"forumpass\" maxlength=\"20\" size=\"30\"></input><br />\r\n<input type=\"submit\" name=\"submitfpass\" value=\"Let me in, goddammit\"></input>\r\n</form>', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (204, 'privateforum_noaccess', 'This forum has been set as private by the Administrator. You must be logged in and authorized in order to view it.', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (205, 'makepoll', 'Poll Choices', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (206, 'topic_name_exists', 'A topic with that name already exists in the database.', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (207, 'file_not_copied', 'The file could not be uploaded to the server. Please check your server permissions.', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (208, 'usercp_submit', 'Save Changes', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (209, 'usercp_reset', 'Restore Previous Values', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (211, 'mailer_is_off', 'This server does not support the form mailer, therefore it has been deactivated. If you don\'t like this, cry, but the server doesn\'t care and the Administrator just thinks it\'s funny.<br /><br />\r\nSee what happens when the programmer isn\'t restrained by someone who cares about your feelings? This is known as rude software, if it weren\'t for marketers all software would be like this, but most people like to pander to your feelings instead of taking out their aggression on you, and I admit, it would probably be a more effective way to get your money, but we firmly believe this sort of thing justifies the expense.', 'mail')";
		$q[]="REPLACE arc_wordbit VALUES (212, 'edit_poll_question', 'Poll Question', 'cp')";
		$q[]="REPLACE arc_wordbit VALUES (213, 'edit_poll_closed', 'Poll is closed', 'cp')";
		$q[]="REPLACE arc_wordbit VALUES (214, 'edit_polla_answer', 'Poll Choice', 'cp')";
		$q[]="REPLACE arc_wordbit VALUES (215, 'edit_polla_users', 'Users who voted for this answer', 'cp')";
		$q[]="REPLACE arc_wordbit VALUES (216, 'edit_user_loginname', 'Login Name', 'cp')";
		$q[]="REPLACE arc_wordbit VALUES (217, 'confirm_topic_delete', 'Please confirm that you want to delete the following topics.<br />', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (218, 'edit_layout', 'Change the layout', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (219, 'userphptitletext', '<sitename> User Center <action>', 'misc')";
		$q[]="REPLACE arc_wordbit VALUES (220, 'login_loginname', 'Login Name', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (221, 'login_password', 'Password', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (222, 'invalid_forum', 'The forum you have specified does not appear to exist.', 'error')";
		$q[]="REPLACE arc_wordbit VALUES (226, 'bad_link', 'It appears the link you used to get here is out of date as it does not contain the right number of arguments and/or one of it\'s arguments is an incorrect data type.\r\n\r\nIf you feel like something may have changed since the first time you saw this error message feel free to go back and try again.', 'error')";
		$q[]="REPLACE arc_wordbit VALUES (236, 'find_title_postbyid', '<sitename>: Finding posts by ID', 'misc')";
		$q[]="REPLACE arc_wordbit VALUES (288, 'reg_bday_year', 'Year in which you were born', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (285, 'edit_bday_year', 'Year in which you were born', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (286, 'reg_bday_day', 'Day on which you were born', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (287, 'reg_bday_month', 'Month in which you were born', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (284, 'edit_bday_month', 'Month in which you were born', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (283, 'edit_bday_day', 'Day on which you were born', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (282, 'shrine_pagebit', 'Pagebit (Leave blank to use site pagebit templates)', 'shrine')";
		$q[]="REPLACE arc_wordbit VALUES (233, 'notepostedmsg', 'Note posted. <a href=\"<referer>\">click here</a> to go back to last page you were visiting or wait to be forwarded.', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (281, 'shrine_footer', 'Footer (Leave blank to use site footer)', 'shrine')";
		$q[]="REPLACE arc_wordbit VALUES (280, 'shrine_header', 'Header (Leave blank to use site header)', 'shrine')";
		$q[]="REPLACE arc_wordbit VALUES (237, 'find_noarguments', 'You have submitted an invalid url.', 'error')";
		$q[]="REPLACE arc_wordbit VALUES (238, 'find_msg_postsbyid', 'All posts by <displayname>.', 'misc')";
		$q[]="REPLACE arc_wordbit VALUES (239, 'find_msg_parent_topic', '<a href=\"post.php?action=readcomments&ident=topic&id=<topicid>#<postid>\">View this topic</a>', 'misc')";
		$q[]="REPLACE arc_wordbit VALUES (240, 'find_msg_parent_pagebit', '<a href=\"post.php?action=readcomments&ident=pagebit&id=<topicid>#<postid>\">View this post in context</a>', 'misc')";
		$q[]="REPLACE arc_wordbit VALUES (241, 'find_msg_parent_profile', '<a href=\"user.php?action=profile&id=<topicid>#<postid>\">View this post in context</a>', 'misc')";
		$q[]="REPLACE arc_wordbit VALUES (242, 'text_truncated', '... <i>(truncated)</i>', 'misc')";
		$q[]="REPLACE arc_wordbit VALUES (243, 'topic_closed', '(Closed)', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (244, 'topic_pinned', '(Pinned)', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (245, 'topic_poll', 'Poll: ', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (246, 'reg_race', 'Choose a race from the list', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (247, 'reg_canbattle', 'Participate in battles?', 'user')";
		$q[]="REPLACE arc_wordbit VALUES (248, 'battle_msg_fight', '<name> attacks <target> and does <damage> damage.', 'rpg')";
		$q[]="REPLACE arc_wordbit VALUES (249, 'battle_noopponents', 'You cannot start a battle with no opponents. Please go back and try again, but with a bit more of a challenge. You know, be a man.', 'rpg')";
		$q[]="REPLACE arc_wordbit VALUES (250, 'battle_alreadyinbattle', 'You cannot start a new battle until you finish your last one.', 'rpg')";
		$q[]="REPLACE arc_wordbit VALUES (253, 'battle_victory', 'You have won.', 'rpg')";
		$q[]="REPLACE arc_wordbit VALUES (254, 'battle_action_killed', '<victim> has been killed by <killer>. ', 'rpg')";
		$q[]="REPLACE arc_wordbit VALUES (255, 'battle_lost', 'You have been annihilated.', 'rpg')";
		$q[]="REPLACE arc_wordbit VALUES (256, 'battle_msg_item', '<name> sneaks off and uses a <item>. (Effect: <effect>)', 'rpg')";
		$q[]="REPLACE arc_wordbit VALUES (257, 'challenge_noopponents', 'No challenges could be sent, either because you did not pick any opponents or because none of them were eligible to be challenged. Please go back and try again.<br>', 'rpg')";
		$q[]="REPLACE arc_wordbit VALUES (258, 'battle_challenged', 'You have been challenged to a battle.<br><a href=\"battle.php?action=accept\">Click here to accept</a> or <a href=\"battle.php?action=decline\">click here to decline</a>.', 'rpg')";
		$q[]="REPLACE arc_wordbit VALUES (259, 'user_cannot_battle', '<name> cannot battle, either because they chose not to upon registration or because an Administrator has restricted them from this action.', 'rpg')";
		$q[]="REPLACE arc_wordbit VALUES (260, 'ally_alreadyinbattle', '<name> is already in battle and could not be asked for assistance.', 'rpg')";
		$q[]="REPLACE arc_wordbit VALUES (261, 'enemy_alreadyinbattle', '<name> is already in battle and could not be challenged.', 'rpg')";
		$q[]="REPLACE arc_wordbit VALUES (262, 'user_fighter_list_sort', 'ORDER BY level,exp ASC', 'rpg')";
		$q[]="REPLACE arc_wordbit VALUES (263, 'battle_msg_critical_hit', '<name> attacks <target> and does a <b>critical hit</b> for <damage> damage.', 'rpg')";
		$q[]="REPLACE arc_wordbit VALUES (264, 'battle_msg_skillhurt', '<name> uses <skill> on <target> and does <damage> damage.', 'rpg')";
		$q[]="REPLACE arc_wordbit VALUES (265, 'battle_msg_skillheal', '<name> uses <skill> on <target> and heals <damage> points.', 'rpg')";
		$q[]="REPLACE arc_wordbit VALUES (266, 'new_posts_icon', '<img src=\"lib/images/circle_on.gif\" border=\"0\" />', 'forums')";
		$q[]="REPLACE arc_wordbit VALUES (267, 'search_listmsg', 'Results of search for <keywords>', 'misc')";
		$q[]="REPLACE arc_wordbit VALUES (268, 'find_noposts', 'Could not find any posts.', 'error')";
		$q[]="REPLACE arc_wordbit VALUES (269, 'postevent_title', 'Event Title', 'mod')";
		$q[]="REPLACE arc_wordbit VALUES (270, 'postevent_day', 'Day', 'mod')";
		$q[]="REPLACE arc_wordbit VALUES (271, 'postevent_month', 'Month', 'mod')";
		$q[]="REPLACE arc_wordbit VALUES (272, 'postevent_year', 'Year', 'mod')";
		$q[]="REPLACE arc_wordbit VALUES (273, 'postevent_desc', 'Description', 'mod')";
		$q[]="REPLACE arc_wordbit VALUES (274, 'postevent_private', 'Event is private?', 'mod')";
		$q[]="REPLACE arc_wordbit VALUES (275, 'postevent_submit', 'Post New Event', 'mod')";
		$q[]="REPLACE arc_wordbit VALUES (276, 'postevent_reset', 'Reset', 'mod')";
		$q[]="REPLACE arc_wordbit VALUES (277, 'postevent_neweventbutton', '[<a href=\"calendar.php?action=addevent<urlextra>\">Post New Event</a>]', 'mod')";
		$q[]="REPLACE arc_wordbit VALUES (278, 'postevent_nopermission', 'You do not have permission to post new events.', 'mod')";
		$q[]="REPLACE arc_wordbit VALUES (279, 'postevent_posted', 'Your event has been posted.', 'mod')";

		foreach ($q as $index=>$query) {
			mysql_query($query) or $errors[]="$index:$query";
			if (mysql_error()!='') {
				echo "<br>error on query <b>#$index</b> " .htmlspecialchars($query). ". <br><br>MySQL says: " .mysql_error();
				break;
			}
		}

		mysql_query("UPDATE arc_setting SET settingvalue=0 WHERE settingvalue=''");

		if (count($errors)>0) {
			echo "<br><br>One or more queries could not be performed.";
		} else {
			echo "All data has been successfully entered. If you were performing an upgrade you should now be able to login and resume
				normal operation. <a href=\"index.php\">Click here to do so</a>. <br><br>
				If you are performing a new install click <a href=\"install_v111.php?action=add_admin\">here</a> to create an
				Administrator's user account, which you will need in order to do much of anything.";
		}
		break;
	case 'add_admin':
		mysql_query("INSERT INTO arc_user SET username='Admin', displayname='Admin', access=3,  password='6d4be8d6ae8f190c3fed7d4da4ff8ec0', avatar='lib/images/avatars/default.gif', reg_date=".time().", colorset=3");
		echo 'An account has been added with the login name "Admin" and password "spiffy". Next, go into your FTP and DELETE THIS FILE. Just look at
			  how much validation it takes for someone to create an Administrator account. If you leave this file on your server it is only a matter
			  of time until someone notices and uses it to delete your site.<br><br>
			  Now, click <a href="user.php?action=login">here</a> to login and begin new you life with Seir Anphin.
			  Don\'t forget to change your administrator password. I mean it.';
		break;
}
?>
</body>
</html>