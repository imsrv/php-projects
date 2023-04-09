<?
// afficher le recap en fonction des informations
//			du formulaire de saisie (dans conso.php)
//    champs : input type=\"checkbox\" name=\"spar-$row[Id_evaluation]-$row[Type]-$i
// 
    // Analyse des champs du formulaire
			/* on découpe la clé des champs : choix-E-$row[Id_evaluation]-$dateva-$i
			 */
	//echo "conso<br>\n";
	$i=0;
	$ie=0;
	$io=0;
	$nbligne=0;
	$whereva ="";	
	$wherobj = ""; 
	$oue = "";
	$ouo = "";
			 //echo "**debug postvar $postvar <br>\n";
	while (list($key,$value) = each($postvar))
	{	
		//découper la clé en 2 parties séparées par un - et traiter evaluation 
			 $nbligne=$nbligne+1;
			 $pieces = explode("-", $key);
			 	$sparidevale[$i]="";
				$sparang[$i] = "";
			 if ($pieces[0]== "spar" and $pieces[2]==$mess[22])
				{
				$sparidevale[$i]=$pieces[1];
				$whereva.= " $oue $t_eva_comp.ce_evaluation='".$pieces[1]."' ";
				$sparang[$i]=$pieces[3];  //rang 
				$oue = "OR";  //juste la premier fois il est vide
				$ie=$ie+1;
				}
			if ($pieces[0]== "spar" and $pieces[2]==$mess[23])  //objectif
				{
				$sparidobj[$i]=$pieces[1];
				$wherobj .= " $ouo $t_eva_comp.ce_evaluation='".$pieces[1]."' ";
				$sparang[$i]=$pieces[3];  //rang 
				$ouo = "OR"; 
				$io=$io+1;
				}	
				$i=$i+1;
	}
	$iva=$ie;     //nombre d eval
	$iobj=$io;     //nombre d objectifs
	$nbligne=$nbligne-2; // deux input à ne pas compter			
											
		//fin analyse formulaire	
//
//presentation des paramètres permettant de créer un graphique
//consolidé sur l'ensemble de l'equipe et sur les différentes evaluations
//
// liste de l'équipe et des evaluations disponibles
    $commande= "select $t_equipe.nom,$t_equipe.prenom,$t_evaluation.Id_evaluation, $t_evaluation.Date_evaluation,$t_evaluation.Type";
		$commande.=" from $t_equipe ,$t_evaluation"; 
		$commande.=" where $t_evaluation.ce_equipe=$t_equipe.Id_equipe and $t_evaluation.Type='$mess[22]' "; 
		$commande.=" order by $t_equipe.nom,$t_evaluation.Date_evaluation DESC ";
		//echo "***debug sel equipe evaluation: $commande<br>\n";
	  $resultat = mysql_query ($commande, $connection);
	  if (!$resultat) 
	  {echo "<font color='red'>$mess[10] $t_equipe<b>".BD."</b></font><br>";exit;}
	 //formulaire pour saisie des données à integrer dans la consolidation
echo "<table>\n";
echo " <tr><td><br><b>$mess[32]</b><br><br></td></tr>\n";
echo "<tr><form method=\"post\" action=\"main.php\" name=\"enparam\"><td>\n";
 			//affiche en-tete du tableau
			echo "<table class='tab-phase'>\n";
 			echo " <tr class='tr-titre-phase'>\n";
 			echo "  <td  width=\"150\">$mess[6]</td>\n";  //nom 
			echo "  <td  width=\"150\">$mess[7]</td>\n";  //prenom
			echo "  <td width=\"100\">$mess[33]</td>\n";   //Date evaluation
			echo "  <td width=\"100\">$mess[34]</td>\n";   //type evaluation
 			echo "  <td width=\"20\"></td>\n";   //chek box
			echo " </tr>\n";
			$nomprenom ="";
			$i=0;
 while ($row = mysql_fetch_array ($resultat)) 
{
//
// on affiche les lignes de donnée en ne répetant pas le nom prénom
//
    //echo "**debug $row[0] $row[1]  $row[2] <br>\n";
	 echo "<tr class='tr-phase'>\n";
	 if ($nomprenom <> $row[0].$row[1])
	 {
	 echo "<td align=\"left\">".stripslashes($row[0])."</td>\n";
	 echo "<td align=\"left\">".stripslashes($row[1])."</td>\n";
	 $nomprenom=$row[0].$row[1];
	 $check=1;
	 }
	 else
	 {
	 echo "<td align=\"left\"></td>\n";
	 echo "<td align=\"left\"></td>\n";
	 $check=0;
	 }
	 $dateva = dateusfr($row[3]);
	 echo "  <td width=\"100\">$dateva</td>\n";
	 echo "  <td width=\"100\">$row[4]</td>\n";
	 //check box  le premier de chaque nom est coché
	 $sel="";
	 If ($iva + $iobj==0)
	 {
	    // checked la ligne soit la 1er soit la précedente
	    if ($check==1 and $row[4]==$mess[22]){$sel="CHECKED";}
	 }
	    else
	 {
	 // le formulaire a ete rempli on check en consequence
	    for ($j=0 ; $j < ($nbligne) ; $j++)
			{
			 if ($sparang[$j]==$i){$sel="CHECKED";}
			}
	 }
	 echo "<td><input type=\"checkbox\" name=\"spar-$row[2]-$row[4]-$i\"  $sel></td>\n";   
	 echo "</tr>\n";
	 $i=$i+1;
}		
		 echo "</table>\n";
 // fin du formulaire
 	   echo "<input type=\"hidden\" name=\"action\" value=\"saisparam\">\n";
		 echo "<center><br><br><input class=\"send\" type=\"submit\" name=\"Submit\" value=\"$mess[3]\">\n";
	   echo "</center></form>\n"; 

echo "</table>\n";
?>
