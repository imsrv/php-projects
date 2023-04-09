<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Liquid Frog Chat installation</title>
<link REL='StyleSheet' TYPE='text/css' HREF='style.css'>
</head>
<?php
include "db_file.php";
include "config.php";
echo "<font face='Verdana' size='1'>";
DB_connect();
?>
<body>

<table border="0" cellpadding="2" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber1">
  <tr>
    <td width="15%" bgcolor="#E7EAE1" bgcolor="#E7EAE1">&nbsp;</td>
    <td width="5%" bgcolor="#E7EAE1" bgcolor="#E7EAE1">&nbsp;</td>
    <td width="20%" bgcolor="#E7EAE1">&nbsp;</td>
    <td width="20%" bgcolor="#E7EAE1">&nbsp;</td>
    <td width="20%" bgcolor="#E7EAE1">&nbsp;</td>
    <td width="4%" bgcolor="#E7EAE1" bgcolor="#E7EAE1">&nbsp;</td>
    <td width="16%" bgcolor="#E7EAE1" bgcolor="#E7EAE1">&nbsp;</td>
  </tr>
  <tr>
    <td width="15%" bgcolor="#E7EAE1">&nbsp;</td>
    <td width="5%" bgcolor="#E7EAE1">&nbsp;</td>
    <td width="60%" colspan="3">
    <p align="center">

    <img border="0" src="<?php echo $path_to_smilies; ?>/frogl.jpg"></td>
    <td width="4%" bgcolor="#E7EAE1">&nbsp;</td>
    <td width="16%" bgcolor="#E7EAE1">&nbsp;</td>
  </tr>
  <tr>
    <td width="15%" bgcolor="#E7EAE1">&nbsp;</td>
    <td width="5%" bgcolor="#E7EAE1">&nbsp;</td>
    <td width="60%" colspan="3">
    <p align="center">
    <b>Welcome to Liquid Frog Chat Installation</b><BR><BR><BR>
    </td>
    <td width="4%" bgcolor="#E7EAE1">&nbsp;</td>
    <td width="16%" bgcolor="#E7EAE1">&nbsp;</td>
  </tr>
  <tr>
    <td width="15%" bgcolor="#E7EAE1" valign="top">
    <font face="Verdana" size="1">Also available from Liquid Frog:</font><p>
    <font face="Verdana" size="1"><b>
    <a target="_blank" href="http://liquidfrog.bestdirectbuy.com/Avanti_Web_Stats.htm">
    Avanti Web Stats</a></b> - The most comprehensive &amp; feature rich stats
    package available anywhere. Checks stats for multiple sites right from your
    desktop!</font></p>
    <p><font face="Verdana" size="1"><b>
    <a target="_blank" href="http://liquidfrog.bestdirectbuy.com/strongarm.html">
    Strong Data Encryption</a></b> - Watermarks virtually any sort of file
    invisibly with your copyright.</font></p>
    <p><font face="Verdana" size="1"><b>Pinnacle Download Manager and rating
    system</b> - Coming soon!</font></p>
&nbsp;<p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</td>
    <td width="5%" bgcolor="#E7EAE1" valign="top">&nbsp;</td>
    <td width="60%" colspan="3">    <p align="center">

<?php

function CreateTable() {

   $query="DROP TABLE IF EXISTS LFchat_user";
   $result=mysql_query($query);

   $query="CREATE TABLE LFchat_user (
      ID int(11) NOT NULL auto_increment,
      login char(10),
      password char(10),
      email char(100),
      d8 timestamp(14),
      PRIMARY KEY (ID),
      UNIQUE ID (ID)
   )";
   $result=mysql_query($query);


   $query="DROP TABLE IF EXISTS LFchat_room";
   $result=mysql_query($query);

   $query="CREATE TABLE LFchat_room (
      ID int(11) NOT NULL auto_increment,
      user char(10),
      user_ID char(10),
      remote_addr VARCHAR(16) NULL,
      d8 timestamp(14),
      d8_init datetime,
      PRIMARY KEY (ID),
      UNIQUE ID (ID)
   )";
   $result=mysql_query($query);


   $query="DROP TABLE IF EXISTS LFchat_admin";
   $result=mysql_query($query);

   $query="CREATE TABLE LFchat_admin (
      ID int(11) NOT NULL auto_increment,
      d8_end_use datetime,
      last_chatd8 datetime,
      lasttime datetime,
      adminlastseen datetime,
      PRIMARY KEY (ID),
      UNIQUE ID (ID)
      );";
   $result=mysql_query($query);

   $query="INSERT INTO LFchat_admin (ID, d8_end_use, last_chatd8, lasttime, adminlastseen) VALUES ('', '2004-07-29 11:11:11', '2004-07-29 11:11:11', '2004-07-29 11:11:11','2004-07-29') ";
   $result=mysql_query($query);



   $query="DROP TABLE IF EXISTS LFchat_chat";
   $result=mysql_query($query);

   $query="CREATE TABLE LFchat_chat (
   ID int(11) NOT NULL auto_increment,
   user varchar(10),
   details text,
   spare varchar(10),
   d8 timestamp(14),
   PRIMARY KEY (ID),
   UNIQUE ID (ID)
   )";

   $result=mysql_query($query);

   $query="DROP TABLE IF EXISTS LFchat_banned_ips";
   $result=mysql_query($query);

   $query = "CREATE TABLE LFchat_banned_ips (
   id int(11) AUTO_INCREMENT NOT NULL,
   remote_addr VARCHAR( 16 ) UNIQUE,
   PRIMARY KEY( id )
   )";
   $result=mysql_query($query);

   $query="DROP TABLE IF EXISTS LFchat_banners";
   $result=mysql_query($query);

   $query="CREATE TABLE LFchat_banners (
   ID int(11) NOT NULL auto_increment,
   filename varchar(255),
   url varchar(255),
   details text,
   impressions int(11),
   hits int(11),
   PRIMARY KEY (ID),
   UNIQUE ID (ID)
   )";
   $result=mysql_query($query);

   $query="INSERT INTO LFchat_banners (ID, filename, url, details, impressions, hits) VALUES ('', 'lfbanner.gif', 'http://www.liquidfrog.com', 'The source of this script',0, 0) ";
   $result=mysql_query($query);
   print "<font size='3' color='green'>";
   print "<b><BR>Tables created - Installation was a success!<BR><BR></b>";
   print "<font size='1' color='red'>";
   print "<B>Once you have finished with this install routine, remove or rename the install.php file. This will prevent anyone else running it and overwriting your tables!</B><BR>";
   print "<font size='1' color='black'>";
   print "<BR><BR>Now that your installation is complete you need to edit the <b>config.php</b> file and set up the chat <b>before</b> you enter chat below.<BR><BR>";
   print "Go and do that <b>now</b>, then you can come back to this screen.......<br><hr><br><center>";
   print "Hint* The small window below is the chat <b>index.php</b> file. This is the file that your visitors will use to enter chat.";
   print " It will open into a full size window but you will probably want to use the index.php file in an <b>iframe</b> on the page where you want your ";
   print "visitors to see it. To do this, use the code given below where you want the chat invitiation (index.php) to appear<BR><BR>";
   print "For HTML pages use this - &lt;iframe src=http://www.yoursite.com/chat_directory/index.php width=150 height=240 frameborder=1 scrolling=no></iframe><br><br> ";
   print "For PHP pages use this - echo &quot;&lt;iframe src=http://www.yoursite.com/chat_directory/index.php width=150 height=240 frameborder=1 scrolling=no></iframe>&quot;;<br><br> ";
   print "<b>or</b> use a closing php tag like this ?&gt;, on the next line use the iframe code for HTML and, on the line below the iframe statement, use an opening PHP tag like this &lt;?php<br><br>";
   print "This will produce a small and neat window that the chat invitation will appear in just like that shown below!<br><br>";
   print "<br><br>";
   print "<iframe src='$dir_to_chat./index.php' width=150 height=240 frameborder=1 scrolling=no></iframe>";
   print "<br><br>";
   print "You might prefer to go to admin rather than straight to chat. In this case [<A href='admin.php' target='_blank'>click here</A>].<br><br>";
   print "You can always get to admin by typing this into your browser - 'http://yoursite.com/chat_directory/admin.php'";
   if( is_file( 'install.php' ) )
   print "<BR><BR>";
   print "<font size='3' color='red'>";
   echo"<B>Warning!<br><BR></B>";
   print "<font size='1' color='black'>";
   echo"The file <b>install.php</b> was found on your server. Please remove or rename the file to prevent misuse.";
   }

print "<BR><BR>";
print "<font size='1' color='black'>";
print "Did you read the <A href='readme.txt' target='_blank'>readme.txt</A> file? - You'll probably need to you know!<BR><BR><BR>";



function CheckTable() {
   $ok=1;
   $query="SELECT * FROM LFchat_chat";
   $result=mysql_query($query);
   if ($result==true) {
      $ok=0;
      print"The table LFchat_chat already exists<BR>";
   }
   $query="SELECT * FROM LFchat_user";
   $result=mysql_query($query);
   if ($result==true) {
      $ok=0;
      print"The table LFchat_user already exists<BR>";
   }
   $query="SELECT * FROM LFchat_admin";
   $result=mysql_query($query);
   if ($result==true) {
      $ok=0;
      print"The table LFchat_admin already exists<BR>";
   }
   $query="SELECT * FROM LFchat_room";
   $result=mysql_query($query);
   if ($result==true) {
      $ok=0;
      print"The table LFchat_room already exists<BR>";
   }
   if ($ok==1) {
      print"OK, here we go - I'm ready to create the following tables<BR><BR>";
      print"LFchat_chat - LFchat_user - LFchat_admin - LFchat_room<BR><BR>";


   } else {
      print"<font size='1' color='black'>";
      print"<BR><B>The tables above were found in your database. They have been overwritten!<BR></B>";
     }

   if ($_GET['go']="yes"){
        CreateTable();
 }
 }


if ($_GET['modified'] !="yes") {
      print "<font color = 'red'>";
      print "Before proceeding you will need to have modified the file db_file.php and changed the database settings to match your own.<BR><BR>";
      print "<B>Have you modified the file db_file.php?<BR><A href='install.php?modified=yes'><BR><BR>Yes I have</A></B><BR>";
      print "<font size = '2'>";
      print "<BR><BR><B>Warning!</B>";
      print "<font size = '1'>";
      print "<BR><BR>Once you click Yes I have - any tables already created will be overwritten!";
      print "</font>";
      }elseif
         ($_GET['go']="yes")
          CheckTable();

?>

</td>
    <td width="4%" bgcolor="#E7EAE1" valign="top">&nbsp;</td>
    <td width="16%" bgcolor="#E7EAE1" valign="top">
    <font face="Verdana" size="1">Also available from Liquid Frog:</font><p>
    <font face="Verdana" size="1"><b>
    <a target="_blank" href="http://liquidfrog.bestdirectbuy.com/downloads.html">
    More free scripts</a></b> - </font></p>
    <p><font face="Verdana" size="1">Server Load</font></p>
    <p><font face="Verdana" size="1">Internet Traffic Monitor</font></p>
    <p><font face="Verdana" size="1">Calendar Page</font></p>
    <p><font face="Verdana" size="1">Visitors Online</font></p>
    <p><font face="Verdana" size="1">News Ticker - and many more!</font></p>
    <p>&nbsp;</td>
  </tr>
  <tr>
    <td width="15%" bgcolor="#E7EAE1">&nbsp;</td>
    <td width="5%" bgcolor="#E7EAE1">&nbsp;</td>
    <td width="60%" colspan="3">&nbsp;</td>
    <td width="4%" bgcolor="#E7EAE1">&nbsp;</td>
    <td width="16%" bgcolor="#E7EAE1">&nbsp;</td>
  </tr>
  <tr>
    <td width="15%" bgcolor="#E7EAE1">&nbsp;</td>
    <td width="5%" bgcolor="#E7EAE1">&nbsp;</td>
    <td width="20%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
    <td width="4%" bgcolor="#E7EAE1">&nbsp;</td>
    <td width="16%" bgcolor="#E7EAE1">&nbsp;</td>
  </tr>
  <tr>
    <td width="15%" bgcolor="#E7EAE1">&nbsp;</td>
    <td width="5%" bgcolor="#E7EAE1">&nbsp;</td>
    <td width="20%" bgcolor="#E7EAE1">&nbsp;</td>
    <td width="20%" bgcolor="#E7EAE1">&nbsp;</td>
    <td width="20%" bgcolor="#E7EAE1">&nbsp;</td>
    <td width="4%" bgcolor="#E7EAE1">&nbsp;</td>
    <td width="16%" bgcolor="#E7EAE1">&nbsp;</td>
  </tr>
</table>

</body>

</html>