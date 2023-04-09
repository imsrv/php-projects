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
		$str = "ɾ�� $num ���ʼ�".($num>1?"":"");
	}else if ($type == "move"){
		$str = "���� $num ���ʼ�".($num>1?"":"")." �� $folder";
	}
	
	return $str;
}

$mainStrings=array(
	0=>"�Ķ����� %p ��/�� %n ��",
	1=>" ���ʼ�",
	2=>"��һ��",
	3=>" ��",
	4=>"��һ��",
	5=>" ��",
	6=>"�ʼ���ּ",
	7=>"������",
	8=>"������",
	9=>"����",
	10=>"ɾ��",
	11=>"�������Ͳ",
	12=>"�ļ�",
	13=>"����",
	14=>"��С",
	15=>"δ����",
	16=>"��ʾ",
	17=>"������ʼ�",
	18=>"ɾ������",
	19=>"ȡ��"
);

$mainErrors=array(
	0=>"���ż�����û���κ��ʼ���",
	1=>"���ż�����û���κ��ʼ���",
	2=>"�޷������ʼ�������Ͳ��",
	3=>"�޷�����ʼ�Ϊ��ɾ����",
	4=>"�޷������ʼ���",
    5=>"��δָ������Ͳ��",
	6=>"�޷��������Ͳ��",
	7=>"��ȷʵҪɾ�������� %f �е��ʼ���"
);


?>