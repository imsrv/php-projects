<?
//---------------------------------------------------------------------------------------------------
//							
//	fdrouin -  Competence v1.0
//	
//	Francis DROUIN
//	http://fdrouin.free.fr
//	fdrouin@free.fr	
//
//---------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------------------------------
//	ce module ne sert qu a authentifier l utilisateur la boucle principale du prog est dan main
//-----------------------------------------------------------------------------------------------------------------------------------------
/* gestion de session necessite PHP4  */
if(!session_start()) {session_start(); }
//pour rendre le programe compatible PHP4
$getvar=$_GET;
$postvar=$_POST;
$iform=0;
while (list($key,$value)=each($_POST))
{  $iform=1;
${strval($key)}=$value;
}

if ($iform == 0) // on ne cherche que si rien dans la FORM
{
 	 while (list($key,$value)=each($_GET))
	 {
	 ${strval($key)}=$value;
	 }
}
 	 //table t_equipe
define("Id_equipe", 0);
define("nom", 1);
define("prenom", 2);
define("login", 3);
define("password", 4);
define("date", 5);
define("heure", 6);
define("level", 7);
define("ent", 8);
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
// fin de compatibilité PHP4
/* accès aux données de configuration de l'application */
include("prive/conf.php");
if (!isset($langue))
{
$langue=$dft_langue;
session_register("langue");
}
$HTTP_SESSION_VARS["langue"]=$langue;
include("include/${langue}.php");
require("include/functions.php");
/*connection à la base de donnée MySQL  paramètres dans conf.php  */
DBinfo($langue);
//les tables sont différentes en en et en fr
$connection = @mysql_connect("$DBHost", "$DBUser", "$DBPass");
if ($connection  == False)
{
 echo "<font color='red'>Erreur base de donnée <b>$DBHost</b></font><br>\n";
exit;
}
$db = @mysql_select_db($DBName, $connection); 
  // si les tables n 'existent pas on les crée
	include("include/creatable.php");
include($hautpage);
if (!isset($action)){$action = "default";}
/* boucle principale */
switch($action) {
//-----------------------------------------------------------------------------------------------------------------------------------------
//	AIDE / HELP
//-----------------------------------------------------------------------------------------------------------------------------------------
case "aide":
include("include/${langue}_help.htm");
break;

//-----------------------------------------------------------------------------------------------------------------------------------------
//	Création d'un nouvel utilisateur
//-----------------------------------------------------------------------------------------------------------------------------------------

case "creauser":
// création d un utilisateur
  echo "<br><br><h3>$mess[5]</h3><BR>\n";
  echo "<table><tr>\n";
	echo "<form method=\"post\" name=\"f_user\" onSubmit=\"return vformlog();\" >\n";
	echo "<font  size=\"2\">\n";
	echo "<td><b>$mess[6]</b></td>\n";
	echo "<td><input type=\"text\" name=\"snom\"></td></tr>\n";
	echo "<td><br><b>$mess[7]</b>\n";
	echo "<td><input type=\"text\" name=\"sprenom\"></td></tr>\n";
	echo "<td><br><b>$mess[8]</b>\n";
	echo "<td><input type=\"text\" name=\"login\"></td></tr>\n";
	echo "<td><br><b>$mess[2]</b>\n";
	echo "<td><input type=\"password\" name=\"pass1\"></td></tr>\n";
	echo "<td><br><b>$mess[9]</b>\n";
	echo "<td><input type=\"password\" name=\"pass2\"></td></tr>\n";
	echo "<tr><td></td><td><input class=\"send\" type=\"submit\" name=\"Submit\"  value=\"$mess[3]\"></td></tr>\n";
	echo "</tr></table>\n";
	echo "<input type=\"hidden\" name=\"langue\" value=\"$langue\">\n";
	echo "<input type=\"hidden\" name=\"action\" value=\"veruser\">\n";
	echo "<br><br>\n";

	echo "</font></form>\n";

break;
//-----------------------------------------------------------------------------------------------------------------------------------------
//	VERIFICATION LOGIN/PASSE
//-----------------------------------------------------------------------------------------------------------------------------------------

case "veruser":
// test si utilisateur existe déja
		 			 // verifier si l utilisateur existe sinon on le crée 
			  $nom="";  //effacer si nom déja en cours
			 $commande= "SELECT COUNT(*) FROM $t_equipe WHERE login='$login'";
			 $resultat= mysql_query ($commande, $connection);
			 $row = mysql_fetch_array ($resultat);
		if ($row[0]==0)
			{
			 //il n'existe pas donc on le crée avec les infos récupéres;
			 if ($pass1==$admpass){$level =9;}else {$level =0;}
	     	 $commande = "Insert into $t_equipe Set nom='$snom',prenom='$sprenom',login='$login',password='$pass1',level='$level'";
	         //echo "***debug insert user: $commande<br>\n";
				 $resultat = mysql_query ($commande, $connection) or die ("Table equipe non disponible");
			}
       	else 
			{
			 echo "<br><br><font color='red'><B>$mess[16] </font></B><br>\n";
			 echo "<form method=\"post\" action=\"index.php?action=creauser\">\n";
			 echo "<input class=\"send\" type=\"submit\" name=\"Submit\" value=\"$mess[17]\">\n";
			   echo "</font></form>\n";
			   exit; 
			 }
	echo "<form method=\"post\" action=\"index.php?action=verif\">\n";
	echo "<font  size=\"2\">";
	echo "<br><table>\n";
	echo "<tr><td><b>$mess[1]</b></td>\n";
	echo "<td><input type=\"text\" name=\"login\"></td></tr>\n";
	echo "<tr><td><b>$mess[2]</td></b>\n";
	echo "<td><input type=\"password\" name=\"passe\"></td></tr>\n";
	echo "<input type=\"hidden\" name=\"action\" value=\"verif\">\n";
	echo "<tr><td></td><td><input class=\"send\" type=\"submit\" name=\"Submit\" value=\"$mess[3]\"></td></tr>\n";
	echo "</table>\n";
	echo "</font></form>\n";
	/* step suivant vérifier le login et password */
	echo "<br><br><a href=index.php?action=creauser>\n";
	echo "$mess[4]</a>\n";
break;
//-----------------------------------------------------------------------------------------------------------------------------------------
//	VERIFICATION LOGIN/PASSE
//-----------------------------------------------------------------------------------------------------------------------------------------

case "verif":
	
	$result=mysql_query("select * from $t_equipe where login='$login'") or die("Echec accès Base de données.");
	$nom ="";
	while ($row=mysql_fetch_array($result))
	  {
		if ($row["password"]==$passe)
		    {
             session_register("Id_nom");		
             $Id_nom = $row["Id_equipe"];     /* user autorisé */
						 $nom = $row["nom"];     /* nom de l'user autorisé */
						 session_register("nom");
						 $prenom = $row["prenom"];     /* prenom de l'user autorisé */
						 $level =$row["level"];
						 $ent =$row["ent"];   /* entité d'appartenance de la personne'
						 $login =$row["login"];
						 session_register("prenom");
						 session_register("level");
						 session_register("ent");						 
						 session_register("login");
						 session_register("last_date");    /* date de précédente connection */
						 $HTTP_SESSION_VARS["Id_nom"]=$Id_nom;
						 $HTTP_SESSION_VARS["nom"]=$nom;
						 $HTTP_SESSION_VARS["prenom"]=$prenom;
						 $HTTP_SESSION_VARS["level"]=$level;
						 $HTTP_SESSION_VARS["ent"]=$ent;						 
						 $HTTP_SESSION_VARS["login"]=$login;
						 $HTTP_SESSION_VARS["langue"]=$langue;
						 $last_date = $row["date"]." à ".$row["heure"];  /*user */
					// garder le choix de l utilisateur dans le menu
					   session_register("partype");
						 session_register("parid");	
			  		 session_register("pardate");
						 session_register("parang");
						 session_register("imax");	 
					// on recupere l'heure et la date et l'heure courante 
						 $date  = date("d-m-Y");
						 $heure = date("H")." h ".date("i")." mn";
					// on met a jour la colonne "date de derniere connexion" //
            $commande = "UPDATE $t_equipe SET date='$date',heure='$heure' where Id_equipe='$Id_nom'";
            $resultat = mysql_query ($commande, $connection);
						if (!$resultat) {
						    echo "<font color='red'> Erreur mise à jour Date/heure <b>$DBName</b></font><br>";
						    exit;
						                }	
	 				   echo "<br><b>\n";
						echo "$nom  $prenom : ";
	 		      echo "$mess[36]= $last_date\n";
		        echo "<br></b>\n";
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
			   }    /* fin du IF */
		} /* fin du While */	
    if ($nom == "")  /* user non trouvé on reaffiche le formulaire*/ 
         {
	echo "<form method=\"post\" action=\"index.php?action=verif\">\n";
	echo "<font  size=\"2\">";
	echo "<br><table>\n";
	echo "<tr><td><b><font color='red'>$mess[1]</font></b></td>\n";
	echo "<td><input type=\"text\" name=\"login\"></td></tr>\n";
	echo "<tr><td><b><font color='red'>$mess[2]</font></td></b>\n";
	echo "<td><input type=\"password\" name=\"passe\"></td></tr>\n";
	//choix de la langue
	if ($langue=="fr"){$lgfr="checked";$lgen="";}else{$lgfr="";$lgen="checked";}
	echo "<tr><td><center></td><td><img src=\"images/lang_fr.gif\" alt=\"fr\"><input type=\"radio\" value=\"fr\" name=\"langue\" $lgfr>\n";
	echo "<img src=\"images/lang_en.gif\" alt=\"en\"><input type=\"radio\" name=\"langue\" value=\"en\" $lgen></center></td></tr>\n";
	// fin du choix de la langue
	echo "<tr><td></td><td>\n";
	echo "<input class=\"send\" type=\"submit\" name=\"Submit\" value=\"$mess[3]\"></center></td></tr>\n";
	echo "</td></tr>\n";	
	echo "</table>\n";
	echo "</font></form>\n";
	/* step suivant vérifier le login et password */
	echo "<br><br><a href=index.php?action=creauser&langue=$langue>\n";
	echo "$mess[4]</a>\n";
	//reinit des valeurs en cours au cas ou un autre etait déja loggé
	$nom="";$prenom="";$login="";
				 }
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

//-----------------------------------------------------------------------------------------------------------------------------------------
//	DEFAUT
//-----------------------------------------------------------------------------------------------------------------------------------------

default:
	echo "<form method=\"post\" action=\"index.php?action=verif\">\n";
	echo "<font  size=\"2\">";
	echo "<br><table>\n";
	echo "<tr><td><b>$mess[1]</b></td>\n";
	echo "<td><input type=\"text\" name=\"login\"></td></tr>\n";
	echo "<tr><td><b>$mess[2]</td></b>\n";
	echo "<td><input type=\"password\" name=\"passe\"></td></tr>\n";
	//choix de la langue
	if ($langue=="fr"){$lgfr="checked";$lgen="";} else {$lgfr="";$lgen="checked";}
	echo "<tr><td><center></td><td><img src=\"images/lang_fr.gif\" alt=\"fr\"><input type=\"radio\" value=\"fr\" name=\"langue\" $lgfr>\n";
	echo "<img src=\"images/lang_en.gif\" alt=\"en\"><input type=\"radio\" name=\"langue\" value=\"en\" $lgen></center></td></tr>\n";
	// fin du choix de la langue
	echo "<tr><td></td><td><center><input type=\"hidden\" name=\"action\" value=\"verif\">\n";
	// valider
	echo "<input class=\"send\" type=\"submit\" name=\"Submit\" value=\"$mess[3]\"></center></td></tr>\n";
	// afficher le choix de l'entité d'appartenance  (non opérationnel danas cette version)
	/*echo "<tr><td></td><td>\n";
	echo "<select size=\"1\" name=\"ent\">\n";
	foreach ($sel_ent as $ent)
	{
      echo "<option value=\"$ent\">$ent</option>\n";
	}
	echo "</select></td></tr>\n";  */
	//  fin affichage appartenance	
	echo "</table>\n";
	echo "</font></form>\n";
	/* step suivant vérifier le login et password */
	echo "<br><br><a href=index.php?action=creauser&langue=$langue>\n";
	echo "$mess[4]</a>\n";
	//reinit des valeurs en cours au cas ou un autre etait déja loggé
	$nom="";$prenom="";$login="";
break;
}  //fin du case
include($baspage);
?>
