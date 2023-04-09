<?
// mcNews 1.3 Marc Cagninacci marc@phpforums.net
include ("conf.inc.php");
$connect= mysql_connect($host,$login,$pass);
mysql_select_db($base, $connect);
$query = "SELECT * FROM mcnews_design";
$row=mysql_fetch_array(mysql_query($query, $connect));
include ("admin/$row[lang]");
include ("admin/$row[skin]");
$listnews= $row['nbliste'];
$skin=$row['skin'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>mcNews</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
a:actif {  font-family: <? echo $FontLien; ?>; color: <?echo $LienColor; ?>; font-weight: <? echo $LienWeight; ?>; text-decoration: none}
a:link {  font-family: <? echo $FontLien; ?>; color: <?echo $LienColor; ?>; font-weight: <? echo $LienWeight; ?>; text-decoration: none}
a:visited {  font-family: <? echo $FontLien; ?>; color: <?echo $LienColor; ?>; font-weight: <? echo $LienWeight; ?>; text-decoration: none}
a:hover {  font-family: <? echo $FontLien; ?>; color: <?echo $LienSurvolColor; ?>; font-weight: <? echo $LienWeight; ?>; text-decoration: none}
-->
</style>
</head>
<body bgcolor="<? echo $BodyBgcolor; ?>" text="black">


<table width="480" border="0" cellspacing="0" cellpadding="1" bgcolor="<? echo $TableBgcolor; ?>" align="center">
<?
// REPLCE THIS BY ANYTHING YOU WANT ----------------------------
// REMPLACEZ CE QUI SUIT PAR CE QUE VOUS VOULEZ ----------------
echo '<tr><td align="right" colspan="3" bgcolor="'.$TDBgcolorTexte.'"><font face="'.$FontFace.'" size="4" color="'.$FontColorTitre.'">';
echo 'mcNews 1.3';
echo '</font></td></tr>';
// FIN DE LA ZONE A REMPLACER ----------------------------------
// END OF THE AREA ---------------------------------------------
?>
<tr>
<td width="33%" bgcolor="<? echo $TDBgcolorTexte; ?>"><font face="<? echo $FontFace; ?>" color="<? echo $FontColorTitre; ?>" size="<? echo $FontSizeTitre; ?>">
         &nbsp;<a href="index.php"><? echo $nbnews.' '.$lLast; ?></a></font></td>
<td width="33%" bgcolor="<? echo $TDBgcolorTexte; ?>" align="center"><font face="<? echo $FontFace; ?>" color="<? echo $FontColorTitre; ?>" size="<? echo $FontSizeTitre; ?>">
         <a href="search.php"><? echo $lSearch; ?></a></font></td>
<td width="33%" bgcolor="<? echo $TDBgcolorTexte; ?>" align="right"><font face="<? echo $FontFace; ?>" color="<? echo $FontColorTitre; ?>" size="<? echo $FontSizeTitre; ?>">
         <a href="ecrire.php"><? echo $lPropo; ?></a>&nbsp;</font></td>
</tr>
<tr>
<td bgcolor="<? echo $BodyBgcolor; ?>" colspan="3">
         &nbsp;</td>
</tr>
</table>
<table width="480" border="0" cellspacing="1" cellpadding="1" bgcolor="<? echo $TableBgcolor; ?>" align="center">
<tr><td bgcolor="<? echo $TDBgcolorAuteur; ?>" align="right"><font face="<? echo $FontFace; ?>" size="<? echo $FontSizeAuteur; ?>" color="<? echo $FontColorTitre; ?>">
<?
$resultat=mysql_query("SELECT id FROM mcnews_news");
$mcnnum = mysql_num_rows($resultat);
$nb=$listnews;
if($start=='') {$start=0;}
echo '';
if($start>0)
{
echo '<a href="list.php?start='.($start-$nb).'"><font size="1"><b><<</b></font></a>&nbsp;&nbsp;';
}

$result=mysql_query("SELECT COUNT(id) FROM mcnews_news");
$rowp=mysql_fetch_row($result);
$i=1;
while ($i<(($start + $nb)/$nb))
 {
   echo '<font face="'.$FontFace.'" size="1"><a href="list.php?start='.($nb*($i-1)).'">'.$i.'</a></font>&nbsp;';
   $i++;
 }
 echo '<font face="'.$FontFace.'" color="'.$FontColorAuteur.'" size="'.$FontSizeAuteur.'"><b>'.$i.'</b></font>&nbsp;';
 $i++;
while ($i<=ceil($mcnnum/ $nb))
 {
   echo '<font face="'.$FontFace.'" size="1"><a href="list.php?start='.($nb*($i-1)).'">'.$i.'</a></font>&nbsp;';
   $i++;
 } 
if($rowp[0]>($start+$nb))
{
echo '<a href="list.php?start='.($start+$nb).'"><font size="1"><b>>></b></font></a>&nbsp;';
}
echo '</td></tr></font>';

$query2="SELECT id, date, titre, auteur FROM mcnews_news WHERE valid='Y' ORDER BY date DESC, id DESC LIMIT $start,$nb";
$result=mysql_query($query2, $connect);
while($news=mysql_fetch_array($result))
{
         if ($lFormatDate=="fr")
         {
         list($y,$m,$d) = explode("-",$news['date']);
         $news['date'] = $d.' '.$m.' '.$y;
         }

?>

<tr>
<td bgcolor="<? echo $TDBgcolorAuteur; ?>"><font face="<? echo $FontFace; ?>" size="<? echo $FontSizeAuteur; ?>">
         <a href="lire.php?n=<? echo $news['id']; ?>"><? echo $news['date'].'&nbsp;&nbsp;-&nbsp;&nbsp;'.stripslashes($news['titre']).'&nbsp;&nbsp;-&nbsp;&nbsp;<i>'.stripslashes($news['auteur']).'</i>'; ?></a></font>
 </td>
</tr>


<?
}

echo '</table>';
include ("footer.php");
?>
