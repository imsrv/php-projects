<?
/********************************************************
	lang/pl/compose.inc
	(C) 2002 Marcin Piliszczuk <marti@net26.pl>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html

********************************************************/

$composeHStrings=array(
	0=>"Temat",
	1=>"Od",
	2=>"Do",
	3=>"DW",
	4=>"UDW",
	5=>"Data"
);

$composeStrings=array(
	0=>"Nowa wiadomo¶æ",
	1=>"Wy¶lij wiadomo¶æ",
	2=>"Za³±cz",
	3=>"Wstaw sygnaturê",
	4=>"Zal±cznik",
	5=>"Poka¿ ksi±¿kê adresow±",
	6=>"Ukryj ksi±¿kê adresow±",
	7=>"Tre¶æ wiadomo¶ci:",
	8=>"Dodaj",
	9=>"%d, %s napisa³/a:\n",
	10=>"--- Tre¶æ Orygina³u ---\n",
	11=>"Zamknij Okno"
);

$composeErrors=array(
	0=>"Pole tematu jest puste. Proszê podaæ temat lub nacisn±æ \"".$composeStrings[1]."\" ponownie by wys³aæ wiadomo¶æ.",
	1=>"Pole \"Od\" jest puste.  Proszê wprowadziæ swój adres e-mailowy.",
	2=>"Pole \"Do\" jest puste.  Proszê okreœliæ adres odbiorcy.",
	3=>"Dodanie za³±cznika nie powiod³o siê.",
	4=>"Nie otrzymano ¿adnych plików.",
    5=>"Z powodu ochrony przed za¶miecaniem, mo¿esz wys³aæ wiadomo¶æ do %1 osób/osoby (%2 w trakcie ca³ej sesji) co %3 sekund."
);
?>