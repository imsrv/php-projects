<?

//-----------------------------------------------------------------------------------------------------------------------------------------
//	FONCTIONS
//-----------------------------------------------------------------------------------------------------------------------------------------

function dateusfr($date)
   {
// transformer date YYYY-MM-DD  en DD-MM-YYYY
//par la suite rajouter les controles par rapport au format
	$pos1 = strpos ($date,"-"); //premiere occurence
	$pos2 = strpos ($date,"-",$pos1+1); //derniere occurence
	$len=strlen($date);
	$result= substr($date,$pos2+1,$len-$pos2-1)."/".substr($date, $pos1+1, $pos2-$pos1-1)."/".substr($date, 0, $pos1);
	 return $result;
	 }
function datefrus($date)
   {
// transformer date DD/MM/YYYY	en YYYY-MM-DD
//par la suite rajouter les controles par rapport au format
   $pos1 = strpos ($date,"/"); //premiere occurence
	$pos2 = strpos ($date,"/",$pos1+1); //derniere occurence
	$result= substr($date, ($pos2)+1,4)."-".substr($date, ($pos1)+1, $pos2-$pos1-1)."-".substr($date, 0, $pos1);
	 return $result;
	 }
//--------------------------
// a partir du délai on donne les deux dates de début et fin
// MC=mois courant,M2 =2 mois, M3=3mois, YC=année en cours, Y2=2ans
//-------------------------
function calculdates($s_delai)
{
  $today = getdate();
	$mday = $today['mday']; 
  $month = $today['mon']; 
  $year = $today['year'];
switch($s_delai) {
  case "MC":
	  $s_del= "and date >= '".$year."-".$month."-01' and date <='".$year."-".$month."-".$mday."' ";

  break;
  case "M1":
	     $month1=Round($month-1);$year1=$year;
	  if ($month <=0){$year1=Round($year-1);$month1=Round($month1+12);}
    $s_del= "and date >= '".$year1."-".$month1."-01' and date <='".$year."-".$month."-".$mday."' ";
  break;
  case "M2":
	     $month1=Round($month-2);$year1=$year;
	  if ($month <=0){$year1=Round($year-1);$month1=Round($month1+12);}
    $s_del= "and date >= '".$year1."-".$month1."-01' and date <='".$year."-".$month."-".$mday."' ";
  break;
  case "M3":
	     $month1=Round($month-3);$year1=$year;
			 if ($month<=1){$year1=Round($year-1);$month1=Round($month1+12);} 
       $s_del= "and date >= '".$year1."-".$month1."-01' and date <='".$year."-".$month."-".$mday."' ";
  break;
  case "YC":
         $s_del= "and date >= '".$year."-01-01' and date <='".$year."-".$month."-".$mday."' ";
  break;
  case "Y2":
	     $year1=$year-1;
       $s_del= "and date >= '".$year1."-01-01' and date <='".$year."-".$month."-".$mday."' ";
  break;			
	}
	return $s_del;
}
//--------------------------
//création liste déroulante mois an param1 jusqu a mois an param2
//--------------------------
	$str_mois = array(
	1 => 'Janvier',2 => 'Février',3 => 'Mars',
	4 => 'Avril',5 => 'Mai',6 => 'Juin',
	7 => 'Juillet',8 => 'Aout',9 => 'Septembre',
  10 => 'Octobre',11 => 'Novembre',12 => 'Décembre'
	);
function crecombodate($date1,$date2,$nom,$j)
{
		global $str_mois;
	$str_mnum = array(
	1 => '01',2 => '02',3 => '03',4 => '04',5 => '05',6 => '06',
	7 => '07',8 => '08',9 => '09',10 => '10',11 => '11',12 => '12'
	);
	$d1=substr($date1,0,4)*10000+substr($date1,5,2)*100+substr($date1,8,2);
	$d2=substr($date2,0,4)*10000+substr($date2,5,2)*100+substr($date2,8,2);
	if($d1 > $d2)
	{$mindate=$date2;$maxdate=$date1;}
	else
	{$mindate=$date1;$maxdate=$date2;}
	$min_mois = substr($mindate,5,2);
	$min_jour = substr($mindate,8,2);
	$min_an = substr($mindate,0,4);
	$max_mois = substr($maxdate,5,2);
	$max_jour = substr($maxdate,8,2);
	$max_an = substr($maxdate,0,4);
	//boucle de constitution du tableau du plus recent au plus ancien
	$i=0;$combo="<select size='1' name='".$nom."'>\n";
	$d1=$max_an*100+$max_mois;
	$d2=$min_an*100+$min_mois;
	$max_mois=round($max_mois);
	while ($d1 >= $d2)
	{
	//on positionne comme selctionné le rang j
	if($i==$j){$combo=$combo."<option selected ";} else {$combo=$combo."<option ";}
	$combo=$combo."value='".$max_an."-".$str_mnum[round($max_mois)]."=".$i."'>".$str_mois[round($max_mois)] . "  " . $max_an."</option>\n";
	//on enleve un mois à la date max
	$i=$i+1;
	$max_mois=round($max_mois) -1;
	if ($max_mois == 0){$max_mois = 12;$max_an=$max_an-1;}
	$d1=$max_an*100+$max_mois;
	$d2=$min_an*100+$min_mois;
	}
	$combo=$combo.">/select>\n";
	return $combo;	
}	
//----------------------------------------
// en entrée N° du mois en sortie donne le nom du mois en clair
//-----------------------------------------
function nom_mois($j)
{
  	global $str_mois;
  return $str_mois[$j];
}
//calcul du rang d'un tableau en passant un libellé si le libellé n'existe pas retour = -1
function trouv_lib($table,$libel)	
 {   
		$c=0;$j=-1;
    for ($c=0 ; $c<=count($table) ; $c++)
		{
		 if ($table[$c]== $libel) {$j=$c;}
		} 
		return $j;
  }
// création du style pour les nb négatifs
//-------------------------
function dmoney($amount, $style)
//on affiche en rouge les nombres négatifs si $style <> 0  
{ 
   $amount=doubleval($amount); 
if ($amount==0) 
    {$result= "-";}
else
 {			 
   if ($amount>=0) 
      {$result= "<span class=\"euro\">".sprintf("%01.2f",$amount)."</span>";} 
   else 
      if ($style==0) 
         {$result= "<span class=\"euro\">".sprintf("%01.2f",$amount)."</span>";} 
      else 
         {$result="<font color=red><span class=\"euro\">".sprintf("%01.2f",$amount)."</span></font>";} 
 }  
	 Return $result; 
} 
//-----------------------------------------------------------
// fonction de mise a jour du solde d un compte
//-----------------------------------------------------------
 function majsolde($login,$ncompte,$solde)
 {
 	     	//on met le solde de la table compte à jour
				global $table_compte,$table_mvt,$connection;
				$commande = "update $table_compte Set solde='$solde'  where login='$login' and numcompte='$ncompte'";
				$resultat = mysql_query ($commande, $connection) or die ("Table compte non disponible");
/*			  // on met à jour tous les soldes des mvt du compte correspondant
				$commande = "SELECT solde,numvt,débit,credit FROM $table_mvt where (login='$login' and compte='$ncompte') ORDER BY date DESC";
        //echo "**debug : $commande <br>\n";
				$resultat = mysql_query ($commande, $connection) or die ("Table compte non disponible");
            while ($row = mysql_fetch_array ($resultat)) 
            {
							$nmvt=$row[numvt];
							$command2 = "update $table_mvt Set solde='$solde'   where login='$login' and compte='$ncompte' and numvt='$nmvt'";
				      echo "**debug : $command2 <br>\n";
							$result2 = mysql_query ($command2, $connection) or die ("Table mouvement non disponible");
              $solde = $solde+$row[credit]-$row[débit];
						}
*/						
 } 
//---------------------------------------------------------
// La fonction suivante ne sert qu'à afficher la fleche haute ou basse
//----------------------------------------------------------
  function aff_fleche($sens)
  {
   if ($sens=="DESC")
	    {echo "<img src=\"images/fleche1.gif\" width=\"10\" height=\"10\">\n";}
	  else
	  	{echo "<img src=\"images/fleche0.gif\" width=\"10\" height=\"10\">\n";}
	 }		
//----------------------------------
// gestion de l entete du tableau permettant le trie sur les différentes colonnes	
//-----------------------------------
   function aff_mvt($sens,$ordre)
 {
    global $ncompte;
 echo "<table   border=\"1\" bordercolor=\"#FFFFFF\" cellspacing=\"0\" cellpadding=\"0\" style=\"border-collapse: collapse\">\n";
 echo " <tr class='tr-mvt'>\n";
  // mise à jour de sens
	  if ($sens=='DESC'){$sens='ASC';}
	  else {if ($sens=='ASC'){$sens='DESC';}}	
 echo " <td width=\"30\">N°</td>\n";	
 //date
 echo "  <td width=\"80\"><a href=main.php?action=mouvement&ncompte=$ncompte&debaff=0&ordre=date&sens=$sens>Date</a>\n";
 if ($ordre==date){aff_fleche($sens);}
 echo "   </td>\n";
 //Libellé
 echo "  <td  width=\"250\"><a href=main.php?action=mouvement&ncompte=$ncompte&debaff=0&ordre=tiers&sens=$sens>Libellé</a>\n";
 if ($ordre==tiers){aff_fleche($sens);}
 echo "   </td>\n";
 //Débit
 echo "  <td width=\"80\"><a href=main.php?action=mouvement&ncompte=$ncompte&debaff=0&ordre=débit&sens=$sens>Débit</a>\n";
  if ($ordre==débit){aff_fleche($sens);}
  echo "   </td>\n";
 //Crédit
 echo "  <td width=\"80\"><a href=main.php?action=mouvement&ncompte=$ncompte&debaff=0&ordre=credit&sens=$sens>Crédit</a>\n";
  if ($ordre==credit){aff_fleche($sens);}
  echo "   </td>\n";
 //Catégorie
 echo "  <td width=\"200\"><a href=main.php?action=mouvement&ncompte=$ncompte&debaff=0&ordre=categ&sens=$sens>Catégorie</a>\n";
  if ($ordre==categ){aff_fleche($sens);}
  echo "   </td>\n";
  echo " <td>C.</td>\n";
echo " </tr>\n";
 }
?>

