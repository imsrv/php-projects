<?
/********************************************************
	lang/pl/folders.inc
	(C)2002 Marcin Piliszczuk <marti@net26.pl>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html

********************************************************/

	echo "<p><b>Foldery</b>\n";
	echo "<br>[<a href=\"edit_folders.php?user=".$user."\" target=\"list2\">Zarz±dzanie folderami</a>]";
	echo "<br><br>";

	$sentbox=$my_prefs["sent_box_name"];
	$trashname=$my_prefs["trash_name"];
	$defaults=array(
		"INBOX" =>"Skrzynka odbiorcza",
		$sentbox =>"Wys³ane",
		$trashname =>"Kosz",
	);
?>