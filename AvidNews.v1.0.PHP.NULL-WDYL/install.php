<?php
include './functions.php';

function configfile() {
global $HTTP_POST_VARS;
extract($HTTP_POST_VARS );

$cfgfile = '<?php

/*

AvidNews 1.0
© 2003 AvidNewMedia
http://www.avidnewmedia.com

For license information, please read the license file which came with this edition of AvidNews

Generated automatically by AvidNews.Installer
*/

//Database Communications Settings
$CONF["sitename"] = "'.$sitename.'";
$CONF["domain"] = "'.$domain.'";
$CONF["dbhost"] = "'.$dbhost.'";
$CONF["dbuser"] = "'.$dbuser.'";
$CONF["dbpass"] = "'.$dbpass.'";
$CONF["dbname"] = "'.$dbname.'";
$CONF["table_prefix"] = "";
$CONF["limit_type"] = "'.$limittype.'";
$CONF["limit"] = "'.$limit.'";
$CONF["image_upload_dir"] = "./images/";
?>';

@chmod("config.php", 0777);

//then we write the file
$fp = fopen("config.php", "w");
fwrite($fp, $cfgfile);
fclose($fp);

// finally, we chmod it to 644
@chmod("config.php", 0644);

header('Location: install.php?cmd=do_install');
}

if($cmd == "do_install") {
admin_header2();
include './config.php';
mysql_connect($CONF['dbhost'], $CONF['dbuser'], $CONF['dbpass']);
mysql_select_db($CONF['dbname']);


echo("<center><object classid=clsid:D27CDB6E-AE6D-11cf-96B8-444553540000");
echo("codebase=http://active.macromedia.com/flash4/cabs/swflash.cab#version=4,0,0,0");
echo("id=installprogress width=318 height=150>");
echo("<param name=movie value=installprogress.swf>");
echo("<param name=menu value=false>");
echo("<param name=quality value=best>");
echo("<param name=bgcolor value=#FFFFFF>");
echo("<embed name=installprogress src=installprogress.swf menu=false quality=best bgcolor=#FFFFFF width=318 height=150 type=application/x-shockwave-flash pluginspage=http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash>");
echo("</embed>");
echo("</object></center>");


  mysql_query("DROP TABLE IF EXISTS admins");
  mysql_query("CREATE TABLE admins (
  id int(15) NOT NULL auto_increment,
  username varchar(200) NOT NULL default '',
  password varchar(50) NOT NULL default '',
  status varchar(20) NOT NULL default '',
  name varchar(200) NOT NULL default '',
  email varchar(200) NOT NULL default '',
  bio varchar(200) NOT NULL default '',
  website varchar(200) NOT NULL default '',
  photo varchar(250) NOT NULL default '',
  PRIMARY KEY  (id)
) TYPE=MyISAM;");

mysql_query("INSERT INTO admins (id, username, password, status) VALUES (1, 'admin', 'DDfV6X2zVYFAE', 'admin');");
// --------------------------------------------------------

//
//

  mysql_query("DROP TABLE IF EXISTS categories");
  mysql_query("CREATE TABLE categories (
  catid int(20) NOT NULL auto_increment,
  catname varchar(200) NOT NULL default '',
  PRIMARY KEY  (catid)
) TYPE=MyISAM;");

mysql_query("INSERT INTO categories (catid, catname) VALUES (1, 'Main News');");
// --------------------------------------------------------

//
// Table structure for table News
//

  mysql_query("DROP TABLE IF EXISTS news");
  mysql_query("CREATE TABLE news (
  id int(15) NOT NULL auto_increment,
  category varchar(50) NOT NULL default '',
  headline varchar(200) NOT NULL default '',
  blurb varchar(200) NOT NULL default '',
  text longtext NOT NULL,
  date_added int(10) NOT NULL default '0',
  added_by varchar(50) NOT NULL default '',
  image varchar(250) NOT NULL default '',
  live varchar(3) NOT NULL default '',
  PRIMARY KEY  (id)
) TYPE=MyISAM;");
mysql_query("INSERT INTO news VALUES (1, '1', 'Welcome', 'Welcome to AvidNews.  You may delete this.', 'sample news', '', 'admin', '', 'no');");
// --------------------------------------------------------

//
// Table structure for table Templates
//
  mysql_query("DROP TABLE IF EXISTS templates;");
  mysql_query("CREATE TABLE templates (
  id int(15) NOT NULL auto_increment,
  name varchar(200) NOT NULL default '',
  code longtext NOT NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;");
mysql_query("INSERT INTO templates VALUES (1, 'html_header', '<style type=text/css>\r\nTD {font-family: Verdana;}\r\n.headline {font-size: 11px;font-weight: bold}\r\n.date {font-size: 9px; font-weight: normal}\r\n.blurb {font-size: 9px;font-weight: normal}\r\n</style>');");
mysql_query("INSERT INTO templates VALUES (2, 'headline_bit', '<tr>\r\n    <td><span class=headline><a href=\'viewarticle.php?id=\$news_info[id]\'>\$news_info[headline]</a></span><br>\r\n      <span class=date>\$news_info[date]</span><br>\r\n      <Span class=blurb>\$news_info[blurb]</span></td>\r\n  </tr>');");
mysql_query("INSERT INTO templates VALUES (3, 'headline_header', '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">');");
mysql_query("INSERT INTO templates VALUES (4, 'headline_footer', '</table>');");
mysql_query("INSERT INTO templates VALUES (5, 'headline_separator', '<tr>\r\n<td>\r\n<hr noshade color=#000000 size=1 width=100%>\r\n</td>\r\n</tr>');");
mysql_query("INSERT INTO templates VALUES (6, 'article_header', '<style type=\"text/css\">\r\n<!--\r\n.headline {\r\n    font-family: Verdana;\r\n    font-size: 16px;\r\n    font-weight: bold;\r\n}\r\n.article {\r\n    font-family: Verdana;\r\n    font-size: 9px;\r\n}\r\n-->\r\n</style>');");
mysql_query("INSERT INTO templates VALUES (7, 'article_footer', '');");
mysql_query("INSERT INTO templates VALUES ('8', 'show_article', '\$printpage<br>\$emailpage<br><Span class=headline><!-- startprint -->\$article_info[headline]</span><br><br>by: \$author<br><span class=article>\$article_info[text]</span><!-- stopprint -->');");
// --------------------------------------------------------

//
// Table structure for table Profile Templates
//

  mysql_query("DROP TABLE IF EXISTS protemplates;");
  mysql_query("CREATE TABLE protemplates (
  id int(15) NOT NULL auto_increment,
  name varchar(200) NOT NULL default '',
  code longtext NOT NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;");

mysql_query("INSERT INTO protemplates VALUES (1, 'style_sheet', '<style type=text/css>\r\nTD {font-family: Verdana;}\r\n.headline {font-size: 11px;font-weight: bold}\r\n.date {font-size: 9px; font-weight: normal}\r\n.blurb {font-size: 9px;font-weight: normal}\r\n</style>');");
mysql_query("INSERT INTO protemplates VALUES (2, 'profile_header', '<style type=\"text/css\">\r\n<!--\r\n.headline {\r\n    font-family: Verdana;\r\n    font-size: 16px;\r\n    font-weight: bold;\r\n}\r\n.article {\r\n    font-family: Verdana;\r\n    font-size: 9px;\r\n}\r\n-->\r\n</style>');");
mysql_query("INSERT INTO protemplates VALUES (3, 'profile_footer', '');");
mysql_query("INSERT INTO protemplates VALUES (4, 'show_profile', '<TABLE WIDTH=\"100%\" CELLPADDING=\"2\" CELLSPACING=\"0\" BORDER=\"0\"><TR><TD WIDTH=\"39%\" BGCOLOR=\"#E3E3E3\" VALIGN=TOP><P><FONT FACE=\"Arial,Helvetica,Monaco\"><B>\$profile_info[name]</B></FONT></TD><TD WIDTH=\"61%\" BGCOLOR=\"#E3E3E3\" VALIGN=TOP></TD></TR><TR><TD WIDTH=\"39%\" VALIGN=TOP><P ALIGN=CENTER>\$profile_info[photo]</TD><TD WIDTH=\"61%\" VALIGN=TOP><P><TABLE WIDTH=\"100%\" CELLPADDING=\"2\" CELLSPACING=\"1\" BORDER=\"0\"><TR><TD WIDTH=\"27%\" BGCOLOR=\"#E3E3E3\" VALIGN=TOP><P><FONT SIZE=\"2\"><FONT FACE=\"Arial,Helvetica,Monaco\"><B>Bio:</B></FONT></FONT></TD><TD WIDTH=\"73%\" VALIGN=TOP><P>\$profile_info[bio]</TD></TR><TR><TD WIDTH=\"27%\" BGCOLOR=\"#E3E3E3\" VALIGN=TOP><P><FONT SIZE=\"2\"><FONT FACE=\"Arial,Helvetica,Monaco\"><B>Website:</B></FONT></FONT></TD><TD WIDTH=\"73%\" VALIGN=TOP><P>\$profile_info[website]</TD></TR><TR><TD WIDTH=\"27%\" BGCOLOR=\"#E3E3E3\" VALIGN=TOP><P><B><FONT SIZE=\"2\"><FONT FACE=\"Arial,Helvetica,Monaco\">Latest Articles By \$profile_info[name]</FONT></FONT></B></TD><TD WIDTH=\"73%\" VALIGN=TOP></TD></TR></TABLE></TD></TR><TR><TD WIDTH=\"39%\" VALIGN=TOP></TD><TD WIDTH=\"61%\" VALIGN=TOP></TD></TR></TABLE>');");
// --------------------------------------------------------
 



} elseif(!$cmd) {
admin_header2();
?>
<HTML>
 <HEAD>
  <TITLE>A v i d  [News] - Install</TITLE>
  <META NAME="GENERATOR" CONTENT="MicroVision Development / WebExpress">
  <STYLE>
  body{margin: 0px, 0px, 0px, 0px;}
  </STYLE>
 </HEAD>
 <BODY BGCOLOR="WHITE" LINK="#00007F" VLINK="#00007F" ALINK="#00007F">
  <FORM ACTION="install.php?cmd=makeconfig" METHOD="post">
   <P>
    <TABLE WIDTH="100%" CELLPADDING="2" CELLSPACING="1" BORDER="0">
     <TR>
      <TD WIDTH="21%" BGCOLOR="#E3E3E3" VALIGN=TOP>
       <P>
        <FONT FACE="Arial,Helvetica,Monaco"><FONT SIZE="2"><B>Sitename</B></FONT></FONT></TD>
      <TD WIDTH="79%" VALIGN=TOP>
       <P>
        <FONT FACE="Verdana,Arial,Times New I2"><FONT SIZE="1">Enter the name
        of your company or website</FONT></FONT></P>
       <P>
        <INPUT TYPE=TEXT NAME="sitename" SIZE="20" MAXLENGTH="256"></TD>
     </TR>
     <TR>
      <TD WIDTH="21%" BGCOLOR="#E3E3E3" VALIGN=TOP>
       <P>
        <FONT FACE="Arial,Helvetica,Monaco"><FONT SIZE="2"><B>Domain</B></FONT></FONT></TD>
      <TD WIDTH="79%" VALIGN=TOP>
       <P>
        <FONT SIZE="1"><FONT FACE="Verdana,Arial,Times New I2">Enter the URL
        Location where you will store AvidNews (make sure to include a / at the end)</FONT></FONT></P>
       <P>
        <FONT SIZE="1"><FONT FACE="Verdana,Arial,Times New I2"><INPUT TYPE=TEXT NAME="domain" VALUE="http://"

SIZE="20" MAXLENGTH="256"></FONT></FONT></TD>
     </TR>
     <TR>
      <TD WIDTH="21%" BGCOLOR="#E3E3E3" VALIGN=TOP>
       <P>
        <FONT FACE="Arial,Helvetica,Monaco"><FONT SIZE="2"><B>Host</B></FONT></FONT></TD>
      <TD WIDTH="79%" VALIGN=TOP>
       <P>
        <FONT FACE="Verdana,Arial,Times New I2"><FONT SIZE="1">Enter the host
        of the database (this is usually </FONT></FONT><I><FONT FACE="Verdana,Arial,Times New I2"><FONT

SIZE="1">localhost).</FONT></FONT></I><FONT FACE="Verdana,Arial,Times New I2"><FONT SIZE="1">
        If you don't know what this setting is, please ask your hosting provider.</FONT></FONT></P>
       <P>
        <FONT FACE="Verdana,Arial,Times New I2"><FONT SIZE="1"><INPUT TYPE=TEXT NAME="dbhost" SIZE="20"

MAXLENGTH="256"></FONT></FONT></TD>
     </TR>
     <TR>
      <TD WIDTH="21%" BGCOLOR="#E3E3E3" VALIGN=TOP>
       <P>
        <FONT FACE="Arial,Helvetica,Monaco"><FONT SIZE="2"><B>Database Username</B></FONT></FONT></TD>
      <TD WIDTH="79%" VALIGN=TOP>
       <P>
        <FONT FACE="Verdana,Arial,Times New I2"><FONT SIZE="1">Enter the
        username you've associated to your database (be careful to enter the
        full name)</FONT></FONT></P>
       <P>
        <FONT FACE="Verdana,Arial,Times New I2"><FONT SIZE="1"><INPUT TYPE=TEXT NAME="dbuser" SIZE="20"

MAXLENGTH="256"></FONT></FONT></TD>
     </TR>
     <TR>
      <TD WIDTH="21%" BGCOLOR="#E3E3E3" VALIGN=TOP>
       <P>
        <FONT FACE="Arial,Helvetica,Monaco"><FONT SIZE="2"><B>Database Password</B></FONT></FONT></TD>
      <TD WIDTH="79%" VALIGN=TOP>
       <P>
        <FONT FACE="Verdana,Arial,Times New I2"><FONT SIZE="1">Enter the
        password associated with the above username.</FONT></FONT></P>
       <P>
        <FONT FACE="Verdana,Arial,Times New I2"><FONT SIZE="1"><INPUT TYPE=TEXT NAME="dbpass" SIZE="20"

MAXLENGTH="256"></FONT></FONT></TD>
     </TR>
     <TR>
      <TD WIDTH="21%" BGCOLOR="#E3E3E3" VALIGN=TOP>
       <P>
        <FONT FACE="Arial,Helvetica,Monaco"><FONT SIZE="2"><B>Database Name</B></FONT></FONT></TD>
      <TD WIDTH="79%" VALIGN=TOP>
       <P>
        <FONT FACE="Verdana,Arial,Times New I2"><FONT SIZE="1">Enter the name
        you've given to your database (be careful to enter the full name)</FONT></FONT></P>
       <P>
        <FONT FACE="Verdana,Arial,Times New I2"><FONT SIZE="1"><INPUT TYPE=TEXT NAME="dbname" SIZE="20"

MAXLENGTH="256"></FONT></FONT></TD>
     </TR>
     <TR>
      <TD WIDTH="21%" BGCOLOR="#E3E3E3" VALIGN=TOP>
       <P>
        <FONT FACE="Arial,Helvetica,Monaco"><FONT SIZE="2"><B>Limit Type</B></FONT></FONT></TD>
      <TD WIDTH="79%" VALIGN=TOP>
       <P>
        <FONT FACE="Verdana,Arial,Times New I2"><FONT SIZE="1">Please choose
        how you would like to limit the number of headlines displayed</FONT></FONT></P>
       <P>
        <FONT FACE="Verdana,Arial,Times New I2"><FONT SIZE="1"><INPUT TYPE=RADIO NAME="limittype" VALUE="date">by
         Date <INPUT TYPE=RADIO NAME="limittype" VALUE="number">by number of headlines</FONT></FONT></TD>
     </TR>
     <TR>
      <TD WIDTH="21%" BGCOLOR="#E3E3E3" VALIGN=TOP>
       <P>
        <FONT FACE="Arial,Helvetica,Monaco"><FONT SIZE="2"><B>Limit</B></FONT></FONT></TD>
      <TD WIDTH="79%" VALIGN=TOP>
       <P>
        <FONT FACE="Verdana,Arial,Times New I2"><FONT SIZE="1">Please enter
        the limit. If you have chosen to limit by number, enter the number
        below. If you have chosen to limit by date, please enter the date in
        the following format (mm/dd/yyyy)</FONT></FONT></P>
       <P>
        <FONT FACE="Verdana,Arial,Times New I2"><FONT SIZE="1"><INPUT TYPE=TEXT NAME="limit" SIZE="20"

MAXLENGTH="256"></FONT></FONT></TD>
     </TR>
    </TABLE></P>
   <CENTER>
   <P ALIGN=CENTER>
    <INPUT TYPE=SUBMIT VALUE="Finish"> <INPUT TYPE=RESET VALUE="Reset"></FORM>
 </BODY>
</HTML>
<?php
}elseif($cmd == "makeconfig"){
configfile();
}
admin_footer();
?>

</body>
</html>