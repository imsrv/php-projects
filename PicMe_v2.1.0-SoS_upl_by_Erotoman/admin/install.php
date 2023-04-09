<HEAD><TITLE>PicMe Install</TITLE></HEAD>
<?PHP
/*
#
#	$Id: INSTALL.PHP
#	Version 2.0.0
#
*/
if (!$step) {
$step = 0;
}
if ($step == 0) {
?>
   <form action="<? $PHP_SELF ?>?step=1" method="post">
  <table width="100%" border="0" cellspacing="0" cellpadding="4" align="center">
    <tr> 
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr valign="top"> 
      <td colspan="2" height="24"><font size="2" face="Trebuchet MS, Verdana, Arial, Helvetica, sans-serif">
	<CENTER><h2>Thank you for purchasing PicMe.</h2> <br>This is the installation script which will 
        guide you through the setup of the database and your PicMe installation.</CENTER> 
        <br>
        </font></td>
    </tr>
    <tr valign="top"> 
      <td colspan="2" height="87"> <br>
        <table width="85%" border="0" cellspacing="0" cellpadding="9" align="center">
          <tr> 
	      <td><IMG SRC="../images/logow.gif" BORDER="0"></td>
            <td bgcolor="#DAE0EF"> 
              <p><font face="Trebuchet MS, Verdana, Arial" size="2"><b>PicMe 
                License Required Per Install</b><br>
                <font size="1">To install PicMe you must have a valid license 
                obtained from DirectFreelance.com - By completing this installation process 
                the location of this installation and your IP address will be sent to the PicMe 
                Team for review. If you are in any doubt about the validity or 
                the source of this license please contact <A HREF="mailto:rob@DirectFreelance.com?subject=PicMe Install">rob@DirectFreelance.com</A> prior 
                to completing the installation.</font></font></p>
            </td>
          </tr>
        </table>
        <br>
      </td>
    </tr>
    <tr> 
      <td colspan="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#666666" face="Trebuchet MS, Verdana, Arial" size="3">Database 
        Settings</font></b></font></td>
    </tr>
    <tr> 
      <td width="32">&nbsp;</td>
      <td width="847"> 
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="27%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Database 
              Server </font></td>
            <td width="73%"> 
              <input type="text" name="dbhost" class="gbox" size="30" value="localhost">
            </td>
          </tr>
          <tr> 
            <td width="27%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Database 
              Name </font></td>
            <td width="73%"> 
              <input type="text" name="dbname" class="gbox" size="30">
            </td>
          </tr>
          <tr> 
            <td width="27%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Database 
              Username </font></td>
            <td width="73%"> 
              <input type="text" name="dbuser" class="gbox" size="30">
            </td>
          </tr>
          <tr> 
            <td width="27%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Database 
              Password</font></td>
            <td width="73%"> 
              <input type="text" name="dbpass" class="gbox" size="30">
            </td>
		</tr>
		<tr>
            <td width="27%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Base URL</font></td>
            <td width="73%"> 
              <input type="text" name="baseurl" class="gbox" size="30">
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
          <input type="hidden" name="action" value="step1">
          <input type="hidden" name="host" value="$dbhost">
          <input type="hidden" name="database" value="$dbname">
          <input type="hidden" name="username" value="$dbuser">
          <input type="hidden" name="password" value="$dbpass">
          <CENTER><input type="submit" name="Submit" value="Proceed to Next Step"></CENTER>
</form>

<?php
} // END INTRO

//  BEGIN STEP TWO
if ($step == 1) {

$link = mysql_connect("$dbhost", "$dbuser", "$dbpass") or die ("Cannot connect to your database at this time");
$linkdb = mysql_select_db("$dbname") or die ("Sorry, PicMe was unable to establish a connection with the database. Please check that you have set the variables correctly<br><br><i>Unable to establish database connection</i><br><br><b>Possible Causes<br><ul><li>Invalid Database Name/Username/Password Specified</li><li>Database is not running</li></ul>");

// BUILD THE DATABASE
 
echo "Please be patient while your database is setup...<font size=2 face=Courier New, Courier, mono>";
    echo "<br><br>Creating Announcements Table...";
    $sql1 = "CREATE TABLE authusers (
  		uid smallint(6) NOT NULL auto_increment,
  		username char(15) NOT NULL default '',
  		password char(32) NOT NULL default '',
  		fname char(20) NOT NULL default '',
  		lname char(30) NOT NULL default '0',
  		userlevel tinyint(2) NOT NULL default '0',
  		email char(40) default NULL,
  		PRIMARY KEY  (uid)
		) TYPE=MyISAM";
		mysql_query($sql1);
     echo " [ OK ] <br>";
  
     echo "Creating BANCLK Table...";
     $sql2 = "CREATE TABLE banclk (
  		bannerid varchar(10) NOT NULL default '',
  		clicks int(8) unsigned NOT NULL default '1',
  		since timestamp(8) NOT NULL,
  		PRIMARY KEY  (bannerid)
		) TYPE=MyISAM";
		mysql_query($sql2);
     echo " [ OK ] <br>";

     echo "Creating BANIMP Table...";
     $sql3 = "CREATE TABLE banimp (
  		bannerid varchar(10) NOT NULL default '',
  		hits int(8) unsigned NOT NULL default '1',
  		since timestamp(8) NOT NULL,
  		PRIMARY KEY  (bannerid)
		) TYPE=MyISAM";
             mysql_query($sql3);
    echo " [ OK ] <br>";

    echo "Creating BANNERS Table...";
    $sql4 = "CREATE TABLE banners (
  		id mediumint(9) NOT NULL auto_increment,
  		name varchar(255) NOT NULL default '',
  		details varchar(255) NOT NULL default '',
  		img varchar(100) default NULL,
  		bps varchar(255) default NULL,
  		width varchar(10) default NULL,
  		height varchar(10) default NULL,
  		url varchar(255) default NULL,
  		level varchar(10) NOT NULL default '',
  		datecreate timestamp(8) NOT NULL,
  		Active int(2) NOT NULL default '1',
 		Visible int(2) NOT NULL default '1',
  		PRIMARY KEY  (id)
		) TYPE=MyISAM";
              mysql_query($sql4);
   echo " [ OK ] <br>";

    echo "Creating CATAGORY Table...";
    $sql5 = "CREATE TABLE catagory (
  		id int(11) NOT NULL auto_increment,
  		catagory varchar(100) NOT NULL default '',
  		PRIMARY KEY  (id)
		) TYPE=MyISAM";
              mysql_query($sql5);
   echo " [ OK ] <br>";

   echo "Creating COMMENTS Table...";
   $sql6 = "CREATE TABLE comments (
  		id int(11) NOT NULL auto_increment,
  		pid int(11) NOT NULL default '0',
  		userid varchar(100) NOT NULL default '',
  		text varchar(255) default NULL,
  		PRIMARY KEY  (id)
		) TYPE=MyISAM";
              mysql_query($sql6);
   echo " [ OK ] <br>";

   echo "Creating FAQ Table...";
   $sql7 = "CREATE TABLE faq (
  		id int(11) NOT NULL auto_increment,
  		faq_q varchar(250) NOT NULL default '',
  		faq_a longtext NOT NULL,
  		PRIMARY KEY  (id)
		) TYPE=MyISAM";
          	mysql_query($sql7);
	echo " [ OK ] <br>";

    echo "Creating LINKS Table...";
    $sql8 = "CREATE TABLE links (
  		id int(11) NOT NULL auto_increment,
  		site varchar(50) NOT NULL default '',
  		url varchar(50) NOT NULL default '',
  		UNIQUE KEY id (id)
		) TYPE=MyISAM"; 
          mysql_query($sql8);
	echo " [ OK ] <br>";

   echo "Creating MENU Table...";
   $sql9 = "CREATE TABLE menu (
  		id int(11) NOT NULL auto_increment,
  		site varchar(20) NOT NULL default '',
  		url varchar(50) NOT NULL default '',
  		UNIQUE KEY id (id)
		) TYPE=MyISAM";
           mysql_query($sql9);
    echo " [ OK ] <br>";

   echo "Creating MESSAGES Table...";
   $sql10 = "CREATE TABLE messages (
  		id int(11) NOT NULL auto_increment,
  		touserid varchar(50) NOT NULL default '',
  		fromuserid varchar(50) NOT NULL default '',
  		title varchar(100) NOT NULL default '',
  		message longtext NOT NULL,
  		isread char(1) NOT NULL default '0',
  		sdate varchar(20) NOT NULL default '',
  		PRIMARY KEY  (id)
		) TYPE=MyISAM";
            mysql_query($sql10);
   echo " [ OK ] <br>";

   echo "Creating NEWS Table...";
   $sql11 = "CREATE TABLE news (
  		id int(11) NOT NULL auto_increment,
  		date varchar(20) NOT NULL default '',
  		topic varchar(50) NOT NULL default '',
  		news blob NOT NULL,
  		PRIMARY KEY  (id)
		) TYPE=MyISAM";
             mysql_query($sql11);
   echo " [ OK ] <br>";

   echo "Creating PICUPLOADS Table...";
   $sql12 = "CREATE TABLE picuploads (
  		id int(11) NOT NULL auto_increment,
  		name varchar(100) NOT NULL default '',
  		userid varchar(50) NOT NULL default '',
  		comment longtext,
  		title varchar(50) NOT NULL default '',
  		votes int(100) default NULL,
  		points int(100) default NULL,
  		approved char(1) default NULL,
  		udate datetime NOT NULL default '0000-00-00 00:00:00',
  		catagory tinyint(4) NOT NULL default '1',
  		PRIMARY KEY  (id),
  		UNIQUE KEY name (name)
		) TYPE=MyISAM";
             mysql_query($sql12);
   echo " [ OK ] <br>";

   echo "Creating USERS Table...";
   $sql13 = "CREATE TABLE users (
  		id int(11) NOT NULL auto_increment,
  		userid varchar(50) NOT NULL default '',
  		password varchar(50) NOT NULL default '',
  		email varchar(50) NOT NULL default '',
  		sex varchar(6) default NULL,
  		hobbies varchar(100) default NULL,
  		music varchar(100) default NULL,
  		chat varchar(100) default NULL,
  		updated datetime default NULL,
  		emailvisible char(1) NOT NULL default '0',
  		year varchar(4) NOT NULL default '',
  		country varchar(20) NOT NULL default '',
  		state varchar(20) NOT NULL default '',
  		quote varchar(255) NOT NULL default '',
  		PRIMARY KEY  (id)
		) TYPE=MyISAM";
            mysql_query($sql13);
   echo " [ OK ] <br>";


   echo "Creating USERSONLINE Table...";
   $sql14 = "CREATE TABLE usersonline (
  		id int(11) NOT NULL auto_increment,
  		userIP varchar(20) NOT NULL default '',
  		dateAdded timestamp(14) NOT NULL,
  		PRIMARY KEY  (id)
		) TYPE=MyISAM";
              mysql_query($sql14);
   echo " [ OK ] <br>";

	echo "<center><b>All tables have been created...<br>We will now begin to add data to them...";
	echo "<br>";

	$sql15 = "INSERT INTO catagory VALUES (1, 'Men')";
	mysql_query($sql15);
	$sql16 = "INSERT INTO catagory VALUES (2, 'Woman')";
	mysql_query($sql16);
	$sql17 = "INSERT INTO menu VALUES (1, 'Home', 'index.php')";
	mysql_query($sql17);
	$sql18 = "INSERT INTO menu VALUES (2, 'News', 'news.php')";
	mysql_query($sql18);
	$sql19 = "INSERT INTO menu VALUES (3, 'Rate All', 'rate.php')";
	mysql_query($sql19);
	$sql20 = "INSERT INTO menu VALUES (4, 'Rate Women', 'rate.php?action=female')";
	mysql_query($sql20);
	$sql21 = "INSERT INTO menu VALUES (5, 'Rate Men', 'rate.php?action=men')";
	mysql_query($sql21);
	$sql22 = "INSERT INTO menu VALUES (6, 'Hints and Tips', 'hinttip.php')";
	mysql_query($sql22);
	$sql23 = "INSERT INTO menu VALUES (7, 'Forgot Password', 'forgot.php')";
	mysql_query($sql23);
	$sql24 = "INSERT INTO menu VALUES (8, 'Join PicMe', 'join.php')";
	mysql_query($sql24);
	$sql25 = "INSERT INTO menu VALUES (9, 'About PicMe', 'about.php')";
	mysql_query($sql25);
	$sql26 = "INSERT INTO menu VALUES (10, 'F.A.Q.', 'faq.php')";
	mysql_query($sql26);
	$sql27 = "INSERT INTO menu VALUES (11, 'Feedback', 'feedback.php')";
	mysql_query($sql27);
	$sql28 = "INSERT INTO menu VALUES (12, 'Recommend Us', 'recommend.php')";
	mysql_query($sql28);
	$sql29 = "INSERT INTO faq VALUES (1, 'Your site says my picture is too large.', 'There size limiations of 800 on the long side.  You will need to edit your image with a program like <a href=http://www.jasc.com/>Pain Shop Pro </a>.  You can download an evaluation copy.')";
	mysql_query($sql29);
	$sql30 = "INSERT INTO faq VALUES (2, 'My picture is not displayed.', 'If you\'ve uploaded your photo, the Admin will have to pre-approve your picture.  Don\'t panic, I was sent an e-mail as soon as you uploaded your photo...  I usually get to them in less then 24 hours.')";
	mysql_query($sql30);
	$sql31 = "INSERT INTO faq VALUES (3, 'It says I voted too many times today. Why?', 'You reached your limit of 30 votes.  You\'ll have to try back again tomorrow.')";
	mysql_query($sql31);
	$sql32 = "INSERT INTO faq VALUES (7, 'Why is my rating so low?  Am I that ugly?', 'To keep the rating fair, well as fair as we can...  Everyone starts with a 1 rating, and as people vote, your average of all votes will start to go up...  Unless of course you really are that ugly ;-)')";
	mysql_query($sql32);
	$sql33 = "INSERT INTO faq VALUES (6, 'How can I send a private message?', 'You can click on the icon above the displayed picture.  When sending a message, your user profile username will be used to identify you.')";
	mysql_query($sql33);

	
$radd = $_SERVER['REMOTE_ADDR'];

	$msg = "This is an automated message from a PicMe installation, below are the details of this installation<br>Base URL...: $baseurl<br>Installer..: $radd";
	$subject = "PicMe Installation Completed\n\n";
$email="picme@directfreelance.com";
	$headers = "From: $adminemail\nMime-Version: 1.0\nContent-Type: text/html;\nContent-Transfer-Encoding: 7bit\n";

	mail($email, $subject, $msg, $headers);

    echo "</font><font face=Verdana size=2><br><br><b>SQL Setup Complete<br><br></b><a href=install.php?step=2>FINISH</a>";
}
// END DATABASE BUILD
 
 
//  BEGIN STEP TWO 
if ($step == 2) {
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="27"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Installation 
      Complete</b></font></td>
  </tr>
  <tr> 
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Please make sure that you admin area is protected. </font></td>
  </tr>
  <tr> 
    <td width="93%">&nbsp;</td>
  </tr>
  <tr> 
    <td width="93%" bgcolor="#CCCCCC" height="2"> 
      <table width="100%" border="0" cellspacing="1" cellpadding="2">
        <tr bgcolor="#f1f1f1"> 
          <td> <b><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
            ADMINISTRATION LOGIN</font></b></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr> 
    <td width="93%">&nbsp;</td>
  </tr>
  <tr> 
    <td width="93%" height="29"><font size="2" face="Courier New, Courier, mono"><a href="index.php">Admin 
      Login</a></font></td>
  </tr>
  <tr> 
    <td></td>
  </tr>
  <tr> 
    <td></td>
  </tr>
  <tr> 
    <td height="8"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">You 
      <b>MUST</b> delete this install.php file before accessing the administration 
      panel for security reasons.</font></td>
  </tr>
</table>
<?PHP
 }
 ?>
