<?
/********************************************************
	lang/cn/main.inc
	(C)2001-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>
	Simplified Chinese (GB2312), for use in China, 
	Singapore & Malaysia Chinese communities
	Translator: Danny Lin <danny@groopie.com>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html

********************************************************/

function formatStatusString($num, $folder, $type){
	$str="";
	if ($type=="delete"){
		$str = "删除 $num 封邮件".($num>1?"":"");
	}else if ($type == "move"){
		$str = "搬移 $num 封邮件".($num>1?"":"")." 至 $folder";
	}
	
	return $str;
}

$mainStrings=array(
	0=>"阅读：第 %p 封/共 %n 封",
	1=>" 封邮件",
	2=>"上一封",
	3=>" 封",
	4=>"下一封",
	5=>" 封",
	6=>"邮件主旨",
	7=>"收信人",
	8=>"发信人",
	9=>"日期",
	10=>"删除",
	11=>"清空垃圾筒",
	12=>"文件",
	13=>"查找",
	14=>"大小",
	15=>"未命名",
	16=>"显示",
	17=>"检查新邮件",
	18=>"删除所有",
	19=>"取消"
);

$mainErrors=array(
	0=>"此信件箱中没有任何邮件。",
	1=>"此信件箱中没有任何邮件。",
	2=>"无法搬移邮件至垃圾筒。",
	3=>"无法标记邮件为已删除。",
	4=>"无法搬移邮件。",
    5=>"尚未指定垃圾筒。",
	6=>"无法清空垃圾筒。",
	7=>"你确实要删除所有在 %f 中的邮件？"
);


?>
