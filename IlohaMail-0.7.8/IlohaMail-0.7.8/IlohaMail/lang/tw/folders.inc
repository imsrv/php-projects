<?
/********************************************************
	lang/tw/folders.inc
	(C)2001-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>
	Traditional Chinese (BIG5), for use in Taiwan, 
	Hong Kong, and Overseas Chinese communities
	Translator: Danny Lin <danny@groopie.com>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html

********************************************************/

	echo "<p><b>信件匣一覽</b>\n";
	echo "<br>[<a href=\"edit_folders.php?user=".$user."\" target=\"list2\">信件匣管理</a>]";
	echo "<br><br>";

	$sentbox=$my_prefs["sent_box_name"];
	$trashname=$my_prefs["trash_name"];
	$defaults=array(
		"INBOX" =>"收件匣",
		$sentbox =>"寄件備份匣",
		$trashname =>"垃圾筒",
	);
?>