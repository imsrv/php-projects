<?
/********************************************************
	lang/cn/compose.inc
	(C)2001-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>
	Simplified Chinese (GB2312), for use in China, 
	Singapore & Malaysia Chinese communities
	Translator: Danny Lin <danny@groopie.com>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html

********************************************************/

$composeHStrings=array(
	0=>"主旨",
	1=>"发信人",
	2=>"收信人",
	3=>"副本",
	4=>"密件副本",
	5=>"日期"
);

$composeStrings=array(
	0=>"写信",
	1=>"寄信",
	2=>"上传",
	3=>"加上签名档",
	4=>"附件",
	5=>"显示地址簿",
	6=>"隐藏地址簿",
	7=>"邮件本文：",
	8=>"新建",
	9=>"在 %d 的来信中，%s 提及：\n",
	10=>"--- 原始邮件内容 ---\n",
	11=>"关闭本窗口"
);

$composeErrors=array(
	0=>"您忘记填写邮件主旨了，请填上主旨，或点按“".$composeStrings[1]."”再发送一次。",
	1=>"您忘记填写发信人区域了。请指定一个发信人邮箱。",
	2=>"您忘记填写收信人区域了。请指定一个收信人邮箱。",
	3=>"上传失败",
	4=>"系统并未新建任何文件。",
    5=>"为了防杜恶意散发垃圾邮件，你只能每隔 %3 秒钟对 %1 位收信人（每次 %2 封）递送一次邮件。"
);
?>
