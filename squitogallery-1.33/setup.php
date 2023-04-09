<?php
/*
    
	Squito Gallery 1.33
    Copyright (C) 2002-2003  SquitoSoft and Tim Stauffer

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
*/
session_start();
clearstatcache();
if(is_writeable(dirname($_SERVER['DOCUMENT_ROOT'].$_SERVER['PHP_SELF'])))
{
if(isset($_POST['subAccept']))
{
$_SESSION['accept'] =1;
}
include('dbfns.inc.php');
if(!isset($_SESSION['language']))
{
$_SESSION['language'] = 'english';
}
if(!isset($_SESSION['lastpage']))
{
$_SESSION['lastpage'] = $REQUEST_URI;

}
if(isset($_POST['form_language']))
$_SESSION['language'] = $_POST['form_language'];
include('lang/'.$_SESSION['language'].'.inc.php');
$_SESSION['lastpage']=$REQUEST_URI;
$photoroot = $_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/';

if(isset($_POST['joinList']))
{
        if($_POST['form_email'])
        header('Location: http://squitosoft.angrymosquito.com/notify.php?form_email='.$_POST['form_email'].'&Submit=1');
}
if(isset($_POST['Submit']))
{
$db_host = $_POST['form_db_host'];
$db_user = $_POST['form_db_user'];
$db_pass = $_POST['form_db_pass'];
$database = $_POST['form_database'];


$configFile = @fopen('config.inc.php', 'w');
fputs($configFile, '<?php');
fputs($configFile, "\n");
fputs($configFile, '$mainfilename = "'.$form_mainfilename.'";', strlen('<?php $mainfilename = "'.$form_mainfilename.'";'));
fputs($configFile, "\n");
fputs($configFile, '$webimageroot = "'.dirname($_SERVER['PHP_SELF']).'";', strlen('<?php $webimageroot = "'.dirname($_SERVER['PHP_SELF']).'";'));
fputs($configFile, "\n");
fputs($configFile, '$photoroot = "'.$_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/";', strlen('$photoroot = "'.$_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/";'));
fputs($configFile, "\n");
fputs($configFile, '$usedatabase = '.$_POST['form_usedatabase'].';', strlen('$usedatabase = '.$_POST['form_usedatabase'].';'));
fputs($configFile, "\n");
if($_POST['form_usedatabase'])
{
$db = dbConnect();
$file = fopen('gallery.sql','r');
$odump=fread($file,filesize('gallery.sql'));
$dump = explode(';',$odump);
foreach ($dump as $line) {
mysql_query($line,$db);
}
$query = 'insert into access (user_id,dir_id,r,u,d,e) values (1,1,1,1,1,1)';
mysql_query($query,$db);

$query = 'insert into access (user_id,dir_id,r,u,d,e) values (0,1,1,1,0,0)';
mysql_query($query,$db);

$query = "insert into authorization (name, password, access_level) values ('".$_POST['form_admin_name']."',Password('".$_POST['form_admin_pass']."'),200)";
mysql_query($query, $db);
$query = 'insert into photodir (name,anonymous_uploads,icon) values ("Useruploads","1","dir.gif")';
mysql_query($query,$db);
mysql_close();
fputs($configFile, '$db_host = "'.$_POST['form_db_host'].'";', strlen('$db_host = "'.$_POST['form_db_host'].'";'));
fputs($configFile, "\n");
fputs($configFile, '$db_user = "'.$_POST['form_db_user'].'";', strlen('$db_user = "'.$_POST['form_db_user'].'";'));
fputs($configFile, "\n");
fputs($configFile, '$db_pass = "'.$_POST['form_db_pass'].'";', strlen('$db_pass = "'.$_POST['form_db_pass'].'";'));
fputs($configFile, "\n");
fputs($configFile, '$database = "'.$_POST['form_database'].'";', strlen('$database = "'.$_POST['form_database'].'";'));
}
switch($_POST['form_graphics'])
{
case '1':
fputs($configFile, "\n");
fputs($configFile, '$useimagemagick = "1";', strlen('$useimagemagick = "1";'));
fputs($configFile, "\n");
fputs($configFile, '$imagemagickpath = "'.$_POST['form_imagemagickpath'].'";', strlen('$imagemagickpath = "'.$_POST['form_imagemagickpath'].'";'));
fputs($configFile, "\n");
fputs($configFile, '$thumbsize = "'.$_POST['form_thumbsize'].'";', strlen('$thumbsize = "'.$_POST['form_thumbsize'].'";'));
fputs($configFile, "\n");

break;
case '2':
fputs($configFile, "\n");
fputs($configFile, '$usegd184 = "1";', strlen('$usegd184 = "1";'));
fputs($configFile, "\n");
fputs($configFile, '$thumbsize = "'.$_POST['form_thumbsize'].'";', strlen('$thumbsize = "'.$_POST['form_thumbsize'].'";'));
fputs($configFile, "\n");
break;
case '3':
fputs($configFile, "\n");
fputs($configFile, '$usegd201 = "1";', strlen('$usegd201 = "1";'));
fputs($configFile, "\n");
fputs($configFile, '$thumbsize = "'.$_POST['form_thumbsize'].'";', strlen('$thumbsize = "'.$_POST['form_thumbsize'].'";'));
fputs($configFile, "\n");
break;
default:

}
fputs($configFile, '$images = "images/";'."\n");
fputs($configFile, '$thumbnails = "thumbnails/";'."\n");
fputs($configFile, '$homeURL = "'.$_POST['form_homeURL'].'";'."\n");
fputs($configFile, '$site_name = "'.$_POST['form_title'].'";'."\n");
fputs($configFile, '$os = "'.$_POST['form_os'].'";'."\n");

fputs($configFile, "\n?>");
fclose($configFile);
if(!file_exists('images'))
mkdir('images',0777);
if(!file_exists('thumbnails'))
mkdir('thumbnails',0777);
if(!file_exists('icons'))
mkdir('icons',0777);
//chdir($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/')
if(file_exists($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/dir.gif'))
copy($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/dir.gif', $_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/icons/dir.gif');
if(file_exists($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/dir2.gif'))
copy($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/dir2.gif', $_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/icons/dir2.gif');
if(file_exists($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/dir3.gif'))
copy($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/dir3.gif', $_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/icons/dir3.gif');
if(!file_exists('profiles'))
mkdir('profiles',0777);
if(!file_exists('images/Useruploads'))
{
mkdir('images/Useruploads',0777);
mkdir('thumbnails/Useruploads',0777);
}
}

?>
<html>
<head>
<title>Squito Gallery <?php echo $version; ?> - Setup</title>
<style type="text/css">
<!--
.bgtable {  border: #000000 solid; border-width: 1px 3px 3px 1px}
body {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; color: #66666}

a {  font-family: Verdana, Arial, Helvetica, sans-serif; color: #009900; text-decoration: none; font-size: 11px }

a:hover {  text-decoration: underline }

td {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; color: #66666}
.sidebox {  border: 1px #000000 solid}
.imagebox {  border: 1px #000000 solid}

.sportsbg {  background-image: url(images/sports.jpg); background-repeat: no-repeat; background-position: left top}


INPUT, SELECT, TEXTAREA         {
 BACKGROUND-COLOR: #CCCCCC;
 BORDER-LEFT: #234D76 solid 1;
 BORDER-RIGHT: #234D76 solid 1;
 BORDER-TOP: #234D76 solid 1;
 BORDER-BOTTOM: #234D76 solid 1;
 COLOR: #000000;
 FONT-FAMILY: Verdana,Geneva,Arial,Helvetica,sans-serif;
 FONT-SIZE: 10px;
 }

-->
</style>
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table><tr><td align="center"><form name="language_form" ACTION="<?php echo $_SESSION['lastpage']; ?>" method="post"><select name="form_language" onChange="language_form.submit();"><option value="english">Choose Language</option><?php  echo "\n";
       $allfiles = read_in_dir($photoroot.'lang/','file');
       foreach($allfiles as $value)
       {
         $value = explode('.',$value);
         echo '<option value="'.$value[0].'">'.$value[0].'</option>'."\n";
       }
       ?>
       </select></form></td></tr></table>
<table width="100%" height="100%" cellspacing="0" cellpadding="10">
  <tr>
    <td bgcolor="#FFFFFF" colspan="3" height="33%"></td>
  </tr>
  <tr bgcolor="#DDDDDD">
    <td width="33%" height="1">&nbsp;</td>
    <td valign="top" width="33%" height="1">
      <p><img src="squito_lil.gif" border="0"><img src="squito text.gif" border="0"><br>
        <?php
if(!$_SESSION['accept'])
{
?>
    <form action="" method="post">
	<textarea cols="100" rows="20"><?php include($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/gpl.txt');?></textarea>
	<div align="center"><input type="submit" name="subAccept" value="Accept"><input type="submit" name="subDecline" value="Decline"></div>
	</form>
	
	</td>
    <td width="33%" height="1">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" colspan="3" height="33%" valign="top">
      <div align="center">
        <p>&copy; 2002 <a href="http://squitosoft.angrymosquito.com">Squitosoft
          </a><br>
          All Rights Reserved</p>
      </div>
    </td>
  </tr>
</table>
</body>
</html>

<?php
exit;
}

          if($_POST['Submit'])
          {
          ?>
        <br>
      </p>
      <p>&nbsp;</p>
      <p><?php echo $lang['Setup_Thank You']; ?> <br>
        <br>
      </p>
      <form name="form1" method="post" action="">
          <b><?php echo $lang['Setup_Enter your email address']; ?></b>
          <center>
          <p>
            <input type="text" name="form_email" size="100" maxlength="100">

            <input type="submit" name="joinList" value="Submit">
          </p>
        </center>
        </form>
                <?php echo $lang['Installation complete. click'];?> <a href="<?php echo dirname($_SERVER['PHP_SELF']).'/'; ?>"><?php echo $lang['here']; ?></a> <?php echo $lang['to test the script']; ?>

          <?php
          }
          else
          {
          ?>
          <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <p>Title of website:
          <input type="text" name="form_title" size="50" value="<?php echo 'Squito Gallery '.$version; ?>">
        </p>
        <p>Home URL:
          <input type="text" name="form_homeURL" size="50" value="<?php echo $_SERVER['SERVER_NAME']; ?>">
        </p>

        <p><?php echo $lang['Main filename for gallery']; ?>:
          <input type="text" name="form_mainfilename" value="index.php">
        </p>

          <input type="hidden" name="form_usedatabase" value="1">

        <p><?php echo $lang['Setup_Mysql require']; ?><br><hr color="#000000">
        <p><?php echo $lang['Setup_Database Hostname']; ?>:
          <input type="text" name="form_db_host" value="localhost">
          <br>
          <?php echo $lang['Setup_Database Username']; ?>:
          <input type="text" name="form_db_user">
          <br>
          <?php echo $lang['Setup_Database Password']; ?>:
          <input type="text" name="form_db_pass">
          <br>
          <?php echo $lang['Setup_Name of Database']; ?>:
          <input type="text" name="form_database">
        </p><hr> <p><?php if(isset($lang['What operating system is your server?'])) echo $lang['What operating system is your server?']; else echo'What operating system is your server?';?>
          <select name="form_os">
            <option value="0">Unix Clone</option>
            <option value="1">Windows Based</option>

          </select>



                <p><?php echo $lang['Setup_What graphics application are you using for thumbnail creation']; ?>:
          <select name="form_graphics">
            <option value="0"><?php echo $lang['None']; ?></option>
            <option value="1">Imagemagick 5.4.6+</option>
            <option value="2">GD 1.8.4</option>
            <option value="3">GD 2.0.1</option>
          </select>
          <br>
          <br>
          <?php echo $lang['Setup_Imagemagick']; ?>
          <input type="text" name="form_imagemagickpath" value="/usr/local/bin/">
          <br>
          ex. /usr/local/bin/ or c:\\imagemagick\\ under windows</p>
        <p><?php echo $lang['Thumbnail Dimensions']; ?>
          <select name="form_thumbsize">
            <option value="100">Default</option>
            <option value="50">50x50 pixels</option>
                        <option value="75">75x75 pixels</option>
                        <option value="100">100x100 pixels</option>
                        <option value="125">125x125 pixels</option>
                        <option value="150">150x150 pixels</option>
                        <option value="200">200x200 pixels</option>
          </select>
          <br><hr>
        <p><?php echo $lang['Administrator Username']; ?>
          <input type="text" name="form_admin_name">
                  <p><?php echo $lang['Administrator Password']; ?>
          <input type="password" name="form_admin_pass">
        <p align="center">

          <input type="submit" name="Submit" value="Submit">
        </p>
      </form>
          <?php
          }
          ?>
    </td>
    <td width="33%" height="1">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" colspan="3" height="33%" valign="top">
      <div align="center">
        <p>&copy; 2002 <a href="http://squitosoft.angrymosquito.com">Squitosoft
          </a><br>
          All Rights Reserved</p>
      </div>
    </td>
  </tr>
</table>
</body>
</html>
<?php
}
else
echo 'Make sure your file permission are set to 777 for this folder<br><b>note:</b> they will only need to be 777 for the installation process. Once finished you can change them back to what they were.';
?>