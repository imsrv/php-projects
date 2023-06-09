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
		$str = "$num message(s) supprim�(s) ".($num>1?"":"");
	}else if ($type == "move"){
		$str = "$num message(s) transf�r�(s) ".($num>1?"":"")." dans $folder";
	}
	
	return $str;
}

$mainStrings=array(
	0=>"%p de %n affich�(s)",
	1=>" messages trouv�s",
	2=>"<-- ",
	3=>" mess. pr�c�dents",
	4=>"",
	5=>" mess. suivants-->",
	6=>"Sujet",
	7=>"�",
	8=>"Exp�diteur",
	9=>"Date",
	10=>"Supprimer",
	11=>"Vider la corbeille",
	12=>"Transf�rer",
	13=>"Recherche",
	14=>"Taille",
	15=>"Sans titre",
	16=>"Afficher",
	17=>"Lev�e du courrier",
        18=>"Supprimer tout",
        19=>"Annuler"
);

$mainErrors=array(
	0=>"Aucun message n'a �t� trouv� dans ce dossier.",
	1=>"Aucun message dans ce dossier",
	2=>"Incapable de mettre ce massage dans la corbeille.",
	3=>"Incapable de changer le statut des messages � supprimer.",
	4=>"Incapable de d�placer les messages.",
    	5=>"Le dossier servant � la corbeille n'a pas �t� sp�cifi�.",
	6=>"Incapable de vider la corbeille",
	7=>"Supprimer tous les messages dans %f?  "
);
?>
