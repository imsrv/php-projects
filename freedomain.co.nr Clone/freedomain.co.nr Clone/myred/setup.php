<?php
#### Name of this file: setup.php 
#### Does the initial installation of milliscripts redirection 1.4

include("include/vars.php");
require("include/functions.php");

// first check what do do
$do = $_GET["do"];

// If no "do" is specified, go to the main page
if (!$do) {
	$do = "one";
	}

#################################
#### The fourth and last setup page   ####
#################################
if ($do == 'four') {
// Get all the variables
$con_adminusername = $_POST["con_adminusername"];
$con_adminpass1 = $_POST["con_adminpass1"];
$con_adminpass2 = $_POST["con_adminpass2"];
$con_startpage = $_POST["con_startpage"];
$con_pagetitle = $_POST["con_pagetitle"];
$con_adminmail = $_POST["con_adminmail"];
$con_domainip = $_POST["con_domainip"];
$con_maindomain = $_POST["con_maindomain"];
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
if (empty($con_adminusername)) {
	$error1 = "<font size=\"1\" color=\"red\">Username is missing</font>";
	}
if (!$con_adminpass1) {
	$error2 = "<font size=\"1\" color=\"red\">Password is missing</font>";
	}
if (!$con_adminpass2) {
	$error2a = "<font size=\"1\" color=\"red\">Password is missing</font>";
	}
if(ereg("[^a-zA-Z0-9]",$con_adminpass1)) {
	$error2 = "<font size=\"1\" color=\"red\">Invalid caracters</font>";
	}
if(ereg("[^a-zA-Z0-9]",$con_adminpass2)) {
	$error2a = "<font size=\"1\" color=\"red\">Invalid caracters</font>";
	}
if ($con_adminpass1 != $con_adminpass2) {
	$error2a = "<font size=\"1\" color=\"red\">Passwords must be equal</font>";
	}
if (empty($con_startpage)) {
	$error3 = "<font size=\"1\" color=\"red\">Real startpage is missing</font>";
	}
if (empty($con_pagetitle)) {
	$error4 = "<font size=\"1\" color=\"red\">Title is missing</font>";
	}
if(!$con_adminmail || !verify_email($con_adminmail)) {
	$error5 = "<font size=\"1\" color=\"red\">Invalid emailaddress</font>";
	}
if (empty($con_maindomain)) {
	$error6 = "<font size=\"1\" color=\"red\">Main domain name is missing</font>";
	}
if (!is_numeric($con_minlength) || !is_numeric($con_maxlength) || empty($con_minlength) || empty($con_maxlength) || ($con_maxlength-$con_minlength) < 1) {
	$error7 = "<font size=\"1\" color=\"red\">Invalid values</font>";
	}
if (empty($con_reserved)) {
	$error8 = "<font size=\"1\" color=\"red\">This value must not be empty</font>";
	}
if (empty($con_forbidden)) {
	$error9 = "<font size=\"1\" color=\"red\">This value must not be empty</font>";
	}
if ($error1 || $error2  || $error2a || $error3 || $error4 || $error5 || $error6  || $error7  || $error8  || $error9) {
	$do = "three";
}
// If no error occured, lets write the data into the database
else {
$con_adminpass1 = md5($con_adminpass1);
mysql_connect("$mysql_host","$mysql_username","$mysql_passwd") or die (mysql_error()); 
mysql_select_db("$mysql_dbase") or die (mysql_error());
mysql_query("INSERT INTO $options_table (home, sitetitle, adminemail, username, password, domainip, maindomain, mailtoadmin, language, multiple, minlength, maxlength, reserved, forbidden, autoappr, theme, release) VALUES ('$con_startpage', '$con_pagetitle', '$con_adminmail', '$con_adminusername', '$con_adminpass1', '$con_domainip', '$con_maindomain', '$con_mailtoadmin', '$con_language', '$con_multiple', '$con_minlength', '$con_maxlength', '$con_reserved', '$con_forbidden', '$con_autoappr', '$con_theme', '1.4')") or die (mysql_error());

// Show a success page
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>
<head>
<title>milliscripts Redirection 1.4 Setup</title>
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
    <td> <b>milliscripts Redirection 1.4 setup - step 4</b></td>
  </tr>
  <tr> 
    <td> 
      <p>&nbsp;</p>
      <p><b>Setup finished!</b></p>
      <p>Setup has been finished successfully.<br>
        Things you should do now:</p>
      <ul>
        <li><b>Delete &quot;setup.php&quot; (this file) and &quot;upgrade.php&quot;</b></li>
        <li>Log into the admin area (admin.php)</li>
        <li>Add domains to your service (otherwise your users can't register)</li>
        <li>Add categories (same as above)</li>
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
#### The third setup page      ####
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
<title>milliscripts Redirection 1.4 Setup</title>
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
    <td> <b>milliscripts Redirection 1.4 setup - step 3</b></td>
  </tr>
  <tr> 
    <td> 
      <p>&nbsp;</p>
      The scripts need to know a few values...<br>
      Click on &quot;continue&quot; when you are finished.</td>
  </tr>
</table>
<br>
<form method="post" action="setup.php?do=four">
  <table width="60%" border="0" align="center">
    <tr> 
      <td width="23%" bgcolor="#D1DDFC">Administrator Username:</td>
      <td width="59%" bgcolor="#D1DDFC"> 
        <input type="text" name="con_adminusername" size="35" maxlength="50" value="<?php echo $con_adminusername; ?>">
      </td>
      <td width="18%"><?php echo $error1; ?></td>
    </tr>
    <tr> 
      <td width="23%">&nbsp;</td>
      <td width="59%"><font size="1" color="#FF0000">Important: the administrator 
        username cannot be changed later on!</font></td>
      <td width="18%">&nbsp;</td>
    </tr>
    <tr> 
      <td width="23%">&nbsp;</td>
      <td width="59%">&nbsp;</td>
      <td width="18%">&nbsp;</td>
    </tr>
    <tr> 
      <td width="23%" bgcolor="#D1DDFC">Administrator Password:</td>
      <td width="59%" bgcolor="#D1DDFC"> 
        <input type="password" name="con_adminpass1" size="35" maxlength="35" value="<?php echo $con_adminpass1; ?>">
      </td>
      <td width="18%"><?php echo $error2; ?></td>
    </tr>
    <tr> 
      <td width="23%" bgcolor="#D1DDFC">Password again:</td>
      <td width="59%" bgcolor="#D1DDFC"> 
        <input type="password" name="con_adminpass2" size="35" maxlength="35" value="<?php echo $con_adminpass2; ?>">
      </td>
      <td width="18%"><?php echo $error2a; ?></td>
    </tr>
    <tr> 
      <td width="23%">&nbsp;</td>
      <td width="59%">&nbsp;</td>
      <td width="18%">&nbsp;</td>
    </tr>
    <tr> 
      <td width="23%" bgcolor="#E0E0E0">Your &quot;real&quot; startpage:</td>
      <td width="59%" bgcolor="#E0E0E0"> 
        <input type="text" name="con_startpage" size="35" maxlength="50" value="<?php echo $con_startpage; ?>">
      </td>
      <td width="18%"><?php echo $error3; ?></td>
    </tr>
    <tr> 
      <td width="23%">&nbsp;</td>
      <td width="59%"><font size="1">This is the page where visitors will be redirected, 
        if no user subdomain is found. Please specify only the file relative to 
        your webroot directory, for example: home.html or directory/home.html</font></td>
      <td width="18%">&nbsp;</td>
    </tr>
    <tr> 
      <td width="23%">&nbsp;</td>
      <td width="59%">&nbsp;</td>
      <td width="18%">&nbsp;</td>
    </tr>
    <tr> 
      <td width="23%" bgcolor="#E0E0E0">Your websites title:</td>
      <td width="59%" bgcolor="#E0E0E0"> 
        <input type="text" name="con_pagetitle" size="35" maxlength="150" value="<?php echo $con_pagetitle; ?>">
      </td>
      <td width="18%"><?php echo $error4; ?></td>
    </tr>
    <tr> 
      <td width="23%">&nbsp;</td>
      <td width="59%">&nbsp;</td>
      <td width="18%">&nbsp;</td>
    </tr>
    <tr> 
      <td width="23%" bgcolor="#E0E0E0">Emailaddress:</td>
      <td width="59%" bgcolor="#E0E0E0"> 
        <input type="text" name="con_adminmail" size="35" maxlength="50" value="<?php echo $con_adminmail; ?>">
      </td>
      <td width="18%"><?php echo $error5; ?></td>
    </tr>
    <tr> 
      <td width="23%">&nbsp;</td>
      <td width="59%"><font size="1">This is the address that is shown as &quot;sender 
        address&quot; within system emails and mass emails</font></td>
      <td width="18%">&nbsp;</td>
    </tr>
    <tr> 
      <td width="23%">&nbsp;</td>
      <td width="59%">&nbsp;</td>
      <td width="18%">&nbsp;</td>
    </tr>
    <tr> 
      <td width="23%" bgcolor="#E0E0E0">Domain ip:</td>
      <td width="59%" bgcolor="#E0E0E0"> 
        <input type="text" name="con_domainip" size="35" maxlength="15" value="<?php echo $con_domainip; ?>">
      </td>
      <td width="18%">&nbsp;</td>
    </tr>
    <tr> 
      <td width="23%">&nbsp;</td>
      <td width="59%"><font size="1">The ip address of your webserver - not necessary, 
        but maybe needed for future functions</font></td>
      <td width="18%">&nbsp;</td>
    </tr>
    <tr> 
      <td width="23%">&nbsp;</td>
      <td width="59%">&nbsp;</td>
      <td width="18%">&nbsp;</td>
    </tr>
    <tr> 
      <td width="23%" bgcolor="#E0E0E0">Main domain:</td>
      <td width="59%" bgcolor="#E0E0E0"> 
        <input type="text" name="con_maindomain" size="35" maxlength="50" value="<?php echo $con_maindomain; ?>">
      </td>
      <td width="18%"><?php echo $error6; ?></td>
    </tr>
    <tr> 
      <td width="23%">&nbsp;</td>
      <td width="59%"><font size="1">This is the domain name where your site runs 
        on. No &quot;http://www&quot;, just domain.com</font></td>
      <td width="18%">&nbsp;</td>
    </tr>
    <tr> 
      <td width="23%">&nbsp;</td>
      <td width="59%">&nbsp;</td>
      <td width="18%">&nbsp;</td>
    </tr>
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

###########################
#### The second setup page  ####
###########################
if ($do == 'two') {
mysql_connect("$mysql_host","$mysql_username","$mysql_passwd") or die (mysql_error()); 
mysql_select_db("$mysql_dbase") or die (mysql_error());

// Create the tables
mysql_query("CREATE TABLE $redir_table ( host varchar(100) NOT NULL default '', name varchar(25) NOT NULL default '', vname varchar(25) NOT NULL default '', passwd varchar(50) NOT NULL default '', email varchar(100) NOT NULL default '', url varchar(100) NOT NULL default '', title varchar(100) NOT NULL default '', descr text NOT NULL, keyw text NOT NULL, counter int(11) default NULL, robots varchar(50) NOT NULL default '', news char(3) NOT NULL default '', revisit text NOT NULL, time varchar(15) NOT NULL default '', ip varchar(20) NOT NULL default '', cat varchar(50) NOT NULL default '', lasttime varchar(15) NOT NULL default '', stats char(3) NOT NULL default '', mail char(3) NOT NULL default '', adtype varchar(15) NOT NULL default '', acticode varchar(15) NOT NULL default '', active char(3) NOT NULL default '', PRIMARY KEY (host), UNIQUE KEY host (host) )") or die (mysql_error()); 
mysql_query("CREATE TABLE $options_table ( home varchar(50) NOT NULL default '', sitetitle varchar(150) NOT NULL default '', adminemail varchar(50) NOT NULL default '', username varchar(50) NOT NULL default '', password varchar(50) NOT NULL default '', domainip varchar(15) NOT NULL default '', maindomain varchar(50) NOT NULL default '', mailtoadmin char(3) NOT NULL default '', language varchar(20) NOT NULL default '', multiple char(3) NOT NULL default '', minlength char(2) NOT NULL default '', maxlength char(2) NOT NULL default '', reserved text NOT NULL, forbidden text NOT NULL, autoappr char(3) NOT NULL default '', theme varchar(50) NOT NULL default '', release varchar(10) NOT NULL default '' )") or die (mysql_error());
mysql_query("CREATE TABLE $domain_table ( domain varchar(50) NOT NULL default '' )") or die (mysql_error());
mysql_query("CREATE TABLE $category_table ( category varchar(50) NOT NULL default '', advtype varchar(20) NOT NULL default '', adurl varchar(150) NOT NULL default '', height varchar(4) NOT NULL default '', width varchar(4) NOT NULL default '' )") or die (mysql_error());
mysql_query("CREATE TABLE $visitor_table ( host varchar(100) NOT NULL default '', date varchar(15) NOT NULL default '', ip varchar(20) NOT NULL default '', agent varchar(250) NOT NULL default '', ref varchar(250) NOT NULL default '', timestamp varchar(15) NOT NULL default '' )") or die (mysql_error());

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>
<head>
<title>milliscripts Redirection 1.4 Setup</title>
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
        <b>milliscripts Redirection 1.4 setup - step 2</b>
    </td>
  </tr>
  <tr>
      <td>
        <p>&nbsp;</p>
        ...mySQL connection established and database found!<br>
        ...all database tables created!<br><br>
        Click on "continue" below.
      </td>
  </tr>
      <tr>
      <td>
        <p>&nbsp;</p>
        <a href="setup.php?do=three">continue</a>
      </td>
  </tr>
</table>
</body>
</html>
<?php
}

###########################
#### The first setup page    ####
###########################
if ($do == 'one') {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>
<head>
<title>milliscripts Redirection 1.4 Setup</title>
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
        <b>Welcome to the milliscripts Redirection 1.4 setup!</b>
    </td>
  </tr>
  <tr>
      <td>
        <p>&nbsp;</p>
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
        <a href="setup.php?do=two">continue</a>
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