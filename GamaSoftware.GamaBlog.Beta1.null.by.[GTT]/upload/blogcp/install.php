<?php
//GamaSoftware GamaBlog v1.0.0
/* Nullified by GTT */

error_reporting(7);

//collect browser variables
@extract($HTTP_SERVER_VARS, EXTR_SKIP);
@extract($HTTP_COOKIE_VARS, EXTR_SKIP);
@extract($HTTP_POST_FILES, EXTR_SKIP);
@extract($HTTP_POST_VARS, EXTR_SKIP);
@extract($HTTP_GET_VARS, EXTR_SKIP);
@extract($HTTP_ENV_VARS, EXTR_SKIP);

//Obtain configuration files and database class
chdir("../includes");
require("./config.php");
require("./db_mysql.php");

$header='
<html>
<head>
<title>GamaSoftware\'s Gama Blog Beta 1 Installer</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#E4E7ED" text="#FFFFFF" link="#FF8D2C" vlink="#FF8D2C" alink="#FF8D2C">
<table width="600" height="199" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCFFFF">
  <tr bgcolor="#A5B1C5"> 
    <td height="100"><img src="../images/gamaheader.jpg" width="400" height="100">Beta 
      1 Installer</td>
  </tr>
  <tr bgcolor="#405479"> 
    <td height="400" align="center" valign="top"> 
';
$footer='
      </td>
  </tr>
</table>
</body>
</html>
';
if($step=="" && $action=="")
	$step=1;
$nextstep=$step+1;
$nextsteplink="<a href=\"install.php?step=$nextstep\">Next step</a>";



echo "$header";
if($step=="1"){
	echo "Edit your config.php file located in your includes folder then click the next step link after you have uploaded the changes. <br><br>$nextsteplink";
}
if($step == 2){
	//Database init
	$DB_site=new DB_Sql_vb;
	$DB_site->appname="GamaBlog";
	$DB_site->appshortname="blog";
	$DB_site->database=$dbname;
	$DB_site->server=$servername;
	$DB_site->user=$dbusername;
	$DB_site->password=$dbpassword;
	$DB_site->reporterror=0;
	$DB_site->connect();
	$dbpassword="";
	$DB_site->password="";
	require("./cpfunctions.php");

	$errno=$DB_site->errno;
	if ($DB_site->link_id!=0) {
		if ($errno!=0) {
			if ($errno==1049) {
				$DB_site->query("CREATE DATABASE $dbname");
				$DB_site->select_db($dbname);
				$errno=$DB_site->geterrno();
				if ($errno != 0) {
					echo "<p>Contact your host or manualy create this database table.</p>";
					exit;
				}
			}
		}else{
			echo" ";
		}
	}
	echo "Setting up the database for connectivity.";
	echo $nextsteplink;
}

if($step >=3 || $action !=""){
	//Database init
	$DB_site=new DB_Sql_vb;
	$DB_site->appname="GamaBlog";
	$DB_site->appshortname="blog";
	$DB_site->database=$dbname;
	$DB_site->server=$servername;
	$DB_site->user=$dbusername;
	$DB_site->password=$dbpassword;
	$DB_site->connect();
	$dbpassword="";
	$DB_site->password="";
	require("./cpfunctions.php");
}
if($step==3){

	$DB_site->query("DROP TABLE IF EXISTS `blog_entries`;");
	$DB_site->query("CREATE TABLE blog_entries (id int(8) NOT NULL auto_increment,date varchar(16) NOT NULL default'',text text NOT NULL,PRIMARY KEY  (id)) TYPE=MyISAM AUTO_INCREMENT=13;");
	echo"Creating entries table.<br>";
	$DB_site->query("INSERT INTO `blog_entries` VALUES (10, '6.28.03', 'Gama.Blog Beta 1-----Oh yeah ;)');");
	echo"Creating Default Entry.<br>";
	$DB_site->query("DROP TABLE IF EXISTS `blog_templates`;");
	$DB_site->query("CREATE TABLE blog_templates (id int(8) NOT NULL auto_increment,name varchar(100) NOT NULL default '',template text NOT NULL,loadorder int(8) NOT NULL default '0',PRIMARY KEY  (id)) TYPE=MyISAM AUTO_INCREMENT=6;");
	echo"Creating templates table.<br>";
	$DB_site->query("INSERT INTO `blog_templates` VALUES (1, 'entry_bit', '<p>\r\n<i><font size=1 face=\"Arial\">\r\n<center>\$entryinfo[date]\r\n</font></i></center><div align=left>\r\n<font face=\"Arial\" size=1>\r\n\$entryinfo[text] \r\n</font></div>', -1);");
	echo"Creating default entry_bit template.<br>";
	$DB_site->query("INSERT INTO `blog_templates` VALUES (2, 'rightbar', '<p><strong><em>mylife.log</em></strong><br>\r\n        <img src=\"\$opictureurl\"><br>\r\n        <strong>Likes: </strong><br><font size=-2>\r\n       \$olikes</font></p>\r\n      <p><strong>Dislikes:</strong><br>\r\n        <font size=-2>\$odislikes</font></p>\r\n      <p><strong>Contacts:</strong><br>\r\n<img src=\"images/aim.gif\">: \$oaimname<br>\r\n<img src=\"images/msn.gif\">: \$omsnname<br>\r\n<img src=\"images/yim.gif\">: \$oyahooname<br>\r\n<img src=\"images/icq.gif\">: \$oicqname<br>\r\n<img src=\"images/email.gif\">: <a href=\"mailto:\$oemail\">\$oemail</a><br><br>\r\n', 1);");
	echo"Creating default rightbar template.<br>";
	$DB_site->query("INSERT INTO `blog_templates` VALUES (4, 'header', '<table width=\"600\" height=\"199\" border=\"1\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#CCFFFF\">\r\n  <tr bgcolor=\"#A5B1C5\"> \r\n    <td height=\"100\" colspan=\"2\"><img src=\"\$oheaderimage\" width=\"400\" height=\"100\"></td>\r\n  </tr>\r\n  <tr> \r\n    <td width=\"400\" height=\"400\" align=\"center\" valign=\"top\" bgcolor=\"#405479\">', 97);");
	echo"Creating default header template.<br>";
	$DB_site->query("INSERT INTO `blog_templates` VALUES (5, 'footer', '</td>\r\n    <td width=\"157\" align=\"center\" valign=\"top\" bgcolor=\"#132449\">\$rightbar\r\n      </td>\r\n  </tr>\r\n</table><center>\r\n\r\n<font size=-2 color=black>\r\n\r\nPowered Gama.blog. Copyright of GamaSoftware 2003. All rights reserved. Nullified by GTT.\r\nr\\n</font>\r\n</center>', 98);");
	echo"Creating default footer template.<br>";
	$DB_site->query("INSERT INTO `blog_templates` VALUES (3, 'main', '<html>\r\n<head>\r\n<title>GamaSoftware\'s Gama Blog</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\r\n</head>\r\n\r\n<body bgcolor=\"#E4E7ED\" text=\"#FFFFFF\" link=\"#FF8D2C\" vlink=\"#FF8D2C\" alink=\"#FF8D2C\">\r\n\$header\r\n	\$entry\r\n\$footer\r\n</body>\r\n</html>', 99);");
	echo"Creating default main template.<br>";
	echo"<BR><BR><BR><BR>$nextsteplink";
}

if($step==4){
	blogtablehead("Cp Configuration","step5","Enter your userinfo for your Control Panel");
	blogtextbox("Username","Your Cp Username","username");
	blogpassword("Password","Your Cp Password","password");
	blogpassword("Password Repeat","repeat the password above","password2");
	blogtextbox("Cookie Domain","The domain name for your blog(leave out http://)","domain");
	blogtablefoot(0,1);
}

if($step==5 || $action=="step5"){
	if($password != $password2){
		echo"error make sure the passwords match";
		exit;
	}
	$step=5;
	$nextstep=$step+1;
	$nextsteplink="<a href=\"install.php?step=$nextstep\">Next step</a>";
	$DB_site->query("DROP TABLE IF EXISTS `blog_options`;");
	$DB_site->query("CREATE TABLE blog_options (id int(8) NOT NULL auto_increment,name varchar(100) NOT NULL default '',value text NOT NULL,type varchar(100) NOT NULL default '',PRIMARY KEY  (id)) TYPE=MyISAM AUTO_INCREMENT=14;");
	echo"Creating options table.<br>";
	$DB_site->query("INSERT INTO `blog_options` VALUES (1, 'username', '$username', '1');");
	echo"Creating default options.<br>";
	$DB_site->query("INSERT INTO `blog_options` VALUES (2, 'password', '$password', '4');");
	echo"Creating default options.<br>";
	$DB_site->query("INSERT INTO `blog_options` VALUES (3, 'domain', '$domain', '1');");
	echo"Creating default options.<br>";
	$DB_site->query("INSERT INTO `blog_options` VALUES (4, 'aimname', 'myaimname', '1');");
	echo"Creating default options.<br>";
	$DB_site->query("INSERT INTO `blog_options` VALUES (5, 'msnname', 'mymsnname', '1');");
	echo"Creating default options.<br>";
	$DB_site->query("INSERT INTO `blog_options` VALUES (6, 'email', 'my@emailaddress.com', '1');");
	echo"Creating default options.<br>";
	$DB_site->query("INSERT INTO `blog_options` VALUES (7, 'version', 'beta 1', '5');");
	echo"Creating default options.<br>";
	$DB_site->query("INSERT INTO `blog_options` VALUES (8, 'yahooname', 'myyahooname', '1');");
	echo"Creating default options.<br>";
	$DB_site->query("INSERT INTO `blog_options` VALUES (9, 'icqname', 'myicqnumber', '1');");
	echo"Creating default options.<br>";
	$DB_site->query("INSERT INTO `blog_options` VALUES (10, 'pictureurl', 'images/darkgama.jpg', '1');");
	echo"Creating default options.<br>";
	$DB_site->query("INSERT INTO `blog_options` VALUES (11, 'likes', 'these are things i like, did I mention<br><b> ','1');");
	echo"Creating default options.<br>";
	$DB_site->query("INSERT INTO `blog_options` VALUES (12, 'dislikes', 'these are things i dont like', '1');");
	echo"Creating default options.<br>";
	$DB_site->query("INSERT INTO `blog_options` VALUES (13, 'headerimage', 'images/gamaheader.jpg', '1');");
	echo"Creating default options.<br>";
	echo"<br><Br><Br>$nextsteplink";
}
if($step==6){
	echo"Congratulations, First Delete blogcp/install.php as this can be used to destroy your blog and start it over with someone elses information. Then log in to your <a href=\"index.php\">Gama.Blog Cp</a>";
}
echo "$footer";

?>