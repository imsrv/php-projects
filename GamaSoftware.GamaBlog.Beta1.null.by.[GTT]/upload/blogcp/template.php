<?php
/* Nullified by GTT */
error_reporting(7);
chdir("../includes");
require("./cpglobal.php");

blogcphead();

if ($action=="add" or $action=="edit") {

	$templateid=intval($templateid);
	if ($templateid > 0) {
		$templatedata=$DB_site->query_first("SELECT * FROM blog_templates WHERE id='$templateid'");
		$doaction="update";
	} else {
		$doaction="insert";
	}

	blogtablehead("Add/Modify Template","$doaction","Add a new template or modify an existing one here.");
	bloghidden("templateid",$templateid);
	blogtextbox("Name","The name of the variable to call your template. This may not contain any spaces or odd characters.","name",$templatedata['name'],45,100);
	blogtextbox("Load Order","This is the order that the template loads in. This number must be smaller than 99 and non negative.","loadorder",$templatedata['loadorder'],45,100);
	blogtextarea("Template","","template",$templatedata[template],45,15);
	blogtablefoot();

}

if ($action=="insert") {
	$DB_site->query("INSERT INTO blog_templates (id,name,loadorder,template) VALUES (NULL,'".addslashes($name)."','".addslashes($loadorder)."','".addslashes($template)."')");

	echo "Added!";
	$action="list";
}

if ($action=="update") {
	if (!$templateid) {
		echo "No template ID specified";
		exit;
	}
	$DB_site->query("UPDATE blog_templates SET name='".addslashes($name)."',loadorder='$loadorder',template='".addslashes($template)."' WHERE id='$templateid'");

	echo "Updated!<br><br>";
	$action="list";
}

if ($action=="delete") {
	if (!$templateid) {
		echo "No template ID specified";
		exit;
	}
	$DB_site->query("DELETE FROM blog_templates WHERE id='$templateid'");

	echo "Deleted!<br><br>";
	$action="list";
}

if ($action=="list") {
	echo '<font face="Verdana" size="2">Click on an template title to modify it. Click on "Delete" ONLY if you want to delete the template. Deleted templates are not recoverable.'.
		'<table border="0" width="80%" align="center">'.
		'<tr><td><font face="Verdana" size="2"><b>Template Name<br><font size="-2"><center>and variable</center></font></b></font></td>'.
		'<td><font face="Verdana" size="2"><b>Load Order</b></font></td>'.
		'<td><font face="Verdana" size="2"><b>Controls</b></font></td></tr>';

	$alltemplates=$DB_site->query("SELECT * FROM blog_templates ORDER BY loadorder LIMIT 100");
	while ($template=$DB_site->fetch_array($alltemplates)) {
		if($template[loadorder]<0 || $template[loadorder]==99){
			echo "<tr><td><font face=\"Verdana\" size=\"2\"><a href=\"$PHP_SELF?action=edit&templateid=$template[id]\">$template[name]</a></font></td>".
			"<td><font face=\"Verdana\" size=\"2\">$template[loadorder]</font></td>".
			"<td align=\"center\"><a href=\"$PHP_SELF?action=edit&templateid=$template[id]\"><font face=\"Verdana\" size=\"2\" color=\"red\">Edit</font></a>".
			"</td></tr>";
		}else{
			echo "<tr><td><font face=\"Verdana\" size=\"2\"><a href=\"$PHP_SELF?action=edit&templateid=$template[id]\">$template[name]</a></font></td>".
			"<td><font face=\"Verdana\" size=\"2\">$template[loadorder]</font></td>".
			"<td align=\"center\"><a href=\"$PHP_SELF?action=edit&templateid=$template[id]\"><font face=\"Verdana\" size=\"2\" color=\"red\">Edit</font></a> | <a href=\"$PHP_SELF?action=delete&templateid=$template[id]\" title=\"Click only if you're sure!\"><font face=\"Verdana\" size=\"2\" color=\"red\">Delete</font></a>".
			"</td></tr>";
		}
	}
	echo "</table>";
}

blogcpfoot();
?>

