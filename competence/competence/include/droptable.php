<?
// module de suppression des tables
	// Drop de la table des utilisateurs
		$sql="DROP TABLE IF EXISTS $t_equipe";
		$res=mysql_query($sql)or die("Echec suppression table $t_equipe.");
		//Drop de la table competence
		$sql="DROP TABLE IF EXISTS $t_competence";
		$res=mysql_query($sql)or die("Echec suppression table $t_competence.");
		//Drop et création de la table domaine
		$sql="DROP TABLE IF EXISTS $t_domaine";
		$res=mysql_query($sql)or die("Echec suppression table $t_domaine.");
		//Drop de la table eva_comp
		$sql="DROP TABLE IF EXISTS $t_eva_comp";
		$res=mysql_query($sql)or die("Echec suppression table $t_eva_comp.");
		//Drop et création de la table evaluation
		$sql="DROP TABLE IF EXISTS $t_evaluation";
		$res=mysql_query($sql)or die("Echec suppression table $t_evaluation.");
		//Drop et création de la table niveau
		$sql="DROP TABLE IF EXISTS $t_niveau";
		$res=mysql_query($sql)or die("Echec suppression table $t_niveau.");
		//Drop et création de la table phase
		$sql="DROP TABLE IF EXISTS $t_phase";
		$res=mysql_query($sql)or die("Echec suppression table $t_phase.");
?>

