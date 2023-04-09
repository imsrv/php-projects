<?php
#### Name of this file: upgrade.php 
#### Does the upgrade from release 1.2 to 1.4

include("include/vars.php");
require("include/functions.php");

// first check what do do
$do = $_GET["do"];

// If no "do" is specified, go to the main page
if (!$do) {
	$do = "one";
	}

###################################
#### The fourth and last upgrade page   ####
###################################
if ($do == 'four') {
// Get all the variables
$con_language = $_POST["con_language"];
$con_multiple = $_POST["con_multiple"];
$con_minlength = $_POST["con_minlength"];
$con_maxlength = $_POST["con_maxlength"];
$con_autoappr = $_POST["con_autoappr"];
$con_mailtoadmin = $_POST["con_mailtoadmin"];
$con_theme = $_POST["con_theme"];
$con_reserved = $_POST["con_reserved"];
$con_forbidden = $_POST["con_forbidden"];

// And proof them - much work!
if (!is_numeric($con_minlength) || !is_numeric($con_maxlength) || empty($con_minlength) || empty($con_maxlength) || ($con_maxlength-$con_minlength) < 1) {
	$error7 = "<font size=\"1\" color=\"red\">Invalid values</font>";
	}
if (empty($con_reserved)) {
	$error8 = "<font size=\"1\" color=\"red\">This value must not be empty</font>";
	}
if (empty($con_forbidden)) {
	$error9 = "<font size=\"1\" color=\"red\">This value must not be empty</font>";
	}
if ($error7  || $error8  || $error9) {
	$do = "three";
}
// If no error occured, lets write the data into the database
else {
mysql_connect("$mysql_host","$mysql_username","$mysql_passwd") or die (mysql_error()); 
mysql_select_db("$mysql_dbase") or die (mysql_error());
mysql_query("UPDATE $options_table SET mailtoadmin='$con_mailtoadmin', language='$con_language', multiple='$con_multiple', minlength='$con_minlength', maxlength='$con_maxlength', reserved='$con_reserved', forbidden='$con_forbidden', autoappr='$con_autoappr', theme='$con_theme', release='1.4'") or die (mysql_error());

// Show a success page
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>
<head>
<title>milliscripts Redirection 1.4 Upgrade</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
A:link {
        COLOR: #18578e;TEXT-DECORATION: none
}
A:visited {
        COLOR: #777777; TEXT-DECORATION: none
}
A:active {
        COLOR: #000000
}
A:hover {
        COLOR: #000000;TEXT-DECORATION: underline overline
}
BODY {
        BACKGROUND-COLOR: #eeeeee
}
input,textarea,select,option{
        FONT-FAMILY:Verdana,Arial,Helvetica;FONT-SIZE:8pt;COLOR:#2B1F6A;BORDER:1px solid black
}
select{
        FONT-FAMILY:Verdana,Arial,Helvetica;FONT-SIZE:8pt;COLOR:#2B1F6A;BORDER:1px solid black
}
form{
        FONT-FAMILY:Verdana,Arial,Helvetica;FONT-SIZE:8pt;COLOR:#000000
}
TD {
        FONT-SIZE: 8pt; COLOR: #000000; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif
}

</style>
</head>

<body>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  
<table width="40%" border="0" align="center">
  <tr> 
    <td> <b>milliscripts Redirection 1.4 upgrade - step 4</b></td>
  </tr>
  <tr> 
    <td> 
      <p>&nbsp;</p>
      <p><b>Upgrade finished!</b></p>
      <p>Upgrade has been finished successfully.<br>
        Things you must do now:</p>
      <ul>
        <li><b>Delete &quot;setup.php&quot; and &quot;upgrade.php&quot; (this file)</b></li>
        <li>Log into the admin area (admin.php)</li>
        <li>Edit the categories ad scheme (<b>otherwise redirection does not work</b>)</li>
        <li>Optional: delete the no longer used advertising tables (in the old &quot;vars.php&quot; they were called: $advertiser_table, $adverts_table, $adclicks_table, $adviews_table)</li>
      </ul>
      <p><font color="#009900">Afterwards your service is ready to run!</font></p>
    </td>
  </tr>
</table>
</body>
</html>
<?php
}
}

###########################
#### The third upgrade page  ####
###########################
if ($do == 'three') {
// Get the available languages
$handle = opendir("language");
while ($file = readdir($handle)) {
	if (!(($file==".") || ($file==".."))) {
		$lang_listbox .= "<option value=\"$file\"";
		if ($file == $language) {
			$lang_listbox .= " selected";
			}
		$file1 = str_replace(".php", "", $file);
		$lang_listbox .= ">$file1</option>";
		 }
	}
closedir($handle);

// Get the available themes
$handle = opendir("html");
while ($file = readdir($handle)) {
	if (!(($file==".") || ($file==".."))) {
		$theme_listbox .= "<option value=\"$file\"";
		if ($file == $theme) {
			$theme_listbox .= " selected";
			}
		$theme_listbox .= ">$file</option>";
		 }
	}
closedir($handle);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>
<head>
<title>milliscripts Redirection 1.4 Upgrade</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
A:link {
        COLOR: #18578e;TEXT-DECORATION: none
}
A:visited {
        COLOR: #777777; TEXT-DECORATION: none
}
A:active {
        COLOR: #000000
}
A:hover {
        COLOR: #000000;TEXT-DECORATION: underline overline
}
BODY {
        BACKGROUND-COLOR: #eeeeee
}
input,textarea,select,option{
        FONT-FAMILY:Verdana,Arial,Helvetica;FONT-SIZE:8pt;COLOR:#2B1F6A;BORDER:1px solid black
}
select{
        FONT-FAMILY:Verdana,Arial,Helvetica;FONT-SIZE:8pt;COLOR:#2B1F6A;BORDER:1px solid black
}
form{
        FONT-FAMILY:Verdana,Arial,Helvetica;FONT-SIZE:8pt;COLOR:#000000
}
TD {
        FONT-SIZE: 8pt; COLOR: #000000; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif
}

</style>
</head>

<body>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  
<table width="40%" border="0" align="center">
  <tr> 
    <td> <b>milliscripts Redirection 1.4 upgrade - step 3</b></td>
  </tr>
  <tr> 
    <td> 
      <p>&nbsp;</p>
      Because of some options have changed since the last release, the scripts need to know a few values...<br>
      Click on &quot;continue&quot; when you are finished.</td>
  </tr>
</table>
<br>
<form method="post" action="upgrade.php?do=four">
  <table width="60%" border="0" align="center">
    <tr> 
      <td width="23%" bgcolor="#E0E0E0">Language:</td>
      <td width="59%" bgcolor="#E0E0E0"> 
        <select name="con_language">
          <?php echo $lang_listbox; ?>
        </select>
      </td>
      <td width="18%">&nbsp;</td>
    </tr>
    <tr> 
      <td width="23%">&nbsp;</td>
      <td width="59%"><font size="1">In which language shall your redirection 
        site run? All available languages are listed</font></td>
      <td width="18%">&nbsp;</td>
    </tr>
    <tr> 
      <td width="23%">&nbsp;</td>
      <td width="59%">&nbsp;</td>
      <td width="18%">&nbsp;</td>
    </tr>
    <tr> 
      <td width="23%" bgcolor="#E0E0E0">Allow multiple:</td>
      <td width="59%" bgcolor="#E0E0E0"> 
        <select name="con_multiple">
          <option value="on">on</option>
          <option value="off" selected>off</option>
        </select>
      </td>
      <td width="18%">&nbsp;</td>
    </tr>
    <tr> 
      <td width="23%">&nbsp;</td>
      <td width="59%"><font size="1">Do you allow multiple registraions with the 
        same email address? Set to &quot;on&quot; means &quot;yes&quot;</font></td>
      <td width="18%">&nbsp;</td>
    </tr>
    <tr> 
      <td width="23%">&nbsp;</td>
      <td width="59%">&nbsp;</td>
      <td width="18%">&nbsp;</td>
    </tr>
    <tr> 
      <td width="23%" bgcolor="#E0E0E0">Subdomainlength:</td>
      <td width="59%" bgcolor="#E0E0E0">minimum 
        <input type="text" name="con_minlength" size="2" maxlength="2" value="<?php echo $con_minlength; ?>">
        , maximum 
        <input type="text" name="con_maxlength" size="2" maxlength="2" value="<?php echo $con_maxlength; ?>">
        characters</td>
      <td width="18%"><?php echo $error7; ?></td>
    </tr>
    <tr> 
      <td width="23%">&nbsp;</td>
      <td width="59%">&nbsp;</td>
      <td width="18%">&nbsp;</td>
    </tr>
    <tr> 
      <td width="23%" bgcolor="#E0E0E0">Autoapprove:</td>
      <td width="59%" bgcolor="#E0E0E0"> 
        <select name="con_autoappr">
          <option value="on" selected>on</option>
          <option value="off">off</option>
        </select>
      </td>
      <td width="18%">&nbsp;</td>
    </tr>
    <tr> 
      <td width="23%">&nbsp;</td>
      <td width="59%"><font size="1">Do you want new members to be automatically 
        approved? Set to &quot;on&quot; means &quot;yes&quot;, set to &quot;off&quot; 
        means, that you manually have to approve new members</font></td>
      <td width="18%">&nbsp;</td>
    </tr>
    <tr> 
      <td width="23%">&nbsp;</td>
      <td width="59%">&nbsp;</td>
      <td width="18%">&nbsp;</td>
    </tr>
    <tr> 
      <td width="23%" bgcolor="#E0E0E0">Mail to Admin:</td>
      <td width="59%" bgcolor="#E0E0E0"> 
        <select name="con_mailtoadmin">
          <option value="on" selected>on</option>
          <option value="off">off</option>
        </select>
      </td>
      <td width="18%">&nbsp;</td>
    </tr>
    <tr> 
      <td width="23%">&nbsp;</td>
      <td width="59%"><font size="1">Do you want to receive an email everytime 
        a new member registers? You could turn it to &quot;on&quot; in case you 
        chose to manually approve every new member</font></td>
      <td width="18%">&nbsp;</td>
    </tr>
    <tr> 
      <td width="23%">&nbsp;</td>
      <td width="59%">&nbsp;</td>
      <td width="18%">&nbsp;</td>
    </tr>
    <tr> 
      <td width="23%" bgcolor="#E0E0E0">Website Theme:</td>
      <td width="59%" bgcolor="#E0E0E0"> 
        <select name="con_theme">
          <?php echo $theme_listbox; ?>
        </select>
      </td>
      <td width="18%">&nbsp;</td>
    </tr>
    <tr> 
      <td width="23%">&nbsp;</td>
      <td width="59%"><font size="1">All milliscripts Redirection pages appear in 
        the theme you choose here</font></td>
      <td width="18%">&nbsp;</td>
    </tr>
    <tr> 
      <td width="23%">&nbsp;</td>
      <td width="59%">&nbsp;</td>
      <td width="18%">&nbsp;</td>
    </tr>
    <tr> 
      <td width="23%" bgcolor="#E0E0E0">Reserved Words:</td>
      <td width="59%" bgcolor="#E0E0E0"> 
        <input type="text" name="con_reserved" size="40" value="admin--www--nic">
      </td>
      <td width="18%"><?php echo $error8; ?></td>
    </tr>
    <tr> 
      <td width="23%">&nbsp;</td>
      <td width="59%"><font size="1">These are certain words which can't be registered 
        as a subdomain. Fill in any words you want separated by &quot;--&quot;, 
        for example: admin--www--nic</font></td>
      <td width="18%">&nbsp;</td>
    </tr>
    <tr> 
      <td width="23%">&nbsp;</td>
      <td width="59%">&nbsp;</td>
      <td width="18%">&nbsp;</td>
    </tr>
    <tr>
      <td width="23%">Forbidden Words:</td>
      <td width="59%">
        <input type="text" name="con_forbidden" size="40" value="hackz--crackz--appz--warez--hardcore--hitler--nazi--fuck">
      </td>
      <td width="18%"><?php echo $error9; ?></td>
    </tr>
    <tr> 
      <td width="23%">&nbsp;</td>
      <td width="59%"><font size="1">These are words which the users homepage 
        <b>must not</b> contain. Fill in any words you want separated by &quot;--&quot;, 
        for example: hackz--warez </font></td>
      <td width="18%">&nbsp;</td>
    </tr>
    <tr> 
      <td width="23%">&nbsp;</td>
      <td width="59%">&nbsp;</td>
      <td width="18%">&nbsp;</td>
    </tr>
    <tr> 
      <td width="23%"> 
        <p>&nbsp;</p>
      </td>
      <td width="59%">
        <input type="submit" name="submit" value="continue">
      </td>
      <td width="18%">&nbsp;</td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
}

#############################
#### The second upgrade page  ####
#############################
if ($do == 'two') {
mysql_connect("$mysql_host","$mysql_username","$mysql_passwd") or die (mysql_error()); 
mysql_select_db("$mysql_dbase") or die (mysql_error());

// Alter the exisiting tables
// Let's start with $redir_table
mysql_query("ALTER TABLE $redir_table CHANGE `passwd` `passwd` VARCHAR(50) NOT NULL") or die (mysql_error());
mysql_query("ALTER TABLE $redir_table ADD `stats` CHAR(3) NOT NULL, ADD `mail` CHAR(3) NOT NULL, ADD `adtype` VARCHAR(15) NOT NULL, ADD `acticode` VARCHAR(15) NOT NULL, ADD `active` VARCHAR(3) NOT NULL") or die (mysql_error());
// Alter $options_table
mysql_query("ALTER TABLE $options_table CHANGE `username` `username` VARCHAR(50) NOT NULL") or die (mysql_error());
mysql_query("ALTER TABLE $options_table CHANGE `password` `password` VARCHAR(50) NOT NULL") or die (mysql_error());
mysql_query("ALTER TABLE $options_table CHANGE `ads` `mailtoadmin` CHAR(3) NOT NULL") or die (mysql_error());
mysql_query("ALTER TABLE $options_table DROP `standardad") or die (mysql_error());
mysql_query("ALTER TABLE $options_table ADD `language` VARCHAR(20) NOT NULL, ADD `multiple` CHAR(3) NOT NULL, ADD `minlength` CHAR(2) NOT NULL, ADD `maxlength` CHAR(2) NOT NULL, ADD `reserved` TEXT NOT NULL, ADD `forbidden` TEXT NOT NULL, ADD `autoappr` CHAR(3) NOT NULL, ADD `theme` VARCHAR(50) NOT NULL, ADD `release` VARCHAR(10) NOT NULL") or die (mysql_error());
// Alter $category_table
mysql_query("ALTER TABLE `categories` ADD `advtype` VARCHAR(20) NOT NULL, ADD `adurl` VARCHAR(150) NOT NULL, ADD `height` VARCHAR(4) NOT NULL, ADD `width` VARCHAR(4) NOT NULL") or die (mysql_error());

// Create new table $visitor_table
mysql_query("CREATE TABLE $visitor_table ( host varchar(100) NOT NULL default '', date varchar(15) NOT NULL default '', ip varchar(20) NOT NULL default '', agent varchar(250) NOT NULL default '', ref varchar(250) NOT NULL default '', timestamp varchar(15) NOT NULL default '' )") or die (mysql_error());

// Change all members accounts to encrypted password and insert the standard data into the new fields of $redir_table
$passwd_change = mysql_query("SELECT * FROM $redir_table");
while($passwdarray = mysql_fetch_array($passwd_change)) {
	$old_passwd = $passwdarray[passwd];
	$new_passwd = md5($old_passwd);
	$host = $passwdarray[host];
	mysql_query("UPDATE $redir_table SET passwd='$new_passwd', stats='off', mail='off', adtype='on', active='on' WHERE host='$host'") or die (mysql_error());
}
// Change admin password to encrypted
$admin_pass = mysql_fetch_array(mysql_query("SELECT password FROM $options_table"));
$old_adminpass = $admin_pass[0];
$new_adminpass = md5($old_adminpass);
mysql_query("UPDATE $options_table SET password='$new_adminpass'") or die (mysql_error());

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>
<head>
<title>milliscripts Redirection 1.4 Upgrade</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
A:link {
        COLOR: #18578e;TEXT-DECORATION: none
}
A:visited {
        COLOR: #777777; TEXT-DECORATION: none
}
A:active {
        COLOR: #000000
}
A:hover {
        COLOR: #000000;TEXT-DECORATION: underline overline
}
BODY {
        BACKGROUND-COLOR: #eeeeee
}
input,textarea,select,option{
        FONT-FAMILY:Verdana,Arial,Helvetica;FONT-SIZE:8pt;COLOR:#2B1F6A;BORDER:1px solid black
}
select{
        FONT-FAMILY:Verdana,Arial,Helvetica;FONT-SIZE:8pt;COLOR:#2B1F6A;BORDER:1px solid black
}
form{
        FONT-FAMILY:Verdana,Arial,Helvetica;FONT-SIZE:8pt;COLOR:#000000
}
TD {
        FONT-SIZE: 8pt; COLOR: #000000; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif
}

</style>
</head>

<body>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <table width="40%" border="0" align="center">
  <tr>
    <td>
        <b>milliscripts Redirection 1.4 upgrade - step 2</b>
    </td>
  </tr>
  <tr>
      <td>
        <p>&nbsp;</p>
        ...mySQL connection established and database found!<br>
        ...all existing database tables updated!<br>
        ...all new tables created!<br>
        ...all member accounts updated!<br><br>
        Click on "continue" below.
      </td>
  </tr>
      <tr>
      <td>
        <p>&nbsp;</p>
        <a href="upgrade.php?do=three">continue</a>
      </td>
  </tr>
</table>
</body>
</html>
<?php
}

###########################
#### The first upgrade page   ####
###########################
if ($do == 'one') {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>
<head>
<title>milliscripts Redirection 1.4 Upgrade</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
A:link {
        COLOR: #18578e;TEXT-DECORATION: none
}
A:visited {
        COLOR: #777777; TEXT-DECORATION: none
}
A:active {
        COLOR: #000000
}
A:hover {
        COLOR: #000000;TEXT-DECORATION: underline overline
}
BODY {
        BACKGROUND-COLOR: #eeeeee
}
input,textarea,select,option{
        FONT-FAMILY:Verdana,Arial,Helvetica;FONT-SIZE:8pt;COLOR:#2B1F6A;BORDER:1px solid black
}
select{
        FONT-FAMILY:Verdana,Arial,Helvetica;FONT-SIZE:8pt;COLOR:#2B1F6A;BORDER:1px solid black
}
form{
        FONT-FAMILY:Verdana,Arial,Helvetica;FONT-SIZE:8pt;COLOR:#000000
}
TD {
        FONT-SIZE: 8pt; COLOR: #000000; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif
}

</style>
</head>

<body>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <table width="40%" border="0" align="center">
  <tr>
    <td>
        <b>Welcome to the milliscripts Redirection 1.4 upgrade!</b>
    </td>
  </tr>
  <tr>
      <td>
        <p>&nbsp;</p>
        You are about to upgrade your current installation of milliscripts Redirection from release 1.2 to release 1.4<br><br>
        <b>Be sure to make a backup of your mySQL database before.<br>
        Upgrading your installation without making a backup of your database is not recommended!</b><br><br>
        The shown values are the ones you edited in the file "vars.php".<br>
        If they are not correct, please edit the variables in "vars.php" and call this page again.<br>
        Else click on "continue" below.
      </td>
  </tr>
    <tr>
      <td>
        <p>&nbsp;</p>
        <b><font color="#FF5F00">mySQL Server data</font></b><br><br>
        mySQL server host address: <b><?php echo $mysql_host; ?></b><br>
        Your mySQL username: <b><?php echo $mysql_username; ?></b><br>
        Your mySQL password: <b><?php echo $mysql_passwd; ?></b><br>
        mySQL database name: <b><?php echo $mysql_dbase; ?></b><br>
      </td>
  </tr>
    <tr>
      <td>
        <p>&nbsp;</p>
        <b><font color="#00CC66">Table names</font></b><br><br>
        The name of the members table: <b><?php echo $redir_table; ?></b><br>
        The name of the options table: <b><?php echo $options_table; ?></b><br>
        The name of the domain table: <b><?php echo $domain_table; ?></b><br>
        The name of the category table: <b><?php echo $category_table; ?></b><br>
        The name of the statistics table: <b><?php echo $visitor_table; ?></b><br>
      </td>
  </tr>
      <tr>
      <td>
        <p>&nbsp;</p>
        <a href="upgrade.php?do=two">continue</a>
      </td>
  </tr>
</table>
<p>
 <a href="http://validator.w3.org/check/referer"><img border="0" src="http://www.w3.org/Icons/valid-html40" alt="Valid HTML 4.0!" height="31" width="88"></a>
</p>
</body>
</html>
<?php
}
?>