<?
//---------------------------------------------------------------------------------------------------
//							
//	fdrouin -  Competence v1.4
//	
//	Francis DROUIN
//	http://fdrouin.free.fr
//	fdrouin@free.fr	
//
//---------------------------------------------------------------------------------------------------

//-----------------------------------------------------------------------------------------------------------------------------------------
//	VARIABLES A MODIFIER
//	(VARS TO MODIFY)
//-----------------------------------------------------------------------------------------------------------------------------------------

// LANGUE PAR DEFAUT (DEFAULT LANGUAGE)
// French : fr
// English : en 

$dft_langue="fr";

// PAGES D'ENTETE ET DE BAS DE PAGE
// (header and footer files )

$hautpage="include/haut.htm";
$baspage="include/bas.htm";

/* Informations sur la base de donnée */
$DBHost="LocalHost";
$DBUser="root";
$DBPass="";
$DBName="competence";
 /* administrateur pré défini  */
 $admlogin ="sadmin";  //non utilisé si plusieurs entités
 $admpass ="sadmin";

function DBInfo($lg) {
global $DBHost,$DBUser,$DBPass,$DBName,$labniv;
global $t_equipe, $t_evaluation, $t_phase, $t_domaine, $t_niveau, $t_competence, $t_eva_comp;
// nb de niveaux gérés  **modifié pour afficher un libellé dans Listeval
global $nivmax;
     $nivmax = 5;
// Nom des tables utilisées fonction de la langue
$t_equipe ="equipe_".$lg;
$t_evaluation="evaluation_".$lg;
$t_phase="phase_".$lg;
$t_domaine="domaine_".$lg;
$t_niveau="niveau";
$t_competence="competence_".$lg;
$t_eva_comp="eva_comp_".$lg;
}
?>
