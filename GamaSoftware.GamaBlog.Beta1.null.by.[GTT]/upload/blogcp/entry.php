<?php
/* Nullified by GTT */
error_reporting(7);
chdir("../includes");
require("./cpglobal.php");

blogcphead();

if ($action=="add" or $action=="edit") {

	$entryid=intval($entryid);
	if ($entryid > 0) {
		$entrydata=$DB_site->query_first("SELECT * FROM blog_entries WHERE id='$entryid'");
		$doaction="update";
	} else {
		$doaction="insert";
	}

	blogtablehead("Add/Modify Entry","$doaction","Add a new entry or modify an existing one here.");
	bloghidden("entryid",$entryid);
	blogtextbox("Date","Date of Entry","date",$entrydata['date'],45,100);
	blogtextarea("Entry","","entry",$entrydata[text],45,15);
	blogtablefoot();

}

if ($action=="insert") {
	$DB_site->query("INSERT INTO blog_entries (id,date,text) VALUES (NULL,'".addslashes($date)."','".addslashes($entry)."')");

	echo "Added!";
	$action="list";
}

if ($action=="update") {
	if (!$entryid) {
		echo "No entry ID specified";
		exit;
	}
	$DB_site->query("UPDATE blog_entries SET date='".addslashes($date)."',text='".addslashes($entry)."' WHERE id='$entryid'");

	echo "Updated!<br><br>";
	$action="list";
}

if ($action=="delete") {
	if (!$entryid) {
		echo "No entry ID specified";
		exit;
	}
	$DB_site->query("DELETE FROM blog_entries WHERE id='$entryid'");

	echo "Deleted!<br><br>";
	$action="list";
}

if ($action=="list") {
	echo '<font face="Verdana" size="2">Click on an entry title to modify it. Click on "Delete" ONLY if you want to delete the entry. Deleted entries are not recoverable.'.
		'<table border="0" width="80%" align="center">'.
		'<tr><td><font face="Verdana" size="2"><b>Entry</b></font></td>'.
		'<td><font face="Verdana" size="2"><b>Date</b></font></td>'.
		'<td><font face="Verdana" size="2"><b>Controls</b></font></td></tr>';

	$allentries=$DB_site->query("SELECT * FROM blog_entries ORDER BY id DESC LIMIT 100");
	while ($entry=$DB_site->fetch_array($allentries)) {
		$entry[title]=substr($entry[text],0,50);
		echo "<tr><td><font face=\"Verdana\" size=\"2\"><a href=\"$PHP_SELF?action=edit&entryid=$entry[id]\">$entry[title]</a></font></td>".
			"<td><font face=\"Verdana\" size=\"2\">$entry[date]</font></td>".
			"<td align=\"center\"><a href=\"$PHP_SELF?action=edit&entryid=$entry[id]\" title=\"Click only if you're sure!\"><font face=\"Verdana\" size=\"2\" color=\"red\">Edit</font></a> | <a href=\"$PHP_SELF?action=delete&entryid=$entry[id]\" title=\"Click only if you're sure!\"><font face=\"Verdana\" size=\"2\" color=\"red\">Delete</font></a>".
			"</td></tr>";
	}
	echo "</table>";
}

blogcpfoot();
?>