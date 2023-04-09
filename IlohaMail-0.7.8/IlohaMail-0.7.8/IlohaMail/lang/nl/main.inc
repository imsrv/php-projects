<?
/********************************************************
	lang/nl/main.inc
	(C) 1999-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html

********************************************************/

function formatStatusString($num, $folder, $type){
	$str="";
	if ($type=="delete"){
		$str = "$num bericht".($num>1?"en":"")." verwijderd.";
	}else if ($type == "move"){
		$str = "$num bericht".($num>1?"en":"")." verplaatst naar $folder.";
	}
	
	return $str;
}

$mainStrings=array(
	0=>"%p van %n berichten",
	1=>" berichten gevonden",
	2=>"Vorige",
	3=>"",
	4=>"Volgende",
	5=>"",
	6=>"Onderwerp",
	7=>"Aan",
	8=>"Afzender",
	9=>"Ontvangen",
	10=>"Verwijder",
	11=>"Leeg prullenbak",
	12=>"Verplaats",
	13=>"Zoek",
	14=>"Grootte",
	15=>"Geen onderwerp",
	16=>"Laat zien",
	17=>"Controleer op nieuwe berichten",
	18=>"Verwijder alle berichten",
	19=>"Annuleren"
);

$mainErrors=array(
	0=>"Geen berichten gevonden in deze map.",
	1=>"Geen berichten deze map.",
	2=>"Kon de berichten niet naar de prullenbak verplaatsen.",
	3=>"Kon de berichten niet markeren als \"verwijderd\".",
	4=>"Kon de berichten niet verplaatsten.",
	5=>"Geen prullenbak opgegeven.",
	6=>"Kon de prullenbak niet legen.",
	7=>"Weet je zeker dat je ALLE berichten in %f wilt verwijderen?"
);
?>