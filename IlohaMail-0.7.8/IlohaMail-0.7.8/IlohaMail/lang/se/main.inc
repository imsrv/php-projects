<?
/********************************************************
	lang/se/main.inc
	(C)2001-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html

	Translated by Markus Svensson <markus.svensson@linux.nu>

********************************************************/

function formatStatusString($num, $folder, $type){
	$str="";
	if ($type=="delete"){
		$str = "Ta bort $num meddelande".($num>1?"s":"");
	}else if ($type == "move"){
		$str = "Flyttade $num meddelande".($num>1?"s":"")." till $folder";
	}
	
	return $str;
}

$mainStrings=array(
	0=>"Visar %p av %n",
	1=>" meddelande funna",
	2=>"förra",
	3=>" med.",
	4=>"Nästa",
	5=>" med.",
	6=>"Ämne",
	7=>"Till",
	8=>"Från",
	9=>"Datum",
	10=>"Ta bort",
	11=>"Töm Skräp",
	12=>"Fil",
	13=>"Sök",
	14=>"Storlek",
	15=>"namnlös",
	16=>"Visa",
	17=>"Titta efter ny",
	18=>"Ta bort alla",
	19=>"Avbryt"
);

$mainErrors=array(
	0=>"Inga meddelande hittade i denna mapp",
	1=>"Inga meddelande i denna mapp",
	2=>"Kunde inte flytta meddelanden till skräpmappen.",
	3=>"Kunde inte markera meddelanden som raderade.",
	4=>"Kunde inte flytta meddelanden.",
    5=>"Skräp-mapp ej angiven.",
	6=>"Kunde inte tömma skräpmappen",
	7=>"Är du säker på att du vill ta bort ALLA meddelanden i %f?"
);


?>