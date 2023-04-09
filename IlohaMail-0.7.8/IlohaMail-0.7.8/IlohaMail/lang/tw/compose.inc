<?
/********************************************************
	lang/tw/compose.inc
	(C)2001-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>
	Traditional Chinese (BIG5), for use in Taiwan, 
	Hong Kong, and Overseas Chinese communities
	Translator: Danny Lin <danny@groopie.com>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html

********************************************************/

$composeHStrings=array(
	0=>"主旨",
	1=>"發信人",
	2=>"收信人",
	3=>"副本",
	4=>"密件副本",
	5=>"日期"
);

$composeStrings=array(
	0=>"寫信",
	1=>"寄信",
	2=>"上傳",
	3=>"加上簽名檔",
	4=>"附件",
	5=>"顯示通訊錄",
	6=>"隱藏通訊錄",
	7=>"信件本文：",
	8=>"新增",
	9=>"在 %d 的來信中，%s 提及：\n",
	10=>"--- 原始信件內容 ---\n",
	11=>"關閉本視窗"
);

$composeErrors=array(
	0=>"您忘記填寫信件主旨了，請填上主旨，或點按「".$composeStrings[1]."」再傳送一次。",
	1=>"您忘記填寫發信人欄位了。請指定一個發信人信箱。",
	2=>"您忘記填寫收信人欄位了。請指定一個收信人信箱。",
	3=>"上傳失敗",
	4=>"系統並未新增任何檔案。",
    5=>"為了防杜惡意散發垃圾信件，你只能每隔 %3 秒鐘對 %1 位收信人（每次 %2 封）遞送一次信件。"
);
?>