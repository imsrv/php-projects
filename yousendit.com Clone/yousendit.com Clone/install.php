<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>YouSendItClone</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="script.js"></script>
</head>

<body>
<table width="794" border="0" align="center" cellpadding="0" cellspacing="0" style="border: solid 1px #999999">
  <tr>
    <td width="792"><table width="795" border="0" align="center" cellpadding="0" cellspacing="0">

  <tr>
          <td width="794"><p align="center"><img src="images/yourlogo.jpg" width="493" height="125"></p>
    </td>
          <td width="1" valign="top">&nbsp;</td>
  </tr>
        <tr>
          <td height="20" colspan="2" background="images/index_12.gif"><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><a href="index.php">Upload</a>          |<a href="aboutus.php">About
                  Us</a> | <a href="privacy.php">Privacy
                  policy</a> | <a href="terms.php">Terms of service</a> | <a href="mailto:admin@popscript.com">Contact</a> </font></div></td>

        </tr>
      </table>
</td>
  </tr>
  <tr>
    <td valign="center"><div align="center">
      <table width="60%" border="0">
        <tr>
          <td><div align="center">

            <table width="100%" border="0" align="center">
              <tr>
                <td><div id="table1" style="visibility: hidden; display: none">
                    <table width="100%" border="0" cellpadding="2" cellspacing="0">
                      <tr>
                        <td><H4 class="ltxt">
                            YouSendItClone                            <br>
                            <font size="2">Sending Your File. Please Stand By...</font></H4>

                        </td>
                      </tr>
                      <tr>
                        <td>                          <!-- <iframe src="progress.html"  frameborder="0" marginWidth=0 marginHeight=0 scrolling="auto" width="100%" height="5"></iframe> -->                          <img src="images/sending_progress.gif" width="150" height="5"></td>
                      </tr>
                      <tr>
                        <td class="ltxt"><font size="2"><B>Note:</B> Don't
                            close this page or browse away while the YouSendIt
                            progress bar is being displayed above. You'll see
                            a confirmation screen when your file has been successfully
                            sent. Keep in mind that a one megabyte (1MB) file
                            can take 1 to 5 minutes to send depending on your
                            connection speed.</font></td>

                      </tr>
                    </table>
                  </div>
                    <br>
                    <div id="table2SD"></div>
                    <div id="table2" style="visibility: visible; display: inline">
                      <div align="center" class="ltxt">
                      <?php
                        if(!isset($_GET['install']))
                         {
                         ?>
                           Welcome to the YouSendItClone installation. Within the next five minutes
                           this script will walk you through the installation of your YouSendItClone.
                           <br /><br />
                           Step One: Open /include/dbinfo.php and change accordingly to your
                           database information.
                           <br /><br />
                           Step Two: Open /include/vars.php and change the first five values to suit your
                           website. Don't edit past the conviently placed warning saying not too. <br /><br />
Step Three: CHMOD Uploads directory to 0777 <br /><br /><a href="install.php?install=yes">Install</a>
                       <?php   //'
                       } else {
                         require('./include/dbinfo.php');
                         require('./include/vars.php');
                         require('./include/db.php');
                         $db->query("
create table ".$db['prefix']."fileinfo(
id int not null auto_increment,
idkey varchar(30) not null unique,
dir varchar(30) not null unique,
mime_type varchar(50),
file_name varchar(200) not null,
size bigint not null default '0',
upload_time int default '0',
no_of_dwnld int  default '0',
expire_time int default '0',
max_dwnld int default '0',
link_status tinyint default '1',
recipient varchar(50) not null,
sender varchar(50),
primary key(id)
)");
$db->query("create table ".$db['prefix']."configuration (
conf_id int not null auto_increment,
conf_name varchar(20) not null,
conf_value text,
conf_optional varchar(250),
primary key(conf_id)
)");
$db->query("create table ".$db['prefix']."admin(
uid int not null auto_increment,
uname varchar(15) not null unique,
pwd varchar(32) not null,
email varchar(50) not null,
primary key(uid)
)");
$db->query("create table ".$db['prefix']."adminlog(
uid int(11) not null,
timein int(11) not null,
timeout int(11) default null,
ip varchar(16) default null)");
$db->query("
insert into ".$db['prefix']."configuration(conf_id,conf_name,conf_value,conf_optional) values(1,'MAX_SIZE','1024','1 MB')
,(2,'MIME_TYPES','image/jpeg,image/pjpeg,application/x-gzip-compressed','')
,(3,'MAX_COUNT','5','a limited number of')
,(4,'MAX_TIME','7','7 Days')
,(5,'AUTO_FILE_DELETE','Yes','')
,(6,'DAILY_TRANSFER','0','29-04-2005')");
$db->query("INSERT INTO ".$db['prefix']."admin(uid,uname,pwd,email) VALUES ('1', '".ADMIN_INSTALL_USERNAME."', '".md5('admin')."', 'admin@admin.com')");
                         echo('Installation is complete, Your admin login details are User: admin Password: admin, you can change it via your admin control panel. Please delete this installation file.');
                       }
                       ?>
                        </div>
                    </div>
                </td>
              </tr>
            </table>
          </div></td>
        </tr>

      </table>
      <p>&nbsp;</p>
    </div></td>
  </tr>
  <tr>
    <td>
      <table width="100%" border="0">
  <tr>
    <td><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><a href="index.php">Home</a>        | <a href="mailto:admin@popscript.com">Contact</a> |
          <a href="http://www.popscript.com">&copy; 2005
            PopScript.com All Rights Reserved.</a></font></div></td>

  </tr>
</table>
    </td>
  </tr>
</table>
</body>
</html>
