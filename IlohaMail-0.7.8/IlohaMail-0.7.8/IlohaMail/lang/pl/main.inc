<?
/********************************************************
	lang/pl/main.inc
	(C)2002 Marcin Piliszczuk <marti@net26.pl>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html

********************************************************/

function formatStatusString($num, $folder, $type){
	$str="";
	if ($type=="delete"){
		$str = "Usuniêto $num wiadomo¶".($num>1?"ci":"æ");
	}else if ($type == "move"){
		$str = "Przeniesiono $num wiadomo¶".($num>1?"ci":"æ")." do $folder";
	}
	
	return $str;
}

$mainStrings=array(
	0=>"Wy¶wietlonych %p z %n wiadomo¶ci",
	1=>" wiadomo¶ci",
	2=>"Poprzednia",
	3=>" wiad.",
	4=>"Nastêpna",
	5=>" wiad.",
	6=>"Temat",
	7=>"Do",
	8=>"Od",
	9=>"Data",
	10=>"Usuñ",
	11=>"Opró¿nij kosz",
	12=>"Plik",
	13=>"Szukaj",
	14=>"Rozmiar",
	15=>"bez tytu³u",
	16=>"Poka¿",
	17=>"Pobierz nowe",
	18=>"Usuñ wszystkie",
	19=>"Anuluj"
);

$mainErrors=array(
	0=>"Brak wiadomo¶ci w tym folderze",
	1=>"Brak wiadomo¶ci.",
	2=>"Nie mo¿na przenieœæ wiadomo¶ci do kosza.",
	3=>"Nie mo¿na oznaczyæ wiadomo¶ci jako usuniêtych.",
	4=>"Nie mo¿na przenieœæ wiadomoœci.",
    	5=>"Nie okre¶lono folderu dla kosza.",
	6=>"Nie mo¿na opró¿niæ kosza",
	7=>"Czy na pewno chcesz usun±æ WSZYSTKIE wiadomo¶ci w %f?"
);


?>