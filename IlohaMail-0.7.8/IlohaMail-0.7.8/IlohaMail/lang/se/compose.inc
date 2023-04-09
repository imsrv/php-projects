<?
/********************************************************
	lang/se/compose.inc
	(C)2001-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html

	Translated by Markus Svensson <markus.svensson@linux.nu>

********************************************************/

$composeHStrings=array(
	0=>"Ämne",
	1=>"Från",
	2=>"Till",
	3=>"Kopia",
	4=>"Hemlig kopia",
	5=>"Datum"
);

$composeStrings=array(
	0=>"Skriv Meddelande",
	1=>"Skicka Meddelande",
	2=>"Ladda up",
	3=>"Bifoga Signatur",
	4=>"Bifoga",
	5=>"Visa kontakter",
	6=>"Göm kontakter",
	7=>"Meddelande:",
	8=>"Lägg till",
	9=>"Den %d, skrev %s:\n",
	10=>"--- Ursprungligt meddelande ---\n",
	11=>"Stäng fönster"
);

$composeErrors=array(
	0=>"Ämnesfältet är tomt. Skriv in ett ämne, eller klicka på \"".$composeStrings[1]."\" igen för att skicka.",
	1=>"\"Från\" fältet är tomt.  Skriv in din email adress.",
	2=>"\"Till\" fältet är tomt.  Ange mottagare.",
	3=>"Uppladdningen misslyckades",
	4=>"Inga filer mottagna.",
    5=>"För att motverka spam, kan du bara skicka till %1 mottagare (%2 totalt per session) var %3 sekund."
);
?>