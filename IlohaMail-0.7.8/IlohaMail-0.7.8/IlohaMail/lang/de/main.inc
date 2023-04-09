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
		$str = "L&ouml;sche $num Nachricht".($num>1?"en":"");
	}else if ($type == "move"){
		$str = "$num Nachricht".($num>1?"en":"")." in Ordner <I>$folder</I> verschoben";
	}
	
	return $str;
}

$mainStrings=array(
	0=>"%p von insgesamt %n Nachrichten",
	1=>" Nachrichten gefunden",
	2=>"Vorhergehende",
	3=>" Nachrichten",
	4=>"N&auml;chste",
	5=>" Nachrichten",
	6=>"Betreff",
	7=>"An",
	8=>"Absender",
	9=>"Datum",
	10=>"L&ouml;schen",
	11=>"Papierkorb leeren",
	12=>"Verschieben",
	13=>"Suche",
	14=>"Gr&ouml;&szlig;e",
	15=>"kein Titel",
	16=>"Anzeigen",
	17=>"Neue empfangen",
	18=>"Alle l&ouml;schen",
	19=>"Abbrechen"
);

$mainErrors=array(
	0=>"Keine Nachrichten in diesem Ordner gefunden",
	1=>"Keine Nachrichten in diesem Ordner",
	2=>"Nachrichten konnten nicht in Papierkorb verschoben werden.",
	3=>"Nachrichten konnten nicht als gel&ouml;scht markiert werden.",
	4=>"Nachrichten konnten nicht verschoben werden.",
	5=>"Ordner f&uuml Papierkorb nicht angegeben.",
	6=>"Papierkorb konnte nicht geleert werden",
	7=>"Wollen Sie wirklich ALLE Nachrichten in %f l”schen?"
);


?>)