<?
/********************************************************
	lang/eng/compose.inc
	(C)2001-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html

********************************************************/

$composeHStrings=array(
	0=>"Betreff",
	1=>"Von",
	2=>"An",
	3=>"CC",
	4=>"BCC",
	5=>"Datum"
);

$composeStrings=array(
	0=>"Neue Nachricht",
	1=>"Nachricht senden",
	2=>"Datei schicken",
	3=>"Unterschrift hinzu",
	4=>"Anhang",
	5=>"Kontakte zeigen",
	6=>"Kontakte ausblenden",
	7=>"Text der Nachricht:",
	8=>"Hinzu",
	9=>"%s schrieb am %d:\n",
	10=>"--- Urspruengliche Nachricht ---\n",
	11=>"Fenster schliessen"
);

$composeErrors=array(
	0=>"Das Betreff-Feld ist leer.  Bitte geben Sie einen Betreff ein oder clicken Sie auf \"".$composeStrings[1]."\", um die Nachricht so zu senden.",
	1=>"Das Absenderfeld ist leer.  Bitte geben Sie Ihre E-mail-Adresse ein.",
	2=>"Das Empf&auml;nger-Adressfeld ist leer.  Bitte geben Sie die E-mail-Adresse des Empf&auml;ngers ein.",
	3=>"Schicken der Datei fehlgeschlagen",
	4=>"Keine Datei(en) empfangen.",
    5=>"Um Missbrauch (SPAM) zu verhindern, darf die Nachricht nur an %1 Empf&auml;nger (insgesamt %2 pro Sitzung) alle %3 Sekunden verschickt werden."
);
?>)