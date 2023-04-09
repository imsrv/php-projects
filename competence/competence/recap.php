<?
  //echo "recap<br>\n";
	//recup des données consolidées pour les evaluations
	If ($iva != 0)
	{			
	   $commande = "SELECT $t_phase.Phase, $t_domaine.Domaine,$t_competence.competence, $t_eva_comp.Niveau,$t_eva_comp.ce_evaluation ";
		 $commande.= " FROM $t_phase left JOIN $t_domaine ON $t_phase.Id_phase = $t_domaine.ce_phase left JOIN $t_competence ON ";
		 $commande.=" $t_domaine.Id_domaine = $t_competence.ce_domaine left join $t_eva_comp on $t_competence.Id_competence = $t_eva_comp.ce_competence ";
  	 $commande.=" where $whereva";
		 $commande.=" ORDER BY $t_phase.Phase, $t_domaine.Domaine, $t_competence.competence";
	 //echo "***debug sel conso result obj: $commande<br>\n";
		$resultat = mysql_query ($commande, $connection);
	  if (!$resultat) 
	  {echo "<font color='red'>$mess[10] $t_eva_comp<b>".BD."</b></font><br>";exit;}
		// titre du tableau
			echo "<table class='tab-phase'>\n";
 			echo " <tr class='tr-titre-phase'>\n";
 			echo "  <td  width=\"150\">$mess[12]</td>\n";  //Phase
			echo "  <td width=\"100\">$mess[13]</td>\n";   //Domaine
			echo "  <td width=\"100\">$mess[14]</td>\n";   //Competence
			for ($i = 0; $i <= $nivmax; $i++)
			{
			echo "  <td width=\"30\">$i</td>\n";	 // resultat eval
			$tabniv[$i] = 0;
			$nomliste[$i]="";
			}	
			echo " </tr>\n";
			$phasold="";$domold="";$compold="";	$phinit=0;
			$row2[0]=""; //juste pour eviter un warning
	while ($row = mysql_fetch_array ($resultat)) 
	{
			//echo "debug**eva: $row[Phase],$row[Domaine], $row[countcomp],$row[sumniv]<br>\n";
			//on récupére le nom pour l afficher en infobulle
			$command2= "select $t_equipe.nom,$t_equipe.prenom";
		    $command2.=" from $t_evaluation left JOIN $t_equipe ON $t_evaluation.ce_equipe = $t_equipe.Id_equipe ";
		    $command2.=" where $t_evaluation.Id_evaluation = $row[4]"; 
		    //echo "***debug sel nom equipe: $command2<br>\n";
	         $resultat2 = mysql_query ($command2, $connection);
	         if (!$resultat2) 
	         {echo "<font color='red'>$mess[10] $t_equipe<b>".BD."</b></font><br>";exit;}
			 $row2 = mysql_fetch_array ($resultat2);  // 1er enreg
			 //		constitution des lignes du tableau 
	 if ($phinit != 0)
	  {	
    		If (($row[0] != $phasold or $row[1] != $domold or $row[2] != $compold))
    		{	
    			// sur chgt on affiche la somme précédente
    			echo "<tr class='tr-phase'>\n";
    	    echo "<td align=\"left\" width=\"100\">".stripslashes($phasold)."</td>\n";
    	    echo "  <td width=\"100\">".stripslashes($domold)."</td>\n";
    			echo "  <td width=\"100\">".stripslashes($compold)."</td>\n";
    			for ($i = 0; $i <= $nivmax; $i++)
    			{
    			 $aff=$tabniv[$i];
				 $aff2=substr($nomliste[$i],0,strlen($nomliste[$i])-1);
    			 if ($aff== 0)
				 {$aff="";//on n'affiche pas zero
				 echo "  <td width=\"30\" class='td_niv'>$aff</td>\n";  //somme des niveaux de eva_comp
				 }
				 else
				 {
    	         echo "  <td width=\"30\" class='td_niv'><a title =\"$aff2\" href=\"#\">$aff</a></td>\n";  //somme des niveaux de eva_comp
    			 }
				}
    			$phasold=$row[0];$domold=$row[1];$compold=$row[2];
    				for ($i = 0; $i <= $nivmax; $i++)
    				{
    				$tabniv[$i] = 0;
					$nomliste[$i]="";
    				}	
					$k = $row[3];
    		    $tabniv[$k]=$tabniv[$k]+1;
				$nomliste[$k]=$nomliste[$k].$row2[0].",";
    		}
    		else
    		{
    		// on fait la somme et on construit le commentaire avec les noms des personnes
			 $k = $row[3];
			$nomliste[$k]=$nomliste[$k].$row2[0].",";
    		$tabniv[$k]=$tabniv[$k]+1;
    		}
		}
		else
		{
		$phinit =1;
		$phasold=$row[0];$domold=$row[1];$compold=$row[2];
		$k = $row[3];
    $tabniv[$k]=$tabniv[$k]+1;
	$nomliste[$k]=$nomliste[$k].$row2[0].",";
		}			
	}
	  // pour la dernière ligne
    echo "<tr class='tr-phase'>\n";
    echo "<td align=\"left\" width=\"100\">".stripslashes($phasold)."</td>\n";
    echo "  <td width=\"100\">".stripslashes($domold)."</td>\n";
    echo "  <td width=\"100\">".stripslashes($compold)."</td>\n";
    for ($i = 0; $i <= $nivmax; $i++)
    	{
    	$aff=$tabniv[$i];
			$aff2=substr($nomliste[$i],0,strlen($nomliste[$i])-1);
    	if ($aff== 0)
				 {$aff="";//on n'affiche pas zero
				 echo "  <td width=\"30\" class='td_niv'>$aff</td>\n";  //somme des niveaux de eva_comp
				 }
				 else
				 {
    	    echo "  <td width=\"30\" class='td_niv'><a title =\"$aff2\" href=\"#\">$aff</a></td>\n";  //somme des niveaux de eva_comp
    		 }
			}
			echo "</table>\n"; 
	} // fin du If sur ieva
	 			 
?>
