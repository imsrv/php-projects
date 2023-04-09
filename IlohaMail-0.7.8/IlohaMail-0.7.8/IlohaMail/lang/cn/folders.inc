<?
/********************************************************
	lang/cn/folders.inc
	(C)2001-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>
	Simplified Chinese (GB2312), for use in China, 
	Singapore & Malaysia Chinese communities
	Translator: Danny Lin <danny@groopie.com>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html

********************************************************/

	echo "<p><b>信件箱一览</b>\n";
	echo "<br>[<a href=\"edit_folders.php?user=".$user."\" target=\"list2\">信件箱管理</a>]";
	echo "<br><br>";

	$sentbox=$my_prefs["sent_box_name"];
	$trashname=$my_prefs["trash_name"];
	$defaults=array(
		"INBOX" =>"收件匣",
		$sentbox =>"寄件备份匣",
		$trashname =>"垃圾筒",
	);
?>
