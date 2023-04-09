<?
/********************************************************
	lang/eng/main.inc
	(C)2001-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html

********************************************************/

function formatStatusString($num, $folder, $type){
	$str="";
	if ($type=="delete"){
		$str = "Delete $num message".($num>1?"s":"");
	}else if ($type == "move"){
		$str = "Moved $num message".($num>1?"s":"")." to $folder";
	}
	
	return $str;
}

$mainStrings=array(
	0=>"Showing %p of %n",
	1=>" messages found",
	2=>"Previous",
	3=>" msgs",
	4=>"Next",
	5=>" msgs",
	6=>"Subject",
	7=>"To",
	8=>"From",
	9=>"Date",
	10=>"Delete",
	11=>"Empty Trash",
	12=>"File",
	13=>"Search",
	14=>"Size",
	15=>"untitled",
	16=>"Show",
	17=>"Check New",
	18=>"Delete All",
	19=>"Cancel"
);

$mainErrors=array(
	0=>"No messages found in this folder",
	1=>"No messages in this folder",
	2=>"Couldn't move messages to trash.",
	3=>"Couldn't flag messages as deleted.",
	4=>"Couldn't move messages.",
    5=>"Trash folder not specified.",
	6=>"Couldn't empty trash",
	7=>"Are you sure you want to delete ALL messages in %f?"
);


?>