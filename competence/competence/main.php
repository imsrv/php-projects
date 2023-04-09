<?
//---------------------------------------------------------------------------------------------------
//							
//	fdrouin -  Competence v1.1
//	
//	Francis DROUIN
//	http://fdrouin.free.fr
//	fdrouin@free.fr	
//
//---------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------------------------------
//	MAIN
//-----------------------------------------------------------------------------------------------------------------------------------------
/* gestion de session necessite PHP4  */
session_start();
$getvar=$_GET;
$postvar=$_POST;
//pour rendre le programe compatible PHP4
$iform=0;
while (list($key,$value)=each($_POST))
{  $iform=1;
${strval($key)}=$value;
//echo "***debug entrée main: $key, $value<br>\n";
}
if ($iform == 0) // on ne cherche que si rien dans la FORM
{
 	 while (list($key,$value)=each($_GET))
	 { 
	 ${strval($key)}=$value;
	 }
}
//declarer les constantes
 	 //table t_equipe
define("Id_equipe", 0);
define("nom", 1);
define("prenom", 2);
define("login", 3);
define("password", 4);
define("date", 5);
define("heure", 6);
define("level", 7);
	//table t_competence
define("Id_competence", 0);
define("ce_domaine", 1);
define("competence", 2);
define("ce_niveau", 3);
define("description", 4);
	//table t_domaine
define("Id_domaine", 0);
define("ce_phase", 1);
define("Domaine", 2);
	//table t_eva_comp
define("Id_eva_comp", 0);
define("ce_evaluation", 1);
define("ce_competence", 2);
define("niveau", 3);
define("type", 4);
	//table t_evaluation
define("Id_evaluation", 0);
define("ce_equipe", 1);
define("Date_evaluation", 2);
define("Type", 3);
	//table t_niveau
define("Id_niveau", 0);
define("Niveau", 1);
	//table t_phase
define("Id_phase", 0);
define("Phase", 1);
// restitution des variables globales de session dans variables locales
	$Id_nom=$HTTP_SESSION_VARS["Id_nom"];
	$nom=$HTTP_SESSION_VARS["nom"];
	$prenom=$HTTP_SESSION_VARS["prenom"];
	$level=$HTTP_SESSION_VARS["level"];
	$login=$HTTP_SESSION_VARS["login"];
// fin de compatibilité PHP4

/* accès aux données de configuration de l'application */
include("prive/conf.php");
 $langue=$HTTP_SESSION_VARS["langue"];
include("include/${langue}.php");
require("include/functions.php");
/*connection à la base de donnée MySQL  paramètres dans conf.php  */
// connection à la base de donnée de la langue choisie
DBinfo($langue);
$connection = @mysql_connect("$DBHost", "$DBUser", "$DBPass")  
    or die("Couldn't connect."); 

$db = @mysql_select_db($DBName, $connection) 
    or die("Couldn't select database."); 
include($hautpage);
/* boucle principale */
   //echo "***debug debut main : $action\n";
if (!isset($action)){$action = "default";}	 
switch($action) {


//-----------------------------------------------------------------------------------------------------------------------------------------
//	AIDE / HELP
//-----------------------------------------------------------------------------------------------------------------------------------------

case "aide":
include("include/${langue}_help.htm");
break;

//-----------------------------------------------------------------------------------------------------------------------------------------
//	Lister les phases Domaines et competences pour admin
//-----------------------------------------------------------------------------------------------------------------------------------------
case "phases":
				/* on affiche la liste des phases Domaines et competencs
			 */
				include ("listphas.php");		
break;

//-----------------------------------------------------------------------------------------------------------------------------------------
//	Changer l user par l acces au menu administrateur
//-----------------------------------------------------------------------------------------------------------------------------------------
case "chguser":
	$result=mysql_query("select * from $t_equipe where login='$luser'") or die("Echec accès Base de données.");
	while ($row=mysql_fetch_array($result))
	  {	
             $Id_nom = $row["Id_equipe"];     /* user autorisé */
						 $nom = $row["nom"];     /* nom de l'user autorisé */
						 $login = $luser;
						 $HTTP_SESSION_VARS["Id_nom"]=$Id_nom;
						 $HTTP_SESSION_VARS["login"]=$login;
						 $prenom = $row["prenom"];     /* prenom de l'user autorisé */
						 $HTTP_SESSION_VARS["nom"]=$nom;
						 $HTTP_SESSION_VARS["prenom"]=$prenom;
		}
				/* on affiche la liste des phases Domaines et competencs
			 */
		/* on affiche la derniere evaluation */
	$commande = "SELECT * FROM $t_evaluation where ce_equipe='$Id_nom' And Type='$mess[22]'";
	$commande.= " Order by Date_evaluation DESC";
	$imax=0;
	$resultat = mysql_query ($commande, $connection);
	if (!$resultat) {
			echo "<font color='red'>Erreur:Table $t_evaluation non présente<b>".BD."</b></font><br>";
				exit;
					}  
	$row = mysql_fetch_array ($resultat);  // 1er enreg
	$partype[0]="E";
	$parid[0]=$row[Id_evaluation];
	$parang[0]=1;
	$pardate[0]="";
	$imax=1;  // pour passer une fois dans boucle de listmenu
				            include("listeval.php");			
break;

//-----------------------------------------------------------------------------------------------------------------------------------------
//	modifier les params d'un user
//-----------------------------------------------------------------------------------------------------------------------------------------

case "moduser":
// liste params d un utilisateur
		$login=$HTTP_SESSION_VARS["login"];
		$nom=$HTTP_SESSION_VARS["nom"];
		$prenom=$HTTP_SESSION_VARS["prenom"];
  echo "<br><br><h3>$mess[38]</h3><BR>\n";
  echo "<table><tr>\n";
	echo "<form method=\"post\" name=\"f_user\"  onSubmit=\"return vformlog();\" >\n";
	echo "<font  size=\"2\">\n";
	echo "<td>\n";
	if ($level >= 5)    //seul un admin peut supprimer l utilisateur
	{
	echo "<a href=\"main.php?action=supuser&c_user=$Id_nom\">\n";
	echo "<img src=\"images/supprimer.gif\" alt=\"$mess[15]\" width=\"10\" height=\"10\" border=\"0\"></a>\n";
	}
	echo "<b>$mess[6]</b></td>\n";
	echo "<td><input type=\"text\" name=\"snom\" value=\"$nom\"></td></tr>\n";
	echo "<td><br><b>$mess[7]</b>\n";
	echo "<td><input type=\"text\" name=\"sprenom\"  value=\"$prenom\"></td></tr>\n";
	echo "<td><br><b>$mess[8]</b>\n";
	echo "<td><input type=\"text\" name=\"login\" value=\"$login\"></td></tr>\n";
	if ($level >= 5)
	{
	echo "<td><br><b>$mess[25]</b>\n";
	echo "<td><input type=\"text\" name=\"slevel\" value=\"0\"></td></tr>\n";
	}
	else
	{
	 echo "<input type=\"hidden\" name=\"slevel\" value=\"0\">\n";
	}
	echo "<td><br><b>$mess[2]</b>\n";
	echo "<td><input type=\"password\" name=\"pass1\"></td></tr>\n";
	echo "<td><br><b>$mess[9]</b>\n";
	echo "<td><input type=\"password\" name=\"pass2\"></td></tr>\n";
	echo "<tr><td></td><td><input class=\"send\" type=\"submit\" name=\"Submit\"  value=\"$mess[3]\"></td></tr>\n";
	echo "</tr></table>\n";
	echo "<input type=\"hidden\" name=\"action\" value=\"moduser2\">\n";
	echo "<br><br>\n";

	echo "</font></form>\n";

break;
//-----------------------------------------------------------------------------------------------------------------------------------------
//	retour modification des params d'un user 
//-----------------------------------------------------------------------------------------------------------------------------------------

case "moduser2":
// modifier le paramètres saisis par l user
//verifier que le login n est pas utilisé par ailleurs

$commande= "SELECT COUNT(*) FROM $t_equipe WHERE login='$login' and Id_equipe != '$Id_nom'";
$resultat= mysql_query ($commande, $connection);
$row = mysql_fetch_array ($resultat);
if ($row[0]==0)
{
		//il n'existe pas donc on le crée avec les infos récupéres;				
  $commande = "UPDATE $t_equipe SET  nom='$snom',prenom='$sprenom',login='$login',level ='$slevel' ,password='$pass1' where Id_equipe='$Id_nom'";
  $resultat = mysql_query ($commande, $connection);
	if (!$resultat) 
	{
		echo "<font color='red'> Erreur mise à jour Date/heure <b>$DBName</b></font><br>";
		exit;
	}	
	$nom = $snom;     /* nom de l'user autorisé */
	$HTTP_SESSION_VARS["Id_nom"]=$Id_nom;
	$HTTP_SESSION_VARS["login"]=$login;
	$prenom = $sprenom;     /* prenom de l'user autorisé */
	$HTTP_SESSION_VARS["nom"]=$nom;
	$HTTP_SESSION_VARS["prenom"]=$prenom;
	echo "<br><br><h3>$mess[38]</h3><BR>\n";
}
else
{
	echo "<br><br><font color='red'><h3>$mess[16]</h3></font><BR>\n";
}

  echo "<table><tr>\n";
	echo "<form method=\"post\" name=\"f_user\"  onSubmit=\"return vformlog();\" >\n";
	echo "<font  size=\"2\">\n";
	echo "<td><b>$mess[6]</b></td>\n";
	echo "<td><input type=\"text\" name=\"snom\" value=\"$nom\"></td></tr>\n";
	echo "<td><br><b>$mess[7]</b>\n";
	echo "<td><input type=\"text\" name=\"sprenom\"  value=\"$prenom\"></td></tr>\n";
	echo "<td><br><b>$mess[8]</b>\n";
	echo "<td><input type=\"text\" name=\"login\" value=\"$login\"></td></tr>\n";
	if ($level >= 5)
	{
	echo "<td><br><b>$mess[25]</b>\n";
	echo "<td><input type=\"text\" name=\"slevel\" value=\"$slevel\"></td></tr>\n";
	}
	echo "<td><br><b>$mess[2]</b>\n";
	echo "<td><input type=\"password\" name=\"pass1\"></td></tr>\n";
	echo "<td><br><b>$mess[9]</b>\n";
	echo "<td><input type=\"password\" name=\"pass2\"></td></tr>\n";
	echo "<tr><td></td><td><input class=\"send\" type=\"submit\" name=\"Submit\"  value=\"$mess[3]\"></td></tr>\n";
	echo "</tr></table>\n";
	echo "<input type=\"hidden\" name=\"action\" value=\"moduser2\">\n";
	echo "<br><br>\n";

	echo "</font></form>\n";
break;
//-----------------------------------------------------------------------------------------------------------------------------------------
//	supprimer un utilisateur et toutes ses évaluations
//  en entrée $c_user= Id_User à supprimer
//-----------------------------------------------------------------------------------------------------------------------------------------
case "supuser":
$commande = "SELECT * FROM $t_evaluation where ce_equipe=$c_user";
//echo "***debug supuser  select: $commande<br>\n";
$resultat = mysql_query ($commande, $connection);
if (!$resultat) 
{
  echo "***debug supuser rien à supprimer<br>\n";
}  
else
{
	while ($row = mysql_fetch_array ($resultat))
	 {
	 $s_eva = $row["Id_evaluation"];   	
	 //pour chaque évaluation supprimer eva_comp
	$command2="DELETE FROM $t_eva_comp where ce_evaluation=$s_eva ";
	//echo "***debug delete eva_comp: $command2<br>\n";
	$resultat2 = mysql_query ($command2, $connection);
	}
	$commande="DELETE FROM $t_evaluation where ce_equipe=$c_user ";
	//echo "***debug delete evaluation: $commande<br>\n";
	$resultat = mysql_query ($commande, $connection); // or die ("Table evaluation non disponible");
}
//reste à supprimer l'utilisateur dans la table des utilisateur
   	$commande="DELETE FROM $t_equipe where Id_equipe=$c_user ";
	//echo "***debug delete equipe: $commande<br>\n";
	$resultat = mysql_query ($commande, $connection);
	break;  //on oblige à se logger à nouveau
//-----------------------------------------------------------------------------------------------------------------------------------------
//	Afficher les paramètres de selection pour la restitution equipe
//-----------------------------------------------------------------------------------------------------------------------------------------

case "saisparam":
				include ("conso.php");
				include ("recap.php");
			break;
//-----------------------------------------------------------------------------------------------------------------------------------------
//	retour selection afficher tableau recap
//-----------------------------------------------------------------------------------------------------------------------------------------

case "enparam":
				include ("recap.php");
			break;			
//-----------------------------------------------------------------------------------------------------------------------------------------
//	Afficher le graphique correspondant aux parametres saisis de selection pour la restitution equipe
//-----------------------------------------------------------------------------------------------------------------------------------------

case "saisparam":
				include ("conso.php");
			break;							
//-----------------------------------------------------------------------------------------------------------------------------------------
//	Retour de mise à jour d une liste
//-----------------------------------------------------------------------------------------------------------------------------------------

case "majeval":
   // analyse de la saise et mise à jour de la table eva_comp
	  //lecture des elements de la forme débutant par Niv- suivi de la clé de eva_comp et de la valeur init
	$i=0;
	while (list($key,$value) = each($postvar))
	{	
		//découper la clé en 3 parties séparées par un -
			 $pieces = explode("-", $key);
 //echo "***debug majeval: $key,$value <br>\n";
			 if ($pieces[0]== "Niv")
		 	 		{
					$commande = "UPDATE  $t_eva_comp SET niveau ='$value' where Id_eva_comp = '$pieces[1]'";
	//echo "***debug update niveau: $commande<br>\n";
					$resultat = mysql_query ($commande, $connection) or die ("Table $t_eva_comp non disponible");
					$i=$i+1;
					}
	}
	/* on affiche la derniere evaluation */
	$imax=0; // pour le cas ou l'on ne trouve pas d'enreg enc cours''
	$commande = "SELECT * FROM $t_evaluation where ce_equipe='$Id_nom' And Type='$mess[22]'";
	$commande.= " Order by Date_evaluation DESC";
	$resultat = mysql_query ($commande, $connection);
	if (!$resultat) 
		{
		echo "<font color='red'>Erreur:Table $t_evaluation non présente<b>".BD."</b></font><br>";
		exit;
		}  
	$row = mysql_fetch_array ($resultat);  // 1er enreg
	$partype[0]="E";
	$parid[0]=$row[Id_evaluation];
	$parang[0]=1;
	$pardate[0]="";
	$imax=1;  // pour passer une fois dans boucle de listmenu
	include("listeval.php");	
			break;
//-----------------------------------------------------------------------------------------------------------------------------------------
//	Retour choix des evaluations à afficher
//-----------------------------------------------------------------------------------------------------------------------------------------
case "affeval":
				/* on découpe la clé des champs : choix-E-$row[Id_evaluation]-$dateva-$i
			 */
	$i=0;		 
	while (list($key,$value) = each($postvar))
	{	
		//découper la clé en 2 parties séparées par un -
			 $pieces = explode("-", $key);
	//	echo "***debug affeval:$pieces[0],$pieces[1],$pieces[2],$pieces[3],$pieces[4]<br>\n";
			 	$partype[$i]="";
				$parid[$i]="";
				$pardate[$i]="";
				$parang[$i]="";
			 if ($pieces[0]== "choix")
				{
				$partype[$i]=$pieces[1];
				$parid[$i]=$pieces[2];
				$pardate[$i]=$pieces[3];
				$parang[$i]=$pieces[4];
				$i=$i+1;
				}
	}
				$imax=$i;
// on sauvegarde les tableaux pour la suite	dans variable de session			
				include ("listeval.php");		
break;

																						
//-----------------------------------------------------------------------------------------------------------------------------------------
//	Suppresion Phases
//-----------------------------------------------------------------------------------------------------------------------------------------

case "suphase":
   //suppression d'une phase
	 // lecture des domaines pour suppression des competences rattachées
	 $command1 = "SELECT * FROM $t_domaine  where ce_phase= '$s_phase'";
	 //echo "***debug supphase: $command1\n";
	 $resultat1 = mysql_query ($command1, $connection);
	 if (!$resultat1) {
	 echo "<font color='red'>$mess[10]<b>".BD."</b></font><br>";
	 exit;
   }
	 while ($row1 = mysql_fetch_array ($resultat1))
	{
	 // lecture des competences pour suppresion des enregs de eva_competence
	 	 $command2 = "SELECT * FROM $t_competence where  ce_domaine='$row1[Id_domaine]'";
		 //echo "***debug supphase_suite: $command2\n";
	 	 $resultat2 = mysql_query ($command2, $connection);
   	 	while ($row2 = mysql_fetch_array ($resultat2)) 
		 	{
			$commande="DELETE FROM $t_eva_comp where ce_competence='$row2[Id_competence]' ";
			//echo "***debug supphase sql delete: $command1\n";
			$resultat = mysql_query ($commande, $connection) or die ("Table eva_comp non disponible");
			}
	 	  $commande="DELETE FROM $t_competence where ce_domaine='$row1[Id_domaine]' ";
			//echo "***debug delete competence: $commande<br>\n";
		  $resultat = mysql_query ($commande, $connection) or die ("Table competence non disponible");
	}
	$commande="DELETE FROM $t_phase where Id_phase='$s_phase' ";
	$resultat = mysql_query ($commande, $connection) or die ("Table competence non disponible");
		  include ("listphas.php");
			break;
//-----------------------------------------------------------------------------------------------------------------------------------------
//	Suppression domaine
//-----------------------------------------------------------------------------------------------------------------------------------------

case "supdom":
   //suppression d'un domaine
	 	 // lecture des competences pour suppresion des enregs de eva_competence
	 	 $command2 = "SELECT * FROM $t_competence where  ce_domaine='$s_dom'";
		 //echo "***debug supdom: $command2<br>\n";
	 	 $resultat2 = mysql_query ($command2, $connection);
   	 	while ($row2 = mysql_fetch_array ($resultat2)) 
		 	{
			$commande2="DELETE FROM $t_eva_comp where ce_competence='$row2[Id_competence]' ";
			$resultat2 = mysql_query ($commande2, $connection);// or die ("Table eva_competence non disponible");
			}
	 	  $commande="DELETE FROM $t_competence where ce_domaine='$s_dom' ";
			$resultat = mysql_query ($commande, $connection) ;//or die ("Table competence non disponible");
	 	 
		 //supprimer domaine en final
		  $commande="DELETE FROM $t_domaine where Id_domaine='$s_dom' ";
		  $resultat = mysql_query ($commande, $connection) ;//or die ("Table competence non disponible");

		    include ("listphas.php");
			break;
//-----------------------------------------------------------------------------------------------------------------------------------------
//	Suppression competence
//-----------------------------------------------------------------------------------------------------------------------------------------

case "supcomp":
   //suppression d'une competence
			$commande2="DELETE FROM $t_eva_comp where ce_competence='$s_comp' ";
			//echo "***debug delete eva_comp: $commande2<br>\n";
			$resultat2 = mysql_query ($commande2, $connection);
	 	  $commande="DELETE FROM $t_competence where Id_competence='$s_comp' ";
			//echo "***debug delete competence: $commande<br>\n";
		  $resultat = mysql_query ($commande, $connection) ;//or die ("Table competence non disponible");
		    include ("listphas.php");
			break;	
//-----------------------------------------------------------------------------------------------------------------------------------------
//	Suppression evaluation
//-----------------------------------------------------------------------------------------------------------------------------------------

case "supeval":
   //suppression d'une evaluation
			$commande="DELETE FROM $t_eva_comp where ce_evaluation='$s_eva' ";
			//echo "***debug delete eva_comp: $commande<br>\n";
			$resultat = mysql_query ($commande, $connection);
	 	  $commande="DELETE FROM $t_evaluation where Id_evaluation='$s_eva' ";
			//echo "***debug delete evaluation: $commande<br>\n";
		  $resultat = mysql_query ($commande, $connection); // or die ("Table evaluation non disponible");
				include ("listeval.php");
	break;																			
//-----------------------------------------------------------------------------------------------------------------------------------------
//	création phase domaine et-ou competence
//-----------------------------------------------------------------------------------------------------------------------------------------
case "crephase":
 //lecture des elements de la forme
	while (list($key,$value) = each($postvar))
	{	
    $value = stripslashes($value);
		if ($value != "")
		{
		 	 //echo "***debug crephase:$key,$value<br>\n";
			 //découper la clé en 3 parties séparées par un _
			 $pieces = explode("-", $key);
			 //echo "***debug crephase:$pieces[0],$pieces[1],$pieces[2]<br>\n";
			 if ($pieces[0]== "phas")
		 	 		{
					$commande = "Insert into $t_phase Set Phase='".addslashes($value)."'";
					//echo "***debug insert phase: $commande<br>\n";
					$resultat = mysql_query ($commande, $connection) or die ("Table $t_phase non disponible");
		 			}
			 if ($pieces[0]== "dom")
			 {
			 $commande = "Insert into $t_domaine Set Domaine='".addslashes($value)."',ce_phase='$pieces[1]'";
			 //echo "***debug insert domaine: $commande<br>\n";
			 $resultat = mysql_query ($commande, $connection) or die ("Table $t_domaine non disponible");
			 }
			 if ($pieces[0]== "com") 
		   		{
					 	$commande = "Insert into $t_competence Set competence='".addslashes($value)."',ce_domaine='$pieces[1]'";
						//echo "***debug insert competence: $commande<br>\n";
						$resultat = mysql_query ($commande, $connection) or die ("Table $t_competence non disponible");
		 				//lecture de l'Id_evaluation dans table evaluation de l enreg que l'on vient de créer
						$command2 = "SELECT Id_competence FROM $t_competence where  competence='".addslashes($value)."' and ce_domaine='$pieces[1]'";
						//echo "***debug sel evaluation: $command2<br>\n";
						$resultat2 = mysql_query ($command2, $connection);
  					while ($row2 = mysql_fetch_array ($resultat2)) 
		 				{
									$Idcomp=$row2[Id_competence];
						}		
						// création des enregs dans $t_eva_comp suite lecture de t_evaluation
						$command3 = "SELECT Id_evaluation,Type FROM $t_evaluation";
						//echo "***debug sql evaluation: $command3<br>\n";
						$resultat3 = mysql_query ($command3, $connection);
 						 while ($row3 = mysql_fetch_array ($resultat3)) 
						  {
					 		$commande = "Insert into $t_eva_comp Set ce_competence='$Idcomp',ce_evaluation='$row3[Id_evaluation]',type='$row3[Type]'";
							 //echo "***debug insert evaluation: $commande<br>\n";
							  $resultat = mysql_query ($commande, $connection) or die ("Table $t_evaluation non disponible");		 
  						 }	
					 }	//fin du IF com
			}		  
   }
		    include ("listphas.php");
			break;
											
//-----------------------------------------------------------------------------------------------------------------------------------------
//	creation d une nouvelle evaluation pour l utilisateur en cours
//-----------------------------------------------------------------------------------------------------------------------------------------
case "creval":
				/* cas d'une nouvelle évaluation sans eval existante
			 */
	//création d'un enreg dans evaluation pour recuperer l'ID
	$dateva=datefrus($dateva);  //transformation en format YYYY-DD-YY
	$commande = "Insert into $t_evaluation Set ce_equipe='$Id_nom',Date_evaluation='$dateva',Type='$typeva'";
	//echo "***debug insert evaluation: $commande<br>\n";
	$resultat = mysql_query ($commande, $connection) or die ("Table $t_evaluation non disponible");		 
	//echo "***debug creval: creation d une nouvelle evaluation<br>\n";
	//lecture de l'Id_evaluation dans table evaluation de l enreg que l'on vient de créer
	$command2 = "SELECT Id_evaluation FROM $t_evaluation where  ce_equipe='$Id_nom'AND Date_evaluation='$dateva' AND Type='$typeva'";
	//echo "***debug sel evaluation: $command2<br>\n";
	$resultat2 = mysql_query ($command2, $connection);
  while ($row2 = mysql_fetch_array ($resultat2)) 
		 	{
			$Ideval=$row2[Id_evaluation];
			}		
	// création des enregs dans $t_eva_comp suite lecture de t_competence
	$command3 = "SELECT Id_competence FROM $t_competence";
	//echo "***debug sql: $command3<br>\n";
	$resultat3 = mysql_query ($command3, $connection);
  while ($row3 = mysql_fetch_array ($resultat3)) 
		{
			$commande = "Insert into $t_eva_comp Set ce_evaluation='$Ideval',ce_competence='$row3[Id_competence]',type='$typeva'";
			//echo "***debug insert evaluation: $commande<br>\n";
			$resultat = mysql_query ($commande, $connection) or die ("Table $t_evaluation non disponible");		 
		}
	/* on affiche la derniere evaluation */
	$commande = "SELECT * FROM $t_evaluation where ce_equipe='$Id_nom' And Type='$mess[22]'";
	$commande.= " Order by Date_evaluation DESC";
	$resultat = mysql_query ($commande, $connection);
	if (!$resultat) {
		echo "<font color='red'>Erreur:Table $t_evaluation non présente<b>".BD."</b></font><br>";
		exit;
					}  
	$row = mysql_fetch_array ($resultat);  // 1er enreg
	$partype[0]="E";
	$parid[0]=$row[Id_evaluation];
	$parang[0]=1;
	$pardate[0]="";
	$imax=1;  // pour passer une fois dans boucle de listmenu
				            include("listeval.php");			
break;

//-----------------------------------------------------------------------------------------------------------------------------------------
//	DECONNEXION
//-----------------------------------------------------------------------------------------------------------------------------------------

case "deconnexion":
   echo "<br><b>deconnection de  = $log</b>\n";
	 $log="";
   echo "<br><b>fin de la session</b>\n";
	 session_destroy();
   exit;
break;


//---------------------------------------------------------------------------------------------------------------------
//	DEFAUT
//---------------------------------------------------------------------------------------------------------------------

default:
	echo "Accès non autorise<br>\n";
  	//reinit des valeurs en cours au cas ou un autre etait déja loggé
	 $nom="";$prenom="";$login="";
break;
}  //fin du case
include($baspage);
?>
