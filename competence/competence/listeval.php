<?
// afficher les evaluation selon les prametres fournis dans le tableau suivant:
//			$partype[$i]=type   E ou O
//			$parid[$i]=id de la table evaluation
//			$pardate[$i]= date d evaluation
//			$parang[$i]= rang dans la liste
//       $imax = nb d elements à afficher
//       $jmax = nb de competences
// Preparer le tableau des niveaux à afficher

    if (!isset($parid))
	{
	 /* l'appel n'a rien défini comme affichage donc
	     on affiche la derniere evaluation si elle existe*/
	$commande = "SELECT * FROM $t_evaluation where ce_equipe='$Id_nom' And Type='$mess[22]'";
	$commande.= " Order by Date_evaluation DESC";
	$resultat = mysql_query ($commande, $connection);
	$imax=0;
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
	}
   	for ($i = 0; $i < $imax; $i++)
		{
	  $neval=$parid[$i];
		if ($partype[$i]=="E"){$typeva=$mess[22];}else{$typeva=$mess[23];}		
   $commande= "SELECT A.Phase, B.Domaine,C.competence,D.niveau,D.Id_eva_comp ";
	 $commande.=" FROM $t_phase A,$t_domaine B , $t_competence C , $t_eva_comp D";
	 $commande.=" where D.ce_competence=C.Id_competence"; 
	 $commande.=" And D.ce_evaluation='$neval'";
	 $commande.=" And C.ce_domaine=B.Id_domaine AND B.ce_phase=A.Id_phase"; 
	 $commande.=" ORDER BY A.Phase, B.Domaine, C.competence";
    //echo "***debug sel eva_comp: $i, $commande<br>\n";
	  $resultat = mysql_query ($commande, $connection);
	  if (!$resultat) 
	  {echo "<font color='red'>$mess[10] $t_eva_comp<b>".BD."</b></font><br>";exit;}
		 $jmax=0;
		 while ($row = mysql_fetch_array ($resultat)) 
		 			 {
					 $tniv[$i][$jmax]=$row[niveau];
					 $jmax=$jmax+1;
					 }
		}  // fin boucle for et maj jmax
// fin operaration du tableau à afficher
  $ibcl=0; // le premier affichage sert aussi à lister les libellés
	$neval=$parid[0];
	if ($partype[0]=="E"){$typeva=$mess[22];}else{$typeva=$mess[23];}
// select sur eva_comp avec recup des libellés de phase domaine et competence
  $commande= "SELECT A.Phase, B.Domaine,C.competence,D.niveau,D.Id_eva_comp ";
	$commande.=" FROM $t_phase A,$t_domaine B , $t_competence C , $t_eva_comp D";
	$commande.=" where D.ce_competence=C.Id_competence"; 
	$commande.=" And D.ce_evaluation='$neval'"; 
	$commande.=" And C.ce_domaine=B.Id_domaine AND B.ce_phase=A.Id_phase"; 
	$commande.=" ORDER BY A.Phase, B.Domaine, C.competence";
	//echo "***debug sel eva_comp: $commande<br>\n";
	$resultat = mysql_query ($commande, $connection);
	 if (!$resultat) 
	 {
	 echo "<font color='red'>$mess[10] $t_eva_comp<b>".BD."</b></font><br>";
	 exit;
   }
	 //formulaire pour saisie du niveau
echo "<table>\n";
echo "<tr><td><center>\n";		
echo "<b>$nom  $prenom</b><br><br>\n";
 echo "</center></td></tr>\n";
 echo "<tr class='tr-titre-phase'>\n";
 			//affiche en-tete du tableau
 			echo "  <td  width=\"150\">\n";
			echo "<form method=\"post\" action=\"main.php\" name=\"majeval\">$mess[12]</td>\n";
			echo "  <td width=\"100\">$mess[13]</td>\n";
			echo "  <td width=\"100\">$mess[14]</td>\n";
			for ($j = 0; $j < $imax; $j++)
			{
			echo "  <td width=\"30\">\n";
			echo "<a><img src=\"images/check.gif\" alt=\"$pardate[$j]\" width=\"15\" height=\"15\" border=\"0\"><FONT color=\"#FFFFFF\">$parang[$j]</FONT></a></td>\n";
			}
 			echo " </tr>\n";	
			//on n'ecrira que si la phase ou le domaine a changé
			$phaseold="";
			$domold="";
			$ndiv=0;
 while ($row = mysql_fetch_array ($resultat)) 
{
//
// on affiche la ligne de la phase
//
	If ($row[0] != $phaseold)
	{
	 	echo "</table>\n";
		echo "</div>\n";
		echo "<table>\n";
	 $ndiv=$ndiv+1;
	 echo "<tr class='tr-phase'>\n";
	 echo "<td align=\"left\"><b>".stripslashes($row[0])."</b></td>\n";
	 echo "  <td width=\"100\"></td>\n";
	 echo "  <td width=\"100\"></td>\n";
	 for ($j = 0; $j < $imax; $j++)
		{
		echo "  <td width=\"30\"></td>\n";
		}
	 echo "</tr>\n";
	 			$phaseold=$row[0];
	}
	If ($row[1] != $domold)
	{			
		 echo "<tr class='tr-phase'>\n";
		 echo "<td width=\"150\"></td>\n";
		 echo "<td  align=\"left\">".stripslashes($row[1])."</td>\n";
		 echo "<td width=\"100\"></td>\n";
		for ($j = 0; $j < $imax; $j++)
		{
		echo "<td width=\"30\"></td>\n";
		}
		 echo "</tr>\n";
		 $domold=$row[1];
	}	 
	//ligne des competences existe toujours par définition
		echo "<tr class='tr-phase'>\n";
		echo "<td width=\"150\"></td>\n";
		echo "<td width=\"100\"></td>\n";
		echo "<td  align=\"left\">".stripslashes($row[2])."</td>\n";
		//afficher le niveau en liste de selection début 0 jusqu'à $nivmax
		$jl = $row[3];
	  echo "<td width=\"30\"><select size=\"1\" name=\"Niv-$row[4]-$j\">\n";
		for ($i = 0; $i <= $nivmax; $i++)
			{
			  if ($i == $jl)
				{
				echo "<option value=\"$i\" SELECTED>$i</option>\n";
				}
				else
				{
				echo "<option value=\"$i\">$i</option>\n";
				}
			}				
		echo "</select></td>\n";
   	for ($i = 1; $i < $imax; $i++)
		{
			$niv=$tniv[$i][$ibcl];
			if ($partype[$i]=="E")
			{
			echo "<td width=\"30\" class='td_niv'>$niv</td>\n";
			}
			else
			{
			echo "<td width=\"30\" class='td_nivo'>$niv</td>\n";
			}
		}  // fin boucle for
		echo "</tr>\n";
		 $ibcl=$ibcl+1;
}	
		echo "<tr><td></td><td>\n";		
 // fin du formulaire et retour 
      if ($partype[0]=="E"){$typeva=$mess[22];}else{$typeva=$mess[23];}
 	   echo "<input type=\"hidden\" name=\"action\" value=\"majeval\">\n";
		 echo "<input type=\"hidden\" name=\"neval\" value=\"$parid[0]\">\n";
		 echo "<input type=\"hidden\" name=\"dateva\" value=\"$pardate[0]\">\n";
		 echo "<input type=\"hidden\" name=\"typeva\" value=\"$typeva\">\n";
		 	echo "<center><br><br><input class=\"send\" type=\"submit\" name=\"Submit\" value=\"$mess[3]\">\n";
	   echo "</center></form>\n";
 echo "</td></tr></table>\n";		 
?>
