<?
if (!isset($_GET["step"])) $step = 1;
else $step = $_GET["step"];

function writableFolder($folder) {
	if (!is_dir($folder)){
		$oldumask = umask(0);
		@mkdir($folder, 0777);
		umask($oldumask);
	} else if(!is_writable($folder)){
		$oldumask = umask(0);
		@chmod ($folder, 0777);
		umask($oldumask);
	}
	echo '<tr>';
	echo '<td>' . $folder . '</td>';
	echo '<td align="left">';
	if (!is_dir($folder)) echo '<b><font color="red">Not exist!</font></b>';
	else echo is_writable($folder) ? '<b><font color="1593DC">Writeable</font></b>' : '<b><font color="red">Unwriteable!</font></b> <a href="install.php">Enable write mode</a>';
	echo '</td>';
	echo '</tr>';
}
function writableFile($file) {
	$return = true;
	if (is_file($file)){
		$oldumask = umask(0);
		@chmod ($file, 0777);
		umask($oldumask);
	}
	echo '<tr>';
	echo '<td>' . $file . '</td>';
	echo '<td align="left">';
	if (!is_file($file)) echo '<b><font color="red">Not exist!</font></b>';
	else echo is_writable($file) ? '<b><font color="1593DC">Writeable</font></b>' : '<b><font color="red">Unwriteable!</font></b> <a href="install.php">Enable write mode</a>';
	echo '</td>';
	echo '</tr>';
}
?>
<html>
<head>
	<title>Gallery install</title>
	<style media="all" type="text/css">
	.title {
		font-size: 20px;
		font-weight: bold;
	}
	.install {
		margin-left: auto;
		margin-right: auto;
		margin-top: 3em;
		margin-bottom: 3em;
		padding: 10px;
		border: 1px solid #FD6113;
		background: #FFF7E3;
	}
	body {
		margin: 0px;
		padding: 0px;
		color : #333000;
		background-color : #FFF;
		font-size : 11px;
		font-family : Arial, Helvetica, sans-serif;
	}
	table.content {
		width: 100%;
		border: 1px solid #FD6113;
	}
	
	table.content td {
		color : #333333;
		font-size: 11px;
		width: 50%;
	}
	.red{
		font-size: 14px;
		font-weight: bold;
		color: #FF0000;
	}
	.red2{
		font-size: 12px;
		font-weight: bold;
		color: #FF0000;
	}
	.black{
		font-size: 12px;
		color: #000000;
		line-height: 17px;
	}
	a {
		color : #FF9900;
		text-decoration : none;
	}
	a.blue {
		color : #1593dc;
		text-decoration : underline;
		font-weight: bold;
	}
	a:hover {
		color : #999999;
		text-decoration : underline;
	}
	a:active {
		color : #FF6600;
		text-decoration : underline;
	}

	</style>
</head>

<body>
<?
switch ($step) {
	case 1:
?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%">
<tr>
	<td align="center" valign="top">
	<table cellpadding="0" cellspacing="0" border="0" width="400" class="install">
    <tr>
    	<td class="title"><img src="box.jpg" width="65" height="77" border="0" align="absmiddle">&nbsp;&nbsp;Pre-installation check</td>
    </tr>
    <tr>
    	<td valign="top"><strong>Required settings:</strong></td>
	</tr>
	<tr>
		<td>
		<table class="content">
		<tr>
			<td>PHP version >= 4.1.0</td>
			<td align="left"><?php echo phpversion() < '4.1' ? '<b><font color="red">No</font></b>' : '<b><font color="1593DC">Yes</font></b>';?></td>
		</tr>
		<tr>
			<td>&nbsp; - gdlib module support</td>
			<td align="left"><?php echo extension_loaded('gd') ? '<b><font color="1593DC">Available</font></b>' : '<b><font color="red">Unavailable</font></b>';?></td>
		</tr>
		<tr>
			<td>&nbsp; - XML support</td>
			<td align="left"><?php echo extension_loaded('xml') ? '<b><font color="1593DC">Available</font></b>' : '<b><font color="red">Unavailable</font></b>';?></td>
		</tr>
		</table>
	</td>
    </tr>
	<tr>
    	<td valign="top"><strong>Directory and File Permissions:</strong></td>
	</tr>
	<tr>
		<td>
		<table class="content">
<?
writableFolder('tmp');
writableFolder('images');
writableFile('userconfig.xml');
writableFile('database.xml');
writableFile('thumberrors.xml');
writableFile('head.php');
writableFile('admin.php');
$missing = true;
$missing = is_writable('tmp') && $missing;
$missing = is_writable('images') && $missing;
$missing = is_writable('userconfig.xml') && $missing;
$missing = is_writable('database.xml') && $missing;
$missing = is_writable('thumberrors.xml') && $missing;
$missing = is_writable('head.php') && $missing;
$missing = is_writable('admin.php') && $missing;
if (!$missing){
	echo '<tr><td colspan="2" align="center" height="40"><span class="red">Please manualy set 777 right on the above listed folders and files! Reload this page after!</span></td><tr>';
} else {
	echo '<tr><td colspan="2" height="33" align="center"><a href="install.php?step=2" class="title">Continue</a></td><tr>';
}
?>
		</table>
	</td>
    </tr>
    </table>
	</td>
</tr>
</table>
<?
	break;
	case 2: 
	?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%">
<tr>
	<td align="center" valign="top">
	<table cellpadding="0" cellspacing="0" border="0" width="400" class="install">
    <tr>
    	<td class="title"><img src="box.jpg" width="65" height="77" border="0" align="absmiddle">&nbsp;&nbsp;Step 2</td>
    </tr>
    <tr>
    	<td valign="top"><strong>Enter the title of your gallery:</strong></td>
	</tr>
	<form action="install.php" method="get">
	<input type="Hidden" name="step" value="3">
	<tr>
		<td>
		<table class="content">
		<tr>
<?
	if (!isset($_GET["sitename"])){
		$sitename = "Photo Flash Gallery";
	} else {
		$sitename = $_GET["sitename"];
	}
?>
  			<td>Gallery title:</td>
  			<td align="center"><input class="inputbox" type="text" name="sitename" size="45" value="<?php echo $sitename ?>" /></td>
  		</tr>
		<tr>
  			<td>Gallery url:</td>
<?
	if (!isset($_GET["siteurl"])){
		$root = $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
		$root = str_replace("/install.php","",$root);
		$siteurl = "http://".$root.'/';
	} else {
		$siteurl = $_GET["siteurl"];
	}
?>
  			<td align="center"><input class="inputbox" type="text" name="siteurl" size="45" value="<?php echo $siteurl ?>" /></td>
  		</tr>
		</table>
	</td>
    </tr>
	<tr><td colspan="2" height="33" align="center"><a href="javascript:document.forms[0].submit()" class="title">Continue</a></td><tr>
	</form>		
    </table>
	</td>
</tr>
</table>
<?
	break;
	case 3:

	$fp = fopen ("head.php", "w");
	$headere = '	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>'.$_GET["sitename"].'</title>';
	fwrite($fp, $headere);
	fclose ($fp);

	function parseFile($file) {
		$data = @file_get_contents($file) or die("Can't open file $file for reading!");
		return $data;
	}

	function getConfig(&$config, $file){
		$data = parseFile($file);
		$xml = xml_parser_create();
		xml_parser_set_option($xml, XML_OPTION_CASE_FOLDING, 0);
		xml_parser_set_option($xml, XML_OPTION_SKIP_WHITE, 1);
		xml_parse_into_struct($xml,$data,$vals);
		xml_parser_free($xml);
		if ($vals[0]["tag"] == "userConfig"){
			$config = array();
			for ($i=0; $i<count($vals); $i++){
				if ($vals[$i]["tag"] != "userConfig"){
					$config[$vals[$i]["tag"]] = $vals[$i]["attributes"]["value"];
				}
			}
		}
	}
	function writeConfig($config, $filename){
		$file = fopen ($filename, "w");
		if ($file) {
			$header = '<?xml version="1.0" encoding="UTF-8"?>';
			fputs($file, $header."\n");
			fputs($file, '<userConfig>'."\n");
			foreach ($config as $configkey => $configvalue){
				fputs($file, '<'.$configkey.' value="'.htmlentities(stripslashes($configvalue)).'"/>'."\n");
			}
			fputs($file, '</userConfig>'."\n");
			fclose($file);
			return true;
		} else {
			return false;
		}
	}

	getConfig($config, "userconfig.xml");
	$siteurl = $_GET["siteurl"];
	if (strrpos($siteurl,'/')!=strlen($siteurl)-1) $siteurl .= '/';
	$config["yourDomain"] = $siteurl;
	writeConfig($config, "userconfig.xml");
?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%">
<tr>
	<td align="center" valign="top">
	<table cellpadding="0" cellspacing="0" border="0" width="500" class="install">
    <tr>
    	<td class="title"><img src="box.jpg" width="65" height="77" border="0" align="absmiddle">&nbsp;&nbsp;INSTALL COMPLETE</td>
    </tr>
    <tr>
    	<td valign="top">
		<table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%">
        <tr>
        	<td colspan="2"><span class="black"><strong>Now you can start adding images to gallery.</strong></span></td>
        </tr>
        <tr>
        	<td height="30" colspan="2"><span class="black"><strong>You can do this in 2 ways:</strong></span></td>
        </tr>
        <tr>
			<td width="15" valign="top"><span class="black"><strong>1.</strong></span></td>
        	<td colspan="2"><span class="black">Using the upload module from administration area located at <a href="<?=$siteurl."admin/"?>" target="_blank" class="blue"><?=$siteurl."admin/"?></a><br>Default username is "administrator" <br>Default password is "12345"</span></td>
        </tr>
		<tr>
			<td height="5" colspan="2"></td>
		</tr>
		<tr>
			<td height="1" bgcolor="#FD6113" colspan="2"></td>
		</tr>
		<tr>
			<td height="5" colspan="2"></td>
		</tr>
        <tr>
			<td width="15" valign="top"><span class="black"><strong>2.</strong></span></td>
        	<td valign="top"><span class="black">Uploading image files to "images" folder using a ftp client application.<br>Then generate the xml file structure using this link <a href="<?=$siteurl."admin/generate.php"?>" target="_blank" class="blue"><?=$siteurl."admin/generate.php"?></a></span></td>
        </tr>
		<tr>
			<td height="5" colspan="2"></td>
		</tr>
		<tr>
			<td height="1" bgcolor="#FD6113" colspan="2"></td>
		</tr>
		<tr>
			<td height="5" colspan="2"></td>
		</tr>
        <tr>
			<td valign="top" colspan="2"><span class="black"><strong>Warning&nbsp;</strong><br></span><span class="black">To avoid errors while uploading files from Flash create or find the .htaccess file in your root directory then type in:<br>SecFilterEngine Off<br>SecFilterScanPOST Off</span></td>
        </tr>
		<tr>
			<td height="5" colspan="2"></td>
		</tr>
		<tr>
			<td height="1" bgcolor="#FD6113" colspan="2"></td>
		</tr>
		<tr>
			<td height="5" colspan="2"></td>
		</tr>
		<tr>
        	<td colspan="2" height="30" align="center"><span class="red2"><strong>For security reasons please change your password from administration area.</strong></span></td>
        </tr>
		<tr>
        	<td colspan="2" height="30" align="center"><span class="red2"><u><strong>PLEASE REMEMBER TO REMOVE THE INSTALLATION FILE: INSTALL.PHP</strong></u></span></td>
        </tr>
        </table>
		</td>
	</tr>
    </table>
	</td>
</tr>
</table>
<?
	break;
}
?>
</body>
</html>
