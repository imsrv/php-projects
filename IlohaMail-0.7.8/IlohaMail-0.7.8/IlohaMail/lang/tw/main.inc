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
		$str = "�R�� $num �ʫH��".($num>1?"":"");
	}else if ($type == "move"){
		$str = "�h�� $num �ʫH��".($num>1?"":"")." �� $folder";
	}
	
	return $str;
}

$mainStrings=array(
	0=>"�\Ū�G�� %p ��/�@ %n ��",
	1=>" �ʫH��",
	2=>"�W�@��",
	3=>" ��",
	4=>"�U�@��",
	5=>" ��",
	6=>"�H��D��",
	7=>"���H�H",
	8=>"�o�H�H",
	9=>"���",
	10=>"�R��",
	11=>"�M�ũU����",
	12=>"�ɮ�",
	13=>"�j�M",
	14=>"�j�p",
	15=>"���R�W",
	16=>"���",
	17=>"�ˬd�s�H",
	18=>"�R���Ҧ�",
	19=>"����"
);

$mainErrors=array(
	0=>"���H��X���S������H��C",
	1=>"���H��X���S������H��C",
	2=>"�L�k�h���H��ܩU�����C",
	3=>"�L�k�аO�H�󬰤w�R���C",
	4=>"�L�k�h���H��C",
    5=>"�|�����w�U�����C",
	6=>"�L�k�M�ũU�����C",
	7=>"�A�T�w�n�R���Ҧ��b %f �����H��H"
);


?>