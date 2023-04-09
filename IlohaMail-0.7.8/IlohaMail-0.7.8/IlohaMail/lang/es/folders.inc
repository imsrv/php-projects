<?
/********************************************************
	lang/es/folders.inc
	(C)2001-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html

********************************************************/

	echo "<p><b>Carpetas</b>\n";
	echo "<br>[<a href=\"edit_folders.php?user=".$user."\" target=\"list2\">Administrar Carpetas</a>]";
	echo "<br><br>";

	$sentbox=$my_prefs["sent_box_name"];
	$trashname=$my_prefs["trash_name"];
	$defaults=array(
		"INBOX" =>"Bandeja de Entrada",
		$sentbox =>"Enviados",
		$trashname =>"Basura",
	);
?>
