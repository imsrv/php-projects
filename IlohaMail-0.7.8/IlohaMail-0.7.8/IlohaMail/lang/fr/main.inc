<?
/********************************************************
	lang/fr/main.inc
	(C) 1999-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html

********************************************************/

function formatStatusString($num, $folder, $type){
	$str="";
	if ($type=="delete"){
		$str = "$num message(s) supprimé(s) ".($num>1?"":"");
	}else if ($type == "move"){
		$str = "$num message(s) transféré(s) ".($num>1?"":"")." dans $folder";
	}
	
	return $str;
}

$mainStrings=array(
	0=>"%p de %n affiché(s)",
	1=>" messages trouvés",
	2=>"<-- ",
	3=>" mess. précédents",
	4=>"",
	5=>" mess. suivants-->",
	6=>"Sujet",
	7=>"À",
	8=>"Expéditeur",
	9=>"Date",
	10=>"Supprimer",
	11=>"Vider la corbeille",
	12=>"Transférer",
	13=>"Recherche",
	14=>"Taille",
	15=>"Sans titre",
	16=>"Afficher",
	17=>"Levée du courrier",
        18=>"Supprimer tout",
        19=>"Annuler"
);

$mainErrors=array(
	0=>"Aucun message n'a été trouvé dans ce dossier.",
	1=>"Aucun message dans ce dossier",
	2=>"Incapable de mettre ce massage dans la corbeille.",
	3=>"Incapable de changer le statut des messages à supprimer.",
	4=>"Incapable de déplacer les messages.",
    	5=>"Le dossier servant à la corbeille n'a pas été spécifié.",
	6=>"Incapable de vider la corbeille",
	7=>"Supprimer tous les messages dans %f?  "
);
?>
