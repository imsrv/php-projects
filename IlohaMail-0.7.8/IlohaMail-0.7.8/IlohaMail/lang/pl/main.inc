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
		$str = "Usuni�to $num wiadomo�".($num>1?"ci":"�");
	}else if ($type == "move"){
		$str = "Przeniesiono $num wiadomo�".($num>1?"ci":"�")." do $folder";
	}
	
	return $str;
}

$mainStrings=array(
	0=>"Wy�wietlonych %p z %n wiadomo�ci",
	1=>" wiadomo�ci",
	2=>"Poprzednia",
	3=>" wiad.",
	4=>"Nast�pna",
	5=>" wiad.",
	6=>"Temat",
	7=>"Do",
	8=>"Od",
	9=>"Data",
	10=>"Usu�",
	11=>"Opr�nij kosz",
	12=>"Plik",
	13=>"Szukaj",
	14=>"Rozmiar",
	15=>"bez tytu�u",
	16=>"Poka�",
	17=>"Pobierz nowe",
	18=>"Usu� wszystkie",
	19=>"Anuluj"
);

$mainErrors=array(
	0=>"Brak wiadomo�ci w tym folderze",
	1=>"Brak wiadomo�ci.",
	2=>"Nie mo�na przenie�� wiadomo�ci do kosza.",
	3=>"Nie mo�na oznaczy� wiadomo�ci jako usuni�tych.",
	4=>"Nie mo�na przenie�� wiadomo�ci.",
    	5=>"Nie okre�lono folderu dla kosza.",
	6=>"Nie mo�na opr�ni� kosza",
	7=>"Czy na pewno chcesz usun�� WSZYSTKIE wiadomo�ci w %f?"
);


?>