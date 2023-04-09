<?
//affiche les listes phase/domaine/competence pour administration
// lecture dans boucle principale des phases
// indicateurs incrémentés dans les while imbriqués
	 $iphase =0;
	 $idom=0;
	 $icomp=0;
$command1 = "SELECT * FROM $t_phase  ORDER BY phase";
//echo "***debug sql phase: $command1<br>\n";
$resultat1 = mysql_query ($command1, $connection);
if (!$resultat1) {
	echo "<font color='red'>$mess[10]<b>".BD."</b></font><br>";
	exit;
  }
	 //formulaire pour saisie des nouvelles lignes
	echo "<form method=\"post\" action=\"main.php\" name=\"creaphase\">\n";	
echo "<table>\n";
echo " <tr><td><b>$mess[11]</b><br><br></td></tr>\n";
echo "<tr><td>\n";
 			//affiche en-tete du tableau
			echo "<table class='tab-phase'>\n";
 			echo " <tr class='tr-titre-phase'>\n";
 			echo "  <td  width=\"150\">$mess[12]</td>\n";
			echo "  <td width=\"100\">$mess[13]</td>\n";
			echo "  <td width=\"100\">$mess[14]</td>\n";
			echo "  <td width=\"22\"></td>\n";
 			echo " </tr>\n";			
 while ($row = mysql_fetch_array ($resultat1)) 
{
//
// on affiche la ligne de la phase
//
	 echo "<tr class='tr-phase'>\n";
	 echo "<td align=\"left\"><b>".stripslashes($row[Phase])."</b></td>\n";
	 echo "  <td width=\"100\"></td>\n";
	 echo "  <td width=\"100\"></td>\n";
	 			// IMAGE SUPPRIMER
	 echo "<td>\n";
	 echo "<a href=\"main.php?action=suphase&s_phase=$row[Id_phase]\">\n";
	 echo "<img src=\"images/supprimer.gif\" alt=\"$mess[15]\" width=\"20\" height=\"20\" border=\"0\"></a>\n";
	 echo "</td>\n";
	 echo "</tr>\n";
	 $phase=$row[Id_phase];
	 // lecture dans boucle secondaire des Domaines
	 $command2 = "SELECT * FROM $t_domaine where  ce_phase='$phase' ORDER BY Domaine";
	 //echo "***debug sql phase: $command2<br>\n";
	 $resultat2 = mysql_query ($command2, $connection);
   	 while ($row2 = mysql_fetch_array ($resultat2)) 
		 {
		 echo "<tr class='tr-phase'>\n";
		 echo "  <td width=\"150\"></td>\n";
		 echo "<td  align=\"left\">".stripslashes($row2[Domaine])."</td>\n";
		 echo "  <td width=\"100\">\n";
		 	 			// IMAGE SUPPRIMER
		 $dom=$row2[Id_domaine];
	   echo "<td>\n";
	   echo "<a href=\"main.php?action=supdom&s_dom=$dom\">\n";
	   echo "<img src=\"images/supprimer.gif\" alt=\"$mess[15]\" width=\"10\" height=\"10\" border=\"0\"></a>\n";
	   echo "</td>\n";
		 echo "</tr>\n";
		 			 // lecture dans boucle tertiaire des Competences
	 				 $command3 = "SELECT * FROM $t_competence where  ce_domaine='$dom' ORDER BY competence";
					 //echo "***debug sql: $command3<br>\n";
	 				 $resultat3 = mysql_query ($command3, $connection);
   	 			 while ($row3 = mysql_fetch_array ($resultat3)) 
		 			 {
					  echo "<tr class='tr-phase'>\n";
						echo "  <td width=\"150\"></td>\n";
			      echo "  <td width=\"100\"></td>\n";
		 				echo "<td  align=\"left\">".stripslashes($row3[competence])."</td>\n";
						$comp=$row3[Id_competence];
		 	 					 // IMAGE SUPPRIMER
	   						 echo "<td>\n";
	   						 echo "<a href=\"main.php?action=supcomp&s_comp=$comp\">\n";
	   						 echo "<img src=\"images/supprimer.gif\" alt=\"$mess[15]\" width=\"10\" height=\"10\" border=\"0\"></a>\n";
	   						 echo "</td>\n";
		 						 echo "</tr>\n";
					 }
					 	 echo "<tr class='tr-phase'>\n";
	 					 echo "<td align=\"left\"></td>\n";
	 					 echo "  <td width=\"100\"></td>\n";
	 					 echo "  <td width=\"100\"><input type=\"text\" name=\"com-$dom-$icomp\" size=\"20\"></td>\n";
	 					 $icomp = $icomp +1;
						 // IMAGE Ajouter
	 					 echo "<td>\n";
						 echo "<input class=\"send\" type=\"submit\" name=\"c_comp\" value=\"+\">\n";	 					 echo "</td>\n";
	 					 echo "</tr>\n";
		 }
		 	 echo "<tr class='tr-phase'>\n";
			 echo "  <td width=\"100\"></td>\n";
			 //echo "***debug phase en cours : $phase<br>\n";
	 		 echo "<td align=\"left\"><b><input type=\"text\" name=\"dom-$phase-$idom\" size=\"20\"></b></td>\n";
	 		 echo "  <td width=\"100\"></td>\n";
	 		 $idom=$idom+1;
			 // bouton Ajouter
	 		 echo "<td>\n";
			 echo "<input class=\"send\" type=\"submit\" name=\"c_dom\" value=\"+\">\n";
		 	 echo "</td>\n";
	 		 echo "</tr>\n";
}
	 echo "<tr class='tr-phase'>\n";
	 echo "<td align=\"left\"><input type=\"text\" name=\"phas-$iphase\" size=\"20\"></td>\n";
	 echo "  <td width=\"100\"></td>\n";
	 echo "  <td width=\"100\"></td>\n";
	 $iphase=$iphase+1;
	 			// bouton Ajouter
	 echo "<td>\n";
	echo "<input class=\"send\" type=\"submit\" name=\"c_phase\" value=\"+\">\n";
	 echo "</tr>\n";
 echo "</table>\n"; 
 
 // fin du formulaire et retour 
 	   echo "<input type=\"hidden\" name=\"action\" value=\"crephase\">\n";
	   echo "</form>\n";
		echo "</table>\n"; 
?>
