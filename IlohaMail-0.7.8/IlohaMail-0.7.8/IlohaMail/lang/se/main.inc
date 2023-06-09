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
	2=>"f�rra",
	3=>" med.",
	4=>"N�sta",
	5=>" med.",
	6=>"�mne",
	7=>"Till",
	8=>"Fr�n",
	9=>"Datum",
	10=>"Ta bort",
	11=>"T�m Skr�p",
	12=>"Fil",
	13=>"S�k",
	14=>"Storlek",
	15=>"namnl�s",
	16=>"Visa",
	17=>"Titta efter ny",
	18=>"Ta bort alla",
	19=>"Avbryt"
);

$mainErrors=array(
	0=>"Inga meddelande hittade i denna mapp",
	1=>"Inga meddelande i denna mapp",
	2=>"Kunde inte flytta meddelanden till skr�pmappen.",
	3=>"Kunde inte markera meddelanden som raderade.",
	4=>"Kunde inte flytta meddelanden.",
    5=>"Skr�p-mapp ej angiven.",
	6=>"Kunde inte t�mma skr�pmappen",
	7=>"�r du s�ker p� att du vill ta bort ALLA meddelanden i %f?"
);


?>