<?
// module de cr�ation de la base de donn�e et des tables si elles n'existent pas
$sql="CREATE DATABASE IF NOT EXISTS $DBName";
  $res=mysql_query($sql)or die("Echec cr�ation Base de donn�es $DBName.");
// connection base
$db = @mysql_select_db($DBName, $connection) 
    or die("Couldn't select database."); 
//cr�ation des tables de l'application
	// Cr�ation de la table des utilisateurs
		$sql2="CREATE TABLE IF NOT EXISTS $t_equipe (
  		Id_equipe bigint(20) NOT NULL auto_increment,
  		nom varchar(30) default NULL,
  		prenom varchar(30) default NULL,
  		login varchar(15) NOT NULL default '',
  		password varchar(15) NOT NULL default '',
  		date varchar(30) default NULL,
		heure varchar(30) default NULL,
		level bigint(20) NOT NULL default '0',
		ent varchar(20) default NULL, 
  		PRIMARY KEY  (Id_equipe))";	
		$res2=mysql_query($sql2)or die("Echec cr�ation table $t_equipe.");
	//echo "<font color='red'>$mess[19] user demo password demo</font><br>\n";	
		//Cr�ation de la table competence
		$sql2="CREATE TABLE IF NOT EXISTS $t_competence (
  		Id_competence bigint(20) NOT NULL auto_increment,
  		ce_domaine bigint(20) NOT NULL default '0',
  		competence varchar(30) NOT NULL default '',
  		ce_niveau bigint(20) NOT NULL default '0',
  		description varchar(100) NOT NULL default '',
  		PRIMARY KEY  (Id_competence))";
		$res2=mysql_query($sql2)or die("Echec cr�ation table $t_competence.");
  //echo "<font color='red'>$mess[19] $t_competence</font><br>\n";		
		//Cr�ation de la table domaine
		$sql2="CREATE TABLE IF NOT EXISTS $t_domaine (
  		Id_domaine bigint(20) NOT NULL auto_increment,
  		ce_phase bigint(20) NOT NULL default '0',
 		 Domaine varchar(60) NOT NULL default '',
  		PRIMARY KEY  (Id_domaine))";
		$res2=mysql_query($sql2)or die("Echec cr�ation table $t_domaine.");
  //echo "<font color='red'>$mess[19] $t_domaine</font><br>\n";
		//Cr�ation de la table eva_comp
		$sql2="CREATE TABLE IF NOT EXISTS $t_eva_comp (
  		Id_eva_comp bigint(20) NOT NULL auto_increment,
  		ce_evaluation bigint(20) NOT NULL default '0',
  		ce_competence bigint(20) NOT NULL default '0',
  		niveau varchar(30) default '0',
  		type varchar(30) default NULL,
  		PRIMARY KEY  (Id_eva_comp))";
		$res2=mysql_query($sql2)or die("Echec cr�ation table $t_eva_comp.");
  //echo "<font color='red'>$mess[19] $t_eva_comp</font><br>\n";
		//Cr�ation de la table evaluation
		$sql2="CREATE TABLE IF NOT EXISTS $t_evaluation (
  		Id_evaluation bigint(20) NOT NULL auto_increment,
  		ce_equipe bigint(20) NOT NULL default '0',
  		Date_evaluation date NOT NULL default '0000-00-00',
  		Type varchar(30) NOT NULL default '',
  		PRIMARY KEY  (Id_evaluation))";
		$res2=mysql_query($sql2)or die("Echec cr�ation table $t_evaluation.");
  //echo "<font color='red'>$mess[19] $t_evaluation</font><br>\n";
		//Cr�ation de la table niveau
		$sql2="CREATE TABLE IF NOT EXISTS $t_niveau (
  		Id_niveau bigint(20) NOT NULL auto_increment,
  		Niveau varchar(60) NOT NULL default '',
  		Description varchar(100) NOT NULL default '',
  		PRIMARY KEY  (Id_niveau))";
		$res2=mysql_query($sql2)or die("Echec cr�ation table $t_niveau.");
  //echo "<font color='red'>$mess[19] $t_niveau</font><br>\n";
		//Cr�ation de la table phase
		$sql2="CREATE TABLE IF NOT EXISTS $t_phase (
  		Id_phase bigint(20) NOT NULL auto_increment,
  		Phase varchar(60) NOT NULL default '',
  		PRIMARY KEY  (Id_phase))";
		 $res2=mysql_query($sql2)or die("Echec cr�ation table $t_phase.");
  //echo "<font color='red'>$mess[19] $t_phase</font></center><br>\n";
?>

