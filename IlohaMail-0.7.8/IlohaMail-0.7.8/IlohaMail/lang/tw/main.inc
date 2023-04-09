<?
/********************************************************
	lang/tw/main.inc
	(C)2001-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>
	Traditional Chinese (BIG5), for use in Taiwan, 
	Hong Kong, and Overseas Chinese communities
	Translator: Danny Lin <danny@groopie.com>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html

********************************************************/

function formatStatusString($num, $folder, $type){
	$str="";
	if ($type=="delete"){
		$str = "刪除 $num 封信件".($num>1?"":"");
	}else if ($type == "move"){
		$str = "搬移 $num 封信件".($num>1?"":"")." 至 $folder";
	}
	
	return $str;
}

$mainStrings=array(
	0=>"閱讀：第 %p 封/共 %n 封",
	1=>" 封信件",
	2=>"上一封",
	3=>" 封",
	4=>"下一封",
	5=>" 封",
	6=>"信件主旨",
	7=>"收信人",
	8=>"發信人",
	9=>"日期",
	10=>"刪除",
	11=>"清空垃圾筒",
	12=>"檔案",
	13=>"搜尋",
	14=>"大小",
	15=>"未命名",
	16=>"顯示",
	17=>"檢查新信",
	18=>"刪除所有",
	19=>"取消"
);

$mainErrors=array(
	0=>"此信件匣中沒有任何信件。",
	1=>"此信件匣中沒有任何信件。",
	2=>"無法搬移信件至垃圾筒。",
	3=>"無法標記信件為已刪除。",
	4=>"無法搬移信件。",
    5=>"尚未指定垃圾筒。",
	6=>"無法清空垃圾筒。",
	7=>"你確定要刪除所有在 %f 中的信件？"
);


?>