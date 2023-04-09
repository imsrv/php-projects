<?
/********************************************************
	lang/it/main.inc
	
	Italian Translation by Amos B. <mriya3@surfeu.ch>
	Original english file (C)2001-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html

********************************************************/

function formatStatusString($num, $folder, $type){
	$str="";
	if ($type=="delete"){
		$str = "$num message eliminat".($num>1?"i":"o");
	}else if ($type == "move"){
		$str = "$num spostat".($num>1?"i":"o")." in $folder";
	}
	
	return $str;
}

$mainStrings=array(
	0=>" %p di %n visualizzato/i",
	1=>" messaggi trovati",
	2=>"<-- ",
	3=>" mess. precedenti",
	4=>"",
	5=>" mess. successivi-->",
	6=>"Concerne",
	7=>"A",
	8=>"Da",
	9=>"Data",
	10=>"Elimina",
	11=>"Svuota cestino",
	12=>"Sposta",
	13=>"Cerca",
	14=>"Dimensione",
	15=>"senza nome",
	16=>"Visualizza",
	17=>"Controlla nuova",
	18=>"Cancella tutti",
	19=>"Cancella"
);

$mainErrors=array(
	0=>"Nessun messaggio trovato in questa cartella",
	1=>"Nessun messaggio in questa cartella",
	2=>"Impossibile spostare nel cestino.",
	3=>"Impossibile marcare messaggi come cancellati.",
	4=>"Impossibile muovere messaggi.",
        5=>"Cartella per il Cestino non specificata.",
	6=>"Impossibile svuotare il cestino",
	7=>"Sei sicuro di voler cancellare TUTTI i messaggi di %f?"
);


?>