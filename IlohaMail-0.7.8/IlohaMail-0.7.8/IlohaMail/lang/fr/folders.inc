<?
/********************************************************
	lang/fr/folders.inc
	(C) 1999-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html
********************************************************/
	echo "<p><b>Dossiers</b>\n";
	echo "<br>[<a href=\"edit_folders.php?user=".$user."\" target=\"list2\">G�rer les dossiers</a>]";
	echo "<br><br>";

	$sentbox=$my_prefs["sent_box_name"];
	$trashname=$my_prefs["trash_name"];
	$defaults=array(
		"INBOX" =>"Bo�te de r�ception",
		$sentbox =>"Messages envoy�s",
		$trashname =>"Corbeille",
	);
?>
