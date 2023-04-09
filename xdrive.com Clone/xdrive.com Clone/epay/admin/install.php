<link rel=stylesheet type=text/css href=style.css>
<?
##############################################################################
# PROGRAM : ePay                                                          #
# VERSION : 1.55                                                             #
#                                                                            #
##############################################################################
# All source code, images, programs, files included in this distribution     #
# Copyright (c) 2002-2003                                                    #
#		  Todd M. Findley       										  #
#           All Rights Reserved.                                             #
##############################################################################
#                                                                            #
#    While we distribute the source code for our scripts and you are         #
#    allowed to edit them to better suit your needs, we do not               #
#    support modified code.  Please see the license prior to changing        #
#    anything. You must agree to the license terms before using this         #
#    software package or any code contained herein.                          #
#                                                                            #
#    Any redistribution without permission of Todd M. Findley                      #
#    is strictly forbidden.                                                  #
#                                                                            #
##############################################################################
?>
<?
error_reporting(0);
if ($_POST['go'])
{
  $f = fopen("../connect.php", 'w');
  if ($f)
  {
    $str = "<?\n".
           "@mysql_connect('{$_POST['host']}', '{$_POST['user']}', '{$_POST['psw']}') or die('Cannot connect to MySQL server');\n".
           "@mysql_select_db('{$_POST['dbname']}');\n".
           "?>";
    fwrite($f, $str);
    fclose($f);
    echo "File \"connect.php\" was created<BR>";
  }
  else
    echo "<span style='color:aqua;'><b>Write to file failed. Check write permissions for file \"connect.php\"</span><BR>";
  
  $content = join('', file("../config.php"));
  $f = fopen("../config.php", 'w');
  if ($f)
  {
    $content = str_replace("\$superpass = \"\";", "\$superpass = \"{$_POST['admpsw']}\";", $content);
    fwrite($f, $content);
    fclose($f);
    echo "File \"config.php\" was updated<BR>";
  }
  else
  echo "<span style='color:aqua;'>Password was not saved. Check write permissions for file \"config.php\"<BR>";

  echo "<BR>Please make sure you have changed the permissions (CHMOD 777) to the following files",
	 "<BR>before attempting to to proceed any further or attempting to re-install the script:<UL>",
       "<LI>File: /epay/config.php",
	 "<LI>File: /epay/connect.php (return permissions on this file to 755 after installation)",
	 "<LI>Directory: /epay/backup",
       "<LI>Directory: /epay/files/</LI></UL>",
 	 "If you have received any errors up to this point, you will have to \"drop\" (delete)",
	 "<BR>all the epay tables in your MySQL database and run /epay/admin/install.php again</span>",
  	 "<BR><BR>",
       "<span style='color:yellow;'>Reminder:</span> Delete /admin/install.php before",
	 " proceeding to your admin panel",
       "<BR><BR><B>Once install.php has been deleted</b> you can then proceed to your administration area and login: <a href=index.php style='color:aqua;'>/epay/admin/index.php</a>",
       "<BR><BR><BR>";
  $admname = $_POST['admname'];
  mysql_connect($_POST['host'], $_POST['user'], $_POST['psw']) or die('Cannot connect to MySQL server');
  mysql_query("CREATE DATABASE IF NOT EXISTS ".$_POST['dbname']);
  mysql_select_db($_POST['dbname']);
  include('install_inc.php');
  exit;
}
?>
<HTML>
<HEAD>
<TITLE>epay Installation</TITLE>
</HEAD>
<BODY>
<CENTER>
<font size=+1>epay MySQL Configuration</font>
<BR><BR>
<TABLE cellspacing=0>
<FORM method=post>
<TR><TD>Enter <b>Database Server</b> (ie: localhost):
	<TD><INPUT type=text name=host size=30>
<TR><TD>Enter Your Database <b>USERNAME</b>:
	<TD><INPUT type=text name=user size=30>
<TR><TD>Enter Your Database <b>PASSWORD</b>:
  <TD><INPUT type=text name=psw size=30>
<TR><TD>Enter the <b>NAME</b> of your Database (ie: epay):
	<TD><INPUT type=text name=dbname size=30>
<TR><TD>Enter a <b>Username</b> for your epay Admin Panel:
	<TD><INPUT type=text name=admname size=30>
<TR><TD>Enter a <b>Password</b> for your epay Admin Panel:
	<TD><INPUT type=text name=admpsw size=30>
<TR><TD>&nbsp;
	<TD><INPUT type=submit name=go value="Initialize Database >>"></TD>
</FORM>
</TABLE>

<BR>
<SPAN style='color:red;'><B>Please Note:</B></SPAN> Before initializing the database make sure that your files <b>/connect.php and  /config.php</b> <BR>located in your <b>root</b> directory and the folders <b>/file & /backup</b>  have write permissions (CHMOD 777).

</div>
</body>
</HTML>