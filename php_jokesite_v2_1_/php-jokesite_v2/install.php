<?
$install_email = "rulez@ooOoo@ooOoo.com";
$product = "PHP - JokeSite";
$cf_in['PHP_JOKESITE_VERSION'] = '2.1';
$cf_in['INSTALLATION_DATE'] = date('Y-m-d');
$permissions_dirs = array("logs", "banner_images", "banners", "funny_images", "languages");

$permissions_files = array("config_file.php", "funny_images/daily_active_joke_picture_eng.php", "daily_joke_picture_config_file.php", "site_design_configuration.php", "site_settings.php", "logs/parse_time_log", "admin/admin_settings_backup.php", "admin/auth_pass.php"); 

$plus_permission = array("languages","banners");

function write_config($cf, $filename)
{
    $fp = fopen($filename, "r");
    while (!feof($fp)) {
        $buffer = fgets($fp, 20000);
        for ($i=0;$i<sizeof($cf['h']);$i++) {
                if (eregi("define\('".$cf['h'][$i]."'(.*)",$buffer,$regs)) {
                   if($cf['h'][$i] != "DIR_ADMIN") {
                       $buffer = eregi_replace("define\('".$cf['h'][$i]."'(.*)","define('".$cf['h'][$i]."','".$cf['v'][$i]."');\n",$buffer);
                   }
                   else {
                       $buffer = eregi_replace("define\('".$cf['h'][$i]."'(.*)","define('".$cf['h'][$i]."',".$cf['v'][$i]."');\n",$buffer);
                   }
            }
        }
        $to_write .= $buffer;
    }
    fclose($fp);
    $fp2 = fopen($filename, "w+");
    fwrite($fp2, $to_write);
    fclose($fp2);
} // end func

function write_config_dolarvar($cf, $filename)
{
    $fp = fopen($filename, "r");
    while (!feof($fp)) {
        $buffer = fgets($fp, 20000);
        for ($i=0;$i<sizeof($cf['h']);$i++) {
              //if (eregi("define\('".$cf['h'][$i]."'(.*)",$buffer,$regs)) {
				//echo "\$".$cf['h'][$i].eregi("\$".$cf['h'][$i]."(.*)",$buffer,$regs);exit;
                if (eregi("\\\$".$cf['h'][$i].".*",$buffer,$regs)) {
                   $buffer = eregi_replace("\\\$".$cf['h'][$i].".*","\$".$cf['h'][$i]." = \"".$cf['v'][$i]."\";\n",$buffer);
            }
        }
        $to_write .= $buffer;
		
    }
    fclose($fp);
    $fp2 = fopen($filename, "w+");
    fwrite($fp2, $to_write);
    fclose($fp2);
} // end func
?><html>
<head>
	<title><?echo $site_title;?></title>
<style type="text/css">
<!--
	body	{font-family: helvetica, arial, geneva, sans-serif; font-size: x-small}
	th		{font-family: helvetica, arial, geneva, sans-serif; font-size: x-small; font-weight: bold; background-color: #D3DCE3}
	td		{font-family: helvetica, arial, geneva, sans-serif; font-size: 13px;font-weight: bold;}
	form	{font-family: helvetica, arial, geneva, sans-serif; font-size: x-small, margin-top: 0px; margin-bottom: 0px; }
	A:link	{font-family: helvetica, arial, geneva, sans-serif; font-size: 13px; text-decoration: none; color: #0000ff}
	A:active{font-family: helvetica, arial, geneva, sans-serif; font-size: 13px; text-decoration: none; color: #0000ff}
	A:visited{font-family: helvetica, arial, geneva, sans-serif; font-size: 13px; text-decoration: none; color: #0000ff}
	A:hover	{font-family: helvetica, arial, geneva, sans-serif; font-size: 13px; text-decoration: underline; color: #FF0000}
	.button	{BACKGROUND-COLOR: #e3daf0;	COLOR: #993366;	CURSOR: hand;	FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;	FONT-SIZE: 8pt;	FONT-WEIGHT: bold;	border: 1 solid #000000}
	submit	{BACKGROUND-COLOR: #e3daf0;	COLOR: #993366;	CURSOR: hand;	FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;	FONT-SIZE: 8pt;	FONT-WEIGHT: bold;	border: 1 solid #000000}
	input	{BACKGROUND-COLOR: #FFFFFE;	COLOR: #993366;		FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;	FONT-SIZE: 8pt;	FONT-WEIGHT: bold;	border: 1 solid #000000}
	textarea	{BACKGROUND-COLOR: #FFFFFE;	COLOR: #993366;		FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;	FONT-SIZE: 8pt;	FONT-WEIGHT: bold;	border: 1 solid #000000}
	select	{BACKGROUND-COLOR: #FFFFFE;	COLOR: #993366;		FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;	FONT-SIZE: 8pt;	FONT-WEIGHT: bold;	border: 1 solid #000000}
	.info {color: #993333; font-size: 9pt; font-weight: normal; font-family: verdana}

	#TD { font-size: 10pt; font-weight: bold; color: #000000; font-family: arial}
	#INPUT {color: #003399; background: transparent; font-size: 11pt; text-align: center; font-weight: bold; border: 1px solid #000000}
	TEXTAREA {color: #003399; background: transparent; font-size: 9pt; font-weight: bold; border: 1px solid #000000}
	H1 { font-size: 12pt; font-weight: bold; color: #003399; font-family: arial}
	
	.license {color: #FF0000; font-size: 11pt; font-weight: bold; font-family: arial}
	.error {color: #FF0000; font-size: 9pt; font-weight: normal; font-family: serif}
     .highlight { font-size: 10pt; font-weight: bold; color: #0000FF; font-family: arial}
	.error2 {color: #FF0000; font-size: 10pt; font-weight: bold; font-family: arial;}
	.button {background: #DDDDDD;font-size: 9pt; font-weight: bold; letter-spacing : 1px;}
	.checkbox {color: #003399; background: transparent; font-size: 11pt; text-align: center; font-weight: bold; border: 0px solid #000000}
	//-->
</style>
<body>
<h3>PHP-JokeSite <a href="install.php">install version <?=$cf_in['PHP_JOKESITE_VERSION']?></a></h3>

<?
if ($HTTP_POST_VARS['user_agree']=="N")
{
?>
        <table border="0" width="100%" cellspacing="1" cellpadding="2" align="center">
        <tr>
                <td align="center" colspan="2">&nbsp;</td>
        </tr>
        <tr>
                <td align="center" colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td width="30%">&nbsp;</td><td align="left" width="70%" class="license">You do not agree with the Terms and Conditions!<br>You don't have the right to use this software.</td>
        </tr>
        <tr>
                <td align="center" colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td width="30%">&nbsp;</td><td align="left" width="70%">You can email to the author (<a href="mailto:<?=$install_email?>"><?=$install_email?></a>) for more information.</td>
        </tr>
        <tr>
                <td align="center" colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td width="30%">&nbsp;</td><td align="left" width="70%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Thank You!</td>
        </tr>
        <tr>
                <td align="center" colspan="2">&nbsp;</td>
        </tr>
        </table>
		</body>
		</html>

<?
	exit();
}

if (!$HTTP_GET_VARS['step'] && !$HTTP_POST_VARS['user_agree'])
{
?>
<form method="post" action="install.php">
<input type="hidden" name="stepper" value="agree">
<table border="0" width="100%" cellspacing="1" cellpadding="2" align="center">
<tr>
	<td align="center" colspan="2" class="license"><b>License Agreement!</b></td>
</tr>
<TR><TD colspan="2">&nbsp;</td></tr>
<TR><TD colspan="2">&nbsp;</td></tr>
<tr>
    <td width="30%">&nbsp;</td><td align="left" width="70%">All use of this program is under strict licence.</td>
</tr>
<tr>
    <td width="30%">&nbsp;</td><td align="left" width="70%">bla bla bla bla , <a href="mailto:<?=$install_email?>"><?=$install_email?></a>.</td>
</tr>
<tr>
    <td width="30%">&nbsp;</td><td align="left" width="70%">However you can change, edit the provided code at your own risk.</td>
</tr>
<TR><TD colspan="2">&nbsp;</td></tr>
<tr>
    <td width="30%">&nbsp;</td><td align="left" width="70%">© COPYRIGHT 2003 BitmixSoft by WST </a></td>
</tr>
<TR><TD colspan="2">&nbsp;</td></tr>
<tr>
	<td align="center" colspan="2" class="license">Do you agree with the above Terms and Conditions? <input type="radio" name="user_agree" value="Y" class="checkbox"> Yes <input type="radio" name="user_agree" class="checkbox" value="N" checked> No</td>
</tr>
<TR><TD colspan="2">&nbsp;</td></tr>
<tr>
	<td align="center" colspan="2"><input type="submit" name="next" class="button" value="Next"></td>
</tr>
</table>
</form>
</body>
</html>
<?
exit;
}

echo "<font style=\"font-size:12px;font-weight:bold;font-family:verdana;color:#3300FF\">Welcome to ".$product." install</font>";

$step  = ($HTTP_GET_VARS['step'] ? $HTTP_GET_VARS['step'] : ($HTTP_POST_VARS['step'] ? $HTTP_POST_VARS['step'] : "1"));
echo "<br><br>Step &gt;&gt; ".$step;

$script_dir = dirname(__FILE__)."/";
$script_url = "http://".eregi_replace("/$","",(getenv(HTTP_HOST)?getenv(HTTP_HOST):$HTTP_SERVER_VARS['HTTP_HOST']).dirname((getenv(REQUEST_URI)?getenv(REQUEST_URI):$HTTP_SERVER_VARS['REQUEST_URI'])));
if(!eregi("/$", $script_url)) {
   $script_url .= "/"; 
}
if ($step=='1')
{
?>
<form method=post action="install.php?step=2" style="margin-width:0px;margin-height:0px">
<table border="0" cellspacing="3" cellpadding="4" width="100%">
<tr valign="top">
	<td width="160">
		Script directory (path):
	</td>
	<td>
		<input type="text" name="script_path" value="<?=$script_dir?>" class="" size="100">
		<br><font class="info">(Path to the directory where the script will be located - / at the end is necessary)</font>
	</td>
</tr>
<tr valign="top">
	<td width="160">
		Admin directory (path):
	</td>
	<td>
		<input type="text" name="script_path_admin" value="<?=$script_dir?>admin/" class="" size="100">
		<br><font class="info">(Path to the directory where the script admin will be located - / at the end is necessary)</font>
	</td>
</tr>
<tr valign="top">
	<td width="160">
		Script URL:
	</td>
	<td>
		<input type="text" name="script_url" value="<?=$script_url?>" class="" size="100">
		<br><font class="info">(Path to the directory where the script will be located - / at the end is necessary</font>
	</td>
</tr>
<tr valign="top">
	<td width="160">
		Admin URL:
	</td>
	<td>
		<input type="text" name="script_url_admin" value="<?=$script_url?>admin/" class="" size="100">
		<br><font class="info">(admin url of the script, without http:// - / at the end is necessary)</font>
	</td>
</tr>
<tr valign="top">
	<td width="160">
		Site name:
	</td>
	<td>
		<input type="text" name="site_name" value="Site Name" class="" size="100">
		<br><font class="info">(Your site name, will appear mostly in mail, e.g. <?=$product?>)</font>
	</td>
</tr>
<tr valign="top">
	<td width="160">
		Site title:
	</td>
	<td>
		<input type="text" name="site_title" value="Site Title" class="" size="100">
		<br><font class="info">(Your site title, e.g. <?=$product?>)</font>
	</td>
</tr>
<tr valign="top">
	<td width="160">
		Admin email:
	</td>
	<td>
		<input type="text" name="site_mail" value="office@yourdomain.com" class="" size="100">
		<br><font class="info">(Your email address)</font>
	</td>
</tr>
<tr>
	<td colspan="2" align="center">
		<input type="submit" name="submit" value="Submit" class="">
	</td>
</tr>
</table>
</form>

<?
}
elseif ($step=='2')
{
		$cf['h'][] = "HTTP_SERVER";
        $cf['v'][] = $HTTP_POST_VARS['script_url'];
        $cf['h'][] = "DIR_SERVER_ROOT";
        $cf['v'][] = $HTTP_POST_VARS['script_path'];
		$cf['h'][] = "HTTP_SERVER_ADMIN";
        $cf['v'][] = $HTTP_POST_VARS['script_url_admin'];
        $cf['h'][] = "DIR_SERVER_ADMIN";
        $cf['v'][] = $HTTP_POST_VARS['script_path_admin'];
        $st['h'][] = "site_mail";
        $st['v'][] = $HTTP_POST_VARS['site_mail'];
        $st['h'][] = "site_name";
        $st['v'][] = $HTTP_POST_VARS['site_name'];
        $st['h'][] = "site_title";
        $st['v'][] = $HTTP_POST_VARS['site_title'];
        write_config($cf, "config_file.php");
		write_config_dolarvar($st, "site_settings.php");

echo "<br><br>";
$error = 0;
foreach ($permissions_dirs as $perm)
{

	if (fileperms($HTTP_POST_VARS['script_path'].$perm) != 16895)
	{
		 echo "Cannot write to the specified <font class=\"highlight\">".$perm."</font> directory. Please <b><font color=\"#FF0000\">chmod 777</font></b> this directory and Refresh this page.<br>";
		 $error = 1;
	}
	else
		echo $HTTP_POST_VARS['script_path'].$perm." directory is correctly set to CHMOD 777 - <font color=\"#6633CC\"><b>OK</b></font><br>";

}

foreach ($permissions_files as $perm)
{

	if (fileperms($HTTP_POST_VARS['script_path'].$perm) < 33254)
	{
		echo "<font color=\"#FF0000\">Cannot write to the specified <font class=\"highlight\">".$perm."</font> directory. Please <b><font color=\"#FF0000\">chmod 746</font></b> this directory and Refresh this page.</font><br>";
		$error = 1;
	}
	else
		echo $HTTP_POST_VARS['script_path'].$perm." directory is correctly set to min. CHMOD 746 - <font color=\"#6633CC\"><b>OK</b></font><br>";

}

foreach ($plus_permission as $plus_perm)
{
	echo "=> <font color=\"#000000\"><b>Please chmod 777 all files and directories under <font class=\"highlight\">".$plus_perm."</font> directory. </b></font><br>";
}

if ($error == 1)
{
?>
	<form method="post">
	<table border="0" width="100%" cellspacing="1" cellpadding="2" align="center">
	<?="<tr><td align=\"center\"><input type=\"button\" value=\"Refresh\" onclick=\"document.location.reload();\"></td></tr>";?>
	</table>
	</form>

	</body>
	</html>
<?
//	exit;
}
?>
<form method=post action="install.php?step=3" style="margin-width:0px;margin-height:0px">
<table border="0" cellspacing="3" cellpadding="4" width="100%">
<tr valign="top">
	<td width="160">
		Myqsl database host:
	</td>
	<td>
		<input type="text" name="mysql_host" value="localhost" class="" size="40">
		<br><font class="info">(In most cases is localhost...Ask your webadmin or your hosting company if not sure...)</font>
	</td>
</tr>
<tr valign="top">
	<td width="160">
		Myqsl database user:
	</td>
	<td>
		<input type="text" name="mysql_user" value="" class="" size="40">
		<br><font class="info">(Ask your webadmin or your hosting company if not sure...)</font>
	</td>
</tr>
<tr valign="top">
	<td width="180">
		Myqsl database password:
	</td>
	<td>
		<input type="text" name="mysql_passwd" value="" class="" size="40">
		<br><font class="info">(Ask your webadmin or your hosting company if not sure...)</font>
	</td>
</tr>
<tr valign="top">
	<td width="160">
		Myqsl database name:
	</td>
	<td>
		<input type="text" name="mysql_dbname" value="" class="" size="40">
		<br><font class="info">(You must have created this database in order to take the next step...<br>Ask your webadmin or your hosting company if not sure...)</font>
	</td>
</tr>
<tr>
	<td align="right">&nbsp;&nbsp;<input type="checkbox" name="skip_db" value="yes" title="Skip database tables creation" class="checkbox"></td><td>Skip database tables creation</td>
</tr>
<tr>
	<td colspan="2" align="center">
		<input type="submit" name="submit" value="Submit" class="">
	</td>
</tr>
</table>
</form>

<?}
elseif ($step=='3')
{?>
<form method=post action="install.php?step=4" style="margin-width:0px;margin-height:0px">
<table border="0" cellspacing="3" cellpadding="4" width="500">
<?

	$error = 0;
	if (@mysql_connect($HTTP_POST_VARS['mysql_host'], $HTTP_POST_VARS['mysql_user'], $HTTP_POST_VARS['mysql_passwd'])) {
		if (mysql_select_db($HTTP_POST_VARS['mysql_dbname'])) {
			echo "<tr><td align=\"left\">Successful connection to \"".$HTTP_POST_VARS['mysql_dbname']."\" database...</td></tr>";
		}
		else {
			echo "<tr><td align=\"left\"><font color=\"red\">Mysql connection error...".mysql_error()."</font></td></tr>";
			echo "<tr><td align=\"left\"><font color=\"black\">Go <a href=\"javascript:history.go(-1);\">Back</a> and change the connection settings...</font></td></tr>";
			$error =1;
		}
	}
	else {
	    echo "<tr><td align=\"left\"><font color=\"red\">Mysql connection error...".mysql_error()."</font></td></tr>";
		echo "<tr><td align=\"left\"><font color=\"black\">Go <a href=\"javascript:history.go(-1);\">Back</a> and change the connection settings...</font></td></tr>";
		$error = 1;
	}
	if (!$error) {
		function split_sql($sql) {
			$sql = trim($sql);
			$sql = ereg_replace("#[^\n]*\n", "", $sql);
			$buffer = array();
		    $ret = array();
		    $in_string = false;

		    for($i=0; $i<strlen($sql)-1; $i++) {
		         if($sql[$i] == ";" && !$in_string)	{
		            $ret[] = substr($sql, 0, $i);
				    $sql = substr($sql, $i + 1);
		            $i = 0;
                 }
		         if($in_string && ($sql[$i] == $in_string) && $buffer[0] != "\\") {
			          $in_string = false;
				 }
				 elseif(!$in_string && ($sql[$i] == "\"" || $sql[$i] == "'") && (!isset($buffer[0]) || $buffer[0] != "\\"))	{
					$in_string = $sql[$i];
				 }
				 if(isset($buffer[1])) {
					$buffer[0] = $buffer[1];
				 }
				 $buffer[1] = $sql[$i];
			}
			if(!empty($sql))
				{
				$ret[] = $sql;
			}
			return($ret);
		}
		
		if (!$skip_db) {
			echo "<tr><td align=\"left\">&nbsp;</td></tr>";
			echo "<tr><td align=\"left\">Creating database tables...</td></tr>";
			if (file_exists("admin/setup/mysql.sql")) {
				$sql_query = addslashes(fread(fopen("admin/setup/mysql.sql", "r"), filesize("admin/setup/mysql.sql")));
			}
			else {
				echo "<tr><td align=\"left\">&nbsp;</td></tr>";
				echo "<tr><td align=\"left\" class=\"error2\">Can't find admin/setup/mysql.sql file....in ".dirname(getenv(SCRIPT_FILENAME))." directory...<br>Please correct this error and try again...</td></tr>";
				echo "</table>";
				exit;
			}
			
			$pieces  = split_sql($sql_query);
			if (count($pieces) == 1 && !empty($pieces[0])) {
				$pieces[0] = stripslashes(trim($pieces[0]));
				$result = mysql_query ($pieces[0]) or die("<tr><td class=\"error2\">Unable to execute query: ".$pieces[0]."<br>Please check if you have the original admin/setup/mysql.sql file...</td></tr>");
			}
			else {
				for ($i=0; $i<count($pieces); $i++)
				{
					$pieces[$i] = stripslashes(trim($pieces[$i]));
					if(!empty($pieces[$i]) && $pieces[$i] != "#") {
						$result = mysql_query ($pieces[$i]) or die("<tr><td class=\"error2\">Unable to execute query: ".$pieces[$i]."<br>Please check if you have the original admin/setup/mysql.sql file...</td></tr>");
					}
				}
			}

			echo "<tr><td align=\"left\">Success...</td></tr>";
			echo "<tr><td align=\"left\">&nbsp;</td></tr>";
        }

		echo "<tr><td align=\"left\">Writing config file...</td></tr>";
		$cf['h'][] = "DB_SERVER";
		$cf['v'][] = $HTTP_POST_VARS['mysql_host'];
		$cf['h'][] = "DB_SERVER_USERNAME";
		$cf['v'][] = $HTTP_POST_VARS['mysql_user'];
		$cf['h'][] = "DB_SERVER_PASSWORD";
		$cf['v'][] = $HTTP_POST_VARS['mysql_passwd'];
		$cf['h'][] = "DB_DATABASE";
		$cf['v'][] = $HTTP_POST_VARS['mysql_dbname'];
		$cf['h'][] = "INSTALLATION_DATE";
		$cf['v'][] = date('Y-m-d');
		write_config($cf, "config_file.php");

		@include('config_file.php');
		@include('site_settings.php');
		$mail_admin = "Congratulations!\nYou successfully installed Php-Jokesite ".$cf_in['PHP_JOKESITE_VERSION']."\n";
		$mail_phpjokesite = "New installation of Php-Jokesite ".$cf_in['PHP_JOKESITE_VERSION']."\n";
		$mail_admin .= "Install Date: ".$cf_in['INSTALLATION_DATE']."\n";
		$mail_phpjokesite .= "Install Date: ".$cf_in['INSTALLATION_DATE']."\n";
		$mail_admin .= "Main Link: ".HTTP_SERVER."\n";
		$mail_phpjokesite .= "Root DIR: ".DIR_SERVER_ROOT."\n";
		$mail_phpjokesite .= "Main Link: ".HTTP_SERVER."\n";
		$mail_admin .= "Admin Link: ".HTTP_SERVER_ADMIN."\n\n";
		$mail_phpjokesite .= "Admin Link: ".HTTP_SERVER_ADMIN."\n";
		$mail_phpjokesite .= "Php Version: ".phpversion()."\n";
		$mail_phpjokesite .= "OS: ".PHP_OS."\n";
		$mail_phpjokesite .= "IP: ".$HTTP_SERVER_VARS['REMOTE_ADDR']."\n";
		$mail_phpjokesite .= "Server: ".$HTTP_SERVER_VARS['HTTP_HOST']."\n";
		$mail_admin .= "Any problems or suggestions please send them to joe@ooOoo@ooOoo.com\n";
		$mail_admin .= "We wish you \"Good Luck\".\n\n WST TEAM.";
		


		echo "<tr><td align=\"left\">&nbsp;</td></tr>";
		echo "<tr><td align=\"left\"><h1>Successfull installation</h1></td></tr>";
		echo "<tr><td align=\"left\"><a href=\"index.php\">Go and check out!!!</a></td></tr>";
		echo "<tr><td align=\"right\"><a href=\"admin/admin_site_settings.php\">More Options you can configure from Here!!!<br> <font color=\"#FF0000\">The default username is WarezScripts and the password is rulez!</font></a></td></tr>";
                       
	}               
?>
</table>
</form>
<?
}
else{}

?>
</td>
</tr>
</table>
</body>
</html>
