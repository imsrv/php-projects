<?
/********************************************************
	lang/nl/prefs.inc
	(C) 1999-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html

********************************************************/

$prefHeaderStrings = array(
			0=>"Opties",
			1=>"Algemeen",
			2=>"Kleuren"
);
											
$prefsStrings = array(
			"0.0" => "Identiteit",
				"0.1" => "Naam: ",
				"0.2" => "E-mail: ",
			"1.0" => "Internationaal",
				"1.1" => "Interface: ",
				"1.2" => "Karakter set: ",
				"1.3" => "Tijd zone: ",
			"2.0" => "Lijstweergave opties",
				"2.1" => "Toon maximaal ",
				"2.2" => " items",
				"2.3" => "Laat grootte zien.",
				"2.4" => "Sorteer op: ",
				"2.5" => "",
				"2.6" => "Sorteervolgorde: ",
				"2.7" => "",
				"2.8" => "Laat mappenlijst zien.",
			"3.0" => "Automatisch-opslaan opties",
				"3.1" => "Sla verstuurde berichten op.",
				"3.2"=> "Sla verstuurde berichten op in deze map: ",
				"3.3" => "",
				"3.4" => "Automatisch prullenbak legen.",
				"3.5" => "Verplaats verwijderde berichten naar deze map: ",
				"3.6" => "",
				"3.7" => "Mappenpad: ",
				"3.8" => "Anders",
			"4.0" => "Berichtweergave opties",
				"4.1" => "Toon berichten in een frame.",
				"4.2" => "Geef citaten een afwijkende kleur.",
				"4.3" => "(Dit aanzetten kan de server vertragen.)",
				"4.4" => "Zet adressen om naar links.",
				"4.5" => "Toon HTML berichten.",
				"4.6" => "Laat plaatjes in het bericht zien.",
			"5.0" => "Handtekening",
			 	"5.1" => "Voeg handtekening toe aan nieuwe berichten.",
				"5.2" => ""
);

$sort_fields=array("DATE"=>"Datum", "SUBJECT"=>"Onderwerp", "SIZE"=>"Omvang");
$sort_orders=array("ASC"=>"Oplopend", "DESC"=>"Aflopend");

$prefsButtonStrings = array(0=>"Verversen", 1=>"Toepassen", 2=>"Herstellen", 3=>"Standaard instellingen");

$prefs_new_user = "Het lijkt er op dat je je voor het eerst aanmeldt...welkom!<br>";
$prefs_new_user .= "Bekijk alsjebleift deze instellingen, en klik op \"Pas toe\".";
?>