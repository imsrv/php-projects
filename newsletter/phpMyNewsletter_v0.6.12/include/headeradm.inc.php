<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0//EN">
<html>
<head>
<title>phpMyNewsletter : <? print translate("Administration"); ?></title>
</head>

<body text="#FFFFFF" link="#ffdb27" vlink="#ffdb27" alink="#ffdb27"  bgcolor="#537895">

<table border="0" cellspacing="0" cellpadding=0 border=0 >
    <tr>
        <td width="306"  valign="top" >
		<p><center><img src="img/admin.gif" border="0" align="middle"><b><? print translate("Administration"); ?></b></center></p>

            	<p><img src="img/mail.gif" border="0" align="middle"> <a href="admin.php?mode=envoi"><? print translate("Nouveau message");?></A> 
		<br><img src="img/address.gif" border="0" align="middle"> <a href="admin.php?mode=affiche"><? print translate("Liste des abonnés"); ?></a> 
		<br><img src="img/add.gif" border="0" align="middle"> <a href="admin.php?mode=ajout"><? print translate("Ajout d'un abonné");?></a> 
		<br><img src="img/del.gif" border="0" align="middle"> <a href="admin.php?mode=del"><? print translate("Suppression d'un abonné"); ?></a>
		<br><img src="img/export.gif" border="0" align="middle"> <a href="admin.php?mode=export"><? print translate("Export"); ?></a>
		<br><img src="img/log.gif" border="0" align="middle"> <a href="admin.php?mode=viewlog"><? print translate("Voir l'historique");?></a>
		<br><img src="img/config.gif" border="0" align="middle"> <a href="admin.php?mode=config">Configuration</a>
		<br><img src="img/logout.gif" border="0" align="middle"><a href="admin.php?bye=1"><?print translate("Se déconnecter");?></a>
<br><br>


<?
		if (file_exists("include/config.inc.php"))
		{
include("include/config.inc.php");
$mysql_link =  @MYSQL_CONNECT($news->host,$news->user,$news->passwd) OR DIE("Impossible de trouver la serveur de donnée");
@mysql_select_db($news->db ,$mysql_link ) or die( "Impossible de trouver la base");
$mysql_result = @mysql_db_query( $news->db ,"SELECT * FROM $news->tablenews") OR print("");
$nbrabonnes=@mysql_num_rows($mysql_result);  //nombres d'abonnés
echo "<b>".translate("Nombre d'abonnés")." : ".$nbrabonnes."<br>";

$mysql_result = @mysql_db_query( $news->db ,"SELECT * FROM $news->tabletemp") OR print("");
$nbrvalid=@mysql_num_rows($mysql_result);  //nombres en attente de validation
echo "".translate("En attente de validation")." : ".$nbrvalid."<br>";

$mysql_result = @mysql_db_query( $news->db ,"SELECT * FROM $news->tablelog") OR print("");
$nbrnews=@mysql_num_rows($mysql_result);  //nombres de newsletter déjà envoyée
echo "".translate("Nbr de NewsLetter déjà envoyées")." : ".$nbrnews."<br>";
$nbrnews++;
echo "".translate("Numéro de la prochaine NewsLetter")." : ".$nbrnews."</b>";
		}

?>


</td>
        <td width="652" valign="top">

