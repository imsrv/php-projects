<?
/********************************************************
	lang/se/folders.inc
	(C)2001-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html

	Translated by Markus Svensson <markus.svensson@linux.nu>

********************************************************/

	echo "<p><b>Folders</b>\n";
	echo "<br>[<a href=\"edit_folders.php?user=".$user."\" target=\"list2\">Hantera mappar</a>]";
	echo "<br><br>";

	$sentbox=$my_prefs["sent_box_name"];
	$trashname=$my_prefs["trash_name"];
	$defaults=array(
		"INBOX" =>"Inkorg",
		$sentbox =>"Skickade",
		$trashname =>"Skr�p",
	);
?>