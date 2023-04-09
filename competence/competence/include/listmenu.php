<iframe name="gToday:normal:include/agenda.js" id="gToday:normal:include/agenda.js"
src="include/ipopeng.htm" scrolling="no" frameborder="0"
style="visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
<LAYER name="gToday:normal:include/agenda.js" src="include/npopeng.htm">     </LAYER>
</iframe>
<?
// constitution du tableau des evaluations pour la personne loggée
	$level = $HTTP_SESSION_VARS["level"];
$commande = "SELECT * FROM $t_evaluation where ce_equipe='$Id_nom' And Type='$mess[22]'";
$commande.= " Order by Date_evaluation DESC";
//echo "***debug sql evaluation: $commande<br>\n";
$resultat = mysql_query ($commande, $connection);
if (!$resultat) {
	echo "<font color='red'>Erreur:Table $t_evaluation non présente<b>".BD."</b></font><br>";
	exit;
}  
	$color_on="#C4C4C4";
	$color_norm="#F0FFFF";
	//  Appel aide et titre du menu
	echo "<br><br>\n";
	echo "<a href=\"main.php?action=aide\">\n";
	echo "<img src=\"images/help.gif\" alt=\"$mess[31]\" width=\"20\" height=\"20\" border=\"0\"></a>\n";
	echo "<table class=\"menu\">\n";
	echo "<tr><td class=\"t_menu\">Menu</td></tr>\n";
	//Liste des évaluations effectuées
	echo "<tr><td class=\"t_menu\">$mess[20]\n";
	echo "<form method=\"post\" action=\"main.php\" name=\"affeval\"></td></tr>\n";
	$i=1;
	while ($row = mysql_fetch_array ($resultat))
	 {
	  $dateva=dateusfr($row[Date_evaluation]);
				$sel="";
				$styl="l_menu";
		if (isset($imax))
		{
			 for ($j = 0; $j < $imax; $j++)
			 {
			  //echo "debug : test rang :$parang[$j], $i<br>\n";
				if ($parang[$j]==$i){$sel="CHECKED";$styl="l_menu2";}
			 }
		}
		echo "<tr><td  class=\"$styl\" onmouseover='mOvr(this,\"$color_on\");' onmouseout='mOut(this,\"$color_norm\");'>";
	 if ($level >= 5)
	 {
		echo "<a href=\"main.php?action=supeval&s_eva=$row[Id_evaluation]\">";
	  echo "<img src=\"images/supprimer.gif\" alt=\"$mess[15]\" width=\"10\" height=\"10\" border=\"0\"></a>\n";
	 }	
		echo "<b>&nbsp;&nbsp;$dateva</b>\n";
		echo "<input type=\"checkbox\" name=\"choix-E-$row[Id_evaluation]-$dateva-$i\" $sel>$i</td></tr>\n";   
	  $i=$i+1;
	 }
	//Liste des objectifs définis
	$commande = "SELECT * FROM $t_evaluation where ce_equipe='$Id_nom' And Type='$mess[23]'";
  $commande.= " Order by Date_evaluation DESC";
  //echo "***debug sql evaluation: $commande<br>\n";
  $resultat = mysql_query ($commande, $connection);
	echo "<tr><td class=\"t_menu\">$mess[26]</td></tr>\n";
	while ($row = mysql_fetch_array ($resultat))
	 {
	  $dateva=dateusfr($row[Date_evaluation]);
		$sel="";
		$styl="l_menu";
			if (isset($imax))
			{
			 	for ($j = 0; $j < $imax; $j++)
			 	{
				if ($parang[$j]==$i){$sel="CHECKED";$styl="l_menu2";}
			 	}
			 }
		echo "<tr><td  class=\"$styl\" onmouseover='mOvr(this,\"$color_on\");' onmouseout='mOut(this,\"$color_norm\");'>\n";
		if ($level >= 5)
	  {
		echo "<a href=\"main.php?action=supeval&s_eva=$row[Id_evaluation]\">\n";
	  echo "<img src=\"images/supprimer.gif\" alt=\"$mess[15]\" width=\"10\" height=\"10\" border=\"0\"></a>\n";
		}
		echo "<b>&nbsp;&nbsp;$dateva</b>\n";
		echo "<input type=\"checkbox\" name=\"choix-O-$row[Id_evaluation]-$dateva-$i\" $sel>$i<br></td></tr>\n";   
	 	$i=$i+1;
	 }	
	// action sur les checks boxs
	echo "<tr><td class=\"t_menu\">$mess[27]</td></tr>\n";
	echo "<tr><td><center><input class=\"send\" type=\"submit\" name=\"affeva\" value=\"$mess[28]\"></center>\n";
	echo "<input type=\"hidden\" name=\"action\" value=\"affeval\">\n";
	echo "</form></td></tr>\n";
	// fin de la forme de selection 
	// création d'une nouvelle évaluation 	 
	 echo "<tr><td class=\"t_menu\">$mess[21]</td></tr>\n";
	 echo "<tr><td><FORM action=\"main.php\" name=\"calend\" onSubmit=\"return veriform(this);\">\n";
	 echo "<select size=\"1\" name=\"typeva\">\n";
   echo "<option value=\"$mess[22]\" SELECTED>$mess[22]</option>\n";
   echo "<option value=\"$mess[23]\">$mess[23]</option></select></td></tr>";
	 echo "<tr><td>\n";
	 echo "<input name=\"dateva\" value=\"\" size=\"11\">\n";
	 echo "<a href=\"javascript:void(0)\" onclick=\"if(self.gfPop)gfPop.fPopCalendar(document.calend.dateva);return false;\" HIDEFOCUS>\n";
	 echo "<img name=\"popcal\" align=\"absmiddle\" src=\"include/calbtn.gif\" width=\"34\" height=\"22\" border=\"0\" alt=\"\"></a>\n";
	 echo "</td></tr>\n";
	 echo "<tr><td><center><input class=\"send\" type=\"submit\" name=\"creva\" value=\"$mess[18]\"></center>\n";
 	 echo "<input type=\"hidden\" name=\"action\" value=\"creval\">\n";
	 echo "</FORM></td></tr>\n";
	 //pour changer param d un user
	 echo "<tr><td class=\"t_menu\">$mess[38]</td></tr>\n";  //
	 $Id_nom=$HTTP_SESSION_VARS["Id_nom"];
	 echo "<tr><td onmouseover='mOvr(this,\"$color_on\");' onmouseout='mOut(this,\"$color_norm\");'><a href=main.php?action=moduser&Id_nom=$Id_nom>$mess[38]</a></td></tr>\n";
	 //Administration
	if ($level >= 5)
	{
	 echo "<tr><td class=\"t_menu\">$mess[32]</td></tr>\n";  //
	 echo "<tr><td onmouseover='mOvr(this,\"$color_on\");' onmouseout='mOut(this,\"$color_norm\");'><a href=main.php?action=phases>$mess[30]</a></td></tr>\n";
		 //consolidations
	 echo "<tr><td class=\"t_menu\">$mess[35]</td></tr>\n";
	 echo "<tr><td onmouseover='mOvr(this,\"$color_on\");' onmouseout='mOut(this,\"$color_norm\");'><a href=main.php?action=saisparam>$mess[32]</a></td></tr>\n";
 
 	 //export Excel
	 echo "<tr><td class=\"t_menu\">Export Excel</td></tr>\n";
	 echo "<tr><td onmouseover='mOvr(this,\"$color_on\");' onmouseout='mOut(this,\"$color_norm\");'><a href=excel.php>Export Excel</a></td></tr>\n";
 // si level > 5 liste des users
	 echo "<tr><td class=\"t_menu\">$mess[37]</td></tr>\n";
	 $result=mysql_query("select nom,prenom,login,level from $t_equipe  order by nom") or die("Echec accès Base de données.");
	 echo "<tr><td onmouseover='mOvr(this,\"$color_on\");' onmouseout='mOut(this,\"$color_norm\");'>\n";
	 echo "<form method=\"post\" action=\"main.php\" name=\"affuser\">\n";
	 echo "<select size=\"1\" name=\"luser\">\n";
	 while ($row=mysql_fetch_array($result))
	  {
      	 if($row[3]  < 8)  //on affiche pas les admins
		 {
		 	if ($login == $row[2])
      	 	{
      		 echo "<option value=\"$row[2]\"  SELECTED>$row[0] $row[1]</option>\n";
      	 	}
      	 	else
      	 	{
      	 	echo "<option value=\"$row[2]\">$row[0] $row[1]</option>\n";
      	 	}
		 }
		}
	 echo "</td></tr><tr><td><center><input class=\"send\" type=\"submit\" name=\"chg\" value=\"$mess[3]\">\n";
 	 echo "<input type=\"hidden\" name=\"action\" value=\"chguser\">\n";
	 echo "</select></form></center></td></tr>\n";
	 }	
	 echo "</table>\n";	
?>