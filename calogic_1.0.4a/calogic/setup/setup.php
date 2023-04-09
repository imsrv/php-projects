<?php
include("../include/dbloader.php");
?>
<html>

<head>
<title>CaLogic Calendars Setup</title>

<SCRIPT ID=clientEventHandlersJS LANGUAGE=javascript>
<!--

function calgsetup_onsubmit() {
	calgsetup.siteowner.value = trim(calgsetup.siteowner.value);
	calgsetup.adminemail.value = trim(calgsetup.adminemail.value);
	calgsetup.baseurl.value = trim(calgsetup.baseurl.value);
    if(calgsetup.siteowner.value == "") {
        alert("You must enter a Site Owner Name!");
        return false;
    } 
    if(calgsetup.adminemail.value == "") {
        alert("You must enter an Admin Email!");
        return false;
    } 
    if(calgsetup.baseurl.value == "") {
        alert("You must enter base URL!");
        return false;
    } 
    if(calgsetup.allowopen.value == 0 && calgsetup.allowpublic.value == 0 && calgsetup.allowprivate.value == 0) {
        alert("At least one type of Calendar must be enabled!");
        return false;
    } 
    return true;
}

function gocalnow_onclick() {
<?php
if(isset($submitsetupnow)) {
    echo "location.href='".$fields["baseurl"].$fields["progdir"]."';";
}
?>
}

function trim(value) {
 startpos=0;
 while((value.charAt(startpos)==" ")&&(startpos<value.length)) {
   startpos++;
 }
 if(startpos==value.length) {
   value="";
 } else {
   value=value.substring(startpos,value.length);
   endpos=(value.length)-1;
   while(value.charAt(endpos)==" ") {
     endpos--;
   }
   value=value.substring(0,endpos+1);
 }
 return(value);
}

//-->
</SCRIPT>


</head>

<body background="<?php
    echo "../img/stonbk.jpg"; 
?>">

<h1>CaLogic Calendars - Setup</h1>

<?php

$servertzos = ((date("Z") / 60) / 60);

if($servertzos > 0) {
//    $servertzos = "+$tzpm";
    $servertzos = "+$servertzos";
} elseif($servertzos < 0) {
    $servertzos = "-$servertzos";
}


if(isset($submitsetupnow)) {
echo "Please wait while CaLogic sets up....<br><br>";
// Create tables
flush();
usleep(25);

#
# Table structure for table `".$tabpre."_setup`
#

$sqlstr = "DROP TABLE IF EXISTS ".$tabpre."_setup";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "CREATE TABLE ".$tabpre."_setup (
  siteowner varchar(100) NOT NULL default '',
  email varchar(100) NOT NULL default '',
  sitetitle varchar(100) NOT NULL default '',
  baseurl varchar(100) NOT NULL default '',
  progdir varchar(100) NOT NULL default '',
  standardlangid int(11) NOT NULL default '0',
  standardlangname varchar(20) NOT NULL default '',
  standardbgimg varchar(100) NOT NULL default '',
  servertzos tinyint(4) NOT NULL default '0',
  allowopen tinyint(4) NOT NULL default '0',
  allowpublic tinyint(4) NOT NULL default '0',
  allowprivate tinyint(4) NOT NULL default '0',
  allowreminders tinyint(4) NOT NULL default '0'
) TYPE=MyISAM COMMENT='CaLogic Setup Table'";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

# --------------------------------------------------------

//
// Dumping data for table `".$tabpre."_setup`
//

$sqlstr = "INSERT INTO ".$tabpre."_setup VALUES ('".$fields["siteowner"]."', 
'".$fields["adminemail"]."', '".$fields["sitetitle"]."', '".$fields["baseurl"]."', '".$fields["progdir"]."', 
1, 'English', '".$fields["standardbgimg"]."',0,".$fields["allowopen"].", ".$fields["allowpublic"].", 
".$fields["allowprivate"].", ".$fields["allowreminders"].")";
mysql_query($sqlstr) or die("Cannot execute query<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

// --------------------------------------------------------

    include("calogic_mysql_1.0.4a.php");
    include("calogic_lang_english.php");
    include("calogic_mysql_color.php");

        $siteowner = stripslashes($fields["siteowner"]);
        $adminemail = $fields["adminemail"];
        $sitetitle =  stripslashes($fields["sitetitle"]);
        $baseurl =  $fields["baseurl"];
        $progdir =  $fields["progdir"];
        $standardlang =  1;
        $standardlangname =  "English";
        $standardbgimg =  stripslashes($fields["standardbgimg"]);
        $allowopen =  $fields["allowopen"];
        $allowpublic =  $fields["allowpublic"];
        $allowprivate =  $fields["allowprivate"];
        $allowreminders =  $fields["allowreminders"];
    
    
} else {

        $siteowner = "Your Name";
        $adminemail = "yourname@yourdomain.com";
        $sitetitle =  "CaLogic Calendars";
        $baseurl =  "http://www.yourdomain.com/";
        $progdir =  "calogic/";
        $standardlang =  1;
        $standardlangname =  "English";
        $standardbgimg =  "./img/stonbk.jpg";
        $allowopen =  1;
        $allowpublic =  1;
        $allowprivate =  1;
        $allowreminders =  1;

}

?>


<form method="POST" name="calgsetup" id="calgsetup" action="setup.php" LANGUAGE=javascript onsubmit="return calgsetup_onsubmit()">
<b>Table Prefix: <?php echo $tabpre; ?></b><br><br>
<table border="1" width="100%">
  <tr>
    <th width="23%" align="left">Field</th>
    <th width="22%" align="left">Entry</th>
    <th width="140%" align="left">Remark</th>
  </tr>
  <tr>
    <td width="23%" valign="top" align="left">Site Owner</td>
    <td width="22%" valign="top" align="left"><input type="text" size="31" id="siteowner" name="fields[siteowner]" value="<?php echo $siteowner; ?>" ></td>
    <td width="140%" valign="top" align="left">Enter your full name here</td>
  </tr>
  <tr>
    <td width="23%" valign="top" align="left">E-Mail Adress</td>
    <td width="22%" valign="top" align="left"><input type="text" size="31" id="adminemail" name="fields[adminemail]" value="<?php echo $adminemail; ?>" ></td>
    <td width="140%" valign="top" align="left">Enter your E-Mail Adress here</td>
  </tr>
  <tr>
    <td width="23%" valign="top" align="left">Site Title</td>
    <td width="22%" valign="top" align="left"><input type="text" size="31" id="sitetitle" name="fields[sitetitle]" value="<?php echo $sitetitle; ?>" ></td>
    <td width="140%" valign="top" align="left">Enter the Title of your Site here</td>
  </tr>
  <tr>
    <td width="23%" valign="top" align="left">Base URL</td>
    <td width="22%" valign="top" align="left"><input type="text" size="31" id="baseurl" name="fields[baseurl]" value="<?php echo $baseurl; ?>" ></td>
    <td width="140%" valign="top" align="left">Enter the base URL of your site
      here, don't forget the backslash at the end!</td>
  </tr>
  <tr>
    <td width="23%" valign="top" align="left">Program Folder</td>
    <td width="22%" valign="top" align="left"><input type="text" size="31" id="progdir" name="fields[progdir]" value="<?php echo $progdir; ?>" ></td>
    <td width="140%" valign="top" align="left">Enter the Program Folder here,
      without a starting backslash, but the end backslash is required! <br>
      The Base URL and the Program Folder together should be equil to the URL of
      your CaLogic Installation Folder</td>
  </tr>
  <tr>
    <td width="23%" valign="top" align="left">Standard Language</td>
    <td width="22%" valign="top" align="left">
    
    	<select size="1" disabled id="standardlang" name="fields[standardlang]">
        <option value="1" selected >English</option>
      	</select>
      	
      	</td>
    <td width="140%" valign="top" align="left">Choose a Language. At the moment
      only English is available</td>
  </tr>

  <tr>
    <td width="23%" valign="top" align="left">Standard Background</td>
    <td width="22%" valign="top" align="left"><input type="text" size="31" id="standardbgimg" name="fields[standardbgimg]" value="<?php echo $standardbgimg; ?>" ></td>
    <td width="140%" valign="top" align="left">This is the background image of your calogic installation.</td>
  </tr>

  
  <tr>
    <td width="23%" valign="top" align="left">Server Time Zone Offset</td>
    <td width="22%" valign="top" align="left"><input disabled type="text" size="31" id="servertzos" name="fields[servertzos]" value="<?php echo $servertzos; ?>" ></td>
    <td width="140%" valign="top" align="left">This is the Time Zone Offset of
      your Web Server to GMT. You shouln't need to change this.</td>
  </tr>
  <tr>
    <td width="23%" valign="top" align="left">Allow Open Calendars</td>
    <td width="22%" valign="top" align="left">
    
    	<select size="1" id="allowopen" name="fields[allowopen]">
        <option value="0" <?php if($allowopen == 0) {echo "Selected";} ?>>No</option>
        <option value="1" <?php if($allowopen == 1) {echo "Selected";} ?>>Yes</option>
      	</select>
    
    </td>
    <td width="140%" valign="top" align="left">Open Calendars are free for all
      Calendars, and can be subscribed to.</td>
  </tr>
  <tr>
    <td width="23%" valign="top" align="left">Allow Public Calendars</td>
    <td width="22%" valign="top" align="left">

    	<select size="1" id="allowpublic" name="fields[allowpublic]">
        <option value="0" <?php if($allowpublic == 0) {echo "Selected";} ?>>No</option>
        <option value="1" <?php if($allowpublic == 1) {echo "Selected";} ?>>Yes</option>
      	</select>
    
    </td>
    <td width="140%" valign="top" align="left">Public Calendars are free for all
      to see, but can only be added to, changed or subscribed to from those
      users the Calendar owner (not the site owner) specifies.</td>
  </tr>
  <tr>
    <td width="23%" valign="top" align="left">Allow Private Calendars</td>
    <td width="22%" valign="top" align="left">
    
    	<select size="1" id="allowprivate" name="fields[allowprivate]">
        <option value="0" <?php if($allowprivate == 0) {echo "Selected";} ?>>No</option>
        <option value="1" <?php if($allowprivate == 1) {echo "Selected";} ?>>Yes</option>
      	</select>
    
    </td>
    <td width="140%" valign="top" align="left">Private Calendars are designed
      for single person use. However the Calendar owner may allow certain users
      to view, add to or subscribe to, if desired.</td>
  </tr>
  <tr>
    <td width="23%" valign="top" align="left">Allow Reminders</td>
    <td width="22%" valign="top" align="left">

    	<select size="1" id="allowreminders" name="fields[allowreminders]">
        <option value="0" <?php if($allowreminders == 0) {echo "Selected";} ?>>No</option>
        <option value="1" <?php if($allowreminders == 1) {echo "Selected";} ?>>Yes</option>
      	</select>
    
    </td>
    <td width="140%" valign="top" align="left">If you are able to set up a cron
      tab (on a Unix Web Server) or some other sort of automatic timer, then you
      could use reminders if desired.</td>
  </tr>
  <tr>
  
    <td width="23%" valign="top" align="center">
    <input type="submit" <?php if(isset($submitsetupnow)) {echo "disabled"; } ?> value="Submit" name="submitsetupnow">
    </td>
    <td width="22%" valign="top" align="center">
    <input type="reset"  <?php if(isset($submitsetupnow)) {echo "disabled"; } ?> value="Reset">
    </td>
    <td width="140%" valign="top" align="left">
    <?php if(isset($submitsetupnow)) {
    
    echo "<input type=\"button\"  value=\"Start CaLogic\" id=\"gocalnow\" name=\"gocalnow\" LANGUAGE=javascript onclick=\"return gocalnow_onclick()\">";
    
    } else {
        echo "&nbsp;";
    } ?>     
    
    </td>
  </tr>
</table>
</form>

<?php
if(isset($submitsetupnow)) {
    echo "<br><b>You may now start CaLogic!</b><br>";
}
?>

<?php
// Please do not remove this information
// I worked a lot of long hard hours on this program
// give credit where credit is due.
echo "<center>";
echo "<table border=\"0\" width=\"50%\">\n";
echo "<tr>\n";
echo "<td width=\"33%\" align=\"center\">";
echo "<A class=\"gcprevlink\" target=\"_blank\" href=\"http://sourceforge.net \">
<IMG src=\"../img/sf_logo.bmp\" width=\"125\" height=\"37\" border=\"0\" alt=\"SourceForge Logo\"></A>";
echo "<td width=\"33%\" align=\"center\" nowrap>
<a title=\"Visit the Home of CaLogic!\" target=\"_blank\" class=\"gcprevlink\" href=\"http://www.calogic.de \">
<font size=\"-1\">CaLogic Calendars V1.0.4a</font></a><br>
<a title=\"EMail the author!\" target=\"_blank\" class=\"gcprevlink\" href=\"mailto:philip@calogic.de\">
<font size=\"-1\">&#xA9; Philip Boone</font></a></td>\n";
echo "<td width=\"34%\" align=\"center\">
<a target=\"_blank\" class=\"gcprevlink\" href=\"http://www.mysql.com \">
<img border=\"1\" width=\"125\" height=\"37\" src=\"../img/mysql_logo.png\" alt=\"MySQL Logo\"></a></td>\n";
echo "</tr>\n";
echo "</table>\n";
echo "<a target=\"_blank\" class=\"gcprevlink\" href=\"http://www.php.net \">
<img border=\"1\" src=\"../img/php_logo2.gif\" alt=\"PHP Logo\"></a></td>\n";
echo "</center></body>\n";
echo "</html>\n";
?>
